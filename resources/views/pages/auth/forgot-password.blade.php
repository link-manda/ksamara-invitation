<x-layouts::auth :title="__('Lupa Kata Sandi')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Lupa Kata Sandi?')" :description="__('Masukkan alamat email Anda untuk menerima tautan atur ulang kata sandi.')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Email Address -->
            <flux:field>
                <flux:label>Alamat Email <span class="text-red-500 font-bold">*</span></flux:label>
                <flux:input
                    name="email"
                    type="email"
                    icon="envelope"
                    required
                    autofocus
                    placeholder="nama@email.com"
                />
                <flux:error name="email" />
            </flux:field>

            <div class="pt-2">
                <flux:button variant="primary" type="submit" class="w-full" icon="paper-airplane" data-test="email-password-reset-link-button">
                    Kirim Link Reset Password
                </flux:button>
            </div>
        </form>

        <div class="text-center text-sm text-zinc-400 pt-4 border-t border-zinc-800">
            <span>Kembali ke halaman</span>
            <flux:link :href="route('login')" class="font-semibold text-amber-400 hover:underline" wire:navigate>
                Masuk
            </flux:link>
        </div>
    </div>
</x-layouts::auth>
