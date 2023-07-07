<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-800">
    <div class="flex flex-col flex-nowrap h-screen">
        <header class="bg-gray-600 py-4">
            <div class="max-w-6xl mx-auto grid place-content-center text-white text-5xl">
                {{ $header ?? 'Example app' }}
            </div>
        </header>

        <div class="grow py-8 max-w-6xl mx-auto grid text-white">
            {{ $slot }}
        </div>

        <footer class="bg-gray-600 py-4">
            <div class="max-w-6xl mx-auto grid place-content-center text-white text-xl">
                {{ $footer ?? 'For composer package development purposes' }}
            </div>
        </footer>
    </div>
</body>

</html>
