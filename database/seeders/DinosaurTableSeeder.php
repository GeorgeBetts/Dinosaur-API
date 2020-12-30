<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Dinosaur;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DinosaurTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Clear previous data
        DB::table('dinosaurs')->delete();
        //Read data from JSON file
        $data = json_decode(file_get_contents('database/data/wikidata_dinosaurs.json'), true);
        //Create the dinosaur, image and articles records
        foreach ($data as $value) {
            //Validate the potentially missing fields
            if (!isset($value['startTime'])) {
                $value['startTime'] = null;
            }
            if (!isset($value['endTime'])) {
                $value['endTime'] = null;
            }
            if (!isset($value['sizeComparison'])) {
                $value['sizeComparison'] = null;
            }
            if (!isset($value['encyclopedia'])) {
                $value['encyclopedia'] = null;
            }
            if (!isset($value['taxon'])) {
                $value['taxon'] = null;
            }
            if (!isset($value['article'])) {
                $value['article'] = null;
            }
            //Add the dino if it doesn't exist already
            $dinosaur = Dinosaur::firstOrCreate(
                [
                    'name' => $value['dinosaurLabel']
                ],
                [
                    'taxon' => $value['taxon'],
                    'start_time' => $value['startTime'],
                    'end_time' => $value['endTime'],
                    'size_comparison' => $value['sizeComparison'],
                    'wikidata_entry' => $value['dinosaur'],
                    'wikipedia_entry' => $value['article'],
                ]
            );
            //Add this image for the dino
            if ($value['image']) {
                Image::firstOrCreate([
                    'dinosaur_id' => $dinosaur->id,
                    'url' => $value['image']
                ]);
            }
            //Add this article for the dino
            if ($value['encyclopedia']) {
                Article::firstOrCreate(
                    [
                        'dinosaur_id' => $dinosaur->id,
                        'url' => 'https://www.britannica.com/' . $value['encyclopedia']
                    ],
                    [
                        'name' => 'Encyclopedia Britannica'
                    ]
                );
            }
        }
    }
}
