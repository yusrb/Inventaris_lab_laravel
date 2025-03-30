<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluars';
    protected $primaryKey = 'id';

    protected $fillable = [
        'barang_id', 'jumlah', 'tanggal_keluar', 'penerima', 'keterangan', 'supplier_id'
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
