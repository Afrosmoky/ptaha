@extends('layouts.layout')

@section('content')

    <h1 class="text-4xl font-bold mb-16 text-center">
        {{ $type === 'building' ? 'Budynki' : 'Wnętrza' }}
    </h1>

    <div class="grid md:grid-cols-3 gap-8">

        @foreach ($projects as $project)
            @foreach ($project->getMedia('gallery') as $media)

                <a href="{{ $media->getUrl() }}"
                   class="glightbox block overflow-hidden group cursor-zoom-in">

                    <img
                        src="{{ $media->getUrl('thumb') }}"
                        class="w-full aspect-square object-cover transition duration-500 ease-out group-hover:scale-105"
                    >

                </a>

            @endforeach
        @endforeach

    </div>

@endsection
