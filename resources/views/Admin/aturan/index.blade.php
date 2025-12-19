@extends('admin.layout.dashboard')
{{-- ... (style) ... --}}
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/aturan_admin.css') }}">
@endpush
@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Basis Pengetahuan (Aturan)</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dasbor Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Aturan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                {{-- ... (Notifikasi Sukses) ... --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="mb-3">
                    <a href="{{ route('admin.aturan.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle-fill"></i> Tambah Penyakit & Aturan Baru
                    </a>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            {{-- ... (Card Header dengan Form Pencarian) ... --}}
                            <div class="card-header">
                                <h3 class="card-title">Daftar Aturan Penyakit, Gejala & Solusi Penanganan</h3>
                                <div class="card-tools">
                                    <form action="{{ route('admin.aturan.index') }}" method="GET"
                                        class="input-group input-group-sm" style="width: 250px;">
                                        <input type="text" name="search" class="form-control float-right"
                                            placeholder="Cari penyakit..." value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            {{-- ... (th no, kode, nama) ... --}}
                                            <th style="width: 10px">No</th>
                                            <th>Kode</th>
                                            <th>Nama Penyakit</th>
                                            <th>Gejala Terhubung</th>
                                            <th style="width: 180px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($penyakits as $index => $penyakit)
                                            <tr class="align-middle">
                                                <td>{{ $penyakits->firstItem() + $index }}</td>
                                                <td><span class="badge bg-danger">{{ $penyakit->kode }}</span></td>
                                                <td>{{ $penyakit->nama_penyakit }}</td>
                                                <td class="gejala-list">
                                                    {{-- ... (loop gejala) ... --}}
                                                    @forelse ($penyakit->gejalas->sortBy('kode') as $gejala)
                                                        <span class="badge bg-secondary">{{ $gejala->kode }}</span>
                                                    @empty
                                                        <span class="text-muted">Belum ada gejala terhubung</span>
                                                    @endforelse
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.aturan.show', $penyakit->id) }}"
                                                        class="btn btn-sm btn-success ">
                                                        <i class="bi bi-eye-fill"></i> Lihat
                                                    </a>
                                                    <a href="{{ route('admin.aturan.edit', $penyakit->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>

                                                    <form action="{{ route('admin.aturan.destroy', $penyakit->id) }}"
                                                        method="POST" class="d-inline"
                                                        id="delete-form-{{ $penyakit->id }}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                            data-id="{{ $penyakit->id }}"
                                                            data-name="{{ $penyakit->nama_penyakit }}">
                                                            <i class="bi bi-trash-fill"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Data penyakit tidak
                                                    ditemukan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{-- ... (Card Footer Paginasi) ... --}}
                            <div class="card-footer d-flex justify-content-end custom-pagination">
                                {{ $penyakits->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/aturan_admin.js') }}"></script>

    <script>
        // Pastikan jQuery sudah dimuat (dari layout)
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id'); // Ini adalah ID Penyakit
                    const userName = this.getAttribute('data-name'); // Ini adalah Nama Penyakit

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda akan menghapus penyakit "${userName}". Tindakan ini tidak dapat dibatalkan!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim form yang benar
                            document.getElementById(`delete-form-${userId}`).submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
