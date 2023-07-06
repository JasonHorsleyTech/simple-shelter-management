<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Larry\Larry\Components\ChatComponent;
use Larry\Larry\Controllers\ChatController;
use Larry\Larry\LarryController;

class ExchangeController extends ChatController
{
    public function getPrompt(): ChatComponent
    {
        return new ChatComponent();
    }
}
