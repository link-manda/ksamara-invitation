<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $invitation_id
 * @property string $name
 * @property Carbon $start_time
 * @property Carbon|null $end_time
 * @property string $location_name
 * @property string $location_address
 * @property string|null $google_maps_link
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['invitation_id', 'name', 'start_time', 'end_time', 'location_name', 'location_address', 'google_maps_link'])]
class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }
}
