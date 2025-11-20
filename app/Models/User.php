<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * 
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * 
     * 
     */
    // 

    /**
     * 
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'nama',
        'email',
        'password',
        'role',
        'no_telepon',
        'alamat',
    ];

    /**
     *
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->orWhere('email', $username)->first();
    }

    /**
     * 
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'username'; 
    }

    /**
     *
     *
     * @return array<string, string>
     */
        protected function casts(): array
    {
        return [];
    }

    /**
     * 
     */
    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'id_user');
    }

    /**
     *
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_user');
    }

    /**
     *                           
     */
    public function jadwalRegulers()
    {
        return $this->hasMany(JadwalReguler::class, 'id_user');
    }
}
