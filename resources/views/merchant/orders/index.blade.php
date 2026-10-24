<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan - Merchant</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 25px; border-radius: 8px; }
        nav { margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        nav a { margin-right: 15px; text-decoration: none; color: #0d6efd; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f8f9fa; }
    </style>
</head>
<body>

<div class="container">
    <h2>Daftar Pesanan & Invoice Masuk</h2>

    <nav>
        <a href="{{ route('merchant.dashboard') }}">Profil Usaha</a>
        <a href="{{ route('merchant.menus.index') }}">Kelola Menu</a>
        <a href="{{ route('merchant.orders.index') }}">Daftar Pesanan & Invoice</a>
    </nav>

    @if (session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Kantor Pemesan</th>
                <th>Menu & Porsi</th>
                <th>Tgl Pengiriman</th>
                <th>Total Harga</th>
                <th>Status Order</th>
                <th>Aksi Ubah Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td><b>{{ $order->invoice->invoice_number ?? '-' }}</b></td>
                    <td>
                        {{ $order->customer->company_name }}<br>
                        <small>Telp: {{ $order->customer->phone }}</small>
                    </td>
                    <td>{{ $order->menu->name }} ({{ $order->portion }} porsi)</td>
                    <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td><b style="text-transform: uppercase;">{{ $order->status }}</b></td>
                    <td>
                        <form action="{{ route('merchant.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Belum ada pesanan masuk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>