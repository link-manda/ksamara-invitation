<?php

namespace App\Models;

use App\Enums\RsvpStatus;
use Database\Factories\RsvpFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $invitation_id
 * @property string $guest_name
 * @property RsvpStatus $status
 * @property int $guest_count
 * @property string|null $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['invitation_id', 'guest_name', 'status', 'guest_count', 'message'])]
class Rsvp extends Model
{
    /** @use HasFactory<RsvpFactory> */
    use HasFactory;

    protected $attributes = [
        'guest_count' => 1,
    ];

    protected function casts(): array
    {
        return [
            'status' => RsvpStatus::class,
            'guest_count' => 'integer',
        ];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }
}
