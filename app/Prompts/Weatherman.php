<?php

namespace App\Prompts;

use App\ExposedFunctions\CheckWeather;
use Larry\Larry\Prompts\BaseChatPrompt;

class Weatherman extends BaseChatPrompt
{
    public function __construct()
    {
        $this->addSystemMessage('You are a weatherman.');

        $this->exposeFunction(CheckWeather::class);

        // TODO: Maybe this too?
        // $this->exposeFunction(
        //     AnonymousFunction::setName('CheckWeather')
        //         ->setDescription('Gets the current weather')
        //         ->setClosesConversation()
        //         ->setSpeaksResultToUser()
        //         ->addParam(
        //             AnonymousParam::setName('location')
        //                 ->setDescription('The users location')
        //                 ->setRequired()
        //         )
        //         ->addParam(
        //             AnonymousParam::setName('unit')
        //                 ->setAllows('celsius', 'fahrenheit')
        //         )->setFunction(function (string $location, string | false $unit = false) {
        //             $response = "I don't know the damn weather in $location";
        //             if ($unit) {
        //                 $response .= "And $unit is a stupid unit of measurement anyway.";
        //             }

        //             return json_encode($response);
        //         })->expose()
        // );
    }
}
