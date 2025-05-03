<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCompanion extends Model
{
    use HasFactory;
    protected $table = 'patient_companion';
    protected $fillable = [
        'companion_id','patient_id'
    ];
}
