<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Settings;
use App\Models\Supplier;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use App\Helpers\LogAktivitasHelper;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $settings = Settings::find(1);
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

    public function create()
    {
        $settings = Settings::find(1);
        $page = 'Tambah Barang Keluar';
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        $cart = session()->get('cart_keluar', []);

        return view('admin.barangkeluar.create', [
            'settings' => $settings,
            'page' => $page,
            'barangs' => $barangs,
            'suppliers' => $suppliers,
            'cart' => $cart,
        ]);
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart_keluar', []);
        if (empty($cart)) {
            return redirect()->route('barang_keluar.create')->with('error', 'Keranjang masih kosong.');
        }

        $barang_keluar_ids = [];

        foreach ($cart as $item) {
            $barang_keluar = BarangKeluar::create($item);

            $barang = Barang::find($item['barang_id']);
            $barang->jumlah -= $item['jumlah'];
            $barang->save();

            $barang_keluar_ids[] = $barang_keluar->id;

            LogAktivitasHelper::catat('Create', 'Barang Keluar', "Barang: {$barang->name_barang}, Jumlah: {$item['jumlah']}, Penerima: {$item['penerima']}");
        }

        session()->forget('cart_keluar');

        return redirect()->route('barang_keluar.show', ['ids' => implode(',', $barang_keluar_ids)])
            ->with('success', 'Semua barang keluar berhasil disimpan.');
    }

    public function show($ids)
    {
        $settings = Settings::first();
        $page = 'Detail Barang Keluar';
        $barang_keluar_list = BarangKeluar::whereIn('id', explode(',', $ids))->with(['barang', 'supplier'])->get();

        if ($barang_keluar_list->isEmpty()) {
            return redirect()->route('barang_keluar.index')->with('error', 'Data barang keluar tidak ditemukan.');
        }

        return view('admin.barangkeluar.detail', [
            'settings' => $settings,
            'page' => $page,
            'barang_keluar_list' => $barang_keluar_list,
        ]);
    }

    public function edit(string $id)
    {
        $settings = Settings::find(1);
        $page = 'Edit Barang Keluar';
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangs = Barang::all();
        $suppliers = Supplier::all();

        return view('admin.barangkeluar.edit', [
            'settings' => $settings,
            'page' => $page,
            'barangKeluar' => $barangKeluar,
            'barangs' => $barangs,
            'suppliers' => $suppliers,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'barang_id' => ['required', 'exists:barangs,id'],
            'penerima' => ['required'],
            'keterangan' => ['required'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal_keluar' => ['required', 'date'],
        ]);

        $barangKeluar = BarangKeluar::findOrFail($id);
        $barang = Barang::findOrFail($barangKeluar->barang_id);

        $jumlahLama = $barangKeluar->jumlah;
        $jumlahBaru = $request->jumlah;

        if ($jumlahBaru > $jumlahLama) {
            $barang->jumlah -= ($jumlahBaru - $jumlahLama);
        } elseif ($jumlahBaru < $jumlahLama) {
            $barang->jumlah += ($jumlahLama - $jumlahBaru);
        }

        $barang->save();

        $barangKeluar->update($request->only('barang_id', 'penerima', 'keterangan', 'jumlah', 'tanggal_keluar'));

        LogAktivitasHelper::catat('Update', 'Barang Keluar', "Update Barang Keluar ID: $id");

        return redirect()->route('barang_keluar.index')->with('update', 'Barang Keluar Berhasil Diperbarui dan Stok Diperbarui');
    }

    public function destroy(string $id)
    {
        $barangKeluar = BarangKeluar::find($id);
        if ($barangKeluar) {
            $barangKeluar->delete();
            LogAktivitasHelper::catat('Delete', 'Barang Keluar', "Hapus ID: $id");
        }

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

        LogAktivitasHelper::catat('Delete', 'Barang Keluar', "Pembatalan Barang Keluar ID: $id");

        return redirect()->back()->with('success', 'Barang keluar berhasil dibatalkan dan jumlah stok telah diperbarui.');
    }

    public function cancelAll(Request $request)
    {
        $ids = explode(',', $request->ids);
        $barangKeluarList = BarangKeluar::whereIn('id', $ids)->get();

        foreach ($barangKeluarList as $barangKeluar) {
            $barang = $barangKeluar->barang;
            if ($barang) {
                $barang->jumlah += $barangKeluar->jumlah;
                $barang->save();
            }
            LogAktivitasHelper::catat('Delete', 'Barang Keluar', "Pembatalan Barang Keluar ID: {$barangKeluar->id}");
        }

        BarangKeluar::whereIn('id', $ids)->delete();

        return redirect()->route('barang_keluar.index')->with('success', 'Semua barang keluar telah dibatalkan dan stok diperbarui.');
    }
}
