<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     *
     *
     * @var string
     */
    protected $table = 'room';

    /**
     * 
     *
     * @var string
     */
    protected $primaryKey = 'id_room';

    /**
     *
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_room',
        'lokasi',
        'deskripsi',
        'kapasitas',
    ];

    /**
     
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_room');
    }

    /**
     * 
     */
    public function jadwalRegulers()
    {
        return $this->hasMany(JadwalReguler::class, 'id_room');
    }

    /**
     *
     *
     * @param  string  $tanggalMulai
     * @param  string  $tanggalSelesai
     */
    public function isAvailable($tanggalMulai, $tanggalSelesai, $excludeBookingId = null): bool
    {
        $startDateTime = Carbon::parse($tanggalMulai);
        $endDateTime = Carbon::parse($tanggalSelesai);

       
        $overlappingBookings = $this->bookings()
            ->whereIn('status', ['diterima', 'proses']) // Cek booking yang diterima atau masih proses
            ->when($excludeBookingId, function ($q) use ($excludeBookingId) {
                $q->where('id_booking', '!=', $excludeBookingId);
            })
            ->where(function ($query) use ($startDateTime, $endDateTime) {
               
                $query->where(function($q) use ($startDateTime, $endDateTime) {
                    
                    $q->where('tanggal_mulai', '<', $endDateTime)
                      ->where('tanggal_selesai', '>', $startDateTime);
                });
            })
            ->count();

        if ($overlappingBookings > 0) {
            return false;
        }

        
        $startDate = $startDateTime->toDateString();
        $endDate = $endDateTime->toDateString();

        $overlappingRegular = $this->jadwalRegulers()
            ->where(function ($q) use ($startDate, $endDate) {
                $q->where('tanggal_mulai', '<=', $endDate)
                  ->where('tanggal_selesai', '>=', $startDate);
            })
            ->count();

        return $overlappingRegular === 0;
    }

    /**
     *
     */
    public function priceForRange($start, $end): float
    {
        
        return 0.0;
    }
}
