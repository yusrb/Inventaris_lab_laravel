<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Peminjam;
use App\Models\User;
use App\Models\Barang;
use App\Models\Settings;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $settings = Settings::first();
        $page = 'Daftar Peminjaman';
    
        $query = Peminjaman::with(['peminjam', 'user', 'barang']);
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('peminjam', function ($q) use ($search) {
                $q->where('name_peminjam', 'LIKE', "%$search%")
                  ->orWhere('kontak_peminjam', 'LIKE', "%$search%");
            })
            ->orWhere('status', 'LIKE', "%$search%")
            ->orWhereHas('barang', function ($q) use ($search) {
                $q->where('name_barang', 'LIKE', "%$search%");
            });
        }
    
        if ($request->has('tanggal_pinjam_start') && $request->has('tanggal_pinjam_end')) {
            $tanggalPinjamStart = $request->input('tanggal_pinjam_start');
            $tanggalPinjamEnd = $request->input('tanggal_pinjam_end');
            $query->whereBetween('tanggal_pinjam', [$tanggalPinjamStart, $tanggalPinjamEnd]);
        }
    
        if ($request->has('tanggal_kembali_start') && $request->has('tanggal_kembali_end')) {
            $tanggalKembaliStart = $request->input('tanggal_kembali_start');
            $tanggalKembaliEnd = $request->input('tanggal_kembali_end');
            $query->whereBetween('tanggal_kembali', [$tanggalKembaliStart, $tanggalKembaliEnd]);
        }
    
        $peminjamans = $query->paginate(10);
    
        return view('admin.peminjaman.index', compact('settings', 'peminjamans', 'page'));
    }

    public function create()
    {
        $settings = Settings::first();
        $page = 'Tambah Peminjaman';
    
        $context = [
            'settings' => $settings,
            'page' => $page,
            'peminjams' => Peminjam::all(),
            'petugas' => User::all(),
            'barangs' => Barang::all(),
            'cart' => session()->get('cart_peminjaman', []),
            'peminjam_id' => null,
        ];
    
        return view('admin.peminjaman.create', $context);
    }
    public function store(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'cart.*.barang_id' => 'required|exists:barangs,id',
            'cart.*.peminjam_id' => 'required|exists:peminjams,id',
            'cart.*.jumlah' => 'required|integer|min:1',
            'cart.*.tanggal_pinjam' => 'required|date',
            'cart.*.user_id' => 'required|exists:users,id',
        ]);
    
        $cart = $request->input('cart');
        if (empty($cart)) {
            return redirect()->route('peminjaman.create')->with('error', 'Keranjang masih kosong.');
        }
    
        // Check if the stock is enough for each item in the cart
        foreach ($cart as $item) {
            $barang = Barang::find($item['barang_id']);
            if ($barang->jumlah < $item['jumlah']) {
                return redirect()->route('peminjaman.create')->with('error', 'Stok barang tidak mencukupi.');
            }
        }
    
        // Process the loan
        foreach ($cart as $item) {
            $barang = Barang::find($item['barang_id']);
            $barang->jumlah -= $item['jumlah']; // Update stock
            $barang->save();
    
            Peminjaman::create([
                'peminjam_id' => $item['peminjam_id'],
                'user_id' => $item['user_id'],
                'barang_id' => $item['barang_id'],
                'jumlah' => $item['jumlah'],
                'tanggal_pinjam' => $item['tanggal_pinjam'],
                'status' => 'Dipinjam',
            ]);
        }
    
        session()->forget('cart_peminjaman'); // Clear the cart session
    
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan!');
    }
    
    public function show(string $id)
    {
        $settings = Settings::first();
        $page = 'Detail Peminjaman';

        $peminjaman = Peminjaman::with(['peminjam', 'user', 'barang'])->findOrFail($id);

        return view('admin.peminjaman.show', compact('settings', 'page', 'peminjaman'));
    }

    public function edit(string $id)
    {
        $settings = Settings::first();
        $page = 'Edit Peminjaman';

        $peminjaman = Peminjaman::with(['peminjam', 'user', 'barang'])->findOrFail($id);
        $peminjams = Peminjam::all();
        $petugas = User::all();
        $barangs = Barang::all();

        return view('admin.peminjaman.edit', compact('settings', 'page', 'peminjaman', 'peminjams', 'petugas', 'barangs'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'peminjam_id' => 'required|exists:peminjams,id',
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:Dipinjam,Dikembalikan,Hilang',
        ]);
    
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = Barang::findOrFail($peminjaman->barang_id);
    
        if ($request->status === 'Dikembalikan') {
            $barang->jumlah += $peminjaman->jumlah;
            $barang->save();
        }
    
        if ($peminjaman->barang_id != $request->barang_id) {
            $barangLama = Barang::findOrFail($peminjaman->barang_id);
            $barangBaru = Barang::findOrFail($request->barang_id);
    
            $barangLama->jumlah += $peminjaman->jumlah;
            $barangLama->save();
    
            if ($barangBaru->jumlah < $request->jumlah) {
                return redirect()->back()->with('error', 'Jumlah barang tidak mencukupi untuk perubahan.');
            }
    
            $barangBaru->jumlah -= $request->jumlah;
            $barangBaru->save();
        } else {
            if ($peminjaman->jumlah != $request->jumlah) {
                $jumlahSelisih = $request->jumlah - $peminjaman->jumlah;
    
                if ($jumlahSelisih > 0 && $barang->jumlah < $jumlahSelisih) {
                    return redirect()->back()->with('error', 'Jumlah barang tidak mencukupi untuk peminjaman tambahan.');
                }
    
                $barang->jumlah -= $jumlahSelisih;
                $barang->save();
            }
        }
    
        $peminjaman->update([
            'peminjam_id' => $request->peminjam_id,
            'user_id' => auth()->id(),
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $request->status,
        ]);
    
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('delete', 'Peminjaman berhasil dihapus.');
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'peminjam_id' => 'required',
            'barang_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
        ]);
        
        $peminjam = Peminjam::findOrFail($request->peminjam_id);
        $barang = Barang::findOrFail($request->barang_id);
        
        $cart = session()->get('cart_peminjaman', []);

        $itemIndex = null;
        foreach ($cart as $index => $item) {
            if ($item['barang_id'] == $barang->id && $item['peminjam_id'] == $peminjam->id) {
                $itemIndex = $index;
                break;
            }
        }
        
        if ($itemIndex !== null) {
            $cart[$itemIndex]['jumlah'] += $request->jumlah;
        } else {
            $cart[] = [
                'id' => $barang->id,
                'name_peminjam' => $peminjam->name_peminjam,
                'name_barang' => $barang->name_barang,
                'jumlah' => $request->jumlah,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'user_id' => auth()->id(),
                'peminjam_id' => $peminjam->id,
                'barang_id' => $barang->id,
            ];
        }
    
        session()->put('cart_peminjaman', $cart);
        
        return redirect()->back()->with('success', 'Barang berhasil ditambahkan atau jumlahnya diperbarui di keranjang peminjaman.');
    }
    
    public function removeFromCart($index)
    {
        $cart = session()->get('cart_peminjaman', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            session()->put('cart_peminjaman', array_values($cart));
        }

        return redirect()->route('peminjaman.create')->with('success', 'Barang dihapus dari keranjang.');
    }
}
