<?php

namespace App\Models;

use App\Models\Dinosaur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dinosaur_id',
        'name',
        'url',
    ];

    public function dinosaur()
    {
        return $this->belongsTo(Dinosaur::class);
    }
}
