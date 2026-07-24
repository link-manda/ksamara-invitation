<x-layouts::auth :title="__('Atur Ulang Kata Sandi')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Atur Ulang Kata Sandi')" :description="__('Silakan masukkan kata sandi baru Anda di bawah ini.')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-5">
            @csrf
            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <flux:field>
                <flux:label>Alamat Email</flux:label>
                <flux:input
                    name="email"
                    value="{{ request('email') }}"
                    type="email"
                    icon="envelope"
                    required
                    autocomplete="email"
                />
                <flux:error name="email" />
            </flux:field>

            <!-- Password -->
            <flux:field>
                <flux:label>Kata Sandi Baru</flux:label>
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
                <flux:label>Konfirmasi Kata Sandi</flux:label>
                <flux:input
                    name="password_confirmation"
                    type="password"
                    icon="lock-closed"
                    required
                    autocomplete="new-password"
                    placeholder="Ulangi kata sandi baru"
                    passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                    viewable
                />
                <flux:error name="password_confirmation" />
            </flux:field>

            <div class="pt-2">
                <flux:button type="submit" variant="primary" class="w-full" icon="check" data-test="reset-password-button">
                    Simpan Kata Sandi Baru
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts::auth>

