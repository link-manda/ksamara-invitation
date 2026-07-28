<x-layouts::auth :title="__('Verifikasi Email OTP')">
    <div class="flex flex-col gap-6 text-center" x-data="{
        isSubmitting: false,
        errorMessage: null,
        showSuccessModal: false,
        countdown: 3,
        redirectUrl: '',
        seconds: 60,
        canResend: false,

        init() {
            let isJustResent = {{ session('status') === 'verification-link-sent' ? 'true' : 'false' }};
            let untilKey = 'otp_resend_until_{{ auth()->id() }}';
            let now = Date.now();
            let until = localStorage.getItem(untilKey);

            if (isJustResent || !until) {
                until = now + 60000;
                localStorage.setItem(untilKey, until);
            }

            let updateTimer = () => {
                let currentNow = Date.now();
                let targetUntil = parseInt(localStorage.getItem(untilKey) || 0);
                let diff = Math.ceil((targetUntil - currentNow) / 1000);

                if (diff > 0) {
                    this.seconds = diff;
                    this.canResend = false;
                    return true;
                } else {
                    this.seconds = 0;
                    this.canResend = true;
                    return false;
                }
            };

            if (updateTimer()) {
                let timer = setInterval(() => {
                    if (!updateTimer()) {
                        clearInterval(timer);
                    }
                }, 1000);
            }
        },

        resetTimer() {
            let untilKey = 'otp_resend_until_{{ auth()->id() }}';
            localStorage.setItem(untilKey, Date.now() + 60000);
        },

        async submitOtp(e) {
            this.isSubmitting = true;
            this.errorMessage = null;
            let formData = new FormData(e.target);

            try {
                let res = await fetch('{{ route('verification.otp.store') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                let data = await res.json();

                if (res.ok && data.success) {
                    this.redirectUrl = data.redirect_url;
                    this.showSuccessModal = true;
                    this.countdown = 3;
                    
                    let interval = setInterval(() => {
                        if (this.countdown > 1) {
                            this.countdown--;
                        } else {
                            clearInterval(interval);
                        }
                    }, 1000);

                    setTimeout(() => {
                        window.location.href = this.redirectUrl;
                    }, 3000);
                } else {
                    this.isSubmitting = false;
                    if (data.errors && data.errors.otp) {
                        this.errorMessage = data.errors.otp[0];
                    } else if (data.message) {
                        this.errorMessage = data.message;
                    } else {
                        this.errorMessage = 'Kode OTP yang Anda masukkan salah atau telah kadaluwarsa.';
                    }
                }
            } catch (err) {
                this.isSubmitting = false;
                this.errorMessage = 'Terjadi kesalahan sistem. Silakan coba lagi.';
            }
        }
    }">
        <div class="flex flex-col items-center gap-2">
            <div class="p-3.5 rounded-2xl bg-blue-500/10 border border-blue-500/20 text-blue-600 shadow-xs mb-1">
                <flux:icon icon="shield-check" class="size-8" />
            </div>
            
            <flux:heading size="xl" level="1" class="font-bold tracking-tight text-slate-900 font-serif">
                {{ __('Verifikasi Alamat Email') }}
            </flux:heading>
            
            <flux:subheading class="max-w-xs mx-auto text-xs leading-relaxed text-slate-600 font-light">
                Kode 6-digit OTP telah dikirimkan ke email <br>
                <strong class="text-slate-900 font-semibold underline decoration-blue-500/40">{{ auth()->user()->email }}</strong>
            </flux:subheading>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 text-xs text-center font-medium flex items-center justify-center gap-2">
                <flux:icon icon="sparkles" class="size-4 shrink-0 text-emerald-600" />
                <span>Kode OTP baru telah berhasil dikirimkan ke email Anda.</span>
            </div>
        @endif

        <form @submit.prevent="submitOtp($event)" method="POST" action="{{ route('verification.otp.store') }}" class="flex flex-col gap-6 items-center w-full">
            @csrf

            <flux:field class="w-full flex flex-col items-center">
                <flux:otp name="otp" length="6" label="Kode OTP" label:sr-only :error:icon="false" error:class="text-center" class="mx-auto" autofocus />
                
                <template x-if="errorMessage">
                    <p class="mt-2 text-center text-xs text-red-600 font-medium" x-text="errorMessage"></p>
                </template>
                @error('otp')
                    <p class="mt-2 text-center text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </flux:field>

            <flux:button type="submit" variant="primary" icon="check" class="w-full bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white font-bold shadow-lg shadow-blue-600/25 hover:from-blue-700 hover:to-blue-800 active:scale-95 transition-all duration-300" x-bind:disabled="isSubmitting">
                <span x-show="!isSubmitting">Verifikasi OTP Sekarang</span>
                <span x-show="isSubmitting">Memproses Verifikasi...</span>
            </flux:button>
        </form>

        <div class="flex flex-col items-center justify-between space-y-3 pt-4 border-t border-slate-200">
            <form method="POST" action="{{ route('verification.send') }}" @submit="resetTimer()" class="w-full text-center">
                @csrf
                <template x-if="!canResend">
                    <button type="button" disabled class="text-xs text-slate-400 cursor-not-allowed font-medium py-1">
                        Kirim Ulang Kode OTP (<span x-text="seconds" class="font-mono"></span>s)
                    </button>
                </template>

                <template x-if="canResend">
                    <flux:button type="submit" variant="ghost" class="text-xs text-blue-600 font-semibold hover:underline">
                        Kirim Ulang Kode OTP Sekarang
                    </flux:button>
                </template>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full text-center">
                @csrf
                <flux:button variant="ghost" type="submit" class="text-xs text-slate-500 hover:text-slate-700" data-test="logout-button">
                    Keluar / Sign Out
                </flux:button>
            </form>
        </div>

        <!-- Success Modal Popup -->
        <template x-teleport="body">
            <div x-show="showSuccessModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/75 backdrop-blur-md" 
                 style="display: none;">
                
                <div x-show="showSuccessModal"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="w-full max-w-sm p-6 bg-white rounded-2xl border border-slate-200 shadow-2xl text-center space-y-5 relative overflow-hidden">
                    
                    <!-- Ambient Glow Effect -->
                    <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-32 h-32 bg-emerald-500/20 blur-2xl rounded-full pointer-events-none"></div>

                    <!-- Animated Checkmark Badge -->
                    <div class="relative mx-auto flex items-center justify-center size-16 rounded-full bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 shadow-inner">
                        <flux:icon icon="check-circle" class="size-10 text-emerald-600 animate-bounce" />
                    </div>

                    <div class="space-y-1.5">
                        <h3 class="text-lg font-bold text-slate-900 tracking-tight font-serif">
                            Verifikasi Email Berhasil
                        </h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Selamat datang di <strong>Samara Invitation</strong>. Akun Anda telah aktif dan terverifikasi sepenuhnya.
                        </p>
                    </div>

                    <!-- Countdown & Redirect Badge -->
                    <div class="p-3 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center gap-2 text-xs text-slate-700">
                        <flux:icon icon="arrow-right" class="size-4 text-emerald-600 animate-pulse" />
                        <span>Mengarahkan ke dashboard dalam <strong class="font-mono text-emerald-600 font-bold" x-text="countdown">3</strong> detik...</span>
                    </div>

                    <!-- Animated Progress Line -->
                    <div class="w-full bg-slate-200 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full transition-all duration-1000 ease-linear rounded-full" 
                             :style="'width: ' + (countdown / 3 * 100) + '%'"></div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-layouts::auth>
