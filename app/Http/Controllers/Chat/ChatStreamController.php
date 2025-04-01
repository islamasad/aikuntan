<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Services\GeminiStreamService;
use App\Services\ChatHistoryService;
use Prism\Prism\ValueObjects\Messages\UserMessage;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;
use App\Traits\ConvertsMessages;

class ChatStreamController extends Controller
{
    use ConvertsMessages;

    protected GeminiStreamService $geminiStreamService;
    protected ChatHistoryService $chatHistoryService;

    public function __construct(GeminiStreamService $geminiStreamService, ChatHistoryService $chatHistoryService)
    {
        $this->geminiStreamService = $geminiStreamService;
        $this->chatHistoryService = $chatHistoryService;
    }

    public function stream(Request $request)
{
    try {
        $prompt = base64_decode($request->prompt);
    } catch (\Throwable $e) {
        \Log::error('Invalid prompt encoding', ['error' => $e->getMessage()]);
        abort(400);
    }

    $request->merge(['prompt' => $prompt]);
    $request->validate(['prompt' => 'required|string']);

    $response = new StreamedResponse(function () {
        // Bersihkan semua buffer
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // Konfigurasi header
        header('X-Accel-Buffering: no');
        header('Content-Encoding: none');
        ini_set('output_buffering', '0');
        ini_set('zlib.output_compression', 0);
        
        $finalResponse = '';
        $isMessageSaved = false;
        $chatHistory = $this->chatHistoryService->getHistory();

        try {
            foreach ($this->geminiStreamService->generateStream($chatHistory) as $chunk) {
                $finalResponse .= $chunk . ' '; // Tambahkan spasi di setiap chunk
                echo "data: " . json_encode(['message' => $chunk . ' ']) . "\n\n";
                
                // Hanya flush tanpa ob_flush()
                if (connection_status() == CONNECTION_NORMAL) {
                    flush();
                }
            }

            // Simpan response utuh
            $this->chatHistoryService->addMessage(
                new AssistantMessage(trim($finalResponse))
            );

        } catch (\Throwable $e) {
            \Log::error('Stream error: ' . $e->getMessage());
        } finally {
            // Pastikan tidak ada buffer tersisa
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
        }
    }, 200, [
        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
    ]);

    return $response;
}

}
