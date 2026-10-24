<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Marketplace Katering</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 40px; }
        .card { max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        button:hover { background-color: #218838; }
        .error { color: red; font-size: 12px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Registrasi Akun Baru</h2>

    @if ($errors->any())
        <div style="background: #f8d7da; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="error">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Daftar Sebagai:</label>
            <select name="role" required>
                <option value="customer">Kantor (Customer)</option>
                <option value="merchant">Penyedia Katering (Merchant)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Nama Pemilik / Penanggung Jawab:</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Nama Perusahaan / Kantor / Usaha:</label>
            <input type="text" name="company_name" value="{{ old('company_name') }}" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Nomor Telepon/HP:</label>
            <input type="text" name="phone" value="{{ old('phone') }}" required>
        </div>

        <div class="form-group">
            <label>Alamat Lengkap:</label>
            <textarea name="address" rows="3" required>{{ old('address') }}</textarea>
        </div>

        <div class="form-group">
            <label>Deskripsi Usaha (Khusus Katering - Opsional):</label>
            <textarea name="description" rows="2">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password:</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Daftar Sekarang</button>
    </form>

    <p style="text-align: center; margin-top: 15px;">
        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
    </p>
</div>

</body>
</html>