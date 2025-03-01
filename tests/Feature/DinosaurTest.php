<?php

namespace Tests\Feature;

use App\Models\Dinosaur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DinosaurTest extends TestCase
{
    use RefreshDatabase;

    public function test_listing_dinosaur_resource(): void
    {
        Dinosaur::factory()
            ->hasArticles(2)
            ->hasImages(2)
            ->count(3)
            ->create();

        $response = $this->get('/api/dinosaurs');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'wikipedia_entry', 'images'],
            ],
            'links',
        ]);
    }

    public function test_index_filters_by_name(): void
    {
        Dinosaur::factory()->create(['name' => 'Tyrannosaurus']);
        Dinosaur::factory()->create(['name' => 'Velociraptor']);

        $response = $this->getJson('/api/dinosaurs?name=Tyrannosaurus');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['name' => 'Tyrannosaurus']);
    }

    public function test_index_filters_by_exact_name(): void
    {
        Dinosaur::factory()->create(['name' => 'Tyrannosaurus']);
        Dinosaur::factory()->create(['name' => 'Tyrannosaurus Rex']);

        $response = $this->getJson('/api/dinosaurs?name=Tyrannosaurus&exact_match=true');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['name' => 'Tyrannosaurus']);
    }

    public function test_index_filters_by_has_wikipedia_entry(): void
    {
        $wikipediaEntry = fake()->url;
        Dinosaur::factory()->create(['wikipedia_entry' => $wikipediaEntry]);
        Dinosaur::factory()->create(['wikipedia_entry' => null]);

        $response = $this->getJson('/api/dinosaurs?has_wikipedia_entry=true');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['wikipedia_entry' => $wikipediaEntry]);
    }

    public function test_index_filters_by_has_image(): void
    {
        Dinosaur::factory()
            ->hasImages()
            ->create();
        Dinosaur::factory()->create();

        $response = $this->getJson('/api/dinosaurs?has_image=true');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_index_filters_by_has_article(): void
    {
        Dinosaur::factory()
            ->hasArticles()
            ->create();
        Dinosaur::factory()->create();

        $response = $this->getJson('/api/dinosaurs?has_article=true');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    public function test_show_returns_dinosaur_with_related_data(): void
    {
        $dinosaur = Dinosaur::factory()
            ->hasArticles(2)
            ->hasImages(2)
            ->create();

        $response = $this->getJson("/api/dinosaurs/{$dinosaur->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id', 'name', 'images', 'articles',
            ]);
    }
}
