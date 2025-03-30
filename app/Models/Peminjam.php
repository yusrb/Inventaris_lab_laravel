<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    protected $table = 'peminjams';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name_peminjam', 'kontak_peminjam'
    ];
}
