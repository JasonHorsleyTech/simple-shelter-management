<x-layout>
    <div id="app" class="">
        <assistant-demo :assistant="{{ json_encode($assistant) }}" :input-method="{{ json_encode($inputMethod) }}"></assistant-demo>
    </div>

    @vite('resources/js/app.js')
</x-layout>
