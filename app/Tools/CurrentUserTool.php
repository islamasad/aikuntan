<?php

namespace App\Tools;

use Prism\Prism\Facades\Tool;

class CurrentUserTool
{
    public static function make()
    {
        return Tool::as('current_user')
            ->for('Return the current logged in user name')
            // Tanpa parameter, tool langsung mengambil nama user dari Auth
            ->using(function (): string {
                return Auth::user()->name;
            });
    }
}
