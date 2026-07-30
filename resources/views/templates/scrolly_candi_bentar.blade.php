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
        isCoverOpen: true,
        progress: 0,
        isPlayingBgm: false,
        audioEl: null,
        countdown: { days: 0, hours: 0, minutes: 0, seconds: 0 },
        countdownDone: false,
        lightbox: null,
        openLightbox(url) { this.lightbox = url; },
        closeLightbox() { this.lightbox = null; },

        init() {
            document.body.style.overflow = 'hidden';
            this.preloadImages();
            window.addEventListener('scroll', () => {
                if (window.innerWidth < 1024) this.handleScroll();
            }, { passive: true });
            window.addEventListener('resize', () => this.renderCanvas(this.currentFrame), { passive: true });
        },

        openInvitation() {
            this.isCoverOpen = false;
            document.body.style.overflow = '';
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
            let totalScrollable = document.documentElement.scrollHeight - window.innerHeight;
            if (totalScrollable <= 0) return;

            let scrolled = window.scrollY;
            this.progress = Math.max(0, Math.min(1, scrolled / totalScrollable));

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
            if (!target) return;
            let panel = this.$refs.rightPanel;
            if (panel && window.innerWidth >= 1024) {
                panel.scrollTo({ top: target.offsetTop, behavior: 'smooth' });
            } else {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        },

        handleScrollDesktop() {
            let panel = this.$refs.rightPanel;
            if (!panel) return;
            let totalScrollable = panel.scrollHeight - panel.clientHeight;
            if (totalScrollable <= 0) return;
            this.progress = Math.max(0, Math.min(1, panel.scrollTop / totalScrollable));
        },

        initCountdown(targetDateStr) {
            const update = () => {
                const now = new Date().getTime();
                const target = new Date(targetDateStr).getTime();
                const diff = target - now;

                if (diff <= 0) {
                    this.countdownDone = true;
                    this.countdown = { days: 0, hours: 0, minutes: 0, seconds: 0 };
                    return;
                }

                this.countdown.days    = Math.floor(diff / (1000 * 60 * 60 * 24));
                this.countdown.hours   = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                this.countdown.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                this.countdown.seconds = Math.floor((diff % (1000 * 60)) / 1000);
            };
            update();
            setInterval(update, 1000);
        }
    }"
    class="bg-[#FAF7F2] font-['Outfit',sans-serif] text-[#2C1810] antialiased relative selection:bg-[#C59B27]/20 selection:text-[#7A5230] py-0 lg:py-8"
>

    <!-- Preloader Screen (Light Warm Classic) -->
    <div 
        x-show="!isLoaded"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-[#FAF7F2] p-6 space-y-6 text-center"
    >
        <div class="w-16 h-16 rounded-2xl bg-[#C59B27]/15 border border-[#C59B27]/40 flex items-center justify-center text-[#7A5230] font-serif text-2xl font-bold animate-pulse shadow-md">
            S
        </div>
        <div class="space-y-2">
            <h3 class="text-xl font-serif font-bold text-[#2C1810] tracking-wide">Mempersiapkan Sinematik Undangan...</h3>
            @if($guestName)
            <p class="text-sm font-serif text-[#7A5230]">
                Kepada Yth: <span class="font-bold text-[#2C1810]">{{ $guestName }}</span>
            </p>
            @endif
            <p class="text-xs text-[#7A5230] font-mono">Memuat Frame (<span x-text="loadedImages"></span> / <span x-text="totalFrames"></span>)</p>
        </div>
        <div class="w-64 bg-[#E8DFC8] h-2 rounded-full overflow-hidden border border-[#DCD0B9]">
            <div class="bg-linear-to-r from-[#B38728] via-[#FBF5B7] to-[#9E721D] h-full transition-all duration-200 rounded-full" :style="'width: ' + (loadedImages / totalFrames * 100) + '%'"></div>
        </div>
    </div>

    <!-- COVER SCREEN -->
    <div
        x-show="isLoaded && isCoverOpen"
        x-transition:leave="transition ease-in-out duration-700"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-105"
        class="fixed inset-0 z-40 flex items-center justify-center p-6"
    >
        <div class="w-full max-w-sm mx-auto rounded-3xl bg-[#FAF7F2]/88 border border-[#C59B27]/50 ring-1 ring-[#2C1810]/8 shadow-2xl backdrop-blur-2xl p-8 space-y-6 text-center">

            <div class="flex items-center justify-center gap-3">
                <div class="h-px flex-1 bg-linear-to-r from-transparent to-[#C59B27]/40"></div>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true" class="text-[#C59B27] shrink-0">
                    <path d="M10 2L11.5 7.5H17L12.5 11L14 16.5L10 13.5L6 16.5L7.5 11L3 7.5H8.5L10 2Z" fill="currentColor" opacity="0.6"/>
                </svg>
                <div class="h-px flex-1 bg-linear-to-l from-transparent to-[#C59B27]/40"></div>
            </div>

            @if($guestName)
            <div class="space-y-0.5">
                <p class="text-[10px] uppercase tracking-[0.25em] text-[#C59B27] font-bold">Kepada Yth</p>
                <p class="font-serif text-lg font-bold text-[#2C1810]">{{ $guestName }}</p>
            </div>
            @else
            <p class="text-[10px] uppercase tracking-[0.25em] text-[#C59B27] font-bold">Undangan Pernikahan</p>
            @endif

            <div class="space-y-1">
                <h1 class="font-serif text-3xl font-extrabold text-[#2C1810] tracking-tight leading-tight">
                    {{ $invitation->groom_name }}
                </h1>
                <span class="font-['Great_Vibes',serif] text-[#C59B27] text-4xl font-normal block leading-none">&</span>
                <h1 class="font-serif text-3xl font-extrabold text-[#2C1810] tracking-tight leading-tight">
                    {{ $invitation->bride_name }}
                </h1>
            </div>

            @if($invitation->events && $invitation->events->isNotEmpty())
            <p class="text-xs text-[#7A5230] font-semibold tracking-wide">
                {{ $invitation->events->first()->start_time?->translatedFormat('d F Y') ?? '' }}
            </p>
            @endif

            <div class="w-16 h-0.5 bg-linear-to-r from-transparent via-[#C59B27]/60 to-transparent mx-auto"></div>

            <button
                type="button"
                @click="openInvitation()"
                class="w-full py-3.5 rounded-2xl bg-linear-to-r from-[#7A5230] via-[#8C5D36] to-[#5C3A21] text-white font-bold text-sm shadow-lg shadow-[#7A5230]/25 hover:scale-[1.02] active:scale-95 transition-all duration-300 flex items-center justify-center gap-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Buka Undangan
            </button>

            <p class="text-[10px] text-[#7A5230]/70 font-medium">Sentuh untuk membuka undangan</p>
        </div>
    </div>

    <!-- 1. FIXED FULLSCREEN BACKGROUND CANVAS LAYER (mobile only) -->
    <div class="fixed inset-0 z-0 w-full h-full overflow-hidden bg-[#FAF7F2] pointer-events-none lg:hidden">
        <!-- Canvas Rendering Layer -->
        <canvas x-ref="canvas" class="w-full h-full object-cover"></canvas>
        
        <!-- Light Warm Ambient Mask (Protects Text Contrast) -->
        <div class="absolute inset-0 bg-linear-to-b from-[#FAF7F2]/70 via-slate-950/30 to-[#FAF7F2]/90 pointer-events-none z-10"></div>

        <!-- D: Lateral vignette — desktop only, fades canvas toward edges -->
        <div class="hidden lg:block absolute inset-y-0 left-0 w-64 bg-linear-to-r from-[#FAF7F2]/85 to-transparent pointer-events-none z-10"></div>
        <div class="hidden lg:block absolute inset-y-0 right-0 w-64 bg-linear-to-l from-[#FAF7F2]/85 to-transparent pointer-events-none z-10"></div>
    </div>

    <!-- Floating Audio Control Button -->
    <div
        class="fixed bottom-6 right-6 lg:right-8 z-40 transition-opacity duration-500"
        :class="isCoverOpen ? 'opacity-0 pointer-events-none' : 'opacity-100'"
    >
        <button 
            @click="toggleBgm()"
            type="button" 
            class="w-12 h-12 rounded-full bg-white/95 border border-[#C59B27]/60 text-[#7A5230] flex items-center justify-center shadow-2xl shadow-[#7A5230]/20 hover:scale-110 active:scale-95 transition-all duration-300 backdrop-blur-md"
            aria-label="Toggle Background Music"
        >
            <flux:icon icon="musical-note" class="size-6" ::class="isPlayingBgm ? 'animate-spin' : ''" />
        </button>
        <audio x-ref="bgmAudio" loop preload="auto">
            <source src="https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=romantic-wedding-acoustic-guitar-112702.mp3" type="audio/mpeg">
        </audio>
    </div>

    <!-- DESKTOP SPLIT WRAPPER -->
    <div class="lg:flex lg:h-screen lg:overflow-hidden lg:fixed lg:inset-0 lg:z-10">

        <!-- LEFT PANEL (desktop only) -->
        <div class="hidden lg:flex lg:w-[65%] lg:relative lg:flex-col lg:items-center lg:justify-center lg:overflow-hidden">
            @php $coverPhoto = $invitation->galleries->first(); @endphp
            <img
                src="{{ $coverPhoto ? Storage::url($coverPhoto->file_path) : asset('images/scrollytelling/candi-bentar/cover.webp') }}"
                alt="Cover"
                class="absolute inset-0 w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-linear-to-br from-[#2C1810]/70 via-[#2C1810]/40 to-[#7A5230]/60"></div>
            <div class="absolute inset-x-0 bottom-0 h-48 bg-linear-to-t from-[#2C1810]/80 to-transparent"></div>

            <div class="relative z-10 text-center p-10 space-y-4">
                <p class="text-[11px] uppercase tracking-[0.3em] text-[#C59B27] font-bold">The Wedding Celebration</p>
                <div class="w-12 h-0.5 bg-linear-to-r from-transparent via-[#C59B27]/60 to-transparent mx-auto"></div>
                <h2 class="font-['Great_Vibes',serif] text-6xl text-white leading-tight drop-shadow-lg">
                    {{ $invitation->groom_name }}
                </h2>
                <span class="text-[#C59B27] text-4xl font-serif block leading-none">&</span>
                <h2 class="font-['Great_Vibes',serif] text-6xl text-white leading-tight drop-shadow-lg">
                    {{ $invitation->bride_name }}
                </h2>
                @if($invitation->events && $invitation->events->isNotEmpty() && $invitation->events->first()->start_time)
                <div class="w-12 h-0.5 bg-linear-to-r from-transparent via-[#C59B27]/60 to-transparent mx-auto"></div>
                <p class="text-white/80 text-sm font-medium tracking-widest">
                    {{ $invitation->events->first()->start_time->translatedFormat('d F Y') }}
                </p>
                @endif
                @if($guestName)
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-[#C59B27]/40 backdrop-blur-sm">
                    <span class="text-[10px] uppercase tracking-widest text-[#C59B27] font-bold">Kepada Yth</span>
                    <span class="text-white text-sm font-bold">{{ $guestName }}</span>
                </div>
                @endif
            </div>

            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-[#C59B27]/50 text-[10px] tracking-widest uppercase font-bold">
                Samara Invitation
            </div>
        </div>

        <!-- RIGHT PANEL — konten undangan scroll independent -->
        <div
            class="lg:w-[35%] lg:h-screen lg:overflow-y-auto lg:bg-[#FAF7F2]"
            x-ref="rightPanel"
            @scroll.passive="handleScrollDesktop()"
        >

    <!-- 2. PHONE CONTAINER (mobile full / desktop right panel clean) -->
    <div class="relative z-10 max-w-md mx-auto min-h-screen bg-[#FDFBF7]/40 shadow-2xl border-x border-[#E8DFC8]/50 overflow-hidden pb-20 lg:shadow-none lg:border-x-0 lg:max-w-none lg:mx-0 lg:px-6">

        <!-- A: Phone Status Bar (mobile only) -->
        <div class="hidden items-center justify-between px-6 pt-3.5 pb-1 text-[#2C1810]/50 text-[10px] font-semibold select-none relative">
            <span>12:00</span>
            <!-- Dynamic Island / Notch pill -->
            <div class="absolute left-1/2 -translate-x-1/2 top-2 w-20 h-5 bg-[#2C1810]/10 rounded-full border border-[#2C1810]/8"></div>
            <div class="flex items-center gap-1.5">
                <!-- Signal bars SVG -->
                <svg aria-hidden="true" width="14" height="10" viewBox="0 0 14 10" fill="currentColor">
                    <rect x="0" y="6" width="2.5" height="4" rx="0.5" opacity="0.4"/>
                    <rect x="3.5" y="4" width="2.5" height="6" rx="0.5" opacity="0.6"/>
                    <rect x="7" y="2" width="2.5" height="8" rx="0.5" opacity="0.8"/>
                    <rect x="10.5" y="0" width="2.5" height="10" rx="0.5"/>
                </svg>
                <!-- Battery SVG -->
                <svg aria-hidden="true" width="18" height="10" viewBox="0 0 18 10" fill="none">
                    <rect x="0.5" y="0.5" width="15" height="9" rx="2" stroke="currentColor" stroke-opacity="0.6"/>
                    <rect x="2" y="2" width="10" height="6" rx="1" fill="currentColor" fill-opacity="0.5"/>
                    <path d="M16.5 3.5V6.5" stroke="currentColor" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
        </div>

        <!-- HERO SECTION (Opening Card) -->
        <section
            x-data="{ visible: false }"
            x-init="let obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { visible = true; obs.disconnect(); } }, { threshold: 0.1 }); obs.observe($el)"
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="min-h-screen lg:min-h-[85vh] flex items-center justify-center p-4 text-center transition-all duration-700 ease-out"
        >
            <div class="w-full max-w-sm mx-auto rounded-3xl bg-[#FAF7F2]/94 border border-[#C59B27]/50 ring-1 ring-[#2C1810]/8 shadow-2xl backdrop-blur-xl p-6 sm:p-8 space-y-5">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#C59B27]/20 border border-[#C59B27]/40 text-[#7A5230] text-[11px] font-bold tracking-[0.2em] uppercase shadow-xs">
                    <flux:icon icon="sparkles" class="size-3.5 text-[#C59B27]" />
                    <span>The Wedding Celebration</span>
                </div>

                @if($guestName)
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#C59B27]/15 border border-[#C59B27]/40 backdrop-blur-sm">
                    <span class="text-[10px] uppercase tracking-widest text-[#C59B27] font-bold">Kepada Yth</span>
                    <span class="text-xs text-[#2C1810] font-bold">{{ $guestName }}</span>
                </div>
                @endif

                <h1 class="font-serif text-3xl sm:text-4xl font-extrabold text-[#2C1810] tracking-tight leading-tight drop-shadow-[0_1px_2px_rgba(0,0,0,0.12)]">
                    {{ $invitation->groom_name }} <span class="font-['Great_Vibes',serif] text-[#C59B27] text-4xl sm:text-5xl font-normal drop-shadow-xs">&</span> {{ $invitation->bride_name }}
                </h1>
                
                <div class="w-16 h-0.5 bg-linear-to-r from-transparent via-[#C59B27]/60 to-transparent mx-auto"></div>

                <p class="text-[#5C4535] text-xs sm:text-sm font-medium max-w-xs mx-auto leading-relaxed">
                    Kami mengundang Anda untuk berbagi kebahagiaan dalam momen suci pernikahan kami.
                </p>

                <div class="pt-2">
                    <button 
                        @click="scrollToContent()"
                        type="button" 
                        class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-linear-to-r from-[#7A5230] via-[#8C5D36] to-[#5C3A21] text-white font-bold text-xs shadow-xl shadow-[#7A5230]/25 hover:scale-105 active:scale-95 transition-all duration-300"
                    >
                        <span>Buka Undangan</span>
                        <flux:icon icon="arrow-down" class="size-4" />
                    </button>
                </div>
            </div>
        </section>

        <!-- OM SWASTYASTU SECTION -->
        <section class="py-6 px-4 text-center">
            <div class="space-y-2">
                <p class="font-['Great_Vibes',serif] text-[#C59B27] text-4xl leading-relaxed">Om Swastyastu</p>
                <div class="w-12 h-0.5 bg-linear-to-r from-transparent via-[#C59B27]/50 to-transparent mx-auto"></div>
                <p class="text-xs text-[#7A5230] font-medium leading-relaxed max-w-xs mx-auto">
                    Dengan memohon Asung Kerta Wara Nugraha Ida Sang Hyang Widhi Wasa,<br>
                    kami mengundang Anda dengan penuh rasa syukur dan kebahagiaan.
                </p>
            </div>
        </section>

        <!-- QUOTE SECTION GLASS CARD -->
        <section
            x-data="{ visible: false }"
            x-init="let obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { visible = true; obs.disconnect(); } }, { threshold: 0.15 }); obs.observe($el)"
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="py-10 px-4 text-center transition-all duration-500 ease-out"
        >
            <div class="w-full max-w-sm mx-auto rounded-3xl bg-[#FAF7F2]/92 border border-[#C59B27]/40 ring-1 ring-[#2C1810]/8 shadow-xl backdrop-blur-md p-6 space-y-4 relative overflow-hidden">
                <span class="text-[11px] uppercase tracking-[0.25em] text-[#C59B27] font-bold block relative z-10">Ayat Suci Pernikahan</span>
                <div class="relative z-10">
                    <span class="absolute -top-3 -left-1 text-8xl font-serif text-[#C59B27]/10 select-none leading-none pointer-events-none">&ldquo;</span>
                    <blockquote class="font-serif italic text-base sm:text-lg text-[#2C1810] leading-relaxed">
                        Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan untukmu dari jenismu sendiri.
                    </blockquote>
                </div>
                <div class="w-12 h-0.5 bg-linear-to-r from-transparent via-[#C59B27]/60 to-transparent mx-auto relative z-10"></div>
                <span class="text-xs text-[#7A5230] font-bold uppercase tracking-widest block relative z-10">— QS. Ar-Rum: 21</span>
            </div>
        </section>

        <!-- 3. MEMPELAI SECTION (High Contrast Glass Cards) -->
        <section
            id="mempelai"
            x-data="{ visible: false }"
            x-init="let obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { visible = true; obs.disconnect(); } }, { threshold: 0.15 }); obs.observe($el)"
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="py-14 px-4 text-center space-y-8 transition-all duration-600 ease-out"
        >
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#C59B27]/20 border border-[#C59B27]/40 text-[#7A5230] text-[11px] font-bold tracking-wider uppercase backdrop-blur-sm">
                    <flux:icon icon="heart" class="size-3.5 text-[#C59B27]" />
                    <span>Pasangan Mempelai</span>
                </div>
                <h2 class="text-3xl font-serif font-bold text-[#2C1810] tracking-tight [text-shadow:0_2px_12px_rgba(44,24,16,0.35)]">
                    Mempelai Berbahagia
                </h2>
                <div class="w-16 h-0.5 bg-linear-to-r from-transparent via-[#C59B27]/60 to-transparent mx-auto"></div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Groom Card -->
                <div
                    :class="visible ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-6'"
                    class="rounded-2xl bg-white/94 border border-[#C59B27]/40 ring-1 ring-[#2C1810]/8 p-4 space-y-3 shadow-xl shadow-[#2C1810]/5 backdrop-blur-md text-center transition-all duration-600 ease-out delay-100"
                >
                    <div class="w-16 h-16 mx-auto rounded-full bg-linear-to-br from-[#C59B27] to-[#7A5230] p-0.5 shadow-md shadow-[#C59B27]/20">
                        <div class="w-full h-full rounded-full bg-[#FAF7F2] flex items-center justify-center text-[#7A5230] font-serif text-xl font-bold">
                            {{ substr($invitation->groom_name, 0, 1) }}
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-sm font-serif font-bold text-[#2C1810] leading-tight">{{ $invitation->groom_name }}</h3>
                        <p class="text-[10px] text-[#C59B27] font-bold tracking-wider uppercase">Mempelai Pria</p>
                        <p class="text-[10px] text-[#5C4535] pt-0.5 leading-relaxed">
                            Putra dari<br>{{ $invitation->groom_parents ?? 'Bapak & Ibu Groom' }}
                        </p>
                    </div>
                </div>

                <!-- Bride Card -->
                <div
                    :class="visible ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-6'"
                    class="rounded-2xl bg-white/94 border border-[#C59B27]/40 ring-1 ring-[#2C1810]/8 p-4 space-y-3 shadow-xl shadow-[#2C1810]/5 backdrop-blur-md text-center transition-all duration-600 ease-out delay-250"
                >
                    <div class="w-16 h-16 mx-auto rounded-full bg-linear-to-br from-[#C59B27] to-[#7A5230] p-0.5 shadow-md shadow-[#C59B27]/20">
                        <div class="w-full h-full rounded-full bg-[#FAF7F2] flex items-center justify-center text-[#7A5230] font-serif text-xl font-bold">
                            {{ substr($invitation->bride_name, 0, 1) }}
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-sm font-serif font-bold text-[#2C1810] leading-tight">{{ $invitation->bride_name }}</h3>
                        <p class="text-[10px] text-[#C59B27] font-bold tracking-wider uppercase">Mempelai Wanita</p>
                        <p class="text-[10px] text-[#5C4535] pt-0.5 leading-relaxed">
                            Putri dari<br>{{ $invitation->bride_parents ?? 'Bapak & Ibu Bride' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- COUNTDOWN SECTION -->
        @if($invitation->events && $invitation->events->isNotEmpty() && $invitation->events->first()->start_time)
        <section
            x-data="{ visible: false }"
            x-init="
                let obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { visible = true; obs.disconnect(); } }, { threshold: 0.1 }); obs.observe($el);
                initCountdown('{{ $invitation->events->first()->start_time->toIso8601String() }}');
            "
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="py-10 px-4 text-center transition-all duration-700 ease-out"
        >
            <div class="w-full max-w-sm mx-auto rounded-3xl bg-[#FAF7F2]/92 border border-[#C59B27]/40 ring-1 ring-[#2C1810]/8 shadow-xl backdrop-blur-md p-6 space-y-5">
                <span class="text-[11px] uppercase tracking-[0.25em] text-[#C59B27] font-bold block">Menuju Hari Bahagia</span>

                <div x-show="!countdownDone" class="grid grid-cols-4 gap-2">
                    <template x-for="item in [
                        { val: countdown.days, label: 'Hari' },
                        { val: countdown.hours, label: 'Jam' },
                        { val: countdown.minutes, label: 'Menit' },
                        { val: countdown.seconds, label: 'Detik' }
                    ]">
                        <div class="rounded-2xl bg-[#C59B27]/10 border border-[#C59B27]/30 py-3 px-1 space-y-0.5">
                            <div class="font-serif text-2xl font-extrabold text-[#2C1810]" x-text="String(item.val).padStart(2, '0')"></div>
                            <div class="text-[9px] uppercase tracking-widest text-[#7A5230] font-bold" x-text="item.label"></div>
                        </div>
                    </template>
                </div>

                <div x-show="countdownDone" class="py-2">
                    <p class="font-serif text-lg font-bold text-[#C59B27]">Hari Bahagia Telah Tiba!</p>
                </div>
            </div>
        </section>
        @endif

        <!-- 4. RANGKAIAN ACARA SECTION (High Contrast Glass Cards) -->
        @if($invitation->events && $invitation->events->count() > 0)
        <section
            x-data="{ visible: false }"
            x-init="let obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { visible = true; obs.disconnect(); } }, { threshold: 0.1 }); obs.observe($el)"
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="py-14 px-4 space-y-8 text-center transition-all duration-700 ease-out"
        >
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#C59B27]/20 border border-[#C59B27]/40 text-[#7A5230] text-[11px] font-bold tracking-wider uppercase backdrop-blur-sm">
                    <flux:icon icon="calendar" class="size-3.5 text-[#C59B27]" />
                    <span>Waktu & Lokasi</span>
                </div>
                <h2 class="text-3xl font-serif font-bold text-[#2C1810] tracking-tight [text-shadow:0_2px_12px_rgba(44,24,16,0.35)]">
                    Rangkaian Acara
                </h2>
                <div class="w-16 h-0.5 bg-linear-to-r from-transparent via-[#C59B27]/60 to-transparent mx-auto"></div>
            </div>

            <div class="space-y-5 text-left">
                @foreach($invitation->events as $loop_event)
                <div
                    :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                    class="rounded-2xl bg-white/94 border-t-2 border-[#C59B27] ring-1 ring-[#2C1810]/8 p-6 space-y-4 shadow-xl shadow-[#2C1810]/5 backdrop-blur-md transition-all duration-700 ease-out"
                    style="transition-delay: {{ $loop->index * 100 }}ms"
                >
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-[#C59B27]/15 border border-[#C59B27]/30 flex items-center justify-center text-[#7A5230] shrink-0">
                            <flux:icon icon="clock" class="size-5 text-[#C59B27]" />
                        </div>
                        <div>
                            <h3 class="text-xl font-serif font-bold text-[#2C1810]">{{ $loop_event->name }}</h3>
                            <p class="text-xs text-[#7A5230] font-semibold">
                                {{ $loop_event->start_time ? $loop_event->start_time->format('d F Y, H:i') . ' WITA' : 'Sabtu, 12 Desember 2026' }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-1 pt-2 border-t border-[#E8DFC8]/80 text-xs text-[#5C4535]">
                        <p class="font-semibold text-[#2C1810]">{{ $loop_event->location_name }}</p>
                        <p class="leading-relaxed">{{ $loop_event->location_address }}</p>
                    </div>

                    @php
                        $calStart = $loop_event->start_time?->format('Ymd\THis\Z') ?? '';
                        $calEnd   = $loop_event->end_time?->format('Ymd\THis\Z') ?? ($loop_event->start_time?->addHours(3)->format('Ymd\THis\Z') ?? '');
                        $calTitle = urlencode($loop_event->name . ' - ' . $invitation->groom_name . ' & ' . $invitation->bride_name);
                        $calLoc   = urlencode(($loop_event->location_name ?? '') . ', ' . ($loop_event->location_address ?? ''));
                        $calUrl   = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates={$calStart}/{$calEnd}&location={$calLoc}";
                    @endphp
                    <div class="pt-2 space-y-2">
                        @if($loop_event->google_maps_link)
                        <a href="{{ $loop_event->google_maps_link }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl bg-[#FAF7F2] border border-[#DCD0B9] text-[#2C1810] hover:bg-[#E8DFC8]/60 text-xs font-semibold backdrop-blur-sm transition-all">
                            <flux:icon icon="map-pin" class="size-4 text-[#C59B27]" />
                            <span>Buka Google Maps</span>
                        </a>
                        @endif
                        @if($calStart)
                        <a href="{{ $calUrl }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-2.5 rounded-xl bg-[#FAF7F2] border border-[#DCD0B9] text-[#2C1810] hover:bg-[#E8DFC8]/60 text-xs font-semibold backdrop-blur-sm transition-all">
                            <flux:icon icon="calendar-days" class="size-4 text-[#C59B27]" />
                            <span>Simpan ke Kalender</span>
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- 5. GALERI FOTO SECTION -->
        @if($invitation->galleries && $invitation->galleries->count() > 0)
        <section
            x-data="{ visible: false }"
            x-init="let obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { visible = true; obs.disconnect(); } }, { threshold: 0.1 }); obs.observe($el)"
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="py-14 px-4 space-y-8 text-center transition-all duration-700 ease-out"
        >
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#C59B27]/20 border border-[#C59B27]/40 text-[#7A5230] text-[11px] font-bold tracking-wider uppercase backdrop-blur-sm">
                    <flux:icon icon="photo" class="size-3.5 text-[#C59B27]" />
                    <span>Momen Indah</span>
                </div>
                <h2 class="text-3xl font-serif font-bold text-[#2C1810] tracking-tight [text-shadow:0_2px_12px_rgba(44,24,16,0.35)]">
                    Galeri Foto
                </h2>
                <div class="w-16 h-0.5 bg-linear-to-r from-transparent via-[#C59B27]/60 to-transparent mx-auto"></div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                @foreach($invitation->galleries as $gallery)
                <div
                    :class="visible ? 'opacity-100 scale-100' : 'opacity-0 scale-95'"
                    class="group rounded-xl border border-[#C59B27]/30 bg-white/90 overflow-hidden shadow-lg transition-all duration-500 ease-out cursor-pointer"
                    style="transition-delay: {{ $loop->index * 80 }}ms"
                    @click="openLightbox('{{ Storage::url($gallery->file_path) }}')"
                >
                    <img
                        src="{{ Storage::url($gallery->file_path) }}"
                        alt="Gallery Image"
                        class="w-full h-auto object-contain group-hover:scale-105 transition-transform duration-500"
                        loading="lazy"
                    />
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- 6. AMPLOP DIGITAL SECTION (High Contrast Glass Cards) -->
        @if($invitation->digitalEnvelopes && $invitation->digitalEnvelopes->count() > 0)
        <section
            x-data="{ visible: false }"
            x-init="let obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { visible = true; obs.disconnect(); } }, { threshold: 0.1 }); obs.observe($el)"
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="py-14 px-4 text-center space-y-8 transition-all duration-700 ease-out"
        >
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#C59B27]/20 border border-[#C59B27]/40 text-[#7A5230] text-[11px] font-bold tracking-wider uppercase backdrop-blur-sm">
                    <flux:icon icon="credit-card" class="size-3.5 text-[#C59B27]" />
                    <span>Tanda Kasih</span>
                </div>
                <h2 class="text-3xl font-serif font-bold text-[#2C1810] tracking-tight [text-shadow:0_2px_12px_rgba(44,24,16,0.35)]">
                    Amplop Digital & QRIS
                </h2>
                <div class="w-16 h-0.5 bg-linear-to-r from-transparent via-[#C59B27]/60 to-transparent mx-auto"></div>
                <p class="text-[#5C4535] text-xs leading-relaxed max-w-xs mx-auto">
                    Doa restu Anda merupakan karunia terbesar bagi kami. Jika Anda ingin memberikan tanda kasih:
                </p>
            </div>

            <div class="space-y-4" x-data="{ copied: null }">
                @foreach($invitation->digitalEnvelopes as $envelope)
                <div class="rounded-2xl bg-white/94 border border-[#C59B27]/40 p-5 space-y-3 text-center shadow-xl backdrop-blur-md">
                    <div class="text-base font-serif font-bold text-[#2C1810]">{{ $envelope->bank_name }}</div>
                    <div class="font-mono text-lg text-[#C59B27] font-bold tracking-wider">{{ $envelope->account_number }}</div>
                    <p class="text-xs text-[#5C4535]">a.n {{ $envelope->account_name }}</p>
                    
                    <button 
                        @click="navigator.clipboard.writeText('{{ $envelope->account_number }}'); copied = '{{ $envelope->id }}'; setTimeout(() => copied = null, 2000)"
                        type="button" 
                        class="w-full inline-flex items-center justify-center gap-2 py-2 rounded-xl bg-[#FAF7F2] border border-[#DCD0B9] text-xs font-semibold text-[#2C1810] hover:bg-[#E8DFC8]/60 backdrop-blur-sm transition-all"
                    >
                        <flux:icon icon="document-duplicate" class="size-3.5 text-[#C59B27]" />
                        <span x-text="copied === '{{ $envelope->id }}' ? 'Berhasil Disalin!' : 'Salin Nomor Rekening'"></span>
                    </button>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- 7. RSVP & UCAPAN DOA SECTION (High Contrast Glass Form) -->
        <section
            x-data="{ visible: false }"
            x-init="let obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { visible = true; obs.disconnect(); } }, { threshold: 0.1 }); obs.observe($el)"
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="py-14 px-4 space-y-8 transition-all duration-700 ease-out"
        >
            <div class="text-center space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-[#C59B27]/20 border border-[#C59B27]/40 text-[#7A5230] text-[11px] font-bold tracking-wider uppercase backdrop-blur-sm">
                    <flux:icon icon="chat-bubble-left-right" class="size-3.5 text-[#C59B27]" />
                    <span>RSVP & Doa</span>
                </div>
                <h2 class="text-3xl font-serif font-bold text-[#2C1810] tracking-tight [text-shadow:0_2px_12px_rgba(44,24,16,0.35)]">
                    Konfirmasi Kehadiran
                </h2>
                <div class="w-16 h-0.5 bg-linear-to-r from-transparent via-[#C59B27]/60 to-transparent mx-auto"></div>
            </div>

            @if($rsvpCounts['total'] > 0)
            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-2xl bg-emerald-500/10 border border-emerald-500/30 p-4 text-center space-y-1">
                    <div class="text-2xl font-extrabold font-serif text-emerald-700">{{ $rsvpCounts['hadir'] }}</div>
                    <div class="text-[10px] uppercase tracking-widest text-emerald-600 font-bold">Hadir</div>
                </div>
                <div class="rounded-2xl bg-red-500/10 border border-red-500/30 p-4 text-center space-y-1">
                    <div class="text-2xl font-extrabold font-serif text-red-700">{{ $rsvpCounts['tidak_hadir'] }}</div>
                    <div class="text-[10px] uppercase tracking-widest text-red-500 font-bold">Tidak Hadir</div>
                </div>
            </div>
            @endif

            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-900 text-xs text-center font-bold backdrop-blur-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form RSVP -->
            <form action="{{ route('public.invitation.rsvp', $invitation->slug) }}" method="POST" class="rounded-2xl bg-white/88 border border-[#C59B27]/50 ring-1 ring-[#2C1810]/8 p-6 space-y-5 shadow-2xl shadow-[#2C1810]/8 backdrop-blur-2xl">
                @csrf
                <div class="space-y-1.5 text-left">
                    <label class="text-xs font-bold text-[#2C1810]">Nama Lengkap <span class="text-red-500 font-bold">*</span></label>
                    <input type="text" name="guest_name" required placeholder="Nama Anda" class="w-full rounded-xl bg-[#FAF7F2] border border-[#DCD0B9] p-3 text-xs text-[#2C1810] focus:border-[#C59B27] focus:ring-1 focus:ring-[#C59B27]" />
                </div>

                <div class="grid grid-cols-2 gap-3 text-left">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#2C1810]">Kehadiran</label>
                        <select name="status" required class="w-full rounded-xl bg-[#FAF7F2] border border-[#DCD0B9] p-3 text-xs text-[#2C1810] focus:border-[#C59B27] focus:ring-1 focus:ring-[#C59B27]">
                            <option value="hadir">Hadir</option>
                            <option value="tidak_hadir">Tidak Hadir</option>
                            <option value="ragu">Masih Ragu</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#2C1810]">Jumlah Tamu</label>
                        <input type="number" name="guest_count" min="1" max="10" value="1" required class="w-full rounded-xl bg-[#FAF7F2] border border-[#DCD0B9] p-3 text-xs text-[#2C1810] focus:border-[#C59B27] focus:ring-1 focus:ring-[#C59B27]" />
                    </div>
                </div>

                <div class="space-y-1.5 text-left">
                    <label class="text-xs font-bold text-[#2C1810]">Pesan & Doa Restu</label>
                    <textarea name="message" rows="3" placeholder="Tuliskan ucapan dan doa terbaik..." class="w-full rounded-xl bg-[#FAF7F2] border border-[#DCD0B9] p-3 text-xs text-[#2C1810] focus:border-[#C59B27] focus:ring-1 focus:ring-[#C59B27]"></textarea>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl bg-linear-to-r from-[#7A5230] via-[#8C5D36] to-[#5C3A21] text-white font-bold text-xs shadow-lg shadow-[#7A5230]/25 hover:scale-[1.02] active:scale-95 transition-all">
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
                        <div class="rounded-xl bg-white/92 border border-[#E8DFC8] p-3.5 text-left space-y-1 shadow-sm backdrop-blur-md">
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
        <footer
            x-data="{ visible: false }"
            x-init="let obs = new IntersectionObserver(([e]) => { if (e.isIntersecting) { visible = true; obs.disconnect(); } }, { threshold: 0.5 }); obs.observe($el)"
            :class="visible ? 'opacity-100' : 'opacity-0'"
            class="py-8 border-t border-[#E8DFC8]/60 text-center text-xs text-[#7A5230] transition-opacity duration-700 ease-out"
        >
            &copy; {{ date('Y') }} {{ $invitation->title ?? 'Samara Invitation' }}. Hak cipta dilindungi.
        </footer>

    </div><!-- end phone container -->
        </div><!-- end RIGHT PANEL -->
    </div><!-- end DESKTOP SPLIT WRAPPER -->

    <!-- LIGHTBOX OVERLAY -->
    <div
        x-show="lightbox"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="closeLightbox()"
        @keydown.escape.window="closeLightbox()"
        class="fixed inset-0 z-[60] bg-black/90 flex items-center justify-center p-4 cursor-pointer"
        style="display: none;"
    >
        <img
            :src="lightbox"
            @click.stop
            class="max-w-full max-h-full object-contain rounded-xl shadow-2xl"
            alt="Foto"
        />
        <button
            type="button"
            @click="closeLightbox()"
            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 border border-white/20 text-white flex items-center justify-center hover:bg-white/20 transition-colors"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

@fluxScripts
</body>
</html>
