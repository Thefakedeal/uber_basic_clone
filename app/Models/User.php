<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    const ROLE_ADMIN = 'Admin';
    const ROLE_DRIVER = 'Driver';
    const ROLE_USER = 'User';

    const ROLES = ['Admin','Driver','User'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'location_updated_at' => 'datetime'
    ];

    public function scopeDrivers($query){
        return $query->where('role', self::ROLE_DRIVER);
    }

    public function scopeNearbyDrivers($query,float $lat,float $lon ,int $distance_in_meters){
        // difference of 0.000009009 equals 1 mtr diff in a flat model
        $difference = $distance_in_meters * 0.000009;
        $min_lat = $lat - $difference;
        $max_lat = $lat + $difference;
        $min_lon = $lon - $difference;
        $max_lon = $lon + $difference;

        return $query->drivers()->whereBetween('latitude',[$min_lat,$max_lat])
        ->whereBetween('longitude',[$min_lon, $max_lon]); 
    }

    public function scopeUsers($query){
        return $query->where('role', self::ROLE_USER);
    }

    public function getLastSeenAttribute(){
        return $this->location_updated_at->diffForHumans();
    }
}
