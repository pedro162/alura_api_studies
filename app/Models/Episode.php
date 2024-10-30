<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
}
