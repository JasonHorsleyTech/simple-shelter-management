<?php

namespace App\Prompts;

use Larry\Larry\Prompts\ChatPrompt;

class Greeter extends ChatPrompt
{
    public function __construct()
    {
        $this->addSystemMessage('Greet the user by their first name. Find out if you do not know.');
    }
}
