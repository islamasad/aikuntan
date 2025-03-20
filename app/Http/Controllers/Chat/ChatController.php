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

        \Log::channel('gemini')->info('User prompt received', [
            'prompt' => $request->prompt,
            'ip' => $request->ip(),
        ]);

        $response = $this->geminiService->generateContent([
            [
                'parts' => [
                    ['text' => $request->prompt]
                ]
            ]
        ]);
        
        if (isset($response['error'])) {
            \Log::channel('gemini')->error('Error in chat processing', [
                'error' => $response['error'],
                'prompt' => $request->prompt,
            ]);

            if ($request->header('HX-Request')) {
                return response()->json([
                    'error' => 'Failed to get response: '.
                        (is_array($response['error']) ? json_encode($response['error']) : $response['error']),
                ], 422);
            }

            return redirect()->back()->withErrors([
                'gemini_error' => 'Failed to get response: '.
                    (is_array($response['error']) ? json_encode($response['error']) : $response['error']),
            ]);
        }

        \Log::channel('gemini')->debug('Processed Gemini Response', [
            'response_structure' => array_keys($response),
            'content_exists' => isset($response['candidates'][0]['content']['parts'][0]['text']),
        ]);

        $userMessage = [
            'sender' => 'user',
            'content' => $request->prompt,
            'avatar' => 'U',
        ];

        // Panggil method extractResponseText untuk mendapatkan pesan bot
        $botText = $this->geminiService->extractResponseText($response);

        $botMessage = [
            'sender' => 'bot',
            'content' => $botText,
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
}
