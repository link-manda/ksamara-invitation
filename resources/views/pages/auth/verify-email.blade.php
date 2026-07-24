<x-layouts::auth :title="__('Verifikasi Email OTP')">
    <div class="flex flex-col gap-6 text-center">
        <div class="flex flex-col items-center gap-2">
            <div class="p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 shadow-xs mb-1">
                <flux:icon icon="shield-check" class="size-8" />
            </div>
            
            <flux:heading size="xl" level="1" class="font-bold tracking-tight">
                {{ __('Verifikasi Alamat Email') }}
            </flux:heading>
            
            <flux:subheading class="max-w-xs mx-auto text-xs leading-relaxed text-zinc-600 dark:text-zinc-400">
                Kode 6-digit OTP telah dikirimkan ke email <br>
                <strong class="text-zinc-900 dark:text-white font-semibold underline decoration-amber-500/40">{{ auth()->user()->email }}</strong>
            </flux:subheading>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs text-center font-medium animate-pulse">
                ✨ Kode OTP baru telah berhasil dikirimkan ke email Anda.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.otp.store') }}" class="flex flex-col gap-6 items-center w-full">
            @csrf

            <flux:otp name="otp" length="6" label="Kode OTP" label:sr-only :error:icon="false" error:class="text-center" class="mx-auto" autofocus />

            <flux:button type="submit" variant="primary" icon="check" class="w-full shadow-xs">
                Verifikasi OTP Sekarang
            </flux:button>
        </form>

        <div class="flex flex-col items-center justify-between space-y-3 pt-4 border-t border-zinc-200 dark:border-zinc-800/80" x-data="{
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
            }
        }">
            <form method="POST" action="{{ route('verification.send') }}" @submit="resetTimer()" class="w-full text-center">
                @csrf
                <template x-if="!canResend">
                    <button type="button" disabled class="text-xs text-zinc-400 dark:text-zinc-500 cursor-not-allowed font-medium py-1">
                        Kirim Ulang Kode OTP (<span x-text="seconds" class="font-mono"></span>s)
                    </button>
                </template>

                <template x-if="canResend">
                    <flux:button type="submit" variant="ghost" class="text-xs text-amber-600 dark:text-amber-400 font-semibold hover:underline">
                        Kirim Ulang Kode OTP Sekarang
                    </flux:button>
                </template>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full text-center">
                @csrf
                <flux:button variant="ghost" type="submit" class="text-xs text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300" data-test="logout-button">
                    Keluar / Sign Out
                </flux:button>
            </form>
        </div>
    </div>
</x-layouts::auth>
