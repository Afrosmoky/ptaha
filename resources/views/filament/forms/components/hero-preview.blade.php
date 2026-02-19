@php
    $record = $getRecord();
    $media = $record?->getFirstMedia('hero');
@endphp

@if ($media)
    <div class="mb-4 relative inline-block">
        <img
            src="{{ $media->getUrl('thumb') }}"
            class="w-full h-auto rounded"
        >

        <x-filament::button
            color="danger"
            size="xs"
            wire:click="deleteMedia({{ $media->id }})"
            wire:loading.attr="disabled"
        >
            Usuń
        </x-filament::button>
    </div>
@endif
