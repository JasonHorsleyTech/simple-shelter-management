<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-800 overflow-hidden">
    <div class="flex flex-col flex-nowrap h-[100vh]">
        <header class="bg-gray-600 py-4">
            <div class="md:max-w-6xl mx-auto grid place-content-center text-white text-2xl md:text-5xl">
                {{ $header ?? 'Example app' }}
            </div>
        </header>

        <div class="grow md:py-8 md:max-w-6xl mx-auto grid text-white w-full">
            {{ $slot }}
        </div>

        <footer class="bg-gray-600 py-4">
            <div class="md:max-w-6xl mx-auto grid place-content-center text-white md:text-xl">
                {{ $footer ?? 'For composer package development purposes' }}
            </div>
        </footer>
    </div>
</body>

</html>
