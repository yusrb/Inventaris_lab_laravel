<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Daftar Supplier';

        $query = Supplier::query();

        if ($request->has('supplier_search'))
        {
            $search = $request->input('supplier_search');
            $query->where('name_supplier', 'LIKE', "%{$search}%")
                 ->orWhere('kontak', 'LIKE', "%{$search}%")
                 ->orWhere('alamat', 'LIKE', "%{$search}%");
        }

        $suppliers = $query->get();

        $context = [
            'settings' => $settings,
            'page' => $page,
            'suppliers' => $suppliers
        ];

        return view('Admin.Supplier.index', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Tambah Supllier';

        $context = [
            'settings' => $settings,
            'page' => $page,
        ];

        return view('admin.supplier.create', $context);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_supplier' => ['required', 'max:50'],
            'kontak' => ['required', 'numeric', 'min:8'],
            'alamat' => ['required'],
        ], [
            'name_supplier.required' => 'Nama Supplier harus diisi!',
            'name_supplier.max' => 'Nama Supplier maksimal 8 karakter!',
            'kontak.required' => 'Kontak harus diisi!',
            'kontak.numeric' => 'Kontak harus berupa angka!',
            'kontak.min' => 'Kontak minimal 8 karakter!',
            'alamat.required' => 'Alamat harus diisi!',
        ]);

        Supplier::create([
            'name_supplier' => $request->name_supplier,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier Berhasil Ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $supplier = Supplier::with([
            'barang_masuks' => function ($query) use ($request) {
                if ($request->has('barang_masuk_search')) {
                    $search = $request->input('barang_masuk_search');
                    $query->where('name_barang', 'LIKE', "%{$search}%")
                        ->orWhere('kode_barang', 'LIKE', "%{$search}%");
                }
            },
            'barang_keluars' => function ($query) use ($request) {
                if ($request->has('barang_keluar_search')) {
                    $search = $request->input('barang_keluar_search');
                    $query->where('name_barang', 'LIKE', "%{$search}%")
                        ->orWhere('kode_barang', 'LIKE', "%{$search}%");
                }
            }
        ])->findOrFail($id);

        $settings = Settings::where('id', 1)->first();
        $page = "Detail Supplier - " . $supplier->name_supplier;

        $context = [
            'supplier' => $supplier,
            'settings' => $settings,
            'page' => $page,
            'barang_masuk_search' => $request->barang_masuk_search ?? '',
            'barang_keluar_search' => $request->barang_keluar_search ?? '',
        ];

        return view('admin.supplier.detail', $context);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Update Supplier';

        $get_supplier = Supplier::findOrFail($id);

        $context = [
            'settings' => $settings,
            'page' => $page,

            'supplier' => $get_supplier,
        ];

        return view('Admin.Supplier.edit', $context);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_supplier' => ['required', 'max:50'],
            'kontak' => ['required', 'numeric', 'min:8'],
            'alamat' => ['required'],
        ], [
            'name_supplier.required' => 'Nama Supplier harus diisi!',
            'name_supplier.max' => 'Nama Supplier maksimal 8 karakter!',
            'kontak.required' => 'Kontak harus diisi!',
            'kontak.numeric' => 'Kontak harus berupa angka!',
            'kontak.min' => 'Kontak minimal 8 karakter!',
            'alamat.required' => 'Alamat harus diisi!',
        ]);

        $supplier = Supplier::findOrFail($id);

        $supplier->name_supplier = $request->name_supplier;
        $supplier->kontak = $request->kontak;
        $supplier->alamat = $request->alamat;

        $supplier->save();

        return redirect()->route('supplier.index')->with('update', 'Supplier Berhasil di Update!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Supplier::destroy($id);

        return redirect()->route('supplier.index')->with('delete', 'Supplier Berhasil di Delete!');
    }
}
