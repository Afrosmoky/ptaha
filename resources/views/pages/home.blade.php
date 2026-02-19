@extends('layouts.app')

@section('content')
    @if($page)
        <article class="prose max-w-none">
            {!! $page->content !!}
        </article>

        <x-external-links />
    @else
        <h1>PTAHA</h1>
        <p>Strona główna nie została jeszcze opublikowana.</p>
    @endif
@endsection
