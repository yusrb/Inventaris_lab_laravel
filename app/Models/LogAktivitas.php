<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'logs_aktivitas';

    protected $fillable = ['user_id', 'aksi', 'modul', 'keterangan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
