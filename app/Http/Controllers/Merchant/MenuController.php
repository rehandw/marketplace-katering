<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // 1. Menampilkan Daftar Semua Menu Milik Merchant Ini
    public function index()
    {
        $merchantId = auth()->user()->merchant->id;
        $menus = Menu::where('merchant_id', $merchantId)->latest()->get();

        return view('merchant.menus.index', compact('menus'));
    }

    // 2. Menampilkan Form Tambah Menu
    public function create()
    {
        return view('merchant.menus.create');
    }

    // 3. Memproses Penyimpanan Menu Baru
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ]);

        $photoPath = null;
        // Proses unggah foto native menggunakan Storage Laravel
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('menus', 'public');
        }

        Menu::create([
            'merchant_id' => auth()->user()->merchant->id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'photo'       => $photoPath,
        ]);

        return redirect()->route('merchant.menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit Menu
    public function edit(Menu $menu)
    {
        // Keamanan: pastikan menu ini benar milik merchant yang sedang login
        if ($menu->merchant_id !== auth()->user()->merchant->id) {
            abort(403, 'Akses Ditolak.');
        }

        return view('merchant.menus.edit', compact('menu'));
    }

    // 5. Memproses Perubahan Data Menu
    public function update(Request $request, Menu $menu)
    {
        if ($menu->merchant_id !== auth()->user()->merchant->id) {
            abort(403, 'Akses Ditolak.');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoPath = $menu->photo;

        // Jika user mengunggah foto baru
        if ($request->hasFile('photo')) {
            if ($menu->photo) {
                Storage::disk('public')->delete($menu->photo);
            }
            // Simpan foto baru
            $photoPath = $request->file('photo')->store('menus', 'public');
        }

        $menu->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'photo'       => $photoPath,
        ]);

        return redirect()->route('merchant.menus.index')->with('success', 'Menu berhasil diperbarui!');
    }

    // 6. Menghapus Menu
    public function destroy(Menu $menu)
    {
        if ($menu->merchant_id !== auth()->user()->merchant->id) {
            abort(403, 'Akses Ditolak.');
        }
        if ($menu->photo) {
            Storage::disk('public')->delete($menu->photo);
        }

        $menu->delete();

        return redirect()->route('merchant.menus.index')->with('success', 'Menu berhasil dihapus!');
    }
}