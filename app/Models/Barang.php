<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    protected $table = 'barangs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_barang', 'name_barang', 'kategori_id', 'jumlah', 'kondisi',
            'stok_minimum', 'deskripsi',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function barangMasuks(): BelongsTo
    {
        return $this->belongsTo(BarangMasuk::class, 'barang_id', 'id');
    }

    public function barangKeluars(): BelongsTo
    {
        return $this->belongsTo(BarangKeluar::class, 'barang_id', 'id');
    }
}
