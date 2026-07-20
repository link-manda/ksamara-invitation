<?php

namespace App\Models;

use Database\Factories\DigitalEnvelopeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $invitation_id
 * @property string $bank_name
 * @property string $account_name
 * @property string|null $account_number
 * @property string|null $qr_code_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['invitation_id', 'bank_name', 'account_name', 'account_number', 'qr_code_path'])]
class DigitalEnvelope extends Model
{
    /** @use HasFactory<DigitalEnvelopeFactory> */
    use HasFactory;

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }
}
