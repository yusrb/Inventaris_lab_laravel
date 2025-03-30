<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\Settings;
use App\Models\Peminjaman;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $settings = Settings::first();
        $page = 'Laporan';

        $tanggalStart = $request->input('tanggal_start');
        $tanggalEnd = $request->input('tanggal_end');
        $filterBy = $request->input('filter_by');

        $peminjamanQuery = Peminjaman::with(['peminjam', 'barang'])
            ->when($tanggalStart && $tanggalEnd, function ($query) use ($tanggalStart, $tanggalEnd) {
                return $query->whereBetween('tanggal_pinjam', [$tanggalStart, $tanggalEnd]);
            });

        if ($filterBy) {
            if ($filterBy == 'hari') {
                $peminjamanQuery->whereDate('tanggal_pinjam', '=', now()->format('Y-m-d'));
            } elseif ($filterBy == 'bulan') {
                $peminjamanQuery->whereMonth('tanggal_pinjam', '=', now()->month);
            } elseif ($filterBy == 'tahun') {
                $peminjamanQuery->whereYear('tanggal_pinjam', '=', now()->year);
            }
        }

        $peminjamans = $peminjamanQuery->get();


        $barangMasuks = BarangMasuk::when($tanggalStart && $tanggalEnd, function ($query) use ($tanggalStart, $tanggalEnd) {
            return $query->whereBetween('tanggal_masuk', [$tanggalStart, $tanggalEnd]);
        })->get();

        $barangKeluars = BarangKeluar::when($tanggalStart && $tanggalEnd, function ($query) use ($tanggalStart, $tanggalEnd) {
            return $query->whereBetween('tanggal_keluar', [$tanggalStart, $tanggalEnd]);
        })->get();

        $totalDipinjam = Peminjaman::where('status', 'Dipinjam')->count();
        $totalDikembalikan = Peminjaman::where('status', 'Dikembalikan')->count();
        $totalHilang = Peminjaman::where('status', 'Hilang')->count();
    
        $context = [
            'settings' => $settings,
            'page' => $page,
            'peminjamans' => $peminjamans,
            'barangMasuks' => $barangMasuks,
            'barangKeluars' => $barangKeluars,
            'totalDipinjam' => $totalDipinjam,
            'totalDikembalikan' => $totalDikembalikan,
            'totalHilang' => $totalHilang
        ];

        return view('admin.laporan.index', $context);
    }
}
