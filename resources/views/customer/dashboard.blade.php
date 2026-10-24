<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Kantor - Cari Katering</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>
<body>

<div class="container">
    <div class="header-portal">
        <div>
            <h2>Portal Kantor</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">Pesan menu katering harian</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Keluar</button>
        </form>
    </div>

    <nav>
        <a href="{{ route('customer.dashboard') }}" class="active">Cari Katering</a>
        <a href="{{ route('customer.invoices.index') }}">Daftar Invoice Saya</a>
    </nav>

    <div class="search-container">
        <form action="{{ route('customer.dashboard') }}" method="GET" class="search-box">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama katering, lokasi, atau variasi menu..." class="search-input">
            <button type="submit" class="btn" style="width: auto; padding: 0 24px;">Cari</button>
        </form>
    </div>

    <div class="grid">
        @forelse ($merchants as $merchant)
            @php
                $firstMenuWithPhoto = $merchant->menus->firstWhere('photo', '!=', null);
                $bgUrl = $firstMenuWithPhoto ? asset('storage/' . $firstMenuWithPhoto->photo) : 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=500';
            @endphp

            <div class="card" style="background-image: url('{{ $bgUrl }}');">
                <div class="card-overlay">
                    <div>
                        <h3 class="card-title">{{ $merchant->company_name }}</h3>
                        <p class="card-info"><b>Alamat:</b> {{ $merchant->address }}</p>
                        <p class="card-info"><b>Telepon:</b> {{ $merchant->phone }}</p>

                        <div class="menu-list">
                            <strong style="color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Daftar Menu Tersedia:</strong>
                            @forelse ($merchant->menus as $menu)
                                <div class="menu-item">
                                    <span>{{ $menu->name }}</span>
                                    <span class="price-tag">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                                </div>
                            @empty
                                <p style="color: #94a3b8; margin-top: 4px; font-size: 12px;">Belum ada menu terdaftar.</p>
                            @endforelse
                        </div>
                    </div>

                    <a href="{{ route('customer.catering.show', $merchant->id) }}" class="btn">Pesan Makanan</a>
                </div>
            </div>
        @empty
            <p style="color: var(--text-muted); grid-column: 1/-1; text-align: center; padding: 40px 0;">Tidak ada katering atau menu makanan yang ditemukan.</p>
        @endforelse
    </div>
</div>

</body>
</html>