<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;    
use App\Models\Order;   
use App\Models\Invoice; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Memproses Pembelian dan buat invoice
    public function store(Request $request)
    {
        $request->validate([
            'menu_id'       => 'required|exists:menus,id',
            'portion'       => 'required|integer|min:1',
            'delivery_date' => 'required|date|after_or_equal:today',
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $totalPrice = $menu->price * $request->portion;
        $customerId = auth()->user()->customer->id;

        DB::transaction(function () use ($request, $menu, $totalPrice, $customerId) {
            $order = Order::create([
                'customer_id'   => $customerId,
                'merchant_id'   => $menu->merchant_id,
                'menu_id'       => $menu->id,
                'portion'       => $request->portion,
                'delivery_date' => $request->delivery_date,
                'total_price'   => $totalPrice,
            ]);

        
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
            Invoice::create([
                'order_id'       => $order->id,
                'invoice_number' => $invoiceNumber,
            ]);
        });

        return redirect()->route('customer.invoices.index')->with('success', 'Pesanan berhasil dibuat! Invoice telah diterbitkan.');
    }
}
