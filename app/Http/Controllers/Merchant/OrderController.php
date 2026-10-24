<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // tampil daftar pesanan dan invoice
    public function index()
    {
        $merchantId = auth()->user()->merchant->id;
        $orders = Order::where('merchant_id', $merchantId)
        ->with(['customer', 'menu', 'invoice'])
        ->latest()
        ->get();

        return view('merchant.orders.index', compact('orders'));
    }
    public function updateStatus(Request $request, $id)
    {
       $request->validate([
            'status' => 'required|in:pending,confirmed,delivered,cancelled',
        ]);
        $order = Order::findOrFail($id);
        
        if ($order->merchant_id !== auth()->user()->merchant->id) {
            abort(403, 'Akses Ditolak.');
        }
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }
}
