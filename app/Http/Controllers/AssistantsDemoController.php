<?php

namespace App\Http\Controllers;

use App\Prompts\Greeter;

use Larry\Larry\Prompts\ChatPrompt;
use Larry\Larry\Controllers\ChatController;

class AssistantsDemoController extends ChatController
{
    // TODO: These map to prompts
    public static array $assistants = [
        'greeter' => [
            'prompt' => Greeter::class,
            'description' => 'Greet the user',
        ],
    ];
    public string | null $assistantKey;
    public ChatPrompt | null $prompt;

    // Determines vue component to use
    public static array $inputMethods = [
        // Can write your own front end implementation, following the defined network pattern
        'manual',
        // Can drop in a ready made vue component.
        'converse'
    ];

    public string | null $inputMethod;

    public function getPrompt(): ChatPrompt
    {
        return $this->prompt;
    }

    public function __construct()
    {
        $this->assistantKey = request()->route('assistant') ?? null;
        $className = self::$assistants[$this->assistantKey]['prompt'] ?? null;
        if ($className) {
            $this->prompt = new $className();
        }
        $this->inputMethod = request()->route('inputMethod');
    }

    public function index()
    {
        return view('assistant-demo.index', [
            'assistants' => self::$assistants,
            'inputMethods' => self::$inputMethods,
        ]);
    }

    public function show()
    {
        return view('assistant-demo.show', [
            'assistant' => $this->assistantKey,
            'inputMethod' => $this->inputMethod,
        ]);
    }
}
