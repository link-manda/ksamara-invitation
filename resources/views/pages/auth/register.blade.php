<x-layouts::auth :title="__('Daftar Akun')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Buat Akun Baru')" :description="__('Lengkapi formulir di bawah ini untuk memulai membuat undangan digital.')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Name -->
            <flux:field>
                <flux:label>Nama Lengkap <span class="text-red-500 font-bold">*</span></flux:label>
                <flux:input
                    name="name"
                    type="text"
                    icon="user"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Nama Lengkap Anda"
                />
                <flux:error name="name" />
            </flux:field>

            <!-- Email Address -->
            <flux:field>
                <flux:label>Alamat Email <span class="text-red-500 font-bold">*</span></flux:label>
                <flux:input
                    name="email"
                    type="email"
                    icon="envelope"
                    :value="old('email')"
                    required
                    autocomplete="email"
                    placeholder="nama@email.com"
                />
                <flux:error name="email" />
            </flux:field>

            <!-- Password -->
            <flux:field>
                <flux:label>Kata Sandi <span class="text-red-500 font-bold">*</span></flux:label>
                <flux:input
                    name="password"
                    type="password"
                    icon="lock-closed"
                    required
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                />
                <flux:error name="password" />
            </flux:field>

            <!-- Confirm Password -->
            <flux:field>
                <flux:label>Konfirmasi Kata Sandi <span class="text-red-500 font-bold">*</span></flux:label>
                <flux:input
                    name="password_confirmation"
                    type="password"
                    icon="lock-closed"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi kata sandi"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                />
                <flux:error name="password_confirmation" />
            </flux:field>

            <div class="pt-2">
                <flux:button type="submit" variant="primary" class="w-full bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 text-white font-bold shadow-lg shadow-blue-600/25 hover:from-blue-700 hover:to-blue-800 active:scale-95 transition-all duration-300" icon="user-plus" data-test="register-user-button">
                    Daftar Akun Baru
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 text-center text-sm text-slate-500 pt-4 border-t border-slate-200">
            <span>Sudah memiliki akun?</span>
            <flux:link :href="route('login')" class="font-semibold text-blue-600 hover:underline" wire:navigate>
                Masuk di sini
            </flux:link>
        </div>
    </div>
</x-layouts::auth>
