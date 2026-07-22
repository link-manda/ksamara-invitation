<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDescription }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <title>{{ $invitation->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-amber-50 text-slate-800 font-sans antialiased selection:bg-amber-200">
    <!-- Hero Section -->
    <header class="min-h-screen flex flex-col items-center justify-center text-center p-6 bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80');">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 text-white space-y-6">
            <h3 class="text-xl tracking-widest uppercase">The Wedding Of</h3>
            <h1 class="text-5xl md:text-7xl font-serif mt-4">{{ $invitation->groom_name }} & {{ $invitation->bride_name }}</h1>
        </div>
    </header>

    <!-- Couple Section -->
    <section class="py-20 px-6 max-w-4xl mx-auto text-center space-y-12">
        <h2 class="text-3xl font-serif text-amber-900">Mempelai</h2>
        <div class="grid md:grid-cols-2 gap-12">
            <div>
                <h3 class="text-2xl font-semibold">{{ $invitation->groom_name }}</h3>
                <p class="text-slate-600 mt-2">{{ $invitation->groom_parents }}</p>
            </div>
            <div>
                <h3 class="text-2xl font-semibold">{{ $invitation->bride_name }}</h3>
                <p class="text-slate-600 mt-2">{{ $invitation->bride_parents }}</p>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    @if($invitation->events->count() > 0)
    <section class="py-20 bg-amber-100 px-6">
        <div class="max-w-4xl mx-auto text-center space-y-12">
            <h2 class="text-3xl font-serif text-amber-900">Rangkaian Acara</h2>
            <div class="grid md:grid-cols-2 gap-8">
                @foreach($invitation->events as $event)
                <div class="bg-white p-8 rounded-xl shadow-sm">
                    <h3 class="text-xl font-bold mb-4">{{ $event->name }}</h3>
                    <p class="mb-2"><strong>Waktu:</strong> {{ $event->start_time->format('d M Y, H:i') }}</p>
                    <p class="mb-4"><strong>Tempat:</strong> {{ $event->location_name }} <br> <span class="text-sm text-slate-500">{{ $event->location_address }}</span></p>
                    @if($event->google_maps_link)
                        <a href="{{ $event->google_maps_link }}" target="_blank" class="inline-block bg-amber-700 text-white px-4 py-2 rounded-full text-sm hover:bg-amber-800 transition">Buka Peta</a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Gallery Section -->
    @if($invitation->galleries->count() > 0)
    <section class="py-20 px-6 max-w-5xl mx-auto text-center space-y-12">
        <h2 class="text-3xl font-serif text-amber-900">Galeri</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($invitation->galleries as $gallery)
                <div class="aspect-square overflow-hidden rounded-lg">
                    <img src="{{ Storage::url($gallery->file_path) }}" alt="Gallery Image" class="w-full h-full object-cover hover:scale-110 transition duration-500">
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Digital Envelope -->
    @if($invitation->digitalEnvelopes->count() > 0)
    <section class="py-20 bg-white px-6">
        <div class="max-w-3xl mx-auto text-center space-y-12">
            <h2 class="text-3xl font-serif text-amber-900">Amplop Digital</h2>
            <p class="text-slate-600">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Namun, jika Anda ingin memberikan tanda kasih, dapat disalurkan melalui:</p>
            <div class="grid sm:grid-cols-2 gap-6 justify-center">
                @foreach($invitation->digitalEnvelopes as $envelope)
                <div class="border border-amber-200 p-6 rounded-xl space-y-4">
                    <h3 class="text-xl font-bold">{{ $envelope->bank_name }}</h3>
                    <p>{{ $envelope->account_number }}<br><span class="text-sm">a.n {{ $envelope->account_name }}</span></p>
                    @if($envelope->qr_code_path)
                        <img src="{{ Storage::url($envelope->qr_code_path) }}" alt="QRIS" class="w-32 h-32 mx-auto mt-4 rounded-lg">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- RSVP Section -->
    <section class="py-20 px-6 max-w-3xl mx-auto space-y-8">
        <h2 class="text-3xl font-serif text-amber-900 text-center">RSVP & Ucapan</h2>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg text-center mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('public.invitation.rsvp', $invitation->slug) }}" method="POST" class="bg-white p-8 rounded-xl shadow-sm space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-2">Nama Lengkap</label>
                <input type="text" name="guest_name" required class="w-full border-slate-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500">
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Kehadiran</label>
                    <select name="status" required class="w-full border-slate-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        <option value="hadir">Hadir</option>
                        <option value="tidak_hadir">Tidak Hadir</option>
                        <option value="ragu">Masih Ragu</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">Jumlah Tamu</label>
                    <input type="number" name="guest_count" min="1" max="10" value="1" required class="w-full border-slate-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Pesan/Ucapan</label>
                <textarea name="message" rows="4" class="w-full border-slate-300 rounded-md shadow-sm focus:border-amber-500 focus:ring-amber-500"></textarea>
            </div>

            <button type="submit" class="w-full bg-amber-800 text-white py-3 rounded-md hover:bg-amber-900 transition font-medium">Kirim RSVP</button>
        </form>

        <!-- Display Wishes -->
        @if($invitation->rsvps->count() > 0)
        <div class="mt-12 space-y-4 h-96 overflow-y-auto pr-4">
            <h3 class="font-bold text-xl mb-4">Ucapan Doa & Restu</h3>
            @foreach($invitation->rsvps as $rsvp)
                @if($rsvp->message)
                <div class="bg-amber-50 p-4 rounded-lg">
                    <p class="font-semibold text-amber-900">{{ $rsvp->guest_name }} <span class="text-xs text-slate-500 ml-2 font-normal">{{ $rsvp->created_at->diffForHumans() }}</span></p>
                    <p class="text-slate-700 mt-1 text-sm">{{ $rsvp->message }}</p>
                </div>
                @endif
            @endforeach
        </div>
        @endif
    </section>

    <footer class="text-center py-6 text-sm text-slate-500">
        &copy; {{ date('Y') }} {{ $invitation->title }}. Created with <a href="#" class="font-bold text-amber-700">KSamara</a>.
    </footer>
</body>
</html>
