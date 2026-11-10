<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLayanan extends Model
{
    use HasFactory;

    protected $table = 'jenis_layanans';

    protected $fillable = [
        'nama',          // Jika di database kolomnya bernama 'nama'
        'nama_layanan',  // Ditambahkan sesuai input form
        'deskripsi'      // Ditambahkan jika ada input deskripsi
    ];
}