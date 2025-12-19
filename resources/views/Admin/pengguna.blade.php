@extends('admin.layout.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/menajmen_pengguna.css') }}">
@endpush

@section('content')
    <main class="app-main">
        <!-- Header Konten -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Manajemen Pengguna</h3>
                        <div class="card-tools d-flex align-items-center">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm me-3">
                                <i class="bi bi-plus-circle-fill"></i> Tambah Pengguna
                            </a>

                            <form action="{{ route('admin.users.index') }}" method="GET"
                                class="input-group input-group-sm" style="width: 250px;">
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Dasbor Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Semua Pengguna</h3>
                                <div class="card-tools">
                                    <!-- Form Pencarian -->
                                    <form action="{{ route('admin.users.index') }}" method="GET"
                                        class="input-group input-group-sm" style="width: 250px;">
                                        <input type="text" name="search" class="form-control float-right"
                                            placeholder="Cari pengguna..." value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Nama Pengguna</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <th>Peran (Role)</th>
                                            <th style="width: 150px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $index => $user)
                                            <tr>
                                                <td>{{ $users->firstItem() + $index }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>
                                                    <!-- Menampilkan peran dengan badge -->
                                                    @if ($user->roles->isNotEmpty())
                                                        @php
                                                            $role = $user->roles->first();
                                                            $badgeClass = 'bg-secondary';
                                                            if ($role->name == 'admin') {
                                                                $badgeClass = 'bg-danger';
                                                            }
                                                            if ($role->name == 'penyuluh') {
                                                                $badgeClass = 'bg-warning';
                                                            }
                                                            if ($role->name == 'petani') {
                                                                $badgeClass = 'bg-success';
                                                            }
                                                        @endphp
                                                        <span
                                                            class="badge {{ $badgeClass }}">{{ $role->display_name }}</span>
                                                    @else
                                                        <span class="badge bg-light text-dark">Tidak ada peran</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Tombol Aksi -->
                                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                    <button class="btn btn-sm btn-danger delete-btn"
                                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                                        <i class="bi bi-trash-fill"></i> Hapus
                                                    </button>

                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ route('admin.users.destroy', $user->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Data pengguna tidak
                                                    ditemukan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <!-- Link Paginasi -->
                                {{ $users->links() }}
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
        // Script untuk konfirmasi hapus dengan SweetAlert2
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const userName = this.getAttribute('data-name');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda akan menghapus pengguna "${userName}". Tindakan ini tidak dapat dibatalkan!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${userId}`).submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {


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
