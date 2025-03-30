<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\Barang;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Daftar Kategori';

        $query = Kategori::query();

        if ($request->has('kategori_search'))
        {
            $search = $request->input('kategori_search');
            $query->where('name_kategori', 'LIKE', "%{$search}%");
        }

        $kategoris = $query->get();
        
        $context = [
            'settings' => $settings,
            'page' => $page,

            'kategoris' => $kategoris,
        ];
        return view('admin.kategori.index', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Tambah Kategori';
        $context = [
            'settings' => $settings,
            'page' => $page,
        ];

        return view('admin.kategori.create', $context);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_kategori' => ['required', 'unique:kategoris,name_kategori'],
        ], [
            'name_kategori.required' => 'Nama Kategori Harus Diisi!',
            'name_kategori.unique' => 'Nama Kategori Sudah ada!',
        ]);

        Kategori::create([
            'name_kategori' => $request->name_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Berhasil Menambah Kategori');
    }

    /**
     * Display the specified resource.
     */

    public function show(Request $request, string $id)
    {
        $get_all_barang_from_kategori = Kategori::with(['barangs' => function ($query) use ($request) {
            if ($request->has('barang_search')) {
                $search = $request->input('barang_search');
                $query->where('name_barang', 'LIKE', "%{$search}%")
                      ->orWhere('kode_barang', 'LIKE', "%{$search}%");
            }
        }])->findOrFail($id);
        
        $settings = Settings::where('id', 1)->first();
        $page = $get_all_barang_from_kategori->name_kategori;
    
        $context = [
            'kategori' => $get_all_barang_from_kategori,
            'settings' => $settings,
            'page' => $page,
            'barang_search' => $request->barang_search ?? '',
        ];
    
        return view('admin.kategori.detail', $context);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $settings = Settings::where('id', 1)->first();
        $get_kategori = Kategori::findOrFail($id);
        $page = 'Tambah Kategori';

        $context = [
            'settings' => $settings,
            'page' => $page,

            'kategori' => $get_kategori,
        ];
        
        return view('admin.kategori.edit', $context);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_kategori' => ['required', 'unique:kategoris,name_kategori'],
        ], [
            'name_kategori.required' => 'Nama Kategori Harus Diisi!',
            'name_kategori.unique' => 'Nama Kategori Sudah ada!',
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->name_kategori = $request->name_kategori;

        $kategori->save();

        return redirect()->route('kategori.index')->with('update', 'Kategori Berhasil di Update!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Kategori::destroy($id);

        return redirect()->route('kategori.index')->with('delete', 'Kategori Berhasil di Update!');
    }
}
