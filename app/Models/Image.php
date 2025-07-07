<?php

namespace App\Models;

use Database\Factories\ImageFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    /**
     * @use HasFactory<ImageFactory>
     */
    use HasFactory, HasUuids;

    protected $fillable = [
        'url',
        'dinosaur_id',
    ];

    /**
     * @return BelongsTo<Dinosaur, $this>
     */
    public function dinosaur(): BelongsTo
    {
        return $this->belongsTo(Dinosaur::class);
    }
}
