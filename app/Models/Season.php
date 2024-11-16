<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    use HasFactory;

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class, 'season_id', 'id');
    }

    public function numberOfWatchedEpisodes(): int
    {
        return $this->episodes
            ->filter(fn($episode) => $episode->watched)
            ->count();
    }
}
