@extends('layouts.app')

@section('content')
    <article class="prose max-w-none">
        <h1>{{ $project->title }}</h1>

        @if($project->description)
            <p>{{ $project->description }}</p>
        @endif
    </article>
@endsection
