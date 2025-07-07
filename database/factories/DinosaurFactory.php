<?php

namespace Database\Factories;

use App\Models\Dinosaur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dinosaur>
 */
class DinosaurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'taxon' => $this->faker->word(),
            'period_start' => $this->faker->year(),
            'period_end' => $this->faker->year(),
            'size_comparison' => null,
            'wikidata_entry' => $this->faker->url(),
            'wikipedia_entry' => $this->faker->url(),
        ];
    }
}
