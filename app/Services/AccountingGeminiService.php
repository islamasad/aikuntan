<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AccountingGeminiService extends GeminiService
{
    protected function prepareAccountingPrompt(string $prompt): array
    {
        return [
            [
                'role' => 'user',
                'parts' => [
                    ['text' => config('chat.accounting_system_prompt')],
                    ['text' => $prompt]
                ]
            ]
        ];
    }

    public function processAccountingPrompt(string $prompt): array
    {
        try {
            $contents = $this->prepareAccountingPrompt($prompt);
            $response = $this->generateContent($contents);
            
            \Log::channel('gemini')->debug('Raw Accounting Response', [
                'response' => $response
            ]);

            return $this->parseAccountingResponse($response);
            
        } catch (\Exception $e) {
            \Log::channel('gemini')->error('Accounting Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return ['error' => 'Terjadi kesalahan akuntansi'];
        }
    }

    protected function parseAccountingResponse(array $response): array
{
    try {
        $text = $response['candidates'][0]['content']['parts'][0]['text'] ?? '';
        
        // Bersihkan karakter khusus
        $cleanedText = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $text);
        
        // Deteksi pola missing data
        if (preg_match('/"missing_data"/i', $cleanedText)) {
            return $this->handleMissingDataResponse($cleanedText);
        }
        
        // Deteksi journal entries
        if (preg_match('/"journal_entries"/i', $cleanedText)) {
            return $this->handleSuccessResponse($cleanedText);
        }
        
        throw new \Exception('Format respons tidak dikenali');
        
    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage(),
            'raw_response' => $cleanedText ?? $text
        ];
    }
}

private function handleMissingDataResponse(string $text): array
{
    $pattern = '/{(.*?)}/s';
    preg_match($pattern, $text, $matches);
    
    if (empty($matches)) {
        throw new \Exception('Format permintaan data tambahan tidak valid');
    }
    
    $decoded = json_decode($matches[0], true);
    
    if (!isset($decoded['missing_data']['fields'])) {
        throw new \Exception('Struktur missing data tidak valid');
    }
    
    return [
        'type' => 'data_required',
        'missing_data' => $decoded['missing_data'],
        'example_question' => $decoded['example_question'] ?? 'Bisa lengkapi data berikut?'
    ];
}

private function handleSuccessResponse(string $text): array
{
    $pattern = '/{(.*?)}/s';
    preg_match($pattern, $text, $matches);
    
    $decoded = json_decode($matches[0], true);
    
    return [
        'type' => 'success',
        'journal_entries' => $decoded['journal_entries'],
        'educational_note' => $decoded['educational_note'] ?? 'Penjelasan tambahan tentang transaksi ini'
    ];
}
}