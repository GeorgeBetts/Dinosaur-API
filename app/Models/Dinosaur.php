<?php

namespace App\Models;

use Database\Factories\DinosaurFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dinosaur extends Model
{
    /**
     * @use HasFactory<DinosaurFactory>
     */
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'taxon',
        'period_start',
        'period_end',
        'size_comparison',
        'wikidata_entry',
        'wikipedia_entry',
    ];

    /**
     * @return HasMany<Article, $this>
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * @return HasMany<Image, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * @param  Builder<Dinosaur>  $query
     * @return Builder<Dinosaur>
     */
    public function scopeHasWikipediaEntry(Builder $query): Builder
    {
        return $query->whereNotNull('wikipedia_entry');
    }

    /**
     * @param  Builder<Dinosaur>  $query
     * @return Builder<Dinosaur>
     */
    public function scopeHasImages(Builder $query): Builder
    {
        return $query->has('images');
    }

    /**
     * @param  Builder<Dinosaur>  $query
     * @return Builder<Dinosaur>
     */
    public function scopeHasArticles(Builder $query): Builder
    {
        return $query->has('articles');
    }
}
