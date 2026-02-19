<section class="section section-cta text-right">
    <div>
        @if (!empty($data['headline']))
{{--            <h2>{{ $data['headline'] }}</h2>--}}
        @endif

        @if (!empty($data['text']))
{{--            <p>{{ $data['text'] }}</p>--}}
        @endif

        @if (!empty($data['button_text']) && !empty($data['button_url']))
            <a href="{{ $data['button_url'] }}">
                {{ $data['button_text'] }}
            </a>
        @endif
    </div>
</section>
