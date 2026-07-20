<?php

namespace Database\Factories;

use App\Enums\RsvpStatus;
use App\Models\Invitation;
use App\Models\Rsvp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rsvp>
 */
class RsvpFactory extends Factory
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
            'guest_name' => fake()->name(),
            'status' => fake()->randomElement(RsvpStatus::cases()),
            'guest_count' => fake()->numberBetween(1, 4),
            'message' => fake()->optional()->sentence(),
        ];
    }
}
