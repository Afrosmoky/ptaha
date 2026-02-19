<x-filament::modal
    id="reorder-media"
    width="4xl"
    wire:model="isReorderModalOpen"
>
    <x-slot name="heading">
        Zmień kolejność zdjęć
    </x-slot>

    <ul
        wire:sortable="mediaOrder"
        class="grid grid-cols-4 gap-4"
    >
        @foreach ($this->mediaOrder as $mediaId)
            @php
                $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($mediaId);
            @endphp

            <li
                wire:sortable.item="{{ $mediaId }}"
                wire:key="media-{{ $mediaId }}"
                class="border rounded p-2 cursor-move bg-white"
            >
                <img
                    src="{{ $media->getUrl('thumb') }}"
                    class="w-full rounded"
                >
            </li>
        @endforeach
    </ul>

    <x-slot name="footer">
        <x-filament::button
            color="gray"
            wire:click="$set('isReorderModalOpen', false)"
        >
            Anuluj
        </x-filament::button>

        <x-filament::button
            color="primary"
            wire:click="saveMediaOrder"
        >
            Zapisz kolejność
        </x-filament::button>
    </x-slot>
</x-filament::modal>
