<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GeminiService;
use App\Services\ChatHistoryService;
use Prism\Prism\ValueObjects\Messages\UserMessage;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;
use Illuminate\Support\Facades\Log;
use App\Traits\ConvertsMessages;

class ChatController extends Controller
{
    use ConvertsMessages;

    protected GeminiService $geminiService;
    protected ChatHistoryService $chatHistoryService;

    public function __construct(GeminiService $geminiService, ChatHistoryService $chatHistoryService)
    {
        $this->geminiService = $geminiService;
        $this->chatHistoryService = $chatHistoryService;
    }

    public function index()
    {
        $messages = session('chat_history', []);
        return view('chat.index', [
            'messages' => $this->convertMessagesToArray($messages),
        ]);
    }

    public function ask(Request $request)
    {
        $request->validate(['prompt' => 'required|string']);

        Log::channel('gemini')->info('User prompt received', [
            'prompt' => $request->prompt,
            'ip'     => $request->ip(),
        ]);

        $userMessage = new UserMessage($request->prompt);

        // Dapatkan chat history; base prompt akan ditambahkan jika history masih kosong
        $chatHistory = $this->chatHistoryService->getHistory();

        // Tambahkan pesan user ke chat history
        $chatHistory = $this->chatHistoryService->addMessage($userMessage);

        Log::channel('gemini')->info('Sending chat history to GeminiService', [
            'chat_history' => $this->convertMessagesToArray($chatHistory)
        ]);

        try {
            $response = $this->geminiService->generate($chatHistory);
            Log::channel('gemini')->info('Received response from GeminiService', [
                'response' => $response
            ]);
        } catch (\Throwable $e) {
            Log::channel('gemini')->error('Exception when calling GeminiService', [
                'error'  => $e->getMessage(),
                'prompt' => $request->prompt,
            ]);
            $errorMessage = new AssistantMessage('Terjadi kesalahan, coba lagi!');
            $messagesForView = $this->convertMessagesToArray([$userMessage, $errorMessage]);

            if ($request->header('HX-Request')) {
                return view('partials.chat-message', [
                    'messages' => $messagesForView,
                ]);
            }
            return redirect()->back()->withErrors([
                'gemini_error' => 'Failed to generate response.',
            ]);
        }

        if (!isset($response['text']) || empty($response['text'])) {
            Log::channel('gemini')->error('Empty response received from GeminiService', [
                'response' => $response
            ]);
            $botMessage = new AssistantMessage('Tidak menerima balasan dari Gemini.');
        } else {
            $botMessage = new AssistantMessage($response['text']);
        }

        // Tambahkan pesan balasan dari bot ke chat history
        $chatHistory = $this->chatHistoryService->addMessage($botMessage);

        if ($request->header('HX-Request')) {
            $messagesForView = $this->convertMessagesToArray([$userMessage, $botMessage]);
            return view('partials.chat-message', [
                'messages' => $messagesForView,
            ]);
        }

        return redirect()->route('chat.index');
    }
}
