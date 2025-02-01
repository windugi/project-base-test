<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExaminationMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'examination_id',  // Tambahkan kolom ini
        'medicine_id',
    ];

    // public function examination()
    // {
    //     return $this->belongsTo(Examination::class, 'examination_id');
    // }

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

 
}
