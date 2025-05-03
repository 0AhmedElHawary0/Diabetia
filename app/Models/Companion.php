<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Companion extends Authenticatable implements JWTSubject
{
    protected $table = 'companions';
    protected $fillable = [
        'name', 'email', 'created_at','updated_at','password','photo','photo_url'
    ];
    use HasFactory;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sensor_patients()
    {
        return $this->belongsToMany(related:SensorPatient::class,
                                    table:'patient_companion',
                                    foreignPivotKey:'patient_id',
                                    relatedPivotKey:'companion_id');
    }
}
