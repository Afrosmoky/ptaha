@php
    $record = $getRecord();
@endphp

@if ($record && $record->hasMedia('gallery'))
    <div class="mb-4">
        <p class="text-sm text-gray-500 mb-2">Aktualna galeria strony</p>

        <div class="grid grid-cols-4 gap-4 mb-6">
            @foreach ($record->getMedia('gallery') as $media)
                <div class="grid grid-cols-4 gap-4">
                    <img
                        src="{{ $media->getUrl('thumb') }}"
                        class="w-full aspect-square object-cover rounded"
                    >

                    {{-- FILAMENT DELETE ACTION --}}
                    <x-filament::button
                        color="danger"
                        size="xs"
                        wire:click="deleteMedia({{ $media->id }})"
                        wire:loading.attr="disabled"
                    >
                        Usuń
                    </x-filament::button>
                </div>
            @endforeach
        </div>
{{--        <x-filament::button--}}
{{--            color="gray"--}}
{{--            wire:click="openReorderModal"--}}
{{--        >--}}
{{--            Zmień kolejność zdjęć--}}
{{--        </x-filament::button>--}}
    </div>
@endif
