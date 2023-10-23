<?php

namespace App\Http\Controllers;

use App\Prompts\Greeter;
use App\Prompts\Weatherman;
use App\Prompts\UserSignup;

class AssistantsDemoController extends Controller
{
    private array $assistants = [];

    public function __construct()
    {
        $this->assistants = [
            [
                'name' => 'greeter',
                'route' => route('api.larry.conversation.create', ['prompt' => Greeter::class]),
                'description' => 'Greet the user',
            ],
            [
                'name' => 'weather',
                'route' => route('api.larry.conversation.create', ['prompt' => Weatherman::class]),
                'description' => 'Tells the user what the weather is.',
            ],
            [
                'name' => 'user-signup',
                'route' => route('api.larry.conversation.create', ['prompt' => UserSignup::class]),
                'description' => 'Tells the user what the weather is.',
            ],
        ];
    }

    public function index()
    {
        return view('assistant-demo.index', [
            'assistants' => $this->assistants,
        ]);
    }

    public function show(string $assistantKey, string $inputMethod)
    {
        $assistant = collect($this->assistants)->firstWhere('name', $assistantKey);
        if (!$assistant) {
            abort(404);
        }
        return view('assistant-demo.show', compact('assistant', 'inputMethod'));
    }
}
