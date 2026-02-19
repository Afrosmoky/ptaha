@if (session('success'))
<div class="mb-6 p-4 bg-green-100 text-green-800 rounded">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('contact.send') }}" class="max-w-xl space-y-6">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Imię</label>
        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            required
            class="w-full border rounded px-3 py-2"
        >
        @error('name')
        <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            class="w-full border rounded px-3 py-2"
        >
        @error('email')
        <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Wiadomość</label>
        <textarea
            name="message"
            rows="5"
            required
            class="w-full border rounded px-3 py-2"
        >{{ old('message') }}</textarea>
        @error('message')
        <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- honeypot --}}
    <input type="text" name="company" style="display:none">

    <button
        type="submit"
        class="inline-block bg-black text-white px-6 py-2 rounded hover:bg-gray-800"
    >
        Wyślij wiadomość
    </button>
</form>
