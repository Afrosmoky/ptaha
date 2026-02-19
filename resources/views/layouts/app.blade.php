<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>{{ $page->seo_title ?? $page->title ?? 'PTAHA' }}</title>
    <meta name="description" content="{{ $page->seo_description ?? '' }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>


<body class="bg-white text-gray-900">

<header class="border-b">
{{--    <nav class="container mx-auto flex gap-6 py-4">--}}
{{--        <a href="{{ route('home') }}">Home</a>--}}
{{--        <a href="{{ route('page.show', 'o-nas') }}">O nas</a>--}}
{{--        <a href="{{ route('projects.index') }}">Projektowanie</a>--}}
{{--        <a href="{{ route('page.show', 'budowa') }}">Budowa</a>--}}
{{--        <a href="{{ route('page.show', 'kontakt') }}">Kontakt</a>--}}
{{--    </nav>--}}
    <nav class="container mx-auto flex gap-6 py-4">
        @foreach ($mainMenu as $item)
            <a
                href="{{ $item->href }}"
                @class([
                    'font-semibold underline' => $item->isActive(),
                ])
            >
                {{ $item->label }}
            </a>
        @endforeach
    </nav>
</header>


<main class="container mx-auto py-10 animate-fade-in">
    @yield('content')
</main>

<footer class="border-t py-6 text-center text-sm text-gray-500">
    © {{ date('Y') }} PTAHA
</footer>

@stack('scripts')

<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            zoomable: false,
        });
    });
</script>
</body>
</html>
