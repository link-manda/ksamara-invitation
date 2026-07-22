<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Samara Invitation - Solusi Undangan Digital Elegan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased selection:bg-amber-200">
    
    <!-- Navbar -->
    <nav class="fixed w-full bg-white/90 backdrop-blur-md border-b border-slate-200 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-amber-600 rounded-lg flex items-center justify-center text-white font-bold font-serif">S</div>
                <span class="text-xl font-bold tracking-tight text-slate-900">Samara</span>
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="#fitur" class="text-slate-600 hover:text-amber-600 font-medium transition">Fitur</a>
                <a href="#harga" class="text-slate-600 hover:text-amber-600 font-medium transition">Harga</a>
            </div>
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold leading-6 text-slate-900 hover:text-amber-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-slate-900 hover:text-amber-600">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-md bg-amber-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-amber-500 transition">Buat Undangan</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-slate-900 mb-6">
                Undangan Digital <br class="hidden sm:block"> <span class="text-amber-600">Modern & Elegan</span>
            </h1>
            <p class="mt-4 text-xl text-slate-600 max-w-2xl mx-auto mb-10">
                Bagikan momen bahagia Anda dengan undangan digital interaktif, mudah disesuaikan, dan ramah lingkungan.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="rounded-full bg-amber-600 px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-amber-600/30 hover:bg-amber-500 hover:scale-105 transition duration-300">Buat Undangan Sekarang</a>
                <a href="#fitur" class="rounded-full bg-white px-8 py-3.5 text-base font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition duration-300">Pelajari Lebih Lanjut</a>
            </div>
        </div>
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 -z-10 blur-3xl opacity-30">
            <div class="w-[40rem] h-[40rem] bg-amber-400 rounded-full mix-blend-multiply filter"></div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="fitur" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Semua yang Anda butuhkan</h2>
                <p class="mt-4 text-lg text-slate-600">Fitur lengkap untuk membuat undangan yang berkesan bagi para tamu Anda.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Manajemen RSVP</h3>
                    <p class="text-slate-600">Kelola konfirmasi kehadiran tamu Anda secara real-time dan terpusat langsung dari dashboard.</p>
                </div>
                
                <div class="text-center">
                    <div class="mx-auto w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Galeri Interaktif</h3>
                    <p class="text-slate-600">Tampilkan foto-foto pre-wedding terbaik Anda dalam grid galeri yang cantik dan responsif.</p>
                </div>

                <div class="text-center">
                    <div class="mx-auto w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Amplop Digital</h3>
                    <p class="text-slate-600">Mudahkan tamu memberikan tanda kasih melalui transfer bank atau scan QRIS secara aman.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing Section -->
    <div id="harga" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Pilih Paket Anda</h2>
                <p class="mt-4 text-lg text-slate-600">Harga transparan untuk setiap kebutuhan pernikahan Anda.</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                @forelse($packages as $package)
                <div class="bg-white rounded-3xl p-8 ring-1 ring-slate-200 shadow-sm flex flex-col hover:shadow-xl hover:-translate-y-1 transition duration-300 relative overflow-hidden">
                    @if($loop->iteration === 2)
                        <div class="absolute top-0 inset-x-0 h-2 bg-amber-500"></div>
                    @endif
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">{{ $package->name }}</h3>
                    <div class="flex items-baseline gap-2 mb-6">
                        <span class="text-4xl font-bold text-slate-900">Rp{{ number_format($package->price, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-slate-600 mb-8">{{ $package->description }}</p>
                    
                    <div class="space-y-4 mb-8 flex-1">
                        @if($package->features)
                            @foreach($package->features as $feature)
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="text-slate-600">{{ $feature }}</span>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <a href="{{ route('register') }}" class="w-full py-3 px-4 rounded-xl text-center font-semibold transition duration-300 {{ $loop->iteration === 2 ? 'bg-amber-600 text-white hover:bg-amber-500 shadow-lg shadow-amber-600/30' : 'bg-slate-100 text-slate-900 hover:bg-slate-200' }}">Pilih Paket</a>
                </div>
                @empty
                <div class="col-span-3 text-center text-slate-500 py-12 border-2 border-dashed border-slate-300 rounded-3xl">
                    Paket belum tersedia saat ini. Silakan hubungi Admin.
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-12 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center items-center gap-2 mb-4">
                <div class="w-6 h-6 bg-amber-600 rounded flex items-center justify-center text-white font-bold font-serif text-xs">S</div>
                <span class="text-lg font-bold tracking-tight text-slate-900">Samara</span>
            </div>
            <p class="text-slate-500 text-sm">&copy; {{ date('Y') }} Samara Invitation. Hak cipta dilindungi.</p>
        </div>
    </footer>

</body>
</html>
