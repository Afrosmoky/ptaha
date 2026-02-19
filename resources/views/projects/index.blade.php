@extends('layouts.layout')

@section('content')

    <h1 class="text-4xl font-bold mb-16 text-center">
        Projekty
    </h1>

    <div class="grid md:grid-cols-2 gap-16">

        @foreach ($types as $type)
            @php
                $project = \App\Models\Project::where('type', $type->type)
                    ->where('is_published', true)
                    ->first();
            @endphp

            <a href="{{ route('projects.type', $type->type) }}"
               class="group block">

                <div class="relative overflow-hidden">

                    <img
                        src="{{ $project->getFirstMediaUrl('hero') }}"
                        class="w-full h-[500px] object-cover transition duration-700 group-hover:scale-105"
                    >

                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition duration-500"></div>

                    <div class="absolute bottom-8 left-8 text-white">
                        <h2 class="text-3xl font-semibold">
                            {{ $type->type === 'building' ? 'Budynki' : 'Wnętrza' }}
                        </h2>
                    </div>

                </div>
            </a>

        @endforeach

    </div>

@endsection
