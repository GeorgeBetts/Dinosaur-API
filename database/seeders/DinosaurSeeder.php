<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Dinosaur;
use App\Models\Image;
use Illuminate\Database\Seeder;

class DinosaurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear previous data
        Dinosaur::query()->delete();

        // Read data from JSON file
        $data = json_decode(file_get_contents('database/data/wikidata_dinosaurs.json'), true);

        // Create the dinosaur, image and articles records
        foreach ($data as $value) {
            // Validate the potentially missing fields
            $value = [
                'dinosaur' => $value['dinosaur'],
                'dinosaurLabel' => $value['dinosaurLabel'],
                'startTime' => $value['startTime'] ?? null,
                'endTime' => $value['endTime'] ?? null,
                'sizeComparison' => $value['sizeComparison'] ?? null,
                'encyclopedia' => $value['encyclopedia'] ?? null,
                'taxon' => $value['taxon'] ?? null,
                'article' => $value['article'] ?? null,
                'image' => $value['image'] ?? null,
            ];

            // Add the dino if it doesn't exist already
            $dinosaur = Dinosaur::firstOrCreate(
                [
                    'name' => $value['dinosaurLabel'],
                ],
                [
                    'taxon' => $value['taxon'],
                    'period_start' => $value['startTime'],
                    'period_end' => $value['endTime'],
                    'size_comparison' => $value['sizeComparison'],
                    'wikidata_entry' => $value['dinosaur'],
                    'wikipedia_entry' => $value['article'],
                ]
            );

            // Add this image for the dino
            if ($value['image']) {
                Image::firstOrCreate([
                    'dinosaur_id' => $dinosaur->id,
                    'url' => $value['image'],
                ]);
            }
            // Add this article for the dino
            if ($value['encyclopedia']) {
                Article::firstOrCreate(
                    [
                        'dinosaur_id' => $dinosaur->id,
                        'url' => 'https://www.britannica.com/'.$value['encyclopedia'],
                    ],
                    [
                        'title' => 'Encyclopedia Britannica',
                    ]
                );
            }
        }
    }
}
