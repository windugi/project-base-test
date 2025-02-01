<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;
    
    protected $fillable = [   
    'patient_id',
    'doctor_id',
    'referral_letter',
    'vital_signs',
    'examination_result',
    'medicines',
    'status',
    'tanggal_diterima'
    ];



    public function medicines()
    {
        return $this->hasMany(ExaminationMedicine::class, 'examination_id');
    }
    

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}

