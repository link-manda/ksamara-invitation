<?php

namespace Database\Factories;

use App\Enums\GalleryType;
use App\Models\Gallery;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Gallery>
 */
class GalleryFactory extends Factory
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
            'file_path' => 'galleries/'.fake()->uuid().'.jpg',
            'type' => GalleryType::Photo,
        ];
    }
}
