<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Katering - {{ $merchant->company_name }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 25px; border-radius: 8px; }
        .menu-item { border-bottom: 1px solid #eee; padding: 15px 0; display: flex; gap: 15px; }
        .menu-item img { width: 100px; height: 80px; object-fit: cover; border-radius: 4px; }
        .form-box { background: #f8f9fa; padding: 15px; border-radius: 6px; margin-top: 10px; }
        button { background: #28a745; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <a href="{{ route('customer.dashboard') }}">&laquo; Kembali ke Daftar Katering</a>

    <h2>{{ $merchant->company_name }}</h2>
    <p><b>Alamat:</b> {{ $merchant->address }} | <b>Kontak:</b> {{ $merchant->phone }}</p>
    <p>{{ $merchant->description }}</p>

    <hr>

    <h3>Daftar Menu Makanan</h3>

    @forelse ($merchant->menus as $menu)
        <div class="menu-item">
            @if ($menu->photo)
                <img src="{{ asset('storage/' . $menu->photo) }}">
            @endif
            <div style="flex-grow: 1;">
                <h4 style="margin: 0;">{{ $menu->name }} - Rp {{ number_format($menu->price, 0, ',', '.') }} / porsi</h4>
                <p style="margin: 5px 0; color: #555;">{{ $menu->description }}</p>

                <div class="form-box">
                    <form action="{{ route('customer.checkout.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        
                        <label>Jumlah Porsi:</label>
                        <input type="number" name="portion" min="1" value="10" required style="width: 60px;">

                        <label style="margin-left: 10px;">Tanggal Pengiriman:</label>
                        <input type="date" name="delivery_date" required min="{{ date('Y-m-d') }}">

                        <button type="submit" style="margin-left: 10px;">Pesan Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p>Katering ini belum menambahkan menu makanan.</p>
    @endforelse
</div>

</body>
</html>