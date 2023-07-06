<?php

namespace App\Components;

use Larry\Larry\Components\ChatComponent;

class SimpleAssistant extends ChatComponent
{
    public function __construct()
    {
        $this->addSystemMessage('Greed the user by their first name. Find out if you do not know.');
    }
}
