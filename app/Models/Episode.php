<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string|null $original_name
 * @property string $slug
 * @property string $lostfilm_url
 * @property Carbon $release_date
 *
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 *
 * @property-read Season $season
 * @see Episode::season()
 */
class Episode extends Model
{
    protected $table = 'episodes';

    protected $fillable = [
        'season_id',
        'name',
        'original_name',
        'slug',
        'release_date',
        'lostfilm_url',
    ];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
}
