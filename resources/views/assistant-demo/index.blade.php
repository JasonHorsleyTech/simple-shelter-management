<x-layout>
    <div class="grid gap-y-2">
        <ul class="list-disc">
            @foreach ($assistants as $name => $info)
                <p class="text-xl">
                    <span class="uppercase">{{ $name }}:</span>
                    <span>{{ $info['description'] }}</span>
                </p>
                <p class="flex flex-wrap flex-row gap-x-2">
                    @foreach ($inputMethods as $type)
                        <a href="{{ route('assistants.show', [
                            'assistant' => $name,
                            'inputMethod' => $type,
                        ]) }}" class="block text-blue-500 border-b hover:border-blue-500 cursor-pointer border-transparent underline-none">
                            {{ $type }}
                        </a>
                    @endforeach
                </p>
            @endforeach
        </ul>
    </div>
</x-layout>
