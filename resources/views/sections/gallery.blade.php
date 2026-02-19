@php
    $mediaItems = $page
        ->getMedia('gallery')
        ->sortBy('order_column');
@endphp

@if ($mediaItems->isNotEmpty())
    <div class="flex flex-wrap gap-4 items-start">
        @foreach ($mediaItems as $media)
            <a
                href="{{ $media->getUrl() }}"
                class="glightbox block"
                data-gallery="page-gallery"
            >
                <img
                    src="{{ $media->getUrl('thumb') }}"
                    class="block max-h-[100px] w-auto rounded"
                    loading="lazy"
                >
            </a>
        @endforeach
    </div>
@endif
