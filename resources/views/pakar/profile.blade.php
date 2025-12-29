@extends('pakar.layout.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/edit_menajmen_pengguna.css') }}">
@endpush

@section('content')
    <main class="app-main">
        <!-- HEADER -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3 class="fw-bold mb-0">Edit Profil Pakar</h3>
                        <small class="text-muted">Perbarui informasi akun Anda</small>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Dasbor Pakar</a></li>
                            <li class="breadcrumb-item active">Profil</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="card modern-card">
                            <!-- CARD HEADER -->
                            <div class="card-header modern-card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-person-circle me-2"></i>
                                    Informasi Pribadi
                                </h5>
                            </div>

                            <!-- CARD BODY -->
                            <div class="card-body p-4">
                                <p class="text-muted mb-4">
                                    Perbarui informasi Anda di sini. Klik <b>Simpan Perubahan</b> setelah selesai.
                                </p>

                                <form action="{{ route('pakar.profile.update') }}" method="POST" novalidate>
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-3">
                                        <!-- Nama -->
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Lengkap</label>
                                            <div class="input-group modern-input">
                                                <span class="input-group-text">
                                                    <i class="bi bi-person"></i>
                                                </span>
                                                <input type="text" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name', auth()->user()->name) }}"
                                                    placeholder="Nama lengkap">
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Username -->
                                        <div class="col-md-6">
                                            <label class="form-label">Username</label>
                                            <div class="input-group modern-input">
                                                <span class="input-group-text">
                                                    <i class="bi bi-at"></i>
                                                </span>
                                                <input type="text" name="username"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    value="{{ old('username', auth()->user()->username) }}"
                                                    placeholder="Username">
                                            </div>
                                            @error('username')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="col-12">
                                            <label class="form-label">Alamat Email</label>
                                            <div class="input-group modern-input">
                                                <span class="input-group-text">
                                                    <i class="bi bi-envelope"></i>
                                                </span>
                                                <input type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', auth()->user()->email) }}"
                                                    placeholder="email@example.com">
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- PASSWORD -->
                                    <hr class="my-4">
                                    <h6 class="text-muted mb-3">
                                        <i class="bi bi-lock me-1"></i> Ubah Kata Sandi (Opsional)
                                    </h6>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Kata Sandi Baru</label>
                                            <div class="input-group modern-input">
                                                <span class="input-group-text"><i class="bi bi-lock"></i></span>

                                                <input type="password" id="password" name="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Biarkan kosong jika tidak diubah">

                                                <span class="input-group-text toggle-password"
                                                    onclick="toggleMyPassword('password', this)"
                                                    style="cursor: pointer; z-index: 1000; position: relative;">
                                                    <i class="bi bi-eye-slash"></i>
                                                </span>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Konfirmasi Kata Sandi</label>
                                            <div class="input-group modern-input">
                                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>

                                                <input type="password" id="password_confirmation"
                                                    name="password_confirmation" class="form-control"
                                                    placeholder="Ulangi kata sandi">

                                                <span class="input-group-text toggle-password"
                                                    onclick="toggleMyPassword('password_confirmation', this)"
                                                    style="cursor: pointer; z-index: 1000; position: relative;">
                                                    <i class="bi bi-eye-slash"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ACTION -->
                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <button type="button" onclick="window.history.back()" class="btn btn-light">
                                            <i class="bi bi-arrow-left"></i> Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="bi bi-save"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

<script>
    window.toggleMyPassword = function(inputId, iconSpan) {
        var input = document.getElementById(inputId);
        var icon = iconSpan.querySelector('i');
        if (input && icon) {
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function() {

        // Cek apakah ada pesan 'success' yang dikirim dari controller
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}', // Ambil pesan dari session
                showConfirmButton: false, // Tombol OK tidak ditampilkan
                timer: 2500 // Notifikasi akan hilang setelah 2.5 detik
            });
        @endif

    });
</script>
