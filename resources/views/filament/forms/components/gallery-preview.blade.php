@php
    $record = $getRecord();
@endphp

@if ($record)
    <div class="grid grid-cols-4 gap-4 mb-6">
        @foreach ($record->getMedia('gallery') as $media)
            <div class="border rounded p-2 space-y-2">
                <img
                    src="{{ $media->getUrl('thumb') }}"
                    class="w-full h-auto rounded"
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
{{--            <x-filament::button--}}
{{--                color="gray"--}}
{{--                wire:click="openReorderModal"--}}
{{--            >--}}
{{--                Zmień kolejność zdjęć--}}
{{--            </x-filament::button>--}}
    </div>
@endif
