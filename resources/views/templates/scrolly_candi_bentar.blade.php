<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $ogTitle ?? ($invitation->groom_name . ' & ' . $invitation->bride_name) }}">
    <meta property="og:description" content="{{ $ogDescription ?? 'Undangan Pernikahan Sinematik Digital' }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('images/scrollytelling/candi-bentar/frame_030.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <title>{{ $invitation->title ?? ($invitation->groom_name . ' & ' . $invitation->bride_name) }}</title>

    <!-- Google Fonts: Playfair Display, Great Vibes & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body 
    x-data="{
        totalFrames: 60,
        currentFrame: 1,
        images: [],
        loadedImages: 0,
        isLoaded: false,
        progress: 0,
        isPlayingBgm: false,
        audioEl: null,

        init() {
            this.preloadImages();
            window.addEventListener('scroll', () => this.handleScroll(), { passive: true });
        },

        preloadImages() {
            let loaded = 0;
            for (let i = 1; i <= this.totalFrames; i++) {
                let img = new Image();
                let num = String(i).padStart(3, '0');
                img.src = `/images/scrollytelling/candi-bentar/frame_${num}.webp`;
                img.onload = () => {
                    loaded++;
                    this.loadedImages = loaded;
                    if (loaded === this.totalFrames) {
                        this.isLoaded = true;
                        this.$nextTick(() => {
                            this.renderCanvas(1);
                        });
                    }
                };
                this.images[i] = img;
            }
        },

        handleScroll() {
            let heroEl = this.$refs.scrollyHero;
            if (!heroEl) return;

            let rect = heroEl.getBoundingClientRect();
            let totalScrollable = heroEl.offsetHeight - window.innerHeight;
            if (totalScrollable <= 0) return;

            let scrolled = -rect.top;
            let rawProgress = scrolled / totalScrollable;
            this.progress = Math.max(0, Math.min(1, rawProgress));

            let frameIndex = Math.floor(this.progress * (this.totalFrames - 1)) + 1;
            frameIndex = Math.max(1, Math.min(this.totalFrames, frameIndex));

            if (frameIndex !== this.currentFrame) {
                this.currentFrame = frameIndex;
                this.renderCanvas(frameIndex);
            }
        },

        renderCanvas(frameIdx) {
            let canvas = this.$refs.canvas;
            if (!canvas) return;
            let ctx = canvas.getContext('2d');
            let img = this.images[frameIdx];
            if (!img || !img.complete) return;

            canvas.width = canvas.clientWidth * window.devicePixelRatio;
            canvas.height = canvas.clientHeight * window.devicePixelRatio;

            let cW = canvas.width;
            let cH = canvas.height;
            let iW = img.width;
            let iH = img.height;

            let scale = Math.max(cW / iW, cH / iH);
            let x = (cW - iW * scale) / 2;
            let y = (cH - iH * scale) / 2;

            ctx.clearRect(0, 0, cW, cH);
            ctx.drawImage(img, x, y, iW * scale, iH * scale);
        },

        toggleBgm() {
            if (!this.audioEl) {
                this.audioEl = this.$refs.bgmAudio;
            }
            if (this.isPlayingBgm) {
                this.audioEl.pause();
                this.isPlayingBgm = false;
            } else {
                this.audioEl.play().then(() => {
                    this.isPlayingBgm = true;
                }).catch(() => {
                    this.isPlayingBgm = false;
                });
            }
        },

        scrollToContent() {
            let target = document.getElementById('mempelai');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }"
    class="bg-[#FAF7F2] font-['Outfit',sans-serif] text-[#2C1810] antialiased selection:bg-[#C59B27]/20 selection:text-[#7A5230]"
>

    <!-- Loading Screen Bar (Light Warm Classic) -->
    <div 
        x-show="!isLoaded"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-[#FAF7F2] p-6 space-y-6 text-center"
    >
        <div class="w-16 h-16 rounded-2xl bg-[#C59B27]/10 border border-[#C59B27]/30 flex items-center justify-center text-[#7A5230] font-serif text-2xl font-bold animate-pulse shadow-md">
            <!-- Stupa Mini Bali Ornament -->
            <svg aria-hidden="true" class="w-10 h-10 text-[#C59B27]" viewBox="0 0 100 100" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="22" r="7"/>
                <path d="M50 8L60 36H40Z" opacity="0.85"/>
                <path d="M36 38H64L60 50H40Z" opacity="0.75"/>
                <path d="M32 52H68L62 68H38Z" opacity="0.6"/>
                <path d="M22 72H78L72 86H28Z" opacity="0.45"/>
                <rect x="40" y="87" width="20" height="7" rx="2" opacity="0.35"/>
            </svg>
        </div>
        <div class="space-y-2">
            <h3 class="text-xl font-serif font-bold text-[#2C1810] tracking-wide">Mempersiapkan Sinematik Undangan...</h3>
            <p class="text-xs text-[#7A5230] font-mono">Memuat Frame (<span x-text="loadedImages"></span> / <span x-text="totalFrames"></span>)</p>
        </div>
        <div class="w-64 bg-[#E8DFC8] h-2 rounded-full overflow-hidden border border-[#DCD0B9]">
            <div class="bg-gradient-to-r from-[#B38728] via-[#FBF5B7] to-[#9E721D] h-full transition-all duration-200 rounded-full" :style="'width: ' + (loadedImages / totalFrames * 100) + '%'"></div>
        </div>
    </div>

    <!-- Mobile-First Container Wrapper (Constrained to max-w-md on Desktop, Full Width on Mobile) -->
    <div class="max-w-md mx-auto min-h-screen bg-[#FDFBF7] shadow-2xl border-x border-[#E8DFC8]/60 relative">

        <!-- Floating Audio Control Button -->
        <div class="fixed bottom-6 right-6 lg:right-[calc(50vw-220px)] z-40">
            <button 
                @click="toggleBgm()"
                type="button" 
                class="w-12 h-12 rounded-full bg-white/90 border border-[#C59B27]/50 text-[#7A5230] flex items-center justify-center shadow-xl shadow-[#7A5230]/10 hover:scale-110 active:scale-95 transition-all duration-300 backdrop-blur-md"
                aria-label="Toggle Background Music"
            >
                <flux:icon icon="musical-note" class="size-6 animate-spin" ::class="isPlayingBgm ? 'animate-spin' : ''" />
            </button>
            <audio x-ref="bgmAudio" loop preload="auto">
                <source src="https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=romantic-wedding-acoustic-guitar-112702.mp3" type="audio/mpeg">
            </audio>
        </div>

        <!-- 1. STICKY HERO SCROLLYTELLING CANVAS SECTION (300vh Sticky Scrubbing) -->
        <section x-ref="scrollyHero" class="relative h-[300vh] w-full">
            <!-- Sticky Fullscreen Canvas Viewport -->
            <div class="sticky top-0 h-screen w-full overflow-hidden flex items-center justify-center bg-[#FAF7F2]">
                <!-- Canvas Rendering Layer -->
                <canvas x-ref="canvas" class="w-full h-full object-cover"></canvas>

                <!-- Bali Pepalihan Ornaments (Square Split Motif) -->
                <svg aria-hidden="true" class="absolute top-0 left-0 w-48 h-48 text-[#C59B27]/12 pointer-events-none z-5" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 20H180V180H20Z" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M50 50H150V150H50Z" stroke="currentColor" stroke-width="1" fill="currentColor" fill-opacity="0.25"/>
                    <circle cx="100" cy="100" r="30" stroke="currentColor" stroke-width="1.5"/>
                    <circle cx="100" cy="100" r="8" fill="currentColor"/>
                    <path d="M0 0L30 0L30 30Z" fill="currentColor"/>
                    <path d="M170 0L200 0L200 30Z" fill="currentColor"/>
                    <path d="M0 170L0 200L30 200Z" fill="currentColor"/>
                    <path d="M170 170L170 200L200 200Z" fill="currentColor"/>
                    <path d="M100 0L108 16H92Z" fill="currentColor" opacity="0.3"/>
                    <path d="M100 184L108 168H92Z" fill="currentColor" opacity="0.3"/>
                    <path d="M0 100L16 108L0 116Z" fill="currentColor" opacity="0.3"/>
                    <path d="M184 100L200 108L184 116Z" fill="currentColor" opacity="0.3"/>
                </svg>
                <svg aria-hidden="true" class="absolute top-0 right-0 w-48 h-48 text-[#C59B27]/12 pointer-events-none z-5" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 20H180V180H20Z" transform="rotate(90 100 100)" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M50 50H150V150H50Z" transform="rotate(90 100 100)" stroke="currentColor" stroke-width="1" fill="currentColor" fill-opacity="0.25"/>
                    <circle cx="100" cy="100" r="30" transform="rotate(90 100 100)" stroke="currentColor" stroke-width="1.5"/>
                    <circle cx="100" cy="100" r="8" fill="currentColor"/>
                </svg>

                <!-- Light Warm Vignette Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#FDFBF7] via-slate-950/20 to-[#FAF7F2]/60 pointer-events-none z-10"></div>

                <!-- Dynamic Story Text Overlay Step 1 (Progress 0% - 35%) -->
                <div 
                    x-show="progress >= 0 && progress < 0.35"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="absolute inset-0 z-20 flex flex-col items-center justify-center p-4 text-center pointer-events-none"
                >
                    <div class="w-full max-w-sm mx-auto rounded-3xl bg-[#FAF7F2]/90 border border-[#C59B27]/50 shadow-2xl backdrop-blur-xl p-6 sm:p-8 space-y-4 pointer-events-auto">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#C59B27]/20 border border-[#C59B27]/40 text-[#7A5230] text-xs font-bold tracking-widest uppercase shadow-xs">
                            <flux:icon icon="sparkles" class="size-3.5 text-[#C59B27]" />
                            <span>The Wedding Celebration</span>
                        </div>
                        <h1 class="font-serif text-3xl sm:text-5xl font-extrabold text-[#2C1810] tracking-tight leading-tight">
                            {{ $invitation->groom_name }} <span class="font-['Great_Vibes',serif] text-[#C59B27] text-4xl sm:text-5xl font-bold">&</span> {{ $invitation->bride_name }}
                        </h1>
                        <p class="text-[#5C4535] text-xs sm:text-sm font-medium max-w-xs mx-auto">
                            Scroll ke bawah untuk mengikuti alur cerita pernikahan kami
                        </p>
                        <div class="pt-2 animate-bounce">
                            <flux:icon icon="chevron-down" class="size-5 text-[#C59B27] mx-auto" />
                        </div>
                    </div>
                </div>

                <!-- Dynamic Story Text Overlay Step 2 (Progress 35% - 70%) -->
                <div 
                    x-show="progress >= 0.35 && progress < 0.70"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="absolute inset-0 z-20 flex flex-col items-center justify-center p-4 text-center pointer-events-none"
                >
                    <div class="w-full max-w-sm mx-auto rounded-3xl bg-[#FAF7F2]/90 border border-[#C59B27]/50 shadow-2xl backdrop-blur-xl p-6 sm:p-8 space-y-4 pointer-events-auto">
                        <span class="text-xs uppercase tracking-[0.3em] text-[#C59B27] font-bold">Save The Special Date</span>
                        <blockquote class="font-serif italic text-base sm:text-lg text-[#2C1810] max-w-xs leading-relaxed">
                            &ldquo;Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan untukmu dari jenismu sendiri.&rdquo;
                        </blockquote>
                        <span class="text-xs text-[#7A5230] font-bold uppercase tracking-widest">— QS. Ar-Rum: 21</span>
                    </div>
                </div>

                <!-- Dynamic Story Text Overlay Step 3 (Progress 70% - 100%) -->
                <div 
                    x-show="progress >= 0.70"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4"
                    class="absolute inset-0 z-20 flex flex-col items-center justify-center p-4 text-center"
                >
                    <div class="w-full max-w-sm mx-auto rounded-3xl bg-[#FAF7F2]/90 border border-[#C59B27]/50 shadow-2xl backdrop-blur-xl p-6 sm:p-8 space-y-5">
                        <div class="space-y-1.5">
                            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-[#2C1810]">Selamat Datang</h2>
                            <p class="text-[#5C4535] text-xs max-w-xs mx-auto">Suatu kehormatan bagi kami atas kehadiran dan doa restu Anda.</p>
                        </div>
                        <button 
                            @click="scrollToContent()"
                            type="button" 
                            class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-gradient-to-r from-[#7A5230] via-[#8C5D36] to-[#5C3A21] text-white font-bold text-xs shadow-xl shadow-[#7A5230]/20 hover:scale-105 active:scale-95 transition-all duration-300"
                        >
                            <span>Buka Undangan Lengkap</span>
                            <flux:icon icon="arrow-down" class="size-4" />
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. MEMPELAI SECTION -->
        <section id="mempelai" class="py-20 px-6 text-center space-y-12 relative">
            <!-- Bali Praba/Padma Section Divider -->
            <svg aria-hidden="true" class="w-full pointer-events-none" viewBox="0 0 400 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="16" x2="140" y2="16" stroke="#C59B27" stroke-width="0.75" stroke-opacity="0.3"/>
                <line x1="260" y1="16" x2="400" y2="16" stroke="#C59B27" stroke-width="0.75" stroke-opacity="0.3"/>
                <circle cx="200" cy="16" r="6" stroke="#C59B27" stroke-width="1" stroke-opacity="0.5"/>
                <circle cx="200" cy="16" r="2.5" fill="#C59B27" fill-opacity="0.4"/>
                <path d="M167 16L175 10L183 16L175 22Z" stroke="#C59B27" stroke-width="0.75" stroke-opacity="0.4"/>
                <path d="M217 16L225 10L233 16L225 22Z" stroke="#C59B27" stroke-width="0.75" stroke-opacity="0.4"/>
                <circle cx="152" cy="16" r="2" fill="#C59B27" fill-opacity="0.25"/>
                <circle cx="248" cy="16" r="2" fill="#C59B27" fill-opacity="0.25"/>
            </svg>
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#C59B27]/10 border border-[#C59B27]/30 text-[#7A5230] text-xs font-semibold">
                    <flux:icon icon="heart" class="size-3.5 text-[#C59B27]" />
                    <span>Pasangan Mempelai</span>
                </div>
                <h2 class="text-3xl font-serif font-bold text-[#2C1810] tracking-tight">
                    Mempelai Berbahagia
                </h2>
            </div>

            <div class="space-y-8">
                <!-- Groom Card -->
                <div class="rounded-2xl bg-white border border-[#E8DFC8] p-6 space-y-4 shadow-md shadow-[#2C1810]/5 text-center">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-[#C59B27] to-[#7A5230] p-0.5 shadow-md shadow-[#C59B27]/20">
                        <div class="w-full h-full rounded-full bg-[#FAF7F2] flex items-center justify-center text-[#7A5230] font-serif text-2xl font-bold">
                            {{ substr($invitation->groom_name, 0, 1) }}
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <h3 class="text-xl font-serif font-bold text-[#2C1810]">{{ $invitation->groom_name }}</h3>
                        <p class="text-[11px] text-[#C59B27] font-semibold tracking-wider uppercase">Mempelai Pria</p>
                        <p class="text-xs text-[#5C4535] pt-1 leading-relaxed">
                            Putra dari {{ $invitation->groom_parents ?? 'Bapak & Ibu Groom' }}
                        </p>
                    </div>
                </div>

                <!-- Bride Card -->
                <div class="rounded-2xl bg-white border border-[#E8DFC8] p-6 space-y-4 shadow-md shadow-[#2C1810]/5 text-center">
                    <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-[#C59B27] to-[#7A5230] p-0.5 shadow-md shadow-[#C59B27]/20">
                        <div class="w-full h-full rounded-full bg-[#FAF7F2] flex items-center justify-center text-[#7A5230] font-serif text-2xl font-bold">
                            {{ substr($invitation->bride_name, 0, 1) }}
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <h3 class="text-xl font-serif font-bold text-[#2C1810]">{{ $invitation->bride_name }}</h3>
                        <p class="text-[11px] text-[#C59B27] font-semibold tracking-wider uppercase">Mempelai Wanita</p>
                        <p class="text-xs text-[#5C4535] pt-1 leading-relaxed">
                            Putri dari {{ $invitation->bride_parents ?? 'Bapak & Ibu Bride' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. RANGKAIAN ACARA SECTION -->
        @if($invitation->events && $invitation->events->count() > 0)
        <section class="py-20 px-6 bg-[#F5EFE6]/60 border-y border-[#E8DFC8] space-y-12 text-center">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#C59B27]/10 border border-[#C59B27]/30 text-[#7A5230] text-xs font-semibold">
                    <flux:icon icon="calendar" class="size-3.5 text-[#C59B27]" />
                    <span>Waktu & Lokasi</span>
                </div>
                <h2 class="text-3xl font-serif font-bold text-[#2C1810] tracking-tight">
                    Rangkaian Acara
                </h2>
            </div>

            <div class="space-y-6 text-left">
                @foreach($invitation->events as $event)
                <div class="rounded-2xl bg-white border border-[#E8DFC8] p-6 space-y-4 shadow-md shadow-[#2C1810]/5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#C59B27]/10 border border-[#C59B27]/20 flex items-center justify-center text-[#7A5230] shrink-0">
                            <flux:icon icon="clock" class="size-5" />
                        </div>
                        <div>
                            <h3 class="text-xl font-serif font-bold text-[#2C1810]">{{ $event->name }}</h3>
                            <p class="text-xs text-[#7A5230] font-semibold">
                                {{ $event->start_time ? $event->start_time->format('d F Y, H:i') . ' WITA' : 'Sabtu, 12 Desember 2026' }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-1 pt-2 border-t border-[#E8DFC8]/60 text-xs text-[#5C4535]">
                        <p class="font-semibold text-[#2C1810]">{{ $event->location_name }}</p>
                        <p class="leading-relaxed">{{ $event->location_address }}</p>
                    </div>

                    @if($event->google_maps_link)
                    <div class="pt-2">
                        <a href="{{ $event->google_maps_link }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl bg-[#FAF7F2] border border-[#DCD0B9] text-[#2C1810] hover:bg-[#E8DFC8]/40 text-xs font-semibold transition-all">
                            <flux:icon icon="map-pin" class="size-4 text-[#C59B27]" />
                            <span>Buka Google Maps</span>
                        </a>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- 4. GALERI FOTO SECTION -->
        @if($invitation->galleries && $invitation->galleries->count() > 0)
        <section class="py-20 px-6 space-y-12 text-center relative overflow-hidden">
            <!-- Bali Sulur Daun Pattern Background -->
            <svg aria-hidden="true" class="absolute inset-0 w-full h-full pointer-events-none" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="sulur-galeri" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M20 0 Q28 10 20 20 Q12 30 20 40" stroke="#C59B27" stroke-width="0.6" fill="none" opacity="0.06"/>
                        <path d="M0 20 Q10 12 20 20 Q30 28 40 20" stroke="#C59B27" stroke-width="0.6" fill="none" opacity="0.06"/>
                        <circle cx="20" cy="20" r="1.5" fill="#C59B27" opacity="0.08"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#sulur-galeri)"/>
            </svg>
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#C59B27]/10 border border-[#C59B27]/30 text-[#7A5230] text-xs font-semibold">
                    <flux:icon icon="photo" class="size-3.5 text-[#C59B27]" />
                    <span>Momen Indah</span>
                </div>
                <h2 class="text-3xl font-serif font-bold text-[#2C1810] tracking-tight">
                    Galeri Foto
                </h2>
            </div>

            <div class="grid grid-cols-2 gap-3.5">
                @foreach($invitation->galleries as $gallery)
                <div class="group aspect-4/5 overflow-hidden rounded-xl border border-[#E8DFC8] bg-white relative shadow-sm">
                    <img src="{{ Storage::url($gallery->file_path) }}" alt="Gallery Image" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- 5. AMPLOP DIGITAL SECTION -->
        @if($invitation->digitalEnvelopes && $invitation->digitalEnvelopes->count() > 0)
        <section class="py-20 px-6 bg-[#F5EFE6]/60 border-t border-[#E8DFC8] text-center space-y-10">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#C59B27]/10 border border-[#C59B27]/30 text-[#7A5230] text-xs font-semibold">
                    <flux:icon icon="credit-card" class="size-3.5 text-[#C59B27]" />
                    <span>Tanda Kasih</span>
                </div>
                <h2 class="text-3xl font-serif font-bold text-[#2C1810] tracking-tight">
                    Amplop Digital & QRIS
                </h2>
                <p class="text-[#5C4535] text-xs leading-relaxed max-w-xs mx-auto">
                    Doa restu Anda merupakan karunia terbesar bagi kami. Jika Anda ingin memberikan tanda kasih:
                </p>
            </div>

            <div class="space-y-4" x-data="{ copied: null }">
                @foreach($invitation->digitalEnvelopes as $envelope)
                <div class="rounded-2xl bg-white border border-[#E8DFC8] p-5 space-y-3 text-center shadow-md shadow-[#2C1810]/5">
                    <div class="text-base font-serif font-bold text-[#2C1810]">{{ $envelope->bank_name }}</div>
                    <div class="font-mono text-lg text-[#C59B27] font-bold tracking-wider">{{ $envelope->account_number }}</div>
                    <p class="text-xs text-[#5C4535]">a.n {{ $envelope->account_name }}</p>
                    
                    <button 
                        @click="navigator.clipboard.writeText('{{ $envelope->account_number }}'); copied = '{{ $envelope->id }}'; setTimeout(() => copied = null, 2000)"
                        type="button" 
                        class="w-full inline-flex items-center justify-center gap-2 py-2 rounded-xl bg-[#FAF7F2] border border-[#DCD0B9] text-xs font-semibold text-[#2C1810] hover:bg-[#E8DFC8]/50 transition-all"
                    >
                        <flux:icon icon="document-duplicate" class="size-3.5 text-[#C59B27]" />
                        <span x-text="copied === '{{ $envelope->id }}' ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- 6. RSVP & UCAPAN DOA SECTION -->
        <section class="py-20 px-6 space-y-10 relative overflow-hidden">
            <!-- Bali Sulur Daun Pattern Background -->
            <svg aria-hidden="true" class="absolute inset-0 w-full h-full pointer-events-none" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="sulur-rsvp" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M20 0 Q28 10 20 20 Q12 30 20 40" stroke="#C59B27" stroke-width="0.6" fill="none" opacity="0.05"/>
                        <path d="M0 20 Q10 12 20 20 Q30 28 40 20" stroke="#C59B27" stroke-width="0.6" fill="none" opacity="0.05"/>
                        <circle cx="20" cy="20" r="1.5" fill="#C59B27" opacity="0.07"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#sulur-rsvp)"/>
            </svg>
            <div class="text-center space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#C59B27]/10 border border-[#C59B27]/30 text-[#7A5230] text-xs font-semibold">
                    <flux:icon icon="chat-bubble-left-right" class="size-3.5 text-[#C59B27]" />
                    <span>RSVP & Doa</span>
                </div>
                <h2 class="text-3xl font-serif font-bold text-[#2C1810] tracking-tight">
                    Konfirmasi Kehadiran
                </h2>
            </div>

            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 text-xs text-center font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form RSVP -->
            <form action="{{ route('public.invitation.rsvp', $invitation->slug) }}" method="POST" class="rounded-2xl bg-white border border-[#E8DFC8] p-6 space-y-5 shadow-md shadow-[#2C1810]/5">
                @csrf
                <div class="space-y-1.5 text-left">
                    <label class="text-xs font-semibold text-[#2C1810]">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="guest_name" required placeholder="Nama Anda" class="w-full rounded-xl bg-[#FDFBF7] border border-[#DCD0B9] p-3 text-xs text-[#2C1810] focus:border-[#C59B27] focus:ring-1 focus:ring-[#C59B27]" />
                </div>

                <div class="grid grid-cols-2 gap-3 text-left">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-[#2C1810]">Kehadiran</label>
                        <select name="status" required class="w-full rounded-xl bg-[#FDFBF7] border border-[#DCD0B9] p-3 text-xs text-[#2C1810] focus:border-[#C59B27] focus:ring-1 focus:ring-[#C59B27]">
                            <option value="hadir">Hadir</option>
                            <option value="tidak_hadir">Tidak Hadir</option>
                            <option value="ragu">Masih Ragu</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-[#2C1810]">Jumlah Tamu</label>
                        <input type="number" name="guest_count" min="1" max="10" value="1" required class="w-full rounded-xl bg-[#FDFBF7] border border-[#DCD0B9] p-3 text-xs text-[#2C1810] focus:border-[#C59B27] focus:ring-1 focus:ring-[#C59B27]" />
                    </div>
                </div>

                <div class="space-y-1.5 text-left">
                    <label class="text-xs font-semibold text-[#2C1810]">Pesan & Doa Restu</label>
                    <textarea name="message" rows="3" placeholder="Tuliskan ucapan dan doa terbaik..." class="w-full rounded-xl bg-[#FDFBF7] border border-[#DCD0B9] p-3 text-xs text-[#2C1810] focus:border-[#C59B27] focus:ring-1 focus:ring-[#C59B27]"></textarea>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-[#7A5230] via-[#8C5D36] to-[#5C3A21] text-white font-bold text-xs shadow-lg shadow-[#7A5230]/20 hover:scale-[1.02] active:scale-95 transition-all">
                    Kirim Konfirmasi Kehadiran (RSVP)
                </button>
            </form>

            <!-- Wishes Feed -->
            @if($invitation->rsvps && $invitation->rsvps->count() > 0)
            <div class="space-y-3 pt-4">
                <h3 class="font-serif text-lg font-bold text-[#2C1810] text-left">Ucapan Doa & Restu</h3>
                <div class="space-y-2.5 max-h-80 overflow-y-auto pr-2 scrollbar-none">
                    @foreach($invitation->rsvps as $rsvp)
                        @if($rsvp->message)
                        <div class="rounded-xl bg-white border border-[#E8DFC8] p-3.5 text-left space-y-1 shadow-xs">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-[#7A5230] text-xs">{{ $rsvp->guest_name }}</span>
                                <span class="text-[10px] text-slate-400">{{ $rsvp->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-[#5C4535] leading-relaxed">{{ $rsvp->message }}</p>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
        </section>

        <!-- FOOTER -->
        <footer class="py-8 border-t border-[#E8DFC8] text-center text-xs text-[#7A5230]">
            &copy; {{ date('Y') }} {{ $invitation->title ?? 'Samara Invitation' }}. Hak cipta dilindungi.
        </footer>
    </div>
</div>

@fluxScripts
</body>
</html>
