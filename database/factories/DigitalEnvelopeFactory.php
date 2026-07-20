<?php

namespace Database\Factories;

use App\Models\DigitalEnvelope;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DigitalEnvelope>
 */
class DigitalEnvelopeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invitation_id' => Invitation::factory(),
            'bank_name' => fake()->randomElement(['BCA', 'BRI', 'OVO', 'QRIS']),
            'account_name' => fake()->name(),
            'account_number' => fake()->numerify('##########'),
            'qr_code_path' => null,
        ];
    }
}
