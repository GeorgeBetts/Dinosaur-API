<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dinosaur extends Model
{
    use HasUuids;

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

    public function scopeHasWikipediaEntry(Builder $query): Builder
    {
        return $query->whereNotNull('wikipedia_entry');
    }

    public function scopeHasImages(Builder $query): Builder
    {
        return $query->has('images');
    }

    public function scopeHasArticles(Builder $query): Builder
    {
        return $query->has('articles');
    }
}
