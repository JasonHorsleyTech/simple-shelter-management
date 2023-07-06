<?php

namespace App\Http\Controllers;

use App\Components\SimpleAssistant;
use Illuminate\Http\Request;
use Larry\Larry\Components\ChatComponent;
use Larry\Larry\Controllers\ChatController;
use Larry\Larry\LarryController;

class GreeterController extends ChatController
{
    public function getPrompt(): ChatComponent
    {
        // Without specifying anything else, new ChatComponent is vanilla GPT3.5
        return new ChatComponent();

        // Add something custom inline
        // return (new ChatComponent())->addSystemMessage('Greet the user by their first name. Find out if you do not know.');

        // Add a large prompt via blade
        return (new ChatComponent())->addSystemMessage(view('prompts.greeter'));

        // Or extend the class and build the prompt in the constructor
        // return new SimpleAssistant();
    }
}
