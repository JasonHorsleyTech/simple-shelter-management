<x-layout>
    @php
        $links = [
            [
                'url' => 'feature/converse',
                'type' => 'converse',
                'shortDescription' => 'Opened ended conversation',
                'longDescription' => "Speech to chat responds as it usually does, maybe with some additional custom 'styling' or 'context'.",
            ],
            // [
            //     'url' => 'feature/formfill',
            //     'type' => 'formfill',
            //     'shortDescription' => 'Form dictation',
            //     'longDescription' => 'Speech to text to JSON to prefilled form. If partial, can optionally engage in followup questions to complete.',
            // ],
            // [
            //     'url' => 'feature/navigate',
            //     'type' => 'navigate',
            //     'shortDescription' => 'Site navigation',
            //     'longDescription' => "Speech to you're where you need to be (with proper state)",
            // ],
            // [
            //     'url' => 'feature/inquire',
            //     'type' => 'inquire',
            //     'shortDescription' => 'Analytics on the fly',
            //     'longDescription' => 'Speech to a raw SQL query to an answer',
            // ],
            // [
            //     'url' => 'feature/audit',
            //     'type' => 'audit',
            //     'shortDescription' => 'Nightly audits',
            //     'longDescription' => 'Cron jobs that run multiple slow sort queries and greet you the next morning with results.',
            // ],
            // [
            //     'url' => 'feature/execute',
            //     'type' => 'execute',
            //     'shortDescription' => 'Reversible actions',
            //     'longDescription' => 'Voice initiated actions that execute on timer/next interaction, assuming no objection.',
            // ],
        ];
    @endphp

    <div class="grid gap-y-2">
        <h1 class="text-3xl font-bold underline">
            Static links with real GPT calls.
        </h1>

        <ul class="list-disc">
            @foreach ($links as $link)
                <a href="{{ $link['url'] }}" class="block py-2 border-b hover:border-blue-500 cursor-pointer border-transparent underline-none">
                    <p class="flex items-baseline text-blue-300 gap-x-1">
                        <p class="uppercase text-xl">{{ $link['type'] }}: </p>
                        <p>{{ $link['shortDescription'] }}</p>
                    </p>
                    <span class="text-xs">{{ $link['longDescription'] }}</span>
                </a>
            @endforeach
        </ul>
    </div>
</x-layout>
