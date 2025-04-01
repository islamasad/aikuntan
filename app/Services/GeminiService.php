<?php

namespace App\Services;

use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Prism\Prism\ValueObjects\Messages\UserMessage;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;
use Carbon\Carbon;

class GeminiService
{
    public function generate(array $messages)
    {
        try {
            // Ambil base prompt yang sudah diproses
            $basePrompt = $this->getBasePrompt();

            // Konversi setiap pesan yang diterima menjadi instance UserMessage/AssistantMessage jika diperlukan
            $convertedMessages = array_map(function ($message) {
                if (is_array($message)) {
                    return new UserMessage($message['content'] ?? '');
                }
                return $message; // Jika sudah instance
            }, $messages);

            // Sisipkan pesan sistem sebagai konteks awal
            //array_unshift($convertedMessages, new UserMessage($basePrompt));

            // Panggil API
            $response = Prism::text()
                ->using(Provider::Gemini, 'gemini-2.0-flash')
                ->withMaxSteps(2)
                ->withMessages($convertedMessages)
                ->asText();

            return [
                'text' => Str::markdown($response->text),
                'finish_reason' => $response->finishReason->name,
                'usage' => [
                    'prompt_tokens' => $response->usage->promptTokens,
                    'completion_tokens' => $response->usage->completionTokens,
                ]
            ];
        } catch (\Throwable $e) {
            Log::error('Chat generation failed:', ['error' => $e->getMessage()]);
            return ['error' => 'Failed to generate response.'];
        }
    }

    protected function getBasePrompt()
    {
        // Variabel tambahan yang bisa kamu kembangkan
        $variables = [
            '{name}' => Auth::user()->name ?? 'Pengguna',
            '{date}' => Carbon::now()->translatedFormat('l, d F Y'), // contoh: Minggu, 30 Maret 2025
            '{language}'           => 'id',
            '{user_id}'            => Auth::id(),
            '{user_uuid}'          => Auth::user()->uuid ?? 'UUID tidak ditemukan',
            '{company_id}'         => optional(Auth::user()->company)->id ?? 'Company ID tidak ditemukan',
            '{company_name}'       => optional(Auth::user()->company)->name ?? 'Nama perusahaan tidak ditemukan',
            '{company_tax_number}' => optional(Auth::user()->company)->tax_number ?? 'Tax number tidak ditemukan',
            '{latest_reference_number}' => \DB::connection('accounting_db')
            ->table('transactions')
            ->orderBy('created_at', 'desc')
            ->value('reference_number') ?? 'INV-' . date('Y') . '-0000',   
            '{tips}' => '',
        ];

        // Isi prompt mentah dari config
        $basePrompt = config('promptv2.base_prompt');

        // Log base prompt sebelum replace untuk debugging
        //\Log::info('Original Base Prompt:', ['basePrompt' => $basePrompt]);

        foreach ($variables as $key => $value) {
            $basePrompt = str_replace($key, $value, $basePrompt);
        }

        \Log::info('Final Base Prompt:', ['basePrompt' => $basePrompt]);

        return $basePrompt;
    }

    public function getInitialPrompt(): string
    {
        return $this->getBasePrompt();
    }

}
