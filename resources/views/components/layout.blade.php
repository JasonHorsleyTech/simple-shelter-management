<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body>
    <div class="bg-gray-800 flex flex-col flex-nowrap h-screen overflow-hidden">
        <header class="bg-gray-600 py-4">
            <div class="max-w-6xl mx-auto grid place-content-center text-white text-5xl">
                {{ $header ?? 'Example app' }}
            </div>
        </header>

        <div class="grow p-4 max-w-6xl mx-auto grid text-white">
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
