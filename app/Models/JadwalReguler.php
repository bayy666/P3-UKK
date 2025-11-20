<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalReguler extends Model
{
    use HasFactory;

    /**
     * 
     *
     * @var string
     */
    protected $table = 'jadwal_reguler';

    /**
     * 
     *
     * @var string
     */
    protected $primaryKey = 'id_reguler';

    /**
     * 
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_reguler',
        'id_room',
        'id_user',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
    ];

    /**
     * 
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    /**
     * 
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'id_room');
    }

    /**
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
