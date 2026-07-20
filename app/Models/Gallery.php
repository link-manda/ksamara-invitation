<?php

namespace App\Models;

use App\Enums\GalleryType;
use Database\Factories\GalleryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $invitation_id
 * @property string $file_path
 * @property GalleryType $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['invitation_id', 'file_path', 'type'])]
class Gallery extends Model
{
    /** @use HasFactory<GalleryFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'type' => GalleryType::class,
        ];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }
}
