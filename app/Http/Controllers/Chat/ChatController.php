<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ChatController extends Controller
{
    protected GeminiService $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function index()
    {
        return view('chat.index', [
            'messages' => session('chat_history', []),
        ]);
    }

    public function ask(Request $request)
    {
        $request->validate(['prompt' => 'required|string']);
        $prompt = $request->prompt;
        $context = $this->detectContext($prompt);
        $isAccounting = $context === 'accounting';

        // Simpan konteks di session
        session()->put('current_context', $isAccounting ? 'accounting' : 'general');

        \Log::channel('gemini')->info('Context detected', [
            'original_prompt' => $prompt,
            'context' => $context,
            'processed_prompt' => $prompt,
        ]);

        if ($isAccounting) {
            $processedPrompt = $this->removeTriggerWord($prompt, $context);
            $response = app(AccountingGeminiService::class)->processAccountingPrompt($processedPrompt);
            
            if (isset($response['type']) && $response['type'] === 'data_required') {
                session()->put('pending_transaction', [
                    'missing_data' => $response['missing_data'],
                    'example_question' => $response['example_question']
                ]);
                
                return $this->handleFollowUpQuestion($request, $response);
            }
            
        } else {
            $response = $this->geminiService->generateSimpleTextPrompt($prompt);
        }
    

        if (isset($response['error'])) {
            \Log::channel('gemini')->error('Error in chat processing', [
                'error' => $response['error'],
                'prompt' => $request->prompt,
            ]);

            if ($request->header('HX-Request')) {
                return response()->json([
                    'error' => 'Gagal mendapatkan respons: '.Arr::get($response, 'error', 'Unknown error')
                ], 422);
            }

            return redirect()->back()->withErrors([
                'gemini_error' => 'Gagal mendapatkan respons: '.Arr::get($response, 'error', 'Unknown error')
            ]);
        }

        $userMessage = [
            'sender' => 'user',
            'content' => $request->prompt,
            'avatar' => 'U',
        ];

        $botMessage = [
            'sender' => 'bot',
            'content' => Arr::get($response, 'candidates.0.content.parts.0.text', 'Tidak ada respons'),
            'avatar' => 'B',
        ];

        $chatHistory = session('chat_history', []);
        $chatHistory[] = $userMessage;
        $chatHistory[] = $botMessage;
        session(['chat_history' => $chatHistory]);

        if ($request->header('HX-Request')) {
            return view('partials.chat-message', [
                'messages' => [$userMessage, $botMessage],
            ]);
        }

        return redirect()->route('dashboard');
    }

    protected function detectContext(string $prompt): ?string
    {
        foreach (config('chat.context_triggers') as $context => $trigger) {
            if (str_starts_with(strtolower(trim($prompt)), strtolower($trigger))) {
                return $context;
            }
        }
        return null;
    }

    protected function removeTriggerWord(string $prompt, string $context): string
    {
        $trigger = config("chat.context_triggers.$context");
        return preg_replace("/^$trigger\s*/i", '', $prompt);
    }

    protected function handleMissingData(Request $request, array $response)
    {
        $missingData = $response['missing_data'] ?? [];
        $message = $response['message'] ?? 'Silakan lengkapi data berikut:';
        
        session()->flash('required_fields', $missingData);
        
        if ($request->header('HX-Request')) {
            return response()->json([
                'missing_data' => $missingData,
                'message' => $message
            ], 422);
        }
        
        return redirect()->back()
            ->withInput()
            ->withErrors(['missing_data' => $message]);
    }

    protected function handleFollowUpQuestion(Request $request, array $response)
    {
        $message = [
            'sender' => 'bot',
            'content' => $response['missing_data']['guidance']."\n\n".$response['example_question'],
            'avatar' => 'B',
            'requires_input' => true,
            'required_fields' => $response['missing_data']['fields']
        ];

        if ($request->header('HX-Request')) {
            return view('partials.chat-message', ['messages' => [$message]]);
        }

        return redirect()->back()->with('bot_message', $message);
    }
}