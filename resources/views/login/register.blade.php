<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register | Sistem Pakar Penyakit Padi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="{{ asset('obat/logo.png') }}" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body class="register-bg">

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4 col-md-6 col-sm-10">

                <div class="register-card animate-fade">

                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-white">

                            Sistem Pakar Padi
                        </h2>
                        <p class="text-light">Buat Akun Baru</p>
                    </div>

                    <form action="{{ route('register.store') }}" method="POST" novalidate>
                        @csrf
                        <input type="hidden" name="role_id" value="{{ $role_petani_id }}">

                        <!-- Nama -->
                        <div class="form-floating mb-3">
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap"
                                value="{{ old('name') }}">
                            <label><i class="bi bi-person"></i> Nama Lengkap</label>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="form-floating mb-3">
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror" placeholder="Username"
                                value="{{ old('username') }}">
                            <label><i class="bi bi-person-badge"></i> Username</label>
                            @error('username')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-floating mb-3">
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                value="{{ old('email') }}">
                            <label><i class="bi bi-envelope"></i> Email</label>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                            <label><i class="bi bi-lock"></i> Password</label>

                            <span class="eye-toggle" onclick="togglePassword('password', this)">
                                <i class="bi bi-eye-slash-fill"></i>
                            </span>

                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" placeholder="Ulangi Password">
                            <label><i class="bi bi-lock"></i> Ulangi Password</label>

                            <span class="eye-toggle" onclick="togglePassword('password_confirmation', this)">
                                <i class="bi bi-eye-slash-fill"></i>
                            </span>
                        </div>

                        <button class="btn btn-success w-100 py-2 fw-semibold">
                            Daftar
                        </button>
                    </form>

                    <p class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-light">
                            Saya sudah punya akun
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Eye Toggle -->
    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            const icon = el.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
            } else {
                input.type = "password";
                icon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            }
        }
    </script>

</body>

</html>
