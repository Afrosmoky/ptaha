<section>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-start">

        {{-- TEKST --}}
        <div
            class="
                {{ ($data['image_position'] ?? 'right') === 'left'
                    ? 'md:order-2'
                    : 'md:order-1'
                }}
            "
        >
            <div class="cms-content">
                {!! $data['content'] !!}
            </div>
        </div>

        {{-- OBRAZ --}}
        <figure
            class="
                {{ ($data['image_position'] ?? 'right') === 'left'
                    ? 'md:order-1'
                    : 'md:order-2'
                }}
            "
        >
            <img
                src="{{ $section->getFirstMediaUrl('image') }}"
                alt=""
                class="w-full"
            >

            @if (!empty($data['caption']))
                <figcaption class="mt-4 text-sm text-neutral-500">
                    {{ $data['caption'] }}
                </figcaption>
            @endif
        </figure>

    </div>
</section>
