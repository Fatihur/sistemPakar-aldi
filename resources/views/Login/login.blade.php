<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Pakar Penyakit Padi</title>
    <link rel="icon" type="image/png" href="{{ asset('obat/logo.png') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Pastikan path CSS ini benar -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        /* Gaya sederhana untuk notifikasi */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            color: #fff;
            text-align: center;
            font-size: 0.9rem;
        }
        .alert-success {
            background-color: #28a745; /* Hijau untuk sukses */
        }
        .alert-danger {
            background-color: #dc3545; /* Merah untuk error */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Diubah: Teks ke Bahasa Indonesia -->
            <h1>Login</h1>

            <!-- DITAMBAHKAN: Area untuk menampilkan pesan notifikasi -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @error('username')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror

            @error('password')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror
            
            <div class="input-box">
                
                <input type="text" name="username" placeholder="Username" class="@error('username') is-invalid @enderror" value="{{ old('username') }}" autofocus>
                <i class="bi bi-person"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" >
                 <i class="bi bi-lock"></i>
            </div>

            <div class="remember-forgot">
                <label>
                    <!-- Diubah: Teks ke Bahasa Indonesia -->
                    <input type="checkbox" name="remember"> Ingat Saya
                </label>
                {{-- <a href="#">Lupa Password?</a> --}}
            </div>

            <button type="submit" class="btn">Login</button>

            <div class="register-link">
                <!-- Diubah: Teks ke Bahasa Indonesia -->
                <p>Belum punya akun?
                    <a href="{{ route('register') }}">Daftar di sini</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>

