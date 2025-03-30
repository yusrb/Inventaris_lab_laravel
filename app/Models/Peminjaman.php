<?php

namespace App\Models;

use App\Models\User;
use App\Models\Barang;
use App\Models\Peminjam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'peminjam_id',
        'user_id',
        'barang_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    public function peminjam(): BelongsTo
    {
        return $this->belongsTo(Peminjam::class, 'peminjam_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }
}
