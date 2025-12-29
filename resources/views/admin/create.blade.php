@extends('admin.layout.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endpush

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3 class="fw-bold mb-0">Tambah Pengguna Baru</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-9 mx-auto">
                        <div class="card modern-card">
                            <div class="card-header modern-card-header">
                                <h5 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i> Formulir Pengguna Baru</h5>
                            </div>

                            <div class="card-body p-4">
                                <form action="{{ route('admin.users.store') }}" method="POST" novalidate>
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Lengkap</label>
                                            <div class="input-group modern-input">
                                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                <input type="text" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name') }}" placeholder="Contoh: Budi Santoso">
                                            </div>
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Username</label>
                                            <div class="input-group modern-input">
                                                <span class="input-group-text"><i class="bi bi-at"></i></span>
                                                <input type="text" name="username"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    value="{{ old('username') }}" placeholder="Contoh: budi123">
                                            </div>
                                            @error('username')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <div class="input-group modern-input">
                                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                <input type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email') }}" placeholder="contoh@email.com">
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Role</label>

                                            <div class="input-group modern-input">
                                                <span class="input-group-text">
                                                    <i class="bi bi-shield-lock"></i>
                                                </span>

                                                <select name="role"
                                                    class="form-select @error('role') is-invalid @enderror">
                                                    <option value="" selected disabled>-- Pilih Role --</option>
                                                    <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Admin
                                                    </option>
                                                    <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>
                                                        Penyuluh Pertanian</option>
                                                    <option value="3" {{ old('role') == '3' ? 'selected' : '' }}>
                                                        Petani
                                                    </option>
                                                </select>
                                            </div>

                                            @error('role')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Kata Sandi</label>
                                            <label class="form-label">Kata Sandi</label>
                                            <div class="input-group modern-input">
                                                <span class="input-group-text"><i class="bi bi-lock"></i></span>

                                                <input type="password" id="password" name="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="********">

                                                <span class="input-group-text" onclick="toggleMyPassword('password', this)"
                                                    style="cursor: pointer; z-index: 1000;">
                                                    <i class="bi bi-eye-slash"></i>
                                                </span>
                                                @error('password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Konfirmasi Kata Sandi</label>
                                            <div class="input-group modern-input">
                                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>

                                                <input type="password" id="password_confirmation"
                                                    name="password_confirmation" class="form-control"
                                                    placeholder="********">

                                                <span class="input-group-text"
                                                    onclick="toggleMyPassword('password_confirmation', this)"
                                                    style="cursor: pointer; z-index: 1000;">
                                                    <i class="bi bi-eye-slash"></i>
                                                </span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
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
        // Membuat fungsi global agar bisa dipanggil langsung dari onclick HTML
        window.toggleMyPassword = function(inputId, iconSpan) {
            // Cari input berdasarkan ID
            var input = document.getElementById(inputId);
            // Cari icon <i> di dalam tombol yang diklik
            var icon = iconSpan.querySelector('i');

            // Debugging: Cek di console apakah fungsi terpanggil
            console.log('Tombol diklik untuk:', inputId);

            if (input && icon) {
                if (input.type === "password") {
                    // Ubah jadi Text
                    input.type = "text";
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    // Ubah jadi Password
                    input.type = "password";
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            } else {
                console.error('Element tidak ditemukan! Cek ID input.');
            }
        };
    </script>
@endpush
