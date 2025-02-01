<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'dob', 'gender', 'phone', 'address','birth_date'];

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }
}
