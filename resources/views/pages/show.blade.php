@extends('layouts.layout')

@section('content')
    <section class="py-4">
        <div class="max-w-[1080px] mx-auto">
            <h1 class="text-4xl font-light mb-6">
                {{ $page->title }}
            </h1>

            <div class="cms-content">
                {!! $page->content !!}


                {{-- SEKCJE CMS --}}
                @if ($page->sections->count())
                    @foreach ($page->sections as $section)
                        @includeIf(
                            'sections.' . $section->type,
                            [
                                'data' => $section->data,
                                'page' => $page,
                            ]
                        )
                    @endforeach
                @endif

                @if ($page->slug === 'kontakt')
                    @include('partials.contact-form')
                @endif
            </div>
        </div>
    </section>
@endsection
