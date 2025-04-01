<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use Prism\Prism\ValueObjects\Messages\UserMessage;

class ChatHistoryService
{
    protected GeminiService $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Mengambil chat history dari session.
     * Jika belum ada, inisialisasi dengan base prompt.
     */
    public function getHistory(): array
    {
        $history = session('chat_history', []);
        if (empty($history)) {
            $basePrompt = $this->geminiService->getInitialPrompt();
            // Tambahkan base prompt hanya sekali
            $history[] = new UserMessage($basePrompt);
            session(['chat_history' => $history]);
        }
        return $history;
    }


    /**
     * Menambahkan pesan baru ke chat history dan menyimpannya ke session.
     */
    public function addMessage($message): array
    {
        $history = $this->getHistory();
        $history[] = $message;
        session()->put('chat_history', $history);
        session()->save();
        return $history;
    }

    /**
     * Menghapus seluruh chat history.
     */
    public function clearHistory(): void
    {
        session()->forget('chat_history');
    }
}
