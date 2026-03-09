<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>{{ $page->seo_title ?? $page->title ?? 'PTAHA' }}</title>
    <meta name="description" content="{{ $page->seo_description ?? '' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <script src="https://unpkg.com/lucide@latest"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="bg-white text-neutral-900 antialiased">
{{-- INTRO OVERLAY --}}
<div id="intro-overlay"
     class="fixed inset-0 bg-black z-[9999] flex items-center justify-center">

    <video id="intro-video"
           class="w-full h-full object-cover"
           autoplay
           muted
           playsinline
           preload="metadata">

        <source src="{{ asset('videos/intro.mp4') }}" type="video/mp4">
    </video>

    {{-- Delikatna nakładka --}}
    <div class="absolute inset-0 bg-black/40 pointer-events-none"></div>

    {{-- Przycisk Pomiń --}}
    <button id="skip-intro"
            class="absolute top-6 right-6 text-white text-sm uppercase tracking-widest
                   border px-6 py-2 hover:bg-white hover:text-black transition">
        Pomiń
    </button>

</div>

<header>
    <div class="max-w-[1080px] xl:max-w-[1200px] mx-auto py-6">

        {{-- SOCIAL (desktop only) --}}
        <div class="hidden lg:flex justify-end gap-4 text-sm mb-8">
            <a href="#" class="text-black hover:opacity-70
          hover:-translate-y-1
          transition-transform duration-200">
                <i data-lucide="youtube" class="w-5 h-5"></i>
            </a>

            <a href="#" class="text-black hover:opacity-70
          hover:-translate-y-1
          transition-transform duration-200">
                <i data-lucide="instagram" class="w-5 h-5"></i>
            </a>

            <a href="#" class="text-black hover:opacity-70
          hover:-translate-y-1
          transition-transform duration-200">
                <i data-lucide="facebook" class="w-5 h-5"></i>
            </a>

            <a href="#" class="text-black hover:opacity-70
          hover:-translate-y-1
          transition-transform duration-200">
                <i data-lucide="twitter" class="w-5 h-5"></i>
            </a>

            <a href="#" class="text-black hover:opacity-70
          hover:-translate-y-1
          transition-transform duration-200">
                <i data-lucide="linkedin" class="w-5 h-5"></i>
            </a>
        </div>

        {{-- LOGO ROW --}}
        <label for="mobile-menu-toggle"
               class="flex items-center justify-center gap-10 mb-6 cursor-pointer md:cursor-default">

            {{-- BURGER --}}
            <div class="flex items-center justify-center h-[96px] w-[64px]">
                <div class="space-y-2">
                    <span class="block h-[14px] w-[100px] bg-black"></span>
                    <span class="block h-[14px] w-[100px] bg-black"></span>
                    <span class="block h-[14px] w-[100px] bg-black"></span>
                </div>
            </div>

            {{-- LOGO --}}
            <div class="text-4xl md:text-8xl font-bold uppercase tracking-[0.25em] md:tracking-[0.35em] leading-none">
                PTAHA
            </div>
        </label>

        {{-- DIVIDER --}}
        <div class="mx-auto border-t-4 border-black w-full md:w-[1080px] mb-2"></div>

        {{-- DESKTOP NAV --}}
        <nav class="hidden md:flex justify-center gap-10 text-sm uppercase tracking-widest mt-2">
            @foreach($mainMenu as $item)
                @if($item->children->isNotEmpty())
                    <div class="relative group">
                        <button
                            class="whitespace-nowrap uppercase px-5 py-2
                            {{ $item->isActive() ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
                            {{ $item->label }}
                        </button>

                        <div class="absolute left-0 top-full pt-2 min-w-max bg-white shadow-lg
                                    opacity-0 invisible
                                    group-hover:opacity-100 group-hover:visible
                                    transition duration-200 z-50 rounded-md border border-neutral-200">
                            @foreach($item->children as $child)
                                <a href="{{ $child->href }}"
                                   class="block px-4 py-2 hover:bg-neutral-100 whitespace-nowrap">
                                    {{ $child->label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $item->href }}"
                       class="whitespace-nowrap px-5 py-2 text-black no-underline
                       {{ $item->isActive() ? 'bg-gray-200' : 'hover:bg-gray-200' }}">
                        {{ $item->label }}
                    </a>
                @endif
            @endforeach
        </nav>

    </div>
</header>

{{-- MOBILE OVERLAY --}}
    <input type="checkbox"
       id="mobile-menu-toggle"
       class="hidden peer"
       autocomplete="off">
    <div id="mobile-overlay" class="mobile-overlay fixed inset-0 bg-white z-50
            flex-col items-center justify-center
            space-y-10 text-2xl uppercase tracking-widest">

        <div class="flex flex-col items-center justify-center
                    space-y-10 text-2xl uppercase tracking-widest
                    h-full">

        {{-- CLOSE BUTTON --}}
        <label for="mobile-menu-toggle"
               class="absolute top-6 right-6 text-3xl cursor-pointer">
            ✕
        </label>

            @foreach($mainMenu as $item)

                @if($item->children->isNotEmpty())

                    <details class="text-center">
                        <summary class="cursor-pointer list-none">
                            {{ $item->label }}
                        </summary>

                        <div class="mt-4 space-y-4 text-lg">
                            @foreach($item->children as $child)
                                <a href="{{ $child->href }}" class="block">
                                    {{ $child->label }}
                                </a>
                            @endforeach
                        </div>
                    </details>

                @else

                    <a href="{{ $item->href }}">
                        {{ $item->label }}
                    </a>

                @endif

            @endforeach

        {{-- SOCIAL (mobile) --}}
        <div class="flex gap-6 text-base mt-10">
            <a href="#" class="text-black hover:opacity-70 transition">
                <i data-lucide="youtube" class="w-5 h-5"></i>
            </a>

            <a href="#" class="text-black hover:opacity-70 transition">
                <i data-lucide="instagram" class="w-5 h-5"></i>
            </a>

            <a href="#" class="text-black hover:opacity-70 transition">
                <i data-lucide="facebook" class="w-5 h-5"></i>
            </a>

            <a href="#" class="text-black hover:opacity-70 transition">
                <i data-lucide="twitter" class="w-5 h-5"></i>
            </a>

            <a href="#" class="text-black hover:opacity-70 transition">
                <i data-lucide="linkedin" class="w-5 h-5"></i>
            </a>
        </div>
        </div>
    </div>


<main class="max-w-[1080px] xl:max-w-[1200px] mx-auto px-6 animate-fade-in">
    @yield('content')
</main>

<footer class="border-t mt-12 max-w-[1080px] xl:max-w-[1200px] mx-auto">
    <div class="max-w-7xl mx-auto px-6 py-6 text-sm text-neutral-500 text-center">
        © {{ date('Y') }} PTAHA
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        GLightbox({
            selector: '.glightbox'
        });
    });
</script>
<script>
    lucide.createIcons();
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const intro = document.getElementById('intro-overlay');
        const video = document.getElementById('intro-video');
        const skip  = document.getElementById('skip-intro');

        // jeśli już oglądał — nie pokazuj ponownie
        if (localStorage.getItem('introPlayed')) {
            intro.remove();
            return;
        }

        function closeIntro() {
            intro.style.transition = 'opacity 0.6s ease';
            intro.style.opacity = '0';

            setTimeout(() => {
                intro.remove();
            }, 600);

            localStorage.setItem('introPlayed', 'true');
        }

        // Kliknięcie pomiń
        skip.addEventListener('click', closeIntro);

        // Koniec filmu
        video.addEventListener('ended', closeIntro);

    });
</script>
</body>
</html>
