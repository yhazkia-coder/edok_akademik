<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model   // pastikan P huruf besar
{
    protected $fillable = [
        'user_id',
        'jenis_layanan_id',
        'no_pengajuan',
        'status',
        'catatan_admin',
        // tambahkan kolom lain yang sudah ada di modelmu
    ];

    // Relasi ke siswa yang mengajukan
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke jenis layanan
    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class, 'jenis_layanan_id');
    }
}
