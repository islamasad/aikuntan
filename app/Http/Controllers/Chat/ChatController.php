<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GeminiService;
use Prism\Prism\ValueObjects\Messages\UserMessage;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;
use Illuminate\Support\Facades\Log;
use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;

class ChatController extends Controller
{
    protected GeminiService $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
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

        // Buat pesan pengguna
        $userMessage = new UserMessage($request->prompt);

        // Ambil riwayat chat dari session dan tambahkan pesan pengguna baru
        $chatHistory = session('chat_history', []);
        $chatHistory[] = $userMessage;

        Log::channel('gemini')->info('Sending chat history to GeminiService', [
            'chat_history' => $this->convertMessagesToArray($chatHistory)
        ]);

        try {
            // Panggil GeminiService untuk menghasilkan respons berdasarkan message chain
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

        $chatHistory[] = $botMessage;
        session(['chat_history' => $chatHistory]);

        if ($request->header('HX-Request')) {
            $messagesForView = $this->convertMessagesToArray([$userMessage, $botMessage]);
            return view('partials.chat-message', [
                'messages' => $messagesForView,
            ]);
        }

        return redirect()->route('chat.index');
    }

    /**
     * Helper untuk mengekstrak nilai konten dari objek pesan menggunakan Reflection.
     */
    protected function getMessageContent($message): string
    {
        try {
            $reflection = new \ReflectionClass($message);
            if ($reflection->hasProperty('content')) {
                $prop = $reflection->getProperty('content');
                $prop->setAccessible(true);
                return $prop->getValue($message);
            } elseif ($reflection->hasProperty('text')) {
                $prop = $reflection->getProperty('text');
                $prop->setAccessible(true);
                return $prop->getValue($message);
            }
        } catch (\ReflectionException $e) {
            Log::error('Reflection error:', ['error' => $e->getMessage()]);
        }
        return '';
    }

    /**
     * Konversi objek pesan menjadi array agar view dapat mengaksesnya dengan notasi array.
     */
    protected function convertMessagesToArray(array $messages): array
    {
        return array_map(function ($message) {
            $content = $this->getMessageContent($message);

            if ($message instanceof UserMessage) {
                return [
                    'sender'  => 'user',
                    'avatar'  => 'U',
                    'content' => $content,
                ];
            } elseif ($message instanceof AssistantMessage) {
                return [
                    'sender'  => 'bot',
                    'avatar'  => 'B',
                    'content' => $content,
                ];
            }
            return [
                'sender'  => 'unknown',
                'avatar'  => '?',
                'content' => $content,
            ];
        }, $messages);
    }


}
