<?php

namespace Database\Factories;

use App\Models\Dinosaur;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dinosaur_id' => Dinosaur::factory(),
            'url' => $this->faker->url(),
        ];
    }
}
