<x-layout>
    <div class="grid gap-y-2">
        <ul class="list-disc">
            @foreach ($assistants as $assistant)
                <p class="text-xl">
                    <span class="uppercase">{{ $assistant['name'] }}:</span>
                    <span>{{ $assistant['description'] }}</span>
                </p>
                <p class="flex flex-wrap flex-row gap-x-2">
                    @foreach (['manual', 'converse'] as $inputMethod)
                        <a href="{{ route('assistants.show', [
                            'assistant' => $assistant['name'],
                            'inputMethod' => $inputMethod,
                        ]) }}" class="block text-blue-500 border-b hover:border-blue-500 cursor-pointer border-transparent underline-none">
                            {{ $inputMethod }}
                        </a>
                    @endforeach
                </p>
            @endforeach
        </ul>
    </div>
</x-layout>
