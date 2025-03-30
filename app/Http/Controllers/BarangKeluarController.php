<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Settings;
use App\Models\Supplier;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Daftar Barang Keluar';

        $query = BarangKeluar::with(['barang', 'supplier'])
            ->orderBy('tanggal_keluar', 'desc');

        if ($request->has('search_barang_keluar')) {
            $search = $request->input('search_barang_keluar');
    
            $query->where('penerima', 'LIKE', "%{$search}%")
                  ->orWhere('keterangan', 'LIKE', "%{$search}%")
                  ->orWhere('jumlah', 'LIKE', "%{$search}%")
                  ->orWhere('tanggal_keluar', 'LIKE', "%{$search}%")
                  ->orWhereHas('barang', function ($q) use ($search) {
                      $q->where('name_barang', 'LIKE', "%{$search}%");
                  });
        }

        $daftarTanggal = $query->distinct()->pluck('tanggal_keluar');

        $paginatedTanggal = \Illuminate\Pagination\Paginator::resolveCurrentPage();
        $perPage = 1;
        $pagedTanggal = new \Illuminate\Pagination\LengthAwarePaginator(
            $daftarTanggal->slice(($paginatedTanggal - 1) * $perPage, $perPage)->values(),
            $daftarTanggal->count(),
            $perPage,
            $paginatedTanggal,
            ['path' => request()->url()]
        );

        $barangKeluars = BarangKeluar::whereIn('tanggal_keluar', $pagedTanggal->items())
            ->with(['barang', 'supplier'])
            ->orderBy('tanggal_keluar', 'desc')
            ->get()
            ->groupBy('tanggal_keluar');
    
        return view('admin.barangkeluar.index', [
            'settings' => $settings,
            'page' => $page,
            'barangKeluars' => $barangKeluars,
            'pagedTanggal' => $pagedTanggal,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Tambah Barang Keluar';
        $all_barang = Barang::all();
        $all_suppliers = Supplier::all();
        $cart = session()->get('cart_keluar', []);

        $context = [
            'settings' => $settings,
            'page' => $page,
            'barangs' => $all_barang,
            'suppliers' => $all_suppliers,
            'cart' => $cart,
        ];

        return view('admin.barangkeluar.create', $context);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart_keluar', []);
    
        if (empty($cart)) {
            return redirect()->route('barang_keluar.create')->with('error', 'Keranjang masih kosong.');
        }
    
        $barang_keluar_ids = [];
    
        foreach ($cart as $item) {
            $barang_keluar = BarangKeluar::create([
                'barang_id' => $item['barang_id'],
                'supplier_id' => $item['supplier_id'],
                'penerima' => $item['penerima'],
                'keterangan' => $item['keterangan'],
                'jumlah' => $item['jumlah'],
                'tanggal_keluar' => $item['tanggal_keluar'],
            ]);
    
            $barang = Barang::find($item['barang_id']);
            $barang->update(['jumlah' => $barang->jumlah - $item['jumlah']]);
    
            $barang_keluar_ids[] = $barang_keluar->id;
        }
    
        session()->forget('cart_keluar');
    
        return redirect()->route('barang_keluar.show', ['ids' => implode(',', $barang_keluar_ids)])
                         ->with('success', 'Semua barang keluar berhasil disimpan.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show($ids)
    {
        $settings = Settings::first();
        $page = 'Detail Barang Keluar';
    
        $barang_keluar_list = BarangKeluar::whereIn('id', explode(',', $ids))->with(['barang', 'supplier'])->get();
    
        if ($barang_keluar_list->isEmpty()) {
            return redirect()->route('barang_keluar.index')->with('error', 'Data barang keluar tidak ditemukan.');
        }
    
        $context = [
            'settings' => $settings,
            'page' => $page,
            'barang_keluar_list' => $barang_keluar_list,
        ];
    
        return view('admin.barangkeluar.detail', $context);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Edit Barang Keluar';
    
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangs = Barang::all();
        $suppliers = Supplier::all();
    
        $context = [
            'settings' => $settings,
            'page' => $page,
            'barangKeluar' => $barangKeluar,
            'barangs' => $barangs,
            'suppliers' => $suppliers,
        ];
    
        return view('admin.barangkeluar.edit', $context);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'barang_id' => ['required', 'exists:barangs,id'],
            'penerima' => ['required'],
            'keterangan' => ['required'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal_keluar' => ['required', 'date'],
        ], [
            'barang_id.required' => 'Barang Harus Diisi!',
            'barang_id.exists' => 'Barang yang dipilih tidak valid!',
            'penerima.required' => 'Penerima Harus Diisi!',
            'keterangan.required' => 'Keterangan Harus Diisi!',
            'jumlah.required' => 'Jumlah Harus Diisi!',
            'jumlah.integer' => 'Jumlah harus berupa angka!',
            'jumlah.min' => 'Jumlah minimal 1!',
            'tanggal_keluar.required' => 'Tanggal Keluar Harus Diisi!',
        ]);
    
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barang = Barang::findOrFail($barangKeluar->barang_id);

        $jumlahLama = $barangKeluar->jumlah;
        $jumlahBaru = $request->jumlah;

        if ($jumlahBaru > $jumlahLama) {
            $selisih = $jumlahBaru - $jumlahLama;
            $barang->jumlah -= $selisih;
        } elseif ($jumlahBaru < $jumlahLama) {
            $selisih = $jumlahLama - $jumlahBaru;
            $barang->jumlah += $selisih;
        }

        $barang->save();

        $barangKeluar->update([
            'barang_id' => $request->barang_id,
            'penerima' => $request->penerima,
            'keterangan' => $request->keterangan,
            'jumlah' => $jumlahBaru,
            'tanggal_keluar' => $request->tanggal_keluar,
        ]);
    
        return redirect()->route('barang_keluar.index')->with('update', 'Barang Keluar Berhasil Diperbarui dan Stok Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BarangKeluar::destroy($id);

        return redirect()->route('barang_keluar.index')->with('delete', 'Barang Keluar Berhasil Dihapus!');
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'penerima' => 'required|string',
            'keterangan' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

        $barang = Barang::find($request->barang_id);
        $supplier = Supplier::find($request->supplier_id);

        if (!$barang || !$supplier) {
            return redirect()->back()->with('error', 'Barang atau Supplier tidak ditemukan.');
        }

        $cart = session()->get('cart_keluar', []);

        $cart[] = [
            'barang_id' => $barang->id,
            'supplier_id' => $supplier->id,
            'name_barang' => $barang->name_barang,
            'penerima' => $request->penerima,
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'tanggal_keluar' => $request->tanggal_keluar,
        ];

        session()->put('cart_keluar', $cart);

        return redirect()->route('barang_keluar.create')->with('success', 'Barang ditambahkan ke keranjang.');
    }

    public function removeFromCart($index)
    {
        $cart = session()->get('cart_keluar', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            session()->put('cart_keluar', array_values($cart));
        }

        return redirect()->route('barang_keluar.create')->with('success', 'Barang dihapus dari keranjang.');
    }

    public function cancel($id)
    {
        $barangKeluar = BarangKeluar::find($id);

        if (!$barangKeluar) {
            return redirect()->route('barang_keluar.index')->with('error', 'Barang keluar tidak ditemukan.');
        }

        $barang = $barangKeluar->barang;

        if ($barang) {
            $barang->jumlah += $barangKeluar->jumlah;
            $barang->save();
        }

        $barangKeluar->delete();

        return redirect()->back()->with('success', 'Barang keluar berhasil dibatalkan dan jumlah stok telah diperbarui.');
    }

    public function cancelAll(Request $request)
    {
        $ids = explode(',', $request->ids);

        if (empty($ids)) {
            return redirect()->route('barang_keluar.index')->with('error', 'Tidak ada data yang dipilih untuk dibatalkan.');
        }

        $barangKeluarList = BarangKeluar::whereIn('id', $ids)->get();

        foreach ($barangKeluarList as $barangKeluar) {
            $barang = $barangKeluar->barang;

            if ($barang) {
                $barang->jumlah += $barangKeluar->jumlah;
                $barang->save();
            }
        }

        BarangKeluar::whereIn('id', $ids)->delete();

        return redirect()->route('barang_keluar.index')->with('success', 'Semua barang keluar dalam transaksi telah dibatalkan dan jumlah stok telah diperbarui.');
    }
}
