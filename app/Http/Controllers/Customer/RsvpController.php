<?php

namespace App\Http\Controllers\Customer;

use App\Enums\RsvpStatus;
use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Repositories\RsvpRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RsvpController extends Controller
{
    public function __construct(private readonly RsvpRepository $rsvpRepository) {}

    public function index(Request $request, int $invitationId): View
    {
        $invitation = Invitation::findOrFail($invitationId);

        if ($invitation->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak diizinkan mengakses data ini.');
        }

        $rsvps = $this->rsvpRepository->getByInvitationId($invitationId);

        $stats = [
            'total' => $rsvps->sum('guest_count'),
            'hadir' => $rsvps->where('status', RsvpStatus::Hadir)->sum('guest_count'),
            'tidak_hadir' => $rsvps->where('status', RsvpStatus::TidakHadir)->sum('guest_count'),
            'ragu' => $rsvps->where('status', RsvpStatus::Ragu)->sum('guest_count'),
        ];

        return view('customer.invitation.rsvp_index', compact('invitation', 'rsvps', 'stats'));
    }
}
