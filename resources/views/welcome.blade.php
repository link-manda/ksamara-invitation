<!DOCTYPE html>
<html lang="id" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Samara Invitation - Solusi Undangan Digital Elegan & Modern</title>

    <!-- Google Fonts: Playfair Display & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxStyles
</head>
<body x-data="{ isModalOpen: false, modalTitle: '', modalImageUrl: '', openPreview(name, url) { this.modalTitle = name; this.modalImageUrl = url; this.isModalOpen = true; document.body.style.overflow = 'hidden'; }, closePreview() { this.isModalOpen = false; document.body.style.overflow = 'auto'; } }" class="bg-zinc-950 font-['Outfit',sans-serif] text-zinc-100 antialiased selection:bg-amber-500/30 selection:text-amber-300">

    <!-- Floating Glass Navbar -->
    <nav class="fixed top-0 inset-x-0 z-50 bg-zinc-950/70 backdrop-blur-xl border-b border-zinc-800/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 via-amber-600 to-amber-700 flex items-center justify-center text-white font-serif font-bold text-xl shadow-lg shadow-amber-600/30 group-hover:scale-105 transition-transform duration-300">
                    S
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold tracking-tight font-serif text-white group-hover:text-amber-400 transition-colors">Samara</span>
                    <span class="text-[10px] tracking-widest uppercase text-amber-500/90 font-medium">Digital Invitation</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center gap-8">
                <a href="#fitur" class="text-sm font-medium text-zinc-300 hover:text-amber-400 transition-colors">Fitur Utama</a>
                <a href="#templates" class="text-sm font-medium text-zinc-300 hover:text-amber-400 transition-colors">Showcase Template</a>
                <a href="#harga" class="text-sm font-medium text-zinc-300 hover:text-amber-400 transition-colors">Paket Harga</a>
                <a href="#faq" class="text-sm font-medium text-zinc-300 hover:text-amber-400 transition-colors">FAQ</a>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-zinc-200 hover:text-amber-400 transition-colors">
                        <flux:icon icon="rectangle-group" class="size-4 text-amber-500" />
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-zinc-300 hover:text-white transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-amber-600/25 hover:from-amber-400 hover:to-amber-500 hover:shadow-amber-500/40 transition-all duration-300 active:scale-95">
                        <span>Buat Undangan</span>
                        <flux:icon icon="arrow-right" class="size-4" />
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-36 pb-24 md:pt-48 md:pb-36 overflow-hidden">
        <!-- Background Lighting Effects -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-tr from-amber-600/20 to-orange-500/10 rounded-full blur-[140px] pointer-events-none -z-10"></div>
        <div class="absolute top-1/3 left-1/4 w-[350px] h-[350px] bg-amber-500/10 rounded-full blur-[100px] pointer-events-none -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                <!-- Left Hero Text -->
                <div class="lg:col-span-7 text-center lg:text-left space-y-8">
                    <!-- Glowing Badge -->
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold tracking-wide">
                        <flux:icon icon="sparkles" class="size-4 text-amber-400 animate-pulse" />
                        <span>Platform Undangan Digital Premium #1 di Indonesia</span>
                    </div>

                    <!-- Headline -->
                    <h1 class="text-4xl sm:text-6xl lg:text-6xl font-serif font-extrabold text-white leading-[1.15] tracking-tight">
                        Abadikan Momen Murni Bahagia dengan Undangan <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-amber-500 to-orange-400">Berkelas & Interaktif</span>
                    </h1>

                    <!-- Subheadline -->
                    <p class="text-base sm:text-xl text-zinc-400 font-light leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Bagikan kabar pernikahan Anda melalui undangan digital modern. Dilengkapi fitur konfirmasi kehadiran RSVP realtime, amplop digital QRIS multi-bank, serta galeri foto & musik latar.
                    </p>

                    <!-- Dual CTA & Trust -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-xl bg-gradient-to-r from-amber-500 via-amber-600 to-amber-700 text-white font-semibold shadow-xl shadow-amber-600/30 hover:shadow-amber-500/50 hover:scale-[1.02] active:scale-95 transition-all duration-300">
                            <span>Mulai Buat Undangan Gratis</span>
                            <flux:icon icon="arrow-right" class="size-5" />
                        </a>
                        <a href="#templates" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl bg-zinc-900 border border-zinc-800 text-zinc-300 hover:text-white hover:bg-zinc-800 hover:border-zinc-700 transition-all duration-300">
                            <flux:icon icon="eye" class="size-5 text-amber-400" />
                            <span>Lihat Demo Template</span>
                        </a>
                    </div>

                    <!-- Micro Trust Badge -->
                    <div class="pt-4 flex items-center justify-center lg:justify-start gap-6 text-xs text-zinc-400 border-t border-zinc-800/80">
                        <div class="flex items-center gap-2">
                            <flux:icon icon="check-circle" class="size-4 text-amber-500" />
                            <span>Tanpa Koding</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <flux:icon icon="check-circle" class="size-4 text-amber-500" />
                            <span>Aktif Seketika</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <flux:icon icon="check-circle" class="size-4 text-amber-500" />
                            <span>Masa Aktif Panjang</span>
                        </div>
                    </div>
                </div>

                <!-- Right Live Device Mockup Showcase -->
                <div class="lg:col-span-5 relative flex justify-center">
                    <div class="relative w-full max-w-[340px] rounded-[40px] border-[8px] border-zinc-800 bg-zinc-900 p-4 shadow-2xl shadow-amber-600/20 ring-1 ring-zinc-700/50">
                        <!-- Mockup Top Speaker Bar -->
                        <div class="absolute top-2 left-1/2 -translate-x-1/2 w-24 h-4 bg-zinc-800 rounded-full flex items-center justify-center gap-2 z-20">
                            <div class="w-2 h-2 rounded-full bg-zinc-950"></div>
                            <div class="w-10 h-1.5 rounded-full bg-zinc-950"></div>
                        </div>

                        <!-- Mockup Content Screen -->
                        <div class="rounded-[28px] overflow-hidden bg-gradient-to-b from-zinc-900 to-zinc-950 border border-zinc-800 p-5 space-y-5 text-center relative">
                            <div class="text-[10px] uppercase tracking-widest text-amber-400 font-semibold pt-2">The Wedding Of</div>
                            
                            <div class="font-serif text-2xl font-bold text-amber-100">
                                Romeo & Juliet
                            </div>

                            <div class="p-3 rounded-xl bg-zinc-800/60 border border-zinc-700/50 text-xs text-zinc-300 space-y-1">
                                <div class="font-semibold text-amber-400">Sabtu, 12 Desember 2026</div>
                                <div class="text-[11px] text-zinc-400">Gedung Gran Melia, Jakarta</div>
                            </div>

                            <!-- Live Countdown Pill -->
                            <div class="grid grid-cols-4 gap-1.5 p-2 rounded-xl bg-amber-500/10 border border-amber-500/20 text-center">
                                <div>
                                    <div class="text-sm font-bold text-amber-300">120</div>
                                    <div class="text-[9px] text-zinc-400 uppercase">Hari</div>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-amber-300">18</div>
                                    <div class="text-[9px] text-zinc-400 uppercase">Jam</div>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-amber-300">45</div>
                                    <div class="text-[9px] text-zinc-400 uppercase">Menit</div>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-amber-300">30</div>
                                    <div class="text-[9px] text-zinc-400 uppercase">Detik</div>
                                </div>
                            </div>

                            <!-- Mockup RSVP Button -->
                            <div class="w-full py-2.5 rounded-xl bg-amber-500 text-zinc-950 font-semibold text-xs shadow-md">
                                Konfirmasi Kehadiran (RSVP)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof & Live Metrics -->
    <section class="py-12 bg-zinc-900/60 border-y border-zinc-800/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-zinc-800/60">
                <div class="px-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-white font-serif tracking-tight">10,000+</div>
                    <div class="text-xs sm:text-sm text-zinc-400 mt-1">Pasangan Bahagia</div>
                </div>
                <div class="px-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-amber-400 font-serif tracking-tight">50+</div>
                    <div class="text-xs sm:text-sm text-zinc-400 mt-1">Desain Template Eksklusif</div>
                </div>
                <div class="px-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-white font-serif tracking-tight">99.9%</div>
                    <div class="text-xs sm:text-sm text-zinc-400 mt-1">RSVP Terkonfirmasi</div>
                </div>
                <div class="px-4">
                    <div class="text-3xl sm:text-4xl font-extrabold text-amber-400 font-serif tracking-tight">24/7</div>
                    <div class="text-xs sm:text-sm text-zinc-400 mt-1">Dukungan Sistem</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Template Showcase Section -->
    <section id="templates" class="py-28 bg-zinc-950 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold">
                    <flux:icon icon="paint-brush" class="size-3.5" />
                    <span>Katalog Desain Theme</span>
                </div>
                <h2 class="text-3xl sm:text-5xl font-serif font-bold text-white tracking-tight">
                    Pilihan Template Undangan Mewah
                </h2>
                <p class="text-zinc-400 font-light text-base sm:text-lg">
                    Didesain secara khusus untuk mengekspresikan karakter keanggunan pernikahan Anda.
                </p>
            </div>

            <!-- Dynamic Templates Grid (Portrait Smartphone Frames 9:16) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto items-stretch">
                @forelse($templates as $template)
                <div class="group rounded-[2.5rem] bg-zinc-950 border-[6px] border-zinc-800/90 overflow-hidden hover:border-amber-500/60 transition-all duration-500 flex flex-col shadow-2xl relative h-[460px]">
                    <!-- Dynamic Smartphone Camera Island / Notch -->
                    <div class="absolute top-2.5 left-1/2 -translate-x-1/2 w-20 h-4 bg-zinc-900 rounded-full z-30 flex items-center justify-center border border-zinc-800/80">
                        <div class="size-2 rounded-full bg-zinc-950"></div>
                    </div>

                    <!-- Portrait Thumbnail Viewport -->
                    <div class="relative w-full h-full overflow-hidden">
                        @if($template->thumbnail_url)
                            <img 
                                src="{{ $template->thumbnail_url }}" 
                                alt="{{ $template->name }}" 
                                class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700" 
                            />
                        @else
                            <!-- Fallback Elegant Dark Gradient -->
                            <div class="w-full h-full bg-gradient-to-b from-zinc-900 via-zinc-950 to-black p-6 flex flex-col justify-center items-center text-center">
                                <flux:icon icon="sparkles" class="size-10 text-amber-500/60 mb-2" />
                                <h3 class="text-xl font-serif font-bold text-white">{{ $template->name }}</h3>
                                <span class="text-xs text-zinc-400 font-mono mt-1">{{ $template->view_path }}</span>
                            </div>
                        @endif

                        <!-- Gradient Overlay with Details & Dual Action Buttons -->
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-black/30 p-5 flex flex-col justify-between z-20">
                            <!-- Top Header Badge -->
                            <div class="flex items-center justify-between pt-4">
                                <flux:badge color="amber" size="sm" class="shadow-md">Active Theme</flux:badge>
                                <span class="text-[11px] text-zinc-300 font-mono bg-zinc-900/80 px-2 py-0.5 rounded-md border border-zinc-700/50 backdrop-blur-xs">{{ $template->name }}</span>
                            </div>

                            <!-- Bottom Card Content & Actions -->
                            <div class="space-y-3">
                                <div class="space-y-1.5">
                                    <h3 class="text-xl font-serif font-bold text-white drop-shadow-md">{{ $template->name }}</h3>
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($template->packages as $pkg)
                                            <span class="text-[10px] bg-amber-500/20 text-amber-300 border border-amber-500/30 px-2.5 py-0.5 rounded-full font-medium">{{ $pkg->name }}</span>
                                        @empty
                                            <span class="text-[10px] bg-zinc-800 text-zinc-300 px-2.5 py-0.5 rounded-full">Semua Paket (Universal)</span>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Dual Action Buttons -->
                                <div class="grid grid-cols-2 gap-2 pt-1">
                                    <button 
                                        @click="openPreview('{{ $template->name }}', '{{ $template->thumbnail_url }}')"
                                        type="button" 
                                        class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-zinc-900/90 hover:bg-zinc-800 text-zinc-200 text-xs font-semibold border border-zinc-700/80 transition-all shadow-md">
                                        <flux:icon icon="eye" class="size-3.5 text-amber-400" />
                                        <span>Preview</span>
                                    </button>
                                    <a 
                                        href="{{ route('register') }}" 
                                        class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-white text-xs font-semibold transition-all shadow-lg shadow-amber-600/20">
                                        <span>Pilih</span>
                                        <flux:icon icon="arrow-right" class="size-3.5" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-16 border border-dashed border-zinc-800 rounded-3xl text-zinc-500">
                    Belum ada template aktif saat ini.
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Feature Bento Grid Section -->
    <section id="fitur" class="py-28 bg-zinc-900/40 relative border-t border-zinc-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold">
                    <flux:icon icon="bolt" class="size-3.5" />
                    <span>Fitur Unggulan</span>
                </div>
                <h2 class="text-3xl sm:text-5xl font-serif font-bold text-white tracking-tight">
                    Segala Kemudahan Dalam Satu Genggaman
                </h2>
                <p class="text-zinc-400 font-light text-base sm:text-lg">
                    Fitur terlengkap yang memudahkan Anda dan para tamu undangan.
                </p>
            </div>

            <!-- Gapless Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Bento 1: Large Card (RSVP) -->
                <div class="md:col-span-2 rounded-3xl bg-gradient-to-br from-zinc-900 to-zinc-950 border border-zinc-800 p-8 flex flex-col justify-between hover:border-amber-500/40 transition-all shadow-xl">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                            <flux:icon icon="users" class="size-6" />
                        </div>
                        <h3 class="text-2xl font-serif font-bold text-white">Manajemen RSVP & Buku Tamu Realtime</h3>
                        <p class="text-zinc-400 text-sm leading-relaxed max-w-xl">
                            Dapatkan konfirmasi kehadiran tamu undangan secara instan. Pantau jumlah tamu yang akan hadir, ucapan doa, serta statistik kehadiran langsung melalui Dashboard pribadi Anda.
                        </p>
                    </div>
                    <div class="mt-8 p-4 rounded-xl bg-zinc-950/80 border border-zinc-800 flex items-center justify-between text-xs text-zinc-300">
                        <span class="flex items-center gap-2">
                            <flux:icon icon="check-circle" class="size-4 text-emerald-400" />
                            <span>Statistik Kehadiran Akurat</span>
                        </span>
                        <span class="text-amber-400 font-mono">Live Update</span>
                    </div>
                </div>

                <!-- Bento 2: Amplop Digital QRIS -->
                <div class="rounded-3xl bg-gradient-to-br from-zinc-900 to-zinc-950 border border-zinc-800 p-8 flex flex-col justify-between hover:border-amber-500/40 transition-all shadow-xl">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                            <flux:icon icon="credit-card" class="size-6" />
                        </div>
                        <h3 class="text-xl font-serif font-bold text-white">Amplop Digital & QRIS Multi-Bank</h3>
                        <p class="text-zinc-400 text-sm leading-relaxed">
                            Memudahkan para tamu yang berhalangan hadir untuk mengirimkan kado berupa transfer bank atau scan QRIS secara aman.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-zinc-800/80 flex items-center gap-2 text-xs text-amber-400">
                        <flux:icon icon="qr-code" class="size-4" />
                        <span>Dukungan QRIS & Rekening</span>
                    </div>
                </div>

                <!-- Bento 3: Background Music BGM -->
                <div class="rounded-3xl bg-gradient-to-br from-zinc-900 to-zinc-950 border border-zinc-800 p-8 flex flex-col justify-between hover:border-amber-500/40 transition-all shadow-xl">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                            <flux:icon icon="musical-note" class="size-6" />
                        </div>
                        <h3 class="text-xl font-serif font-bold text-white">Musik Latar Autoplay</h3>
                        <p class="text-zinc-400 text-sm leading-relaxed">
                            Sematkan lagu romantis favorit Anda sebagai musik latar yang akan terputar otomatis saat tamu membuka undangan.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-zinc-800/80 flex items-center gap-2 text-xs text-amber-400">
                        <flux:icon icon="sparkles" class="size-4" />
                        <span>Audio Controls Available</span>
                    </div>
                </div>

                <!-- Bento 4: Google Maps & Countdown (Medium 2 cols) -->
                <div class="md:col-span-2 rounded-3xl bg-gradient-to-br from-zinc-900 to-zinc-950 border border-zinc-800 p-8 flex flex-col justify-between hover:border-amber-500/40 transition-all shadow-xl">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                            <flux:icon icon="map-pin" class="size-6" />
                        </div>
                        <h3 class="text-2xl font-serif font-bold text-white">Peta Lokasi Google Maps & Countdown Timer</h3>
                        <p class="text-zinc-400 text-sm leading-relaxed max-w-xl">
                            Integrasi tombol navigasi langsung ke titik acara via Google Maps dan hitung mundur otomatis menuju hari bahagia Anda.
                        </p>
                    </div>
                    <div class="mt-8 flex items-center gap-4 text-xs text-zinc-300">
                        <div class="px-3 py-1.5 rounded-lg bg-zinc-800 border border-zinc-700 flex items-center gap-2">
                            <flux:icon icon="clock" class="size-3.5 text-amber-400" />
                            <span>Countdown Auto-Sync</span>
                        </div>
                        <div class="px-3 py-1.5 rounded-lg bg-zinc-800 border border-zinc-700 flex items-center gap-2">
                            <flux:icon icon="map" class="size-3.5 text-amber-400" />
                            <span>One-Click Navigation</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="harga" class="py-28 bg-zinc-950 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold">
                    <flux:icon icon="tag" class="size-3.5" />
                    <span>Paket Hemat & Transparan</span>
                </div>
                <h2 class="text-3xl sm:text-5xl font-serif font-bold text-white tracking-tight">
                    Pilih Paket Sesuai Kebutuhan Anda
                </h2>
                <p class="text-zinc-400 font-light text-base sm:text-lg">
                    Tanpa biaya tersembunyi. Pembayaran sekali untuk akses penuh.
                </p>
            </div>

            <!-- Dynamic Hybrid Pricing Grid / Carousel -->
            <div x-data="{
                totalCount: {{ count($packages) }},
                canScrollLeft: false,
                canScrollRight: true,
                checkScroll() {
                    if (!this.$refs.carousel) return;
                    const el = this.$refs.carousel;
                    this.canScrollLeft = el.scrollLeft > 10;
                    this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 10);
                },
                scroll(direction) {
                    if (!this.$refs.carousel) return;
                    const el = this.$refs.carousel;
                    const cardWidth = el.firstElementChild ? el.firstElementChild.getBoundingClientRect().width + 32 : 350;
                    el.scrollBy({ left: direction === 'left' ? -cardWidth : cardWidth, behavior: 'smooth' });
                }
            }" x-init="setTimeout(() => checkScroll(), 100)" class="relative">

                <!-- Navigation Controls (Visible if count > 3) -->
                <div x-show="totalCount > 3" class="hidden md:flex items-center justify-end gap-3 mb-6">
                    <button 
                        @click="scroll('left')" 
                        :disabled="!canScrollLeft"
                        type="button"
                        aria-label="Previous Package"
                        class="w-10 h-10 rounded-full border border-zinc-800 bg-zinc-900/80 text-zinc-300 flex items-center justify-center hover:border-amber-500 hover:text-amber-400 disabled:opacity-30 disabled:cursor-not-allowed transition-all shadow-md">
                        <flux:icon icon="chevron-left" class="size-5" />
                    </button>
                    <button 
                        @click="scroll('right')" 
                        :disabled="!canScrollRight"
                        type="button"
                        aria-label="Next Package"
                        class="w-10 h-10 rounded-full border border-zinc-800 bg-zinc-900/80 text-zinc-300 flex items-center justify-center hover:border-amber-500 hover:text-amber-400 disabled:opacity-30 disabled:cursor-not-allowed transition-all shadow-md">
                        <flux:icon icon="chevron-right" class="size-5" />
                    </button>
                </div>

                <!-- Pricing Cards List Container -->
                <div 
                    x-ref="carousel"
                    @scroll.debounce.50ms="checkScroll()"
                    class="{{ count($packages) > 3 ? 'flex gap-6 lg:gap-8 overflow-x-auto snap-x snap-mandatory scrollbar-none py-4 px-2' : 'grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-6xl mx-auto items-stretch py-4' }}"
                >
                    @forelse($packages as $package)
                    <div class="rounded-3xl bg-zinc-900/90 border {{ $loop->iteration === 2 ? 'border-amber-500/90 ring-2 ring-amber-500/50 shadow-xl shadow-amber-500/10' : 'border-zinc-800/80 hover:border-zinc-700' }} p-8 flex flex-col justify-between relative overflow-hidden transition-all duration-300 {{ count($packages) > 3 ? 'w-[290px] sm:w-[340px] lg:w-[360px] snap-center shrink-0' : 'w-full' }}">
                        @if($loop->iteration === 2)
                            <div class="absolute top-0 right-0 bg-gradient-to-l from-amber-500 to-amber-600 text-zinc-950 text-[11px] font-extrabold uppercase px-4 py-1 rounded-bl-xl shadow-md">
                                Paling Populer
                            </div>
                        @endif

                        <div class="space-y-6">
                            <div>
                                <h3 class="text-2xl font-serif font-bold text-white">{{ $package->name }}</h3>
                                <div class="mt-4 flex items-baseline gap-1">
                                    <span class="text-sm font-semibold text-amber-400">Rp</span>
                                    <span class="text-4xl font-extrabold text-white font-serif tracking-tight">{{ number_format($package->price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="space-y-3 border-t border-zinc-800/80 pt-6">
                                @if($package->features)
                                    @foreach($package->features as $feature)
                                    <div class="flex items-start gap-3 text-sm text-zinc-300">
                                        <flux:icon icon="check-circle" class="size-4 text-amber-500 shrink-0 mt-0.5" />
                                        <span>{{ $feature }}</span>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="pt-8 mt-8 border-t border-zinc-800/80">
                            <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center gap-2 py-3.5 rounded-xl font-semibold text-sm transition-all duration-300 {{ $loop->iteration === 2 ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-lg shadow-amber-600/30 hover:from-amber-400 hover:to-amber-500' : 'bg-zinc-800 text-zinc-200 hover:bg-zinc-700 hover:text-white' }}">
                                <span>Pilih {{ $package->name }}</span>
                                <flux:icon icon="arrow-right" class="size-4" />
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 text-center py-16 border border-dashed border-zinc-800 rounded-3xl text-zinc-500">
                        Paket belum tersedia saat ini. Silakan hubungi Admin.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-28 bg-zinc-900/40 relative border-t border-zinc-800/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold">
                    <flux:icon icon="question-mark-circle" class="size-3.5" />
                    <span>Pertanyaan Umum</span>
                </div>
                <h2 class="text-3xl sm:text-5xl font-serif font-bold text-white tracking-tight">
                    Pertanyaan Yang Sering Diajukan
                </h2>
            </div>

            <!-- Alpine Accordion -->
            <div class="space-y-4" x-data="{ active: null }">
                <!-- FAQ 1 -->
                <div class="rounded-2xl bg-zinc-900/80 border border-zinc-800 overflow-hidden">
                    <button @click="active = (active === 1 ? null : 1)" class="w-full p-6 text-left flex justify-between items-center text-white font-semibold text-base sm:text-lg">
                        <span>Berapa lama proses pembuatan undangan digital?</span>
                        <flux:icon icon="chevron-down" class="size-5 text-amber-400 transition-transform duration-300" ::class="active === 1 ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="active === 1" x-collapse class="px-6 pb-6 text-sm text-zinc-400 leading-relaxed border-t border-zinc-800/60 pt-4">
                        Proses pembuatan sangat cepat dan instan! Setelah mendaftar, Anda dapat langsung memilih template, menginput data pasangan, lokasi resepsi, dan undangan Anda siap disebarkan dalam hitungan menit.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="rounded-2xl bg-zinc-900/80 border border-zinc-800 overflow-hidden">
                    <button @click="active = (active === 2 ? null : 2)" class="w-full p-6 text-left flex justify-between items-center text-white font-semibold text-base sm:text-lg">
                        <span>Apakah saya bisa mencoba dulu sebelum melakukan pembayaran?</span>
                        <flux:icon icon="chevron-down" class="size-5 text-amber-400 transition-transform duration-300" ::class="active === 2 ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="active === 2" x-collapse class="px-6 pb-6 text-sm text-zinc-400 leading-relaxed border-t border-zinc-800/60 pt-4">
                        Ya, tentu saja! Anda bisa mendaftar secara gratis dan membuat draft undangan terlebih dahulu. Pembayaran baru dilakukan ketika Anda siap mengaktifkan status publikasi undangan Anda.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="rounded-2xl bg-zinc-900/80 border border-zinc-800 overflow-hidden">
                    <button @click="active = (active === 3 ? null : 3)" class="w-full p-6 text-left flex justify-between items-center text-white font-semibold text-base sm:text-lg">
                        <span>Bagaimana cara tamu memberikan angpau/amplop digital?</span>
                        <flux:icon icon="chevron-down" class="size-5 text-amber-400 transition-transform duration-300" ::class="active === 3 ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="active === 3" x-collapse class="px-6 pb-6 text-sm text-zinc-400 leading-relaxed border-t border-zinc-800/60 pt-4">
                        Tamu dapat memilih menu Amplop Digital pada undangan Anda, lalu menyalin nomor rekening bank atau menycan kode QRIS resmi yang telah Anda setting di dashboard.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="rounded-2xl bg-zinc-900/80 border border-zinc-800 overflow-hidden">
                    <button @click="active = (active === 4 ? null : 4)" class="w-full p-6 text-left flex justify-between items-center text-white font-semibold text-base sm:text-lg">
                        <span>Apakah undangan fleksibel dibuka di HP maupun Laptop?</span>
                        <flux:icon icon="chevron-down" class="size-5 text-amber-400 transition-transform duration-300" ::class="active === 4 ? 'rotate-180' : ''" />
                    </button>
                    <div x-show="active === 4" x-collapse class="px-6 pb-6 text-sm text-zinc-400 leading-relaxed border-t border-zinc-800/60 pt-4">
                        Tentu! Seluruh template Samara Invitation dirancang dengan pendekatan Mobile-First & Fully Responsive, sehingga tampil sempurna di semua ukuran layar smartphone, tablet, maupun komputer.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- High-Conversion CTA Banner -->
    <section class="py-20 bg-zinc-950 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative rounded-3xl bg-gradient-to-r from-amber-600 via-amber-700 to-orange-600 p-10 sm:p-16 text-center overflow-hidden shadow-2xl shadow-amber-600/30">
                <div class="relative z-10 max-w-3xl mx-auto space-y-6">
                    <h2 class="text-3xl sm:text-5xl font-serif font-extrabold text-white tracking-tight">
                        Siap Membuat Undangan Pernikahan Impian Anda?
                    </h2>
                    <p class="text-amber-100 text-base sm:text-lg font-light">
                        Bergabunglah dengan ribuan pasangan bahagia lainnya dan bagikan momen indah Anda hari ini.
                    </p>
                    <div class="pt-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-3 px-8 py-4 rounded-xl bg-zinc-950 text-amber-400 font-bold text-base shadow-xl hover:bg-zinc-900 hover:scale-105 active:scale-95 transition-all duration-300">
                            <span>Buat Undangan Sekarang</span>
                            <flux:icon icon="arrow-right" class="size-5" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Minimalist Editorial Footer -->
    <footer class="bg-zinc-950 border-t border-zinc-800/80 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-zinc-950 font-serif font-bold text-base">S</div>
                <span class="text-base font-bold font-serif text-white">Samara Invitation</span>
            </div>
            <p class="text-xs text-zinc-500">&copy; {{ date('Y') }} Samara Invitation. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- Live Interactive Smartphone Modal Preview -->
    <div 
        @keydown.escape.window="closePreview()"
        x-show="isModalOpen"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-black/80 backdrop-blur-md"
    >
        <div 
            @click.away="closePreview()"
            class="relative w-full max-w-sm h-[85vh] max-h-[750px] bg-zinc-950 rounded-[3rem] border-[8px] border-zinc-800 shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in duration-300"
        >
            <!-- Mockup Camera Island -->
            <div class="absolute top-3 left-1/2 -translate-x-1/2 w-24 h-5 bg-zinc-900 rounded-full z-40 flex items-center justify-center border border-zinc-800/80">
                <div class="size-2.5 rounded-full bg-zinc-950"></div>
            </div>

            <!-- Modal Top Bar -->
            <div class="p-4 pt-10 bg-zinc-900/90 border-b border-zinc-800 flex items-center justify-between z-30">
                <div>
                    <h4 class="text-sm font-bold text-white" x-text="modalTitle"></h4>
                    <p class="text-[10px] text-amber-400 font-medium">Live Preview Undangan</p>
                </div>
                <button @click="closePreview()" type="button" aria-label="Close Preview" class="w-8 h-8 rounded-full bg-zinc-800 text-zinc-400 hover:text-white flex items-center justify-center transition-colors">
                    <flux:icon icon="x-mark" class="size-4" />
                </button>
            </div>

            <!-- Viewport Container (Scrollable Preview) -->
            <div class="flex-1 overflow-y-auto scrollbar-none bg-zinc-950 p-2">
                <template x-if="modalImageUrl">
                    <img :src="modalImageUrl" :alt="modalTitle" class="w-full rounded-2xl shadow-md" />
                </template>
                <template x-if="!modalImageUrl">
                    <div class="h-full flex flex-col items-center justify-center text-center p-6 text-zinc-500 space-y-2">
                        <flux:icon icon="photo" class="size-10 opacity-40" />
                        <p class="text-xs">Belum ada gambar preview untuk template ini.</p>
                    </div>
                </template>
            </div>

            <!-- Modal Bottom Actions -->
            <div class="p-4 bg-zinc-900/90 border-t border-zinc-800 z-30">
                <a href="{{ route('register') }}" class="w-full inline-flex items-center justify-center gap-2 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold text-xs shadow-lg shadow-amber-600/30 hover:from-amber-400 hover:to-amber-500 transition-all">
                    <span>Gunakan Template Ini</span>
                    <flux:icon icon="arrow-right" class="size-4" />
                </a>
            </div>
        </div>
    </div>

    @fluxScripts
</body>
</html>
