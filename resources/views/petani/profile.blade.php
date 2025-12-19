@extends('petani.layout.dashboard')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit Profil Anda</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('petani.dashboard') }}">Dasbor</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profil</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="profile-page-container-no-photo">
                    <div class="profile-form-card">
                        <h4>Informasi Pribadi</h4>
                        <p class="text-muted">Perbarui informasi Anda di sini. Klik "Simpan Perubahan" setelah selesai.</p>

                        <form id="profile-edit-form" action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- NAMA LENGKAP DENGAN IKON -->
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-icon"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', auth()->user()->name) }}"
                                        placeholder="Masukkan nama lengkap Anda">
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- DITAMBAHKAN: USERNAME DENGAN IKON -->
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <span class="input-group-icon"><i class="bi bi-at"></i></span>
                                    <input type="text" id="username" name="username"
                                        value="{{ old('username', auth()->user()->username) }}"
                                        placeholder="Masukkan username Anda">
                                </div>
                                @error('username')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- EMAIL DENGAN IKON -->
                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-icon"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', auth()->user()->email) }}" placeholder="Masukkan email Anda">
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>
                            <h4>Ubah Kata Sandi (Opsional)</h4>

                            <!-- PASSWORD DENGAN IKON GEMBOK -->
                            <div class="form-group">
                                <label for="password">Kata Sandi Baru</label>
                                <div class="input-group">
                                    <span class="input-group-icon"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="password" name="password"
                                        placeholder="Biarkan kosong jika tidak ingin diubah">
                                    <span class="input-group-icon-toggle" id="togglePassword"><i
                                            class="bi bi-eye-slash-fill"></i></span>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-icon"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        placeholder="Ketik ulang kata sandi baru">
                                    <span class="input-group-icon-toggle" id="togglePasswordConfirmation"><i
                                            class="bi bi-eye-slash-fill"></i></span>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <button type="button" class="btn btn-light" onclick="window.history.back()">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        // Script ini akan berjalan setelah halaman dimuat
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
@endpush
