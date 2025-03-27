<?php

namespace App\Services;

use Prism\Prism\Prism;
use Prism\Prism\Enums\Provider;
use Prism\Prism\ValueObjects\Messages\UserMessage;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeminiService
{
    public function generate(array $messages)
    {
        try {
            $response = Prism::text()
                ->using(Provider::Gemini, 'gemini-2.0-flash')
                ->withMessages($messages) // Menggunakan message chain
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
}
