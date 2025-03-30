<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name_supplier', 'kontak', 'alamat',
    ];

    public function barang_masuks(): HasMany
    {
        return $this->hasMany(BarangMasuk::class, 'supplier_id', 'id');
    }

    public function barang_keluars(): HasMany
    {
        return $this->hasMany(BarangKeluar::class, 'supplier_id', 'id');
    }
}
