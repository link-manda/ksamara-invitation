<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light" data-flux-appearance="light">
    <head>
        @include('partials.head')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
    </head>
    <body class="min-h-screen bg-slate-50 font-['Outfit',sans-serif] text-slate-900 antialiased selection:bg-blue-500/30 selection:text-blue-700">
        <div class="relative grid min-h-screen flex-col items-center justify-center lg:max-w-none lg:grid-cols-12 lg:px-0">
            <!-- Left Side: Brand Showcase Panel (Visible on lg screens) -->
            <div class="relative hidden lg:flex lg:col-span-5 flex-col justify-between h-full p-12 bg-gradient-to-br from-blue-50/80 via-blue-100/30 to-slate-100 border-r border-slate-200/80 overflow-hidden">
                <!-- Background Ambient Glow Effects -->
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-400/20 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Top Brand Header -->
                <a href="{{ route('home') }}" class="relative z-20 flex items-center gap-3 group" wire:navigate>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 flex items-center justify-center text-white font-serif font-bold text-xl shadow-lg shadow-blue-600/30 group-hover:scale-105 transition-transform duration-300">
                        S
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-bold font-serif tracking-tight text-slate-900 group-hover:text-blue-600 transition-colors">Samara</span>
                        <span class="text-[10px] tracking-widest uppercase text-blue-600 font-semibold">Digital Invitation</span>
                    </div>
                </a>

                <!-- Middle Quote Content -->
                <div class="relative z-20 my-auto space-y-6 max-w-lg">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-700 text-xs font-semibold shadow-xs">
                        <flux:icon icon="sparkles" class="size-3.5 animate-pulse text-blue-600" />
                        <span>Momen Bahagia Berkelas</span>
                    </div>

                    <blockquote class="space-y-4">
                        <p class="text-xl font-serif italic text-slate-800 leading-relaxed">
                            &ldquo;Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu merasa tenteram kepadanya.&rdquo;
                        </p>
                        <footer class="text-xs font-bold text-blue-700 uppercase tracking-widest">— QS. Ar-Rum: 21</footer>
                    </blockquote>

                    <!-- Trust Stats Badge -->
                    <div class="pt-6 border-t border-slate-200/80 flex items-center gap-6 text-xs text-slate-600">
                        <div>
                            <div class="text-lg font-bold font-serif text-slate-900">10,000+</div>
                            <div class="text-[11px] text-slate-500">Pasangan Bahagia</div>
                        </div>
                        <div class="h-8 w-px bg-slate-200"></div>
                        <div>
                            <div class="text-lg font-bold font-serif text-blue-600">50+</div>
                            <div class="text-[11px] text-slate-500">Desain Template Eksklusif</div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Footer Info -->
                <div class="relative z-20 text-xs text-slate-500">
                    &copy; {{ date('Y') }} Samara Invitation. Hak cipta dilindungi.
                </div>
            </div>

            <!-- Right Side: Form Panel -->
            <div class="w-full lg:col-span-7 flex items-center justify-center p-6 sm:p-12 relative bg-slate-50">
                <!-- Background Ambient Light for Form Side -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl pointer-events-none -z-10"></div>

                <div class="w-full max-w-md space-y-6">
                    <!-- Mobile Logo Header (visible on mobile only) -->
                    <div class="flex flex-col items-center gap-3 lg:hidden text-center mb-4">
                        <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 group" wire:navigate>
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 flex items-center justify-center text-white font-serif font-bold text-2xl shadow-lg shadow-blue-600/30">
                                S
                            </div>
                            <span class="text-xl font-bold font-serif tracking-tight text-slate-900">
                                Samara <span class="text-blue-600">Invitation</span>
                            </span>
                        </a>
                    </div>

                    <!-- Auth Form Slot Container -->
                    <div class="auth-card rounded-3xl border border-slate-200/90 bg-white p-8 sm:p-10 shadow-xl shadow-slate-200/60 backdrop-blur-xl">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
