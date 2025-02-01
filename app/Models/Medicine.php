<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'nama',
        'token',
        'harga',
        'start_date',
        'end_date',
    ];
}