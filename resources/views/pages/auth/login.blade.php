<x-layouts::auth :title="__('Masuk')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Masuk ke Akun Anda')" :description="__('Masukkan email dan kata sandi Anda untuk mengakses dashboard.')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <x-passkey-verify />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Email Address -->
            <flux:field>
                <flux:label>Alamat Email <span class="text-red-500 font-bold">*</span></flux:label>
                <flux:input
                    name="email"
                    type="email"
                    icon="envelope"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="nama@email.com"
                />
                <flux:error name="email" />
            </flux:field>

            <!-- Password -->
            <flux:field>
                <div class="flex items-center justify-between mb-1.5">
                    <flux:label>Kata Sandi <span class="text-red-500 font-bold">*</span></flux:label>
                    @if (Route::has('password.request'))
                        <flux:link class="text-xs text-amber-500 hover:text-amber-400 font-medium" :href="route('password.request')" wire:navigate>
                            Lupa kata sandi?
                        </flux:link>
                    @endif
                </div>
                <flux:input
                    name="password"
                    type="password"
                    icon="lock-closed"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    viewable
                />
                <flux:error name="password" />
            </flux:field>

            <!-- Remember Me -->
            <flux:checkbox name="remember" label="Ingat saya di perangkat ini" :checked="old('remember')" />

            <div class="pt-2">
                <flux:button variant="primary" type="submit" class="w-full" icon="arrow-right-end-on-rectangle" data-test="login-button">
                    Masuk ke Akun
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 text-sm text-center text-zinc-400 pt-4 border-t border-zinc-800">
            <span>Belum memiliki akun?</span>
            <flux:link :href="route('register')" class="font-semibold text-amber-400 hover:underline" wire:navigate>
                Daftar Sekarang
            </flux:link>
        </div>
    </div>
</x-layouts::auth>
