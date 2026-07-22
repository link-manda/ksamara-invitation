<?php

namespace App\Http\Controllers\Customer;

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

    public function create(): View
    {
        $packages = $this->packageService->getAllPackages();
        $templates = $this->templateService->getAllTemplates();

        return view('customer.invitation.invitation_create', compact('packages', 'templates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'template_id' => 'required|exists:templates,id',
            'slug' => 'required|string|max:255|unique:invitations,slug',
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
        ]);

        $this->invitationService->createInvitationAndOrder($request->user(), $validated);

        return redirect()->route('dashboard')->with('toast', 'Pesanan dan draft undangan berhasil dibuat!');
    }

    public function edit(Request $request, int $id): View
    {
        $invitation = Invitation::with(['events', 'galleries', 'digitalEnvelopes'])->findOrFail($id);

        if ($invitation->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak diizinkan mengubah undangan ini.');
        }

        return view('customer.invitation.invitation_edit', compact('invitation'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $invitation = Invitation::findOrFail($id);

        if ($invitation->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak diizinkan mengubah undangan ini.');
        }

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
            'galleries.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',

            'envelopes' => 'nullable|array',
            'envelopes.*.id' => 'nullable|integer',
            'envelopes.*.bank_name' => 'required|string|max:255',
            'envelopes.*.account_name' => 'required|string|max:255',
            'envelopes.*.account_number' => 'nullable|string|max:255',
            'envelopes.*.qr_code_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

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

        return redirect()->back()->with('toast', 'Detail undangan berhasil disimpan!');
    }

    public function toggleStatus(Request $request, int $id): RedirectResponse
    {
        $invitation = Invitation::findOrFail($id);

        if ($invitation->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak diizinkan mengubah status undangan ini.');
        }

        $this->invitationService->toggleStatus($invitation);

        return redirect()->back()->with('toast', 'Status undangan berhasil diubah!');
    }
}
