<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; color: #333; }
        .invoice-box { border: 1px solid #eee; padding: 30px; border-radius: 8px; max-width: 800px; margin: auto; }
        .header-table, .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table th, .items-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .items-table th { background-color: #f8f9fa; }
        .text-right { text-align: right; }
        .btn-print { background: #0d6efd; color: white; padding: 10px 15px; border: none; cursor: pointer; border-radius: 4px; font-size: 14px; }
        @media print { .btn-print { display: none; } }
    </style>
</head>
<body>

<div class="invoice-box">
    <div style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" class="btn-print">Cetak / Simpan PDF</button>
    </div>

    <table class="header-table">
        <tr>
            <td>
                <h2 style="margin: 0; color: #0d6efd;">INVOICE PESANAN</h2>
                <p><strong>No:</strong> {{ $invoice->invoice_number }}</p>
            </td>
            <td class="text-right">
                <h3>Penyedia Katering:</h3>
                <p><b>{{ $invoice->order->merchant->company_name }}</b></p>
                <p>{{ $invoice->order->merchant->address }}</p>
                <p>Telp: {{ $invoice->order->merchant->phone }}</p>
            </td>
        </tr>
    </table>

    <hr>

    <p><strong>Ditujukan Kepada:</strong> {{ $invoice->order->customer->company_name }}</p>
    <p><strong>Tanggal Pengiriman Makanan:</strong> {{ \Carbon\Carbon::parse($invoice->order->delivery_date)->format('d/m/Y') }}</p>

    <table class="items-table">
        <thead>
            <tr>
                <th>Menu Makanan</th>
                <th>Harga Satuan</th>
                <th>Porsi</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->order->menu->name }}</td>
                <td>Rp {{ number_format($invoice->order->menu->price, 0, ',', '.') }}</td>
                <td>{{ $invoice->order->portion }}</td>
                <td class="text-right">Rp {{ number_format($invoice->order->total_price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h3 class="text-right">Total Tagihan: Rp {{ number_format($invoice->order->total_price, 0, ',', '.') }}</h3>
</div>

</body>
</html>