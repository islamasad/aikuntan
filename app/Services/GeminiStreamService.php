<?php

namespace App\Services;

use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use Illuminate\Support\Facades\Log;
use Generator;

class GeminiStreamService
{
    public function generateStream(array $messages): Generator
    {
        try {
            // Panggil API Gemini dan dapatkan response
            $response = Prism::text()
                ->using(Provider::Gemini, 'gemini-2.0-flash')
                ->withMaxSteps(2)
                ->withMessages($messages)
                ->asText();

            // Konversi teks menjadi array potongan untuk stream
            $chunks = explode(' ', $response->text); // Simulasi pemisahan per kata

            foreach ($chunks as $chunk) {
                yield $chunk; // Stream setiap potongan
                usleep(200000); // Simulasi delay
            }
        } catch (\Throwable $e) {
            Log::error('Gemini Stream Error:', ['error' => $e->getMessage()]);
            yield 'Terjadi kesalahan saat streaming.';
        }
    }
}
