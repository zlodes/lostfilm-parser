<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nicolaslopezj\Searchable\SearchableTrait;

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
    use SearchableTrait;

    protected $table = 'episodes';

    protected $dates = [
        'release_date',
    ];

    protected $fillable = [
        'season_id',
        'name',
        'original_name',
        'slug',
        'release_date',
        'lostfilm_url',
    ];

    public $searchable = [
        'columns' => [
            'series.name' => 10,
            'series.original_name' => 9,
            'episodes.name' => 8,
            'episodes.original_name' => 7,
        ],
        'joins' => [
            'seasons' => ['episodes.season_id', 'seasons.id'],
            'series' => ['seasons.series_id', 'series.id'],
        ],
    ];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'season_id');
    }
}
