<?php

namespace App\Helpers;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class LogAktivitasHelper
{
    public static function catat(string $aksi, string $modul, ?string $keterangan = null)
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => $aksi,
            'modul' => $modul,
            'keterangan' => $keterangan,
        ]);
    }
}
