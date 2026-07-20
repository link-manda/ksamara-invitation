<?php

namespace App\Models;

use App\Enums\InvitationStatus;
use Database\Factories\InvitationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property int $template_id
 * @property string $slug
 * @property string $title
 * @property string $groom_name
 * @property string $bride_name
 * @property string $groom_parents
 * @property string $bride_parents
 * @property string|null $music_path
 * @property InvitationStatus $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['user_id', 'order_id', 'template_id', 'slug', 'title', 'groom_name', 'bride_name', 'groom_parents', 'bride_parents', 'music_path', 'status'])]
class Invitation extends Model
{
    /** @use HasFactory<InvitationFactory> */
    use HasFactory;

    protected $attributes = [
        'status' => InvitationStatus::Draft,
    ];

    protected function casts(): array
    {
        return [
            'status' => InvitationStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(Rsvp::class);
    }

    public function digitalEnvelopes(): HasMany
    {
        return $this->hasMany(DigitalEnvelope::class);
    }
}
