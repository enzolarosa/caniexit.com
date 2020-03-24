<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Collection;

/**
 * Class Country
 * @package App
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property Collection $source
 * @property Collection $mapping
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Country extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'source',
        'mapping',
    ];

    protected $casts = [
        'source' => 'collection',
        'mapping' => 'collection',
    ];
}
