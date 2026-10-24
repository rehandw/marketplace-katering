<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $merchant = auth()->user()->merchant;

        return view('merchant.dashboard', compact('merchant'));
    }

    public function update(Request $request)
    {
        $merchant = auth()->user()->merchant;

        $request->validate([
            'company_name' => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'address'      => 'required|string',
            'description'  => 'nullable|string',
        ]);

        $merchant->update([
            'company_name' => $request->company_name,
            'phone'        => $request->phone,
            'address'      => $request->address,
            'description'  => $request->description,
        ]);

        return redirect()->back()->with('success', 'Profil usaha berhasil diperbarui.');
    }
}