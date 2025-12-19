@extends('admin.layout.dashboard')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Tambah Pengguna Baru</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Manajemen Pengguna</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Formulir Pengguna Baru</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.users.store') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name') }}" required>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-at"></i></span>
                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror" id="username"
                                                name="username" value="{{ old('username') }}" required>
                                        </div>
                                        @error('username')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Alamat Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email') }}" required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="role" class="form-label">Peran (Role)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                                            <select class="form-select @error('role') is-invalid @enderror" id="role"
                                                name="role">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('role') == $role->id ? 'selected' : '' }}>
                                                        {{ $role->display_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('role')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Kata Sandi</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" id="password"
                                                name="password" required>
                                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                                <i class="bi bi-eye-slash-fill"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" required>
                                            <span class="input-group-text" id="togglePasswordConfirmation"
                                                style="cursor: pointer;">
                                                <i class="bi bi-eye-slash-fill"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="card-footer bg-white">
                                        <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
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

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Fungsi reusable untuk toggle password
            function setupPasswordToggle(toggleId, inputId) {
                const toggleElement = document.querySelector(toggleId);
                const inputElement = document.querySelector(inputId);

                if (!toggleElement || !inputElement) return;

                toggleElement.addEventListener('click', function() {
                    // 1. Cek tipe saat ini
                    const type = inputElement.getAttribute('type') === 'password' ? 'text' : 'password';

                    // 2. Ubah tipe input
                    inputElement.setAttribute('type', type);

                    // 3. Ubah Ikon (Mata Coret <-> Mata Biasa)
                    const icon = this.querySelector('i');
                    if (type === 'text') {
                        icon.classList.remove('bi-eye-slash-fill');
                        icon.classList.add('bi-eye-fill');
                    } else {
                        icon.classList.remove('bi-eye-fill');
                        icon.classList.add('bi-eye-slash-fill');
                    }
                });
            }

            // Panggil fungsi untuk Password Utama
            setupPasswordToggle('#togglePassword', '#password');

            // Panggil fungsi untuk Konfirmasi Password
            setupPasswordToggle('#togglePasswordConfirmation', '#password_confirmation');

        });
    </script>
@endpush
