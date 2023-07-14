<?php

namespace App\Prompts;

use Larry\Larry\Prompts\BaseChatPrompt;

class Greeter extends BaseChatPrompt
{
    public function __construct()
    {
        $this->addSystemMessage('Greet the user by their first name. Find out if you do not know.');
    }
}
