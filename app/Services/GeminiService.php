<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    public function generateContent(array $contents): array
    {
        $apiKey = config('services.gemini.api_key');
        $model = 'gemini-2.0-flash';

        Log::channel('gemini')->debug('Attempting Gemini API Request', [
            'contents' => $contents,
            'model' => $model,
            'key' => substr($apiKey, 0, 5).'...',
        ]);

        try {
            $response = Http::baseUrl('https://generativelanguage.googleapis.com/v1beta/models/')
                ->withQueryParameters(['key' => $apiKey])
                ->timeout(30)
                ->retry(3, 100, function ($exception) {
                    // ... kode sebelumnya
                })
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post("{$model}:generateContent", [
                    'contents' => $contents,
                    'generationConfig' => [
                        'responseMimeType' => 'application/json'
                    ]
                ]);

            Log::channel('gemini')->debug('Raw API Response', [
                'status' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
            ]);

            if ($response->failed()) {
                Log::channel('gemini')->error('API Request Failed', [
                    'status' => $response->status(),
                    'error' => $response->json(),
                ]);
                return ['error' => $response->json()];
            }

            $responseData = $response->json();

            if (!isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                Log::channel('gemini')->warning('Unexpected API Response Structure', [
                    'response' => $responseData,
                ]);
            }

            return $responseData;

        } catch (RequestException $e) {
            Log::channel('gemini')->error('API Request Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return ['error' => $e->getMessage()];
        }
    }

    public function generateSimpleTextPrompt(string $prompt): array
    {
        return $this->generateContent([
            [
                'parts' => [
                    ['text' => $prompt]
                ]
            ]
        ]);
    }
}