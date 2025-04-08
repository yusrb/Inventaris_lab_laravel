<?php

namespace App\Http\Controllers;

use App\Helpers\LogAktivitasHelper;
use App\Models\Barang;
use App\Models\Peminjam;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    public function index(Request $request)
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Daftar Anggota Peminjam';

        $query = Peminjam::query();

        if ($request->has('peminjam_search')) {
            $search = $request->input('peminjam_search');
            $query->where(function ($q) use ($search) {
                $q->where('name_peminjam', 'LIKE', "%$search%")
                  ->orWhere('kontak_peminjam', 'LIKE', "%$search%")
                  ->orWhere('id', 'LIKE', "%$search%")
                  ->orWhere('created_at', 'LIKE', "%$search%")
                  ->orWhere('updated_at', 'LIKE', "%$search%");
            });
        }

        $all_peminjam = $query->paginate(10);

        return view('admin.peminjam.index', [
            'settings' => $settings,
            'peminjams' => $all_peminjam,
            'page' => $page,
            'search' => $request->input('peminjam_search')
        ]);
    }

    public function create()
    {
        $settings = Settings::first();
        $page = 'Tambah Anggota Peminjam';

        $context = [
            'settings' => $settings, 
            'page' => $page, 
        ];

        return view('Admin.Peminjam.create', data: $context);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_peminjam' => ['required'],
            'kontak_peminjam' => ['required', 'max:12'],
        ], [
            'name_peminjam.required' => 'Nama Peminjam Harus Diisi',
            'kontak_peminjam.required' => 'Kontak Harus Diisi',
            'kontak_peminjam.max' => 'Kontak Maksimal 12 karakter',
        ]);

        $peminjam = Peminjam::create([
            'name_peminjam' => $request->name_peminjam,
            'kontak_peminjam' => $request->kontak_peminjam,
        ]);

        LogAktivitasHelper::catat('Create', 'Peminjam', 'Menambahkan peminjam baru: ' . $peminjam->name_peminjam);

        return redirect()->route('peminjam.index')->with('success', 'Berhasil Menambahkan Peminjam.');
    }

    public function show(Peminjam $peminjam)
    {
        //
    }

    public function edit(string $id)
    {
        $settings = Settings::first();
        $page = 'Update Anggota Peminjam';

        $get_peminjam = Peminjam::findOrFail($id);

        $context = [
            'settings' => $settings,
            'page' => $page,
            'peminjam' => $get_peminjam,
        ];

        return view('admin.peminjam.edit', $context);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_peminjam' => ['required'],
            'kontak_peminjam' => ['required','max:12'],
        ], [
            'name_peminjam.required' => 'Nama Peminjam Harus Diisi',
            'kontak_peminjam.required' => 'Kontak Harus Diisi',
            'kontak_peminjam.max' => 'Kontak Maksimal 12 karakter',
        ]);
    
        $get_peminjam = Peminjam::findOrFail($id);
    
        $nama_lama = $get_peminjam->name_peminjam;
        $kontak_lama = $get_peminjam->kontak_peminjam;
    
        $get_peminjam->name_peminjam = $request->name_peminjam;
        $get_peminjam->kontak_peminjam = $request->kontak_peminjam;
        $get_peminjam->save();
    
        LogAktivitasHelper::catat(
            'Update',
            'Peminjam',
            "Memperbarui peminjam: nama dari '$nama_lama' ke '{$get_peminjam->name_peminjam}', kontak dari '$kontak_lama' ke '{$get_peminjam->kontak_peminjam}'"
        );
    
        return redirect()->route('peminjam.index')->with('update', 'Peminjam Berhasil Di Update.');
    }

    public function destroy(string $id)
    {
        $get_peminjam = Peminjam::findOrFail($id);
        $nama = $get_peminjam->name_peminjam;

        $get_peminjam->delete();

        LogAktivitasHelper::catat('Delete', 'Peminjam', 'Menghapus peminjam: ' . $nama);

        return redirect()->route('peminjam.index')->with('delete', 'Data Peminjam Berhasil Di Hapus.');
    }
}
