<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PsUnit extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'ps_units';

    /**
     * Field mengikuti skema database rental_ps (bagian database: Abiyyu).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'price_per_hour',
        'status',
        'description',
    ];
}
