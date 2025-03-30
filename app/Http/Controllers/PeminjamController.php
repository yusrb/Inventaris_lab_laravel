<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjam;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Daftar Anggota Peminjam';

        $query = Peminjam::query();

        if ($request->has('peminjam_search')) {
            $search = $request->input('peminjam_search');
            $query->where(function ($q) use ($search) {
                $q->where('name_peminjam', 'LIKE', "%$search%")
                  ->orWhere('kontak_peminjam', 'LIKE', "%$search%");
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
    
    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
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

        Peminjam::create([
            'name_peminjam' => $request->name_peminjam,
            'kontak_peminjam' => $request->kontak_peminjam,
        ]);

        return redirect()->route('peminjam.index')->with('success', 'Berhasil Menambahkan Peminjam.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjam $peminjam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
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

        $get_peminjam->name_peminjam = $request->name_peminjam;
        $get_peminjam->kontak_peminjam = $request->kontak_peminjam;

        $get_peminjam->save();

        return redirect()->route('peminjam.index')->with('update', 'Peminjam Berhasil Di Update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $get_peminjam = Peminjam::findOrFail($id);

        $get_peminjam->delete();

        return redirect()->route('peminjam.index')->with('delete', 'Data Peminjam Berhasil Di Hapus.');
    }
}
