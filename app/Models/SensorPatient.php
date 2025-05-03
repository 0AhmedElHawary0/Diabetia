<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class SensorPatient extends Authenticatable implements JWTSubject
{
    protected $table = 'sensor_patients';
    protected $fillable = [
        'name', 'email', 'created_at','updated_at','password','gender','weight','age','diabetes_type','photo','photo_url'
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

    public function companions()
    {
        return $this->belongsToMany(related:Companion::class,
                                    table:'patient_companion',
                                    foreignPivotKey:'patient_id',
                                    relatedPivotKey:'companion_id');
    }
}

