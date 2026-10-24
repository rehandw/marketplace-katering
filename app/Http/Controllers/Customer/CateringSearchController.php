<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;

class CateringSearchController extends Controller
{
    // Halaman utama portal customer (Pencarian Katering & Daftar Menu)
    public function index(Request $request)
    {
        $query = Merchant::with('menus');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhereHas('menus', function($menuQuery) use ($search) {
                      $menuQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $merchants = $query->latest()->get();

        return view('customer.dashboard', compact('merchants'));
    }

    public function show($id)
    {
        $merchant = Merchant::with('menus')->findOrFail($id);

        return view('customer.catering-detail', compact('merchant'));
    }
}