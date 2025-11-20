<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * 
     *
     * @var string
     */
    protected $table = 'booking';

    /**
     *
     *
     * @var string
     */
    protected $primaryKey = 'id_booking';

    /**
     * 
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'id_petugas',
        'id_room',
        'tipe_booking',
        'harga',
        'durasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'keterangan',
        'alasan_tolak',
    ];

    /**
     * 
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'harga' => 'decimal:2',
    ];

    /**
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     *
     */
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }

    /**
     *
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'id_room');
    }
}
