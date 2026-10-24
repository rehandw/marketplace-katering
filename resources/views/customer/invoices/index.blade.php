<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Invoice Saya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>
<body>

<div class="container">
    <div class="header-portal">
        <div>
            <h2>Daftar Invoice Pemesanan</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">Riwayat pemesanan katering</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>

    <nav>
        <a href="{{ route('customer.dashboard') }}">Cari Katering</a>
        <a href="{{ route('customer.invoices.index') }}" class="active">Daftar Invoice Saya</a>
    </nav>

    @if (session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 12px 16px; margin-bottom: 20px; border-radius: var(--radius-md); font-size: 14px; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Katering</th>
                    <th>Menu & Porsi</th>
                    <th>Tgl Kirim</th>
                    <th>Total Tagihan</th>
                    <th>Status Pesanan</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invoices as $invoice)
                    <tr>
                        <td><b style="color: var(--primary);">{{ $invoice->invoice_number }}</b></td>
                        <td>{{ $invoice->order->merchant->company_name }}</td>
                        <td>{{ $invoice->order->menu->name }} <span style="color: var(--text-muted);">({{ $invoice->order->portion }} porsi)</span></td>
                        <td>{{ \Carbon\Carbon::parse($invoice->order->delivery_date)->format('d/m/Y') }}</td>
                        <td><b>Rp {{ number_format($invoice->order->total_price, 0, ',', '.') }}</b></td>
                        <td>
                            @php
                                $status = $invoice->order->status;
                                $badgeClass = match($status) {
                                    'confirmed' => 'badge-confirmed',
                                    'delivered' => 'badge-delivered',
                                    'cancelled' => 'badge-cancelled',
                                    default     => 'badge-pending',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ strtoupper($status) }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ route('customer.invoices.show', $invoice->id) }}" class="btn" style="padding: 6px 14px; font-size: 13px;">Detail / Cetak</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 32px;">Belum ada invoice atau pesanan katering.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>