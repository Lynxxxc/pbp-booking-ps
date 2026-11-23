<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Payment extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'payments';

    /**
     * Field mengikuti skema database rental_ps (bagian database: Abiyyu).
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_id',
        'amount',
        'method',
        'status',
        'paid_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
        ];
    }
}
