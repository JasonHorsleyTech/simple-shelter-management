<?php

namespace App\Http\Controllers;

use App\Components\SimpleAssistant;
use Illuminate\Http\Request;
use Larry\Larry\Controllers\ChatController;
use Larry\Larry\Components\ChatComponent;

class VanillaGPTController extends ChatController
{
    public function getPrompt(): ChatComponent
    {
        return new SimpleAssistant();
    }
}
