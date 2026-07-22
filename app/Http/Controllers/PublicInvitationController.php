<?php

namespace App\Http\Controllers;

use App\Repositories\InvitationRepository;
use App\Services\RsvpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicInvitationController extends Controller
{
    public function __construct(
        private readonly InvitationRepository $invitationRepository,
        private readonly RsvpService $rsvpService
    ) {}

    public function show(string $slug): View
    {
        $invitation = $this->invitationRepository->findBySlugWithRelations($slug);

        if (! $invitation) {
            abort(404, 'Undangan tidak ditemukan.');
        }

        $view = $invitation->template->view_path;

        return view($view, compact('invitation'));
    }

    public function rsvp(Request $request, string $slug): RedirectResponse
    {
        $invitation = $this->invitationRepository->findBySlugWithRelations($slug);

        if (! $invitation) {
            abort(404, 'Undangan tidak ditemukan.');
        }

        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'status' => 'required|in:hadir,tidak_hadir,ragu',
            'guest_count' => 'required|integer|min:1|max:10',
            'message' => 'nullable|string|max:1000',
        ]);

        $this->rsvpService->submitRsvp($invitation, $validated);

        return redirect()->back()->with('success', 'Terima kasih, RSVP dan ucapan Anda telah terkirim!');
    }
}
