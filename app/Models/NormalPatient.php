<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class NormalPatient extends Authenticatable implements JWTSubject
{
    protected $table = 'normal_patients';
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
}
