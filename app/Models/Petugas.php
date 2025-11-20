<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    /**
     * 
     *
     * @var string
     */
    protected $table = 'petugas';

    /**
     *
     *
     * @var string
     */
    protected $primaryKey = 'id_petugas';

    /**
     *
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_petugas',
        'id_user',
        'no_hp',
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
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_petugas');
    }
}
