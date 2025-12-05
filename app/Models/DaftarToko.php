<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarToko extends Model
{
    use HasFactory;

    protected $table = 'daftar_toko';
    
    protected $fillable = [
        'kode_spg',
        'nama_spg',
        'divisi',
        'nama_toko',
        'kota'
    ];
}