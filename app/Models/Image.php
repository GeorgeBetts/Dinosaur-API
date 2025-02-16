<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasUuids;

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
