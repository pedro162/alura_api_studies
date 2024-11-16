<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;

class Episode extends Model
{
    use HasFactory;

    protected $casts = [
        'watched' => 'boolean'
    ];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    /* protected function watched(): Attribute
    {
        //return Attribute::make();
        return new Attribute(
            get: fn($watched) => (bool)$watched,
            set: fn($watched) => (bool) $watched,
        );
    } */

    public function scopeWatched(Builder $query)
    {
        $query->where('watched', true);
    }
}
