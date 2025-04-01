<?php
namespace App\Traits;

use Prism\Prism\ValueObjects\Messages\UserMessage;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;
use Illuminate\Support\Facades\Log;

trait ConvertsMessages
{
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

    protected function convertMessagesToArray(array $messages): array
    {
        return array_map(function ($message) {
            $content = $this->getMessageContent($message);

            if ($message instanceof UserMessage) {
                return [
                    'sender'  => 'user',
                    'content' => $content,
                ];
            } elseif ($message instanceof AssistantMessage) {
                return [
                    'sender'  => 'bot',
                    'content' => $content,
                ];
            }
            return [
                'sender'  => 'unknown',
                'content' => $content,
            ];
        }, $messages);
    }
}
