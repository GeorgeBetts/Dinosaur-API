<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Dinosaur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'dinosaur_id' => Dinosaur::factory(),
            'url' => $this->faker->url(),
        ];
    }
}
