@if($externalLinks->isNotEmpty())
    <section class="border-t pt-12 mt-16">
        <h2 class="text-2xl font-semibold mb-6">
            Platformy PTAHA
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($externalLinks as $link)
                <a href="{{ $link->url }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="block border p-6 hover:bg-gray-50 transition">

                    <h3 class="font-semibold text-lg">
                        {{ $link->name }}
                    </h3>

                    @if($link->description)
                        <p class="text-sm text-gray-600 mt-2">
                            {{ $link->description }}
                        </p>
                    @endif

                    <span class="inline-block mt-4 text-sm font-medium text-blue-600">
                        {{ $link->cta ?? 'Przejdź do platformy →' }}
                    </span>
                </a>
            @endforeach
        </div>
    </section>
@endif
