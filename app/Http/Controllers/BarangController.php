<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Helpers\LogAktivitasHelper;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Daftar Barang';

        $query = Barang::query();

        if ($request->has('barang_search')) {
            $search = $request->input('barang_search');
            $query->where('name_barang', 'LIKE', "%{$search}%")
                ->orWhere('kode_barang', 'LIKE', "%{$search}%")
                ->orWhereHas('kategori', function ($q) use ($search) {
                    $q->where('name_kategori', 'LIKE', "%{$search}%");
                });
        }

        $barangs = $query->get();

        $context = [
            'settings' => $settings,
            'page' => $page,
            'barangs' => $barangs,
        ];

        return view('admin.barang.index', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Tambah Barang';

        $all_kategori = Kategori::all();

        $context = [
            'settings' => $settings,
            'page' => $page,
            'kategoris' => $all_kategori
        ];

        return view('admin.barang.create', $context);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => ['required', 'unique:barangs,kode_barang'],
            'name_barang' => ['required', 'max:45'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'jumlah' => ['required', 'integer'],
            'kondisi' => ['required', 'in:Baik,Rusak'],
            'stok_minimum' => ['required', 'integer'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'kode_barang.required' => 'Kode Barang Harus Diisi!',
            'kode_barang.unique' => 'Kode Barang Sudah Terdaftar!',
            'name_barang.required' => 'Nama Barang Harus Diisi!',
            'kategori_id.required' => 'Kategori Harus Diisi!',
            'kategori_id.exists' => 'Kategori Tidak Valid!',
            'jumlah.required' => 'Jumlah Harus Diisi!',
            'jumlah.integer' => 'Jumlah Harus Berupa Angka!',
            'kondisi.required' => 'Kondisi Harus Diisi!',
            'kondisi.in' => 'Kondisi harus Baik atau Rusak!',
            'stok_minimum.required' => 'Stok Minimum Harus Diisi!',
            'stok_minimum.integer' => 'Stok Minimum Harus Berupa Angka!',
        ]);

        $barang = Barang::create([
            'kode_barang' => $request->kode_barang,
            'name_barang' => $request->name_barang,
            'kategori_id' => $request->kategori_id,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'stok_minimum' => $request->stok_minimum,
            'deskripsi' => $request->deskripsi,
        ]);

        LogAktivitasHelper::catat('create', 'Barang', 'User ' . Auth::user()->username . ' menambahkan Barang ' . $barang->name_barang);

        return redirect()->route('barang.index')->with('success', 'Barang Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Update Barang';

        $get_barang = Barang::findOrFail($id);
        $all_kategori = Kategori::all();

        $context = [
            'settings' => $settings,
            'page' => $page,
            'barang' => $get_barang,
            'kategoris' => $all_kategori,
        ];

        return view('admin.barang.edit', $context);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barang = Barang::findOrFail($id);
        $old_name = $barang->name_barang;
    
        $request->validate([
            'kode_barang' => ['required'],
            'name_barang' => ['required'],
            'kategori_id' => ['required'],
            'jumlah' => ['required', 'integer'],
            'kondisi' => ['required', 'in:Baik,Rusak'],
            'stok_minimum' => ['required', 'integer'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'kode_barang.required' => 'Kode Barang Harus Diisi!',
            'name_barang.required' => 'Nama Barang Harus Diisi!',
            'kategori_id.required' => 'Kategori Harus Diisi!',
            'jumlah.required' => 'Jumlah Harus Diisi!',
            'jumlah.integer' => 'Kategori Harus Berupa Angka!',
            'kondisi.integer' => 'Kondisi Harus Diisi!',
            'kondisi.in' => 'Kondisi Harus Berupa Baik Atau Rusak!',
            'stok_minimum.required' => 'Stok Minimum Harus Diisi!',
            'deskripsi.required' => 'Deskripsi Harus Diisi!',
        ]);
    
        $barang->update([
            'kode_barang' => $request->kode_barang,
            'name_barang' => $request->name_barang,
            'kategori_id' => $request->kategori_id,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'stok_minimum' => $request->stok_minimum,
            'deskripsi' => $request->deskripsi,
        ]);
    
        LogAktivitasHelper::catat(
            'update',
            'Barang',
            'User ' . Auth::user()->username . ' mengupdate Barang dari "' . $old_name . '" menjadi "' . $barang->name_barang . '"'
        );
    
        return redirect()->route('barang.index')->with('update', 'Barang Berhasil Di Update!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);

        LogAktivitasHelper::catat('delete', 'Barang', 'User ' . Auth::user()->username . ' menghapus Barang ' . $barang->name_barang);

        $barang->delete();

        return redirect()->route('barang.index')->with('delete', 'Barang berhasil Didelete!');
    }
}
