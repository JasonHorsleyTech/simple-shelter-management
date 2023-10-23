<?php

namespace App\Prompts;

use App\Http\Requests\UserSignupForm;
use Larry\Larry\Prompts\BaseChatPrompt;

class UserSignup extends BaseChatPrompt
{
    public $functionCall = 'auto';

    public function __construct()
    {
        $this->addSystemMessage('You analyze voice transcripts and pre-fill web forms for a laravel backend.');
        $this->addSystemMessage('Given the following voice-to-text transcription, return a JSON object that can be used to prefill the form.');
        $this->addSystemMessage('The JSON does not have to be complete; If a value cannot be inferred from the transcript, keep it out of the JSON.');
    }
}
