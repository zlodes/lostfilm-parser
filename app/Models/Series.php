<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int $id
 * @property string $name
 * @property string|null $original_name
 * @property string $slug
 *
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * @property-read Collection|Season[] $seasons
 * @see Series::seasons()
 *
 * @property-read Collection|Episode[] $episodes
 * @see Series::episodes()
 */
class Series extends Model
{
    protected $table = 'series';

    protected $fillable = [
        'name',
        'original_name',
        'slug',
    ];

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class, 'series_id');
    }

    public function episodes(): HasManyThrough
    {
        return $this->hasManyThrough(Episode::class, Season::class);
    }
}
