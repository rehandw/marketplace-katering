<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Merchant - Marketplace Katering</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 25px; border-radius: 8px; }
        nav { margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        nav a { margin-right: 15px; text-decoration: none; color: #0d6efd; font-weight: bold; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Portal Katering: {{ $merchant->company_name }}</h2>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="background: #dc3545;">Logout</button>
        </form>
    </div>

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

    <h3>Pengelolaan Profil Merchant</h3>

    <form action="{{ route('merchant.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Perusahaan / Katering:</label>
            <input type="text" name="company_name" value="{{ old('company_name', $merchant->company_name) }}" required>
        </div>

        <div class="form-group">
            <label>Nomor Telepon / Kontak:</label>
            <input type="text" name="phone" value="{{ old('phone', $merchant->phone) }}" required>
        </div>

        <div class="form-group">
            <label>Alamat Lengkap:</label>
            <textarea name="address" rows="3" required>{{ old('address', $merchant->address) }}</textarea>
        </div>

        <div class="form-group">
            <label>Deskripsi Usaha:</label>
            <textarea name="description" rows="3">{{ old('description', $merchant->description) }}</textarea>
        </div>

        <button type="submit">Simpan Perubahan Profil</button>
    </form>
</div>

</body>
</html>