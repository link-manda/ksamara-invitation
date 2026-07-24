<?php

namespace App\Http\Controllers;

use App\Enums\InvitationStatus;
use App\Helpers\NotificationHelper;
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

        if ($invitation->status !== InvitationStatus::Published) {
            abort(403, 'Undangan ini belum dipublikasikan atau sedang tidak aktif.');
        }

        $ogTitle = $invitation->title.' - Undangan Pernikahan';
        $ogDescription = 'Kami mengundang Anda untuk hadir di acara pernikahan kami.';
        $ogImage = $invitation->galleries->isNotEmpty() ? asset('storage/'.$invitation->galleries->first()->file_path) : asset('img/default-og.jpg');

        return view('templates.'.$invitation->template->view_path, compact('invitation', 'ogTitle', 'ogDescription', 'ogImage'));
    }

    public function rsvp(Request $request, string $slug): RedirectResponse
    {
        $invitation = $this->invitationRepository->findBySlugWithRelations($slug);

        if (! $invitation) {
            abort(404, 'Undangan tidak ditemukan.');
        }

        if ($invitation->status !== InvitationStatus::Published) {
            abort(403, 'Undangan ini tidak menerima RSVP karena sedang tidak aktif.');
        }

        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'status' => 'required|in:hadir,tidak_hadir,ragu',
            'guest_count' => 'required|integer|min:1|max:10',
            'message' => 'nullable|string|max:1000',
        ]);

        $this->rsvpService->submitRsvp($invitation, $validated);

        return NotificationHelper::backWithSuccess('Terima kasih, RSVP dan ucapan Anda telah terkirim!');
    }
}
