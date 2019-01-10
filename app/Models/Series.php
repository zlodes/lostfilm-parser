<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $original_name
 * @property string $slug
 *
 * @property Carbon $release_date
 *
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Series extends Model
{
    protected $table = 'series';

    protected $fillable = [
        'name',
        'original_name',
        'slug',
    ];
}
