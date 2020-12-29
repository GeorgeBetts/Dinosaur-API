<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dinosaur extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'taxon',
        'start_time',
        'end_time',
        'wikidata_entry',
        'wikipedia_entry',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
