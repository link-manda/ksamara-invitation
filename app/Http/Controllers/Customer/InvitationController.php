<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Services\DigitalEnvelopeService;
use App\Services\EventService;
use App\Services\GalleryService;
use App\Services\InvitationService;
use App\Services\PackageService;
use App\Services\TemplateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function __construct(
        private readonly InvitationService $invitationService,
        private readonly PackageService $packageService,
        private readonly TemplateService $templateService,
        private readonly EventService $eventService,
        private readonly GalleryService $galleryService,
        private readonly DigitalEnvelopeService $digitalEnvelopeService
    ) {}

    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user()->invitations()->exists()) {
            return NotificationHelper::redirectWithError('dashboard', 'Anda hanya dapat membuat maksimal 1 undangan per akun.');
        }

        $latestOrder = \App\Models\Order::where('user_id', $request->user()->id)->latest()->first();
        if ($latestOrder && $latestOrder->status !== \App\Enums\OrderStatus::Paid) {
            return NotificationHelper::redirectWithError('customer.orders.index', 'Silakan selesaikan pembayaran terlebih dahulu untuk mulai membuat undangan.');
        }

        $packages = $this->packageService->getAllPackages();
        $templates = $this->templateService->getAllTemplates();

        return view('customer.invitation.invitation_create', compact('packages', 'templates'));
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->invitations()->exists()) {
            return NotificationHelper::redirectWithError('dashboard', 'Anda hanya dapat membuat maksimal 1 undangan per akun.');
        }

        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'template_id' => 'required|exists:templates,id',
            'slug' => 'required|string|max:255|unique:invitations,slug',
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
        ]);

        $this->invitationService->createInvitationAndOrder($request->user(), $validated);

        return NotificationHelper::redirectSuccess('dashboard', 'Pesanan dan draft undangan berhasil dibuat!');
    }

    public function edit(Request $request, int $id): View|RedirectResponse
    {
        $invitation = Invitation::with(['events', 'galleries', 'digitalEnvelopes'])->findOrFail($id);

        if ($invitation->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak diizinkan mengubah undangan ini.');
        }

        if ($invitation->order && $invitation->order->status !== \App\Enums\OrderStatus::Paid) {
            return NotificationHelper::redirectWithError('customer.orders.index', 'Silakan selesaikan pembayaran terlebih dahulu untuk mulai mengedit undangan.');
        }

        return view('customer.invitation.invitation_edit', compact('invitation'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $invitation = Invitation::findOrFail($id);

        if ($invitation->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak diizinkan mengubah undangan ini.');
        }

        if ($invitation->order && $invitation->order->status !== \App\Enums\OrderStatus::Paid) {
            return NotificationHelper::redirectWithError('customer.orders.index', 'Silakan selesaikan pembayaran terlebih dahulu untuk melakukan tindakan ini.');
        }

        $events = collect($request->input('events', []))->filter(fn ($e) => ! empty($e['name']))->values()->toArray();
        $envelopes = collect($request->input('envelopes', []))->filter(fn ($e) => ! empty($e['bank_name']))->values()->toArray();

        $request->merge([
            'events' => $events,
            'envelopes' => $envelopes,
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'groom_parents' => 'nullable|string',
            'bride_parents' => 'nullable|string',

            'events' => 'nullable|array',
            'events.*.id' => 'nullable|integer',
            'events.*.name' => 'required|string|max:255',
            'events.*.start_time' => 'required|date',
            'events.*.end_time' => 'nullable|date|after_or_equal:events.*.start_time',
            'events.*.location_name' => 'required|string|max:255',
            'events.*.location_address' => 'required|string',
            'events.*.google_maps_link' => 'nullable|url',

            'galleries' => 'nullable|array',
            'galleries.*' => 'required|file|image|mimes:jpeg,png,jpg,webp|max:2048',

            'envelopes' => 'nullable|array',
            'envelopes.*.id' => 'nullable|integer',
            'envelopes.*.bank_name' => 'required|string|max:255',
            'envelopes.*.account_name' => 'required|string|max:255',
            'envelopes.*.account_number' => 'nullable|string|max:255',
            'envelopes.*.qr_code_file' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',

            'music_path' => 'nullable|string',
        ], [
            'events.*.name.required' => 'Terdapat acara yang belum memiliki Nama Acara.',
            'events.*.start_time.required' => 'Terdapat acara yang belum memiliki Waktu Mulai.',
            'events.*.location_name.required' => 'Terdapat acara yang belum memiliki Nama Lokasi.',
            'events.*.location_address.required' => 'Terdapat acara yang belum memiliki Alamat.',
            'galleries.*.max' => 'Ukuran salah satu foto galeri melebihi batas 2MB.',
            'galleries.*.uploaded' => 'Gagal mengunggah foto. Pastikan ukuran file kurang dari 2MB (batas server).',
            'galleries.*.image' => 'File galeri harus berupa gambar.',
            'envelopes.*.bank_name.required' => 'Terdapat amplop digital yang belum memiliki Nama Bank.',
            'envelopes.*.account_name.required' => 'Terdapat amplop digital yang belum memiliki Atas Nama.',
            'envelopes.*.qr_code_file.max' => 'Ukuran file QRIS melebihi batas 2MB.',
            'envelopes.*.qr_code_file.uploaded' => 'Gagal mengunggah QRIS. Pastikan file kurang dari 2MB (batas server).',
        ]);

        try {
            $this->invitationService->updateInvitation($invitation, $validated);

            if (isset($validated['events'])) {
                $this->eventService->syncEvents($invitation, $validated['events']);
            }

            if (isset($validated['envelopes'])) {
                $this->digitalEnvelopeService->syncEnvelopes($invitation, $validated['envelopes']);
            }

            if ($request->hasFile('galleries')) {
                $this->galleryService->uploadGalleries($invitation, $request->file('galleries'));
            }

            return NotificationHelper::backWithSuccess('Detail undangan berhasil disimpan!');
        } catch (\Exception $e) {
            return NotificationHelper::backWithError('Gagal menyimpan data: '.$e->getMessage());
        }
    }

    public function toggleStatus(Request $request, int $id): RedirectResponse
    {
        $invitation = Invitation::findOrFail($id);

        if ($invitation->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak diizinkan mengubah status undangan ini.');
        }

        if ($invitation->order && $invitation->order->status !== \App\Enums\OrderStatus::Paid) {
            return NotificationHelper::redirectWithError('customer.orders.index', 'Silakan selesaikan pembayaran terlebih dahulu untuk mempublikasikan undangan.');
        }

        $this->invitationService->toggleStatus($invitation);

        return NotificationHelper::backWithSuccess('Status undangan berhasil diubah!');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $invitation = Invitation::with(['galleries', 'digitalEnvelopes'])->findOrFail($id);

        if ($invitation->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak diizinkan menghapus undangan ini.');
        }

        if ($invitation->order && $invitation->order->status !== \App\Enums\OrderStatus::Paid) {
            return NotificationHelper::redirectWithError('customer.orders.index', 'Silakan selesaikan pembayaran terlebih dahulu sebelum menghapus undangan.');
        }

        $this->invitationService->deleteInvitation($invitation);

        return NotificationHelper::redirectSuccess('dashboard', 'Undangan berhasil dihapus beserta seluruh file pendukungnya!');
    }
}
