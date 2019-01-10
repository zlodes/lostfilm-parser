<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $series_id
 * @property string $name
 * @property string|null $original_name
 *
 * @property Carbon $release_date
 *
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * @property-read Series $series
 * @see Season::series()
 *
 * @property-read Collection|Episode[] $episodes
 * @see Season::episodes()
 */
class Season extends Model
{
    protected $table = 'series';

    protected $fillable = [
        'series_id',
        'name',
        'original_name',
    ];

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class, 'series_id');
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class, 'season_id');
    }
}
