<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $customerId = auth()->user()->customer->id;

        $invoices = Invoice::whereHas('order', function($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        })->with(['order.merchant', 'order.menu'])->latest()->get();

        return view('customer.invoices.index', compact('invoices'));
    }

    public function show($id)
    {
        $invoice = Invoice::with(['order.merchant', 'order.customer.user', 'order.menu'])->findOrFail($id);

        if ($invoice->order->customer_id !== auth()->user()->customer->id) {
            abort(403, 'Akses Ditolak.');
        }

        return view('customer.invoices.show', compact('invoice'));
    }
}