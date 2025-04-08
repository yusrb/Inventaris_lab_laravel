<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $settings = Settings::first();
        $page = 'Riwayat Aktivitas';
        $logs = LogAktivitas::with('user')
            ->latest()
            ->paginate(perPage: 10);

        $context = [
            'settings' => $settings,
            'page' => $page,
            'logs' => $logs,
        ];

        return view('admin.logAktivitas.index', $context);
    }

    public function clear()
    {
        LogAktivitas::truncate();

        \App\Helpers\LogAktivitasHelper::catat(
            'Delete',
            'Log Aktivitas',
            'Seluruh riwayat aktivitas dihapus oleh ' . Auth::user()->name
        );

        return redirect()->route('log_aktivitas.index')->with('success', 'Semua log aktivitas berhasil dihapus!');
    }
}
