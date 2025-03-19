<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChatBubble extends Component
{
    public $sender;

    public $contentType;

    public $avatar;

    public $align;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $sender,
        string $contentType = 'text',
        string $avatar = 'AZ',

    ) {
        $this->sender = $sender;
        $this->contentType = $contentType;
        $this->avatar = $avatar;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chat-bubble');
    }
}
