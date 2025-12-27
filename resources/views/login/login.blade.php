<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | Sistem Pakar Penyakit Padi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('obat/logo.png') }}" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/login-bootstrap.css') }}">
</head>

<body>

    <div class="login-wrapper">
        <div class="overlay"></div>

        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-lg-4 col-md-6 col-sm-10">

                    <div class="login-card animate-fade">

                        <h3 class="text-center mb-4">Login Dulu</h3>

                        <!-- Alert -->
                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        @error('username')
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror

                        @error('password')
                            <div class="alert alert-danger text-center">{{ $message }}</div>
                        @enderror

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Username -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Username" value="{{ old('username') }}" >
                                <label for="username">
                                    <i class="bi bi-person"></i> Username
                                </label>
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Password" >

                                <label for="password">
                                    <i class="bi bi-lock"></i> Password
                                </label>

                                <!-- Eye Toggle -->
                                <span class="password-toggle" onclick="togglePassword()">
                                    <i id="eyeIcon" class="bi bi-eye"></i>
                                </span>
                            </div>

                            <!-- Remember -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>

                            <!-- Button -->
                            <button type="submit" class="btn btn-login w-100 mb-3">
                                Login
                            </button>

                            <!-- Register -->
                            <p class="text-center small">
                                Belum punya akun?
                                <a href="{{ route('register') }}"><b>Daftar di sini</b></a>
                            </p>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>
