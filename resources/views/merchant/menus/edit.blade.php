<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 25px; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; background: #0d6efd; color: white; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Menu Makanan</h2>

    <form action="{{ route('merchant.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Menu:</label>
            <input type="text" name="name" value="{{ old('name', $menu->name) }}" required>
        </div>

        <div class="form-group">
            <label>Harga Porsi (Rp):</label>
            <input type="number" name="price" value="{{ old('price', $menu->price) }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Deskripsi Menu:</label>
            <textarea name="description" rows="3" required>{{ old('description', $menu->description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Foto Menu Saat Ini:</label><br>
            @if ($menu->photo)
                <img src="{{ asset('storage/' . $menu->photo) }}" width="120" style="border-radius: 4px; margin-bottom: 10px;"><br>
            @endif
            <label>Ganti Foto (Opsional):</label>
            <input type="file" name="photo" accept="image/*">
        </div>

        <button type="submit">Update Menu</button>
        <a href="{{ route('merchant.menus.index') }}" style="margin-left: 10px;">Batal</a>
    </form>
</div>

</body>
</html>