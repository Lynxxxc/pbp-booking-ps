<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Booking extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'bookings';

    /**
     * Field mengikuti skema database rental_ps (bagian database: Abiyyu).
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'ps_unit_id',
        'start_time',
        'end_time',
        'total_price',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }
}
