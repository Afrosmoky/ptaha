@php
    $layout = $data['layout'] ?? 'text_left';
    $textFirst = $layout === 'text_left';
@endphp

<section class="section section-split">
    <div class="split">
        @if ($textFirst)
            {{-- TEKST --}}
            <div class="split-text">
                {!! $data['text'] ?? '' !!}
            </div>

            {{-- GALERIA STRONY --}}
            <div class="split-gallery">
                @include('sections.gallery', [
                    'page' => $page,
                    'columns' => 2,
                ])
            </div>
        @else
            {{-- GALERIA STRONY --}}
            <div class="split-gallery">
                <div class="split-gallery">
                    @include('sections.gallery', [
                        'page' => $page,
                        'columns' => 2,
                    ])
                </div>
            </div>

            {{-- TEKST --}}
            <div class="split-text">
                {!! $data['text'] ?? '' !!}
            </div>
        @endif
    </div>
</section>
