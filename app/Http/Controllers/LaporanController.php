<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Settings;
use App\Models\Peminjaman;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $settings = Settings::first();
        $page = 'Laporan';

        $tanggalStart = $request->input('tanggal_start');
        $tanggalEnd = $request->input('tanggal_end');
        $filterBy = $request->input('filter_by');

        // Peminjaman
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

        // Barang Masuk & Keluar
        $barangMasuks = BarangMasuk::when($tanggalStart && $tanggalEnd, function ($query) use ($tanggalStart, $tanggalEnd) {
            return $query->whereBetween('tanggal_masuk', [$tanggalStart, $tanggalEnd]);
        })->get();

        $barangKeluars = BarangKeluar::when($tanggalStart && $tanggalEnd, function ($query) use ($tanggalStart, $tanggalEnd) {
            return $query->whereBetween('tanggal_keluar', [$tanggalStart, $tanggalEnd]);
        })->get();

        // Data Barang
        $barangs = Barang::with('kategori')->get();
        $totalBarang = $barangs->sum('jumlah');
        $barangBaik = $barangs->where('kondisi', 'Baik')->sum('jumlah');
        $barangRusak = $barangs->where('kondisi', 'Rusak')->sum('jumlah');
        $barangHilang = $barangs->where('kondisi', 'Hilang')->sum('jumlah');

        // Status Peminjaman
        $totalDipinjam = $peminjamans->where('status', 'Dipinjam')->count();
        $totalDikembalikan = $peminjamans->where('status', 'Dikembalikan')->count();
        $totalHilang = $peminjamans->where('status', 'Hilang')->count();

        $context = [
            'settings' => $settings,
            'page' => $page,
            'peminjamans' => $peminjamans,
            'barangMasuks' => $barangMasuks,
            'barangKeluars' => $barangKeluars,
            'barangs' => $barangs,
            'totalBarang' => $totalBarang,
            'barangBaik' => $barangBaik,
            'barangRusak' => $barangRusak,
            'barangHilang' => $barangHilang,
            'totalDipinjam' => $totalDipinjam,
            'totalDikembalikan' => $totalDikembalikan,
            'totalHilang' => $totalHilang,
        ];

        return view('admin.laporan.index', $context);
    }

    public function exportPDF(Request $request)
    {
        $settings = Settings::first();
        $barangs = Barang::with('kategori')->get();
        $peminjamans = Peminjaman::with(['peminjam', 'barang'])->get();
        $barangMasuks = BarangMasuk::with('barang')->get();
        $barangKeluars = BarangKeluar::with('barang')->get();

        $totalBarang = $barangs->sum('jumlah');
        $barangBaik = $barangs->where('kondisi', 'Baik')->sum('jumlah');
        $barangRusak = $barangs->where('kondisi', 'Rusak')->sum('jumlah');
        $barangHilang = $barangs->where('kondisi', 'Hilang')->sum('jumlah');

        $totalDipinjam = $peminjamans->where('status', 'Dipinjam')->sum('jumlah');
        $totalDikembalikan = $peminjamans->where('status', 'Dikembalikan')->sum('jumlah');
        $totalHilang = $peminjamans->where('status', 'Hilang')->sum('jumlah');

        $context = [
            'settings' => $settings,
            'barangs' => $barangs,
            'peminjamans' => $peminjamans,
            'barangMasuks' => $barangMasuks,
            'barangKeluars' => $barangKeluars,
            'totalBarang' => $totalBarang,
            'barangBaik' => $barangBaik,
            'barangRusak' => $barangRusak,
            'barangHilang' => $barangHilang,
            'totalDipinjam' => $totalDipinjam,
            'totalDikembalikan' => $totalDikembalikan,
            'totalHilang' => $totalHilang,
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', $context)->setPaper('A4', 'portrait');

        return $pdf->download('laporan_inventaris_sekolah.pdf');
    }
}
