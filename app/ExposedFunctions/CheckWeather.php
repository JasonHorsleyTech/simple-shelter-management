<?php

namespace App\ExposedFunctions;

use Larry\Larry\ExposedFunctions\BaseExposedFunction;

class CheckWeather extends BaseExposedFunction
{
    public static string $name = 'CheckWeather';
    public static string $description = "Gets the current weather";
    public static bool $closesConversation = false;
    public static bool $speaksResultToUser = false;

    public static array $params = [
        'location' => [
            'description' => 'The location to check the weather for',
            'type' => 'string',
            'required' => true,
        ],
        'unit' => [
            'type' => 'string',
            'enum' => ['celsius', 'fahrenheit'],
        ]
    ];

    public function execute(string $location, $unit = 'celsius'): string
    {
        return json_encode([
            'temperature' => '72f',
            'precipitation' => 'rainy',
        ]);
    }
}
