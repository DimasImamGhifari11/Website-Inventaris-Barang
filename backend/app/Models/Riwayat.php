<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;

    protected $table = 'riwayat';

    protected $fillable = [
        'kode_barang',
        'nama_aset',
        'perubahan',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
    ];

    protected $casts = [
        'stok_sebelum' => 'integer',
        'stok_sesudah' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
