<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Menu - Marketplace Katering</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 25px; border-radius: 8px; }
        nav { margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        nav a { margin-right: 15px; text-decoration: none; color: #0d6efd; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f8f9fa; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; color: white; display: inline-block; }
        .btn-add { background: #28a745; }
        .btn-edit { background: #ffc107; color: black; }
        .btn-delete { background: #dc3545; border: none; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <h2>Kelola Menu Makanan</h2>

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

    <a href="{{ route('merchant.menus.create') }}" class="btn btn-add">+ Tambah Menu Baru</a>

    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama Menu</th>
                <th>Deskripsi</th>
                <th>Harga (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($menus as $menu)
                <tr>
                    <td>
                        @if ($menu->photo)
                            <img src="{{ asset('storage/' . $menu->photo) }}" width="80" height="60" style="object-fit: cover; border-radius: 4px;">
                        @else
                            <span style="color: #888;">Tanpa Foto</span>
                        @endif
                    </td>
                    <td><b>{{ $menu->name }}</b></td>
                    <td>{{ $menu->description }}</td>
                    <td>{{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('merchant.menus.edit', $menu->id) }}" class="btn btn-edit">Edit</a>
                        <form action="{{ route('merchant.menus.destroy', $menu->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada menu yang ditambahkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>