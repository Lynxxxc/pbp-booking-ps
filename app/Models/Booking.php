<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use MongoDB\BSON\ObjectId;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function psUnit(): BelongsTo
    {
        return $this->belongsTo(PsUnit::class, 'ps_unit_id');
    }

    /**
     * ID di database tersimpan campuran (string dan ObjectId, tergantung
     * dibuat lewat aplikasi atau langsung di Compass). Fungsi ini memberi
     * semua bentuknya supaya query selalu kena.
     *
     * @return list<mixed>
     */
    public static function bentukId($id): array
    {
        $s = (string) $id;
        try {
            return [$s, new ObjectId($s)];
        } catch (\Exception) {
            return [$s];
        }
    }

    /**
     * Cek apakah unit sudah dibooking pada rentang waktu yang tumpang tindih.
     * Booking berstatus pending/terkonfirmasi/sedang dipakai dianggap mengunci jadwal.
     */
    public static function adaBentrok($unitId, Carbon $start, Carbon $end): bool
    {
        return static::whereIn('ps_unit_id', static::bentukId($unitId))
            ->whereIn('status', ['pending', 'confirmed', 'active'])
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start)
            ->exists();
    }
}
