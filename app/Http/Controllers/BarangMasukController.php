<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Settings;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = Settings::first();
        $title = Settings::where('id', 1)->pluck('name_website')->first();
        $page = 'Tambah Barang Masuk';

        $barangMasuks = BarangMasuk::with(['barang', 'supplier'])
            ->orderBy('tanggal_masuk', 'desc')
            ->get()
            ->groupBy('tanggal_masuk');

        $perPage = 1;
        $currentPage = $request->input('page', 1);

        $tanggalKeys = $barangMasuks->keys();
        $paginatedTanggal = new LengthAwarePaginator(
            $tanggalKeys->slice(($currentPage - 1) * $perPage, $perPage)->values(),
            $tanggalKeys->count(),
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );

        $paginatedBarangMasuks = collect($barangMasuks)
            ->only($paginatedTanggal->items());
    
        $context = [
            'settings' => $settings,
            'title' => $title,
            'page' => $page,
            'barang_masuks' => $paginatedBarangMasuks,
            'paginatedTanggal' => $paginatedTanggal,
        ];
    
        return view('admin.barangmasuk.index', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Tambah Barang Masuk';

        $all_barang = Barang::all();
        $all_supplier = Supplier::all();
        $cart = session()->get('cart', []);

        $context = [
            'settings' => $settings,
            'page' => $page,
            'barangs' => $all_barang,
            'suppliers' => $all_supplier,
            'cart' => $cart,
        ];

        return view('admin.barangmasuk.create', $context);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('barang_masuk.create')->with('error', 'Keranjang masih kosong.');
        }
    
        $barang_masuk_ids = [];
    
        foreach ($cart as $item) {
            $barang_masuk = BarangMasuk::create([
                'barang_id' => $item['barang_id'],
                'supplier_id' => $item['supplier_id'],
                'jumlah' => $item['jumlah'],
                'tanggal_masuk' => $item['tanggal_masuk'],
                'keterangan' => $item['keterangan'],
            ]);
    
            $barang = Barang::find($item['barang_id']);
            $barang->update(['jumlah' => $barang->jumlah + $item['jumlah']]);
    
            $barang_masuk_ids[] = $barang_masuk->id;
        }
    
        session()->forget('cart');
    
        return redirect()->route('barang_masuk.show', ['ids' => implode(',', $barang_masuk_ids)])
                         ->with('success', 'Semua barang berhasil masuk.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show($ids)
    {
        $settings = Settings::first();
        $page = 'Detail Barang Masuk';

        $barang_masuk_list = BarangMasuk::whereIn('id', explode(',', $ids))->with(['barang', 'supplier'])->get();

        if ($barang_masuk_list->isEmpty()) {
            return redirect()->route('barang_masuk.index')->with('error', 'Data barang tidak ditemukan.');
        }

        $context = [
            'settings' => $settings,
            'page' => $page,
            'barang_masuk_list' => $barang_masuk_list,
        ];

        return view('admin.barangmasuk.detail', $context);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Update Barang Masuk';

        $get_barang_masuk = BarangMasuk::findOrFail($id);

        $all_barang = Barang::all();
        $all_supplier = Supplier::all();

        $context = [
            'settings' => $settings,
            'page' => $page,
            'barang_masuk' => $get_barang_masuk,
            'barangs' => $all_barang,
            'suppliers' => $all_supplier,
        ];

        return view('admin.barangmasuk.edit', $context);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barang_masuk = BarangMasuk::findOrFail($id);
    
        $request->validate([
            'barang_id' => ['required'],
            'supplier_id' => ['required'],
            'jumlah' => ['required', 'integer'],
            'tanggal_masuk' => ['required', 'date'],
            'keterangan' => ['required'],
        ], [
            'barang_id.required' => 'Kategori Harus Diisi!',
            'supplier_id.required' => 'Supplier Harus Diisi!',
            'jumlah.required' => 'Jumlah Harus Diisi!',
            'jumlah.integer' => 'Jumlah Harus Berupa Angka!',
            'tanggal_masuk.required' => 'Tanggal Masuk Harus Diisi!',
            'tanggal_masuk.date' => 'Tanggal Masuk Harus Berupa Tanggal!',
            'keterangan.required' => 'Keterangan Harus Diisi!',
        ]);
    
        $barang = Barang::findOrFail($request->barang_id);
    
        $stok_lama = $barang_masuk->jumlah;
        $stok_baru = $request->jumlah;
        $barang->jumlah = $barang->jumlah - $stok_lama + $stok_baru;
        $barang->save();
    
        $barang_masuk->update([
            'barang_id' => $request->barang_id,
            'supplier_id' => $request->supplier_id,
            'jumlah' => $stok_baru,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
        ]);
    
        return redirect()->route('barang_masuk.index')->with('update', 'Barang Masuk Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BarangMasuk::destroy($id);

        return redirect()->route('barang_masuk.index')->with('delete', 'Barang Masuk Berhasil Dihapus');
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'required|string',
        ]);

        $barang = Barang::find($request->barang_id);
        $supplier = Supplier::find($request->supplier_id);

        if (!$barang || !$supplier) {
            return redirect()->back()->with('error', 'Barang atau Supplier tidak ditemukan.');
        }

        $cart = session()->get('cart', []);

        $cart[] = [
            'barang_id' => $barang->id,
            'name_barang' => $barang->name_barang,
            'supplier_id' => $supplier->id,
            'name_supplier' => $supplier->name_supplier,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
        ];

        session()->put('cart', $cart);

        return redirect()->route('barang_masuk.create')->with('success', 'Barang ditambahkan ke keranjang.');
    }

    public function removeFromCart($index)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            session()->put('cart', array_values($cart));
        }

        return redirect()->route('barang_masuk.create')->with('success', 'Barang dihapus dari keranjang.');
    }

    public function cancel($id)
    {
        $barangMasuk = BarangMasuk::find($id);

        if (!$barangMasuk) {
            return redirect()->route('barang_masuk.index')->with('error', 'Barang tidak ditemukan.');
        }

        $barang = $barangMasuk->barang;

        if ($barang) {
            $barang->jumlah -= $barangMasuk->jumlah;
            $barang->save();
        }

        $barangMasuk->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus dan jumlah telah diperbarui.');
    }

    public function cancelAll(Request $request)
    {
        $ids = explode(',', $request->ids);

        if (empty($ids)) {
            return redirect()->route('barang_masuk.index')->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
        }

        $barangMasukList = BarangMasuk::whereIn('id', $ids)->get();

        foreach ($barangMasukList as $barangMasuk) {
            $barang = $barangMasuk->barang;

            if ($barang) {
                $barang->jumlah -= $barangMasuk->jumlah;
                $barang->save();
            }
        }

        BarangMasuk::whereIn('id', $ids)->delete();

        return redirect()->route('barang_masuk.index')->with('success', 'Semua barang dalam transaksi telah dihapus dan jumlah telah diperbarui.');
    }
}
