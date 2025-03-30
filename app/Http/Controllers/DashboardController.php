<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Settings;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Dashboard';

        $total_user = User::count();
        $total_supplier = Supplier::count();
        $total_barang = Barang::count();
        $total_transaksi_barang_masuk = BarangMasuk::count();
        $total_transaksi_barang_keluar = BarangKeluar::count();
        $total_barang_masuk = BarangMasuk::sum('jumlah');
        $total_barang_keluar = BarangKeluar::sum('jumlah');
        $total_peminjaman = Peminjaman::count();
        $total_peminjaman_belum_dikembalikan = Peminjaman::where('status', 'Dipinjam')->count();
        $total_peminjaman_dikembalikan = Peminjaman::where('status', 'Dikembalikan')->count();

        $context = [
            'settings' => $settings,
            'page' => $page,

            'total_user' => $total_user,
            'total_supplier' => $total_supplier,
            'total_barang' => $total_barang,
            'total_barang_masuk' => $total_barang_masuk,
            'total_barang_keluar' => $total_barang_keluar,
            'total_transaksi_barang_masuk' => $total_transaksi_barang_masuk,
            'total_transaksi_barang_keluar' => $total_transaksi_barang_keluar,
            
            'total_peminjaman' => $total_peminjaman,
            'total_peminjaman_belum_dikembalikan' => $total_peminjaman_belum_dikembalikan,
            'total_peminjaman_dikembalikan' => $total_peminjaman_dikembalikan,
        ];
        return view('admin.dashboard.index', $context);
    }
}
