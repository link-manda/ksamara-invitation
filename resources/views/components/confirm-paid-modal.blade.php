<div
    x-data="{
        actionUrl: '',
        orderNumber: '',
        customer: '',
        packageName: '',
        amount: '',
    }"
    x-on:open-paid-confirmation.window="
        actionUrl = $event.detail.action;
        orderNumber = $event.detail.orderNumber;
        customer = $event.detail.customer;
        packageName = $event.detail.packageName;
        amount = $event.detail.amount;
        $dispatch('modal-show', { name: 'confirm-paid-modal' });
    "
>
    <flux:modal name="confirm-paid-modal" class="md:w-md">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Konfirmasi Pembayaran</flux:heading>
                <flux:subheading class="mt-2">
                    Pastikan pembayaran sudah diverifikasi sebelum mengubah status pesanan menjadi lunas.
                </flux:subheading>
            </div>

            <dl class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-2 rounded-lg bg-zinc-50 p-4 text-sm dark:bg-white/5">
                <dt class="text-zinc-500 dark:text-zinc-400">Pesanan</dt>
                <dd class="text-right font-medium text-zinc-900 dark:text-white" x-text="orderNumber"></dd>

                <dt class="text-zinc-500 dark:text-zinc-400">Pelanggan</dt>
                <dd class="text-right font-medium text-zinc-900 dark:text-white" x-text="customer"></dd>

                <dt class="text-zinc-500 dark:text-zinc-400">Paket</dt>
                <dd class="text-right font-medium text-zinc-900 dark:text-white" x-text="packageName"></dd>

                <dt class="text-zinc-500 dark:text-zinc-400">Nominal</dt>
                <dd class="text-right font-semibold text-emerald-600 dark:text-emerald-400" x-text="amount"></dd>
            </dl>

            <form :action="actionUrl" method="POST" class="flex items-center justify-end gap-3">
                @csrf
                @method('PATCH')

                <flux:modal.close>
                    <flux:button type="button" variant="outline">Batal</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary" icon="check-circle">Tandai Lunas</flux:button>
            </form>
        </div>
    </flux:modal>
</div>
