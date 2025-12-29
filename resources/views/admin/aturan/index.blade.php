@extends('admin.layout.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/aturan_admin.css') }}">
@endpush

@section('content')
    <main class="app-main">
        <!-- HEADER -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="page-title">Basis Pengetahuan</h3>
                        <p class="text-muted mb-0">Aturan penyakit, gejala, dan solusi penanganan</p>
                    </div>
                    <nav>
                        <ol class="breadcrumb bg-transparent mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dasbor</a>
                            </li>
                            <li class="breadcrumb-item active">Aturan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="app-content">
            <div class="container-fluid">

                @if (session('success'))
                    <div class="alert alert-success alert-modern">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- ACTION BAR -->
                <div class="action-bar">
                    <a href="{{ route('admin.aturan.create') }}" class="btn btn-primary btn-modern">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Aturan
                    </a>

                    <form action="{{ route('admin.aturan.index') }}" method="GET" class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" name="search" placeholder="Cari penyakit..." value="{{ request('search') }}">
                    </form>
                </div>

                <!-- CARD -->
                <div class="card card-modern">
                    <div class="card-body p-0">

                        <div class="table-responsive">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Penyakit</th>
                                        <th>Gejala</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penyakits as $index => $penyakit)
                                        <tr>
                                            <td>{{ $penyakits->firstItem() + $index }}</td>

                                            <td>
                                                <span class="badge badge-kode">
                                                    {{ $penyakit->kode }}
                                                </span>
                                            </td>

                                            <td class="fw-semibold">
                                                {{ $penyakit->nama_penyakit }}
                                            </td>

                                            <td>
                                                <div class="gejala-wrap">
                                                    @forelse ($penyakit->gejalas->sortBy('kode') as $gejala)
                                                        <span class="badge badge-gejala">
                                                            {{ $gejala->kode }}
                                                        </span>
                                                    @empty
                                                        <span class="text-muted fst-italic">
                                                            Tidak ada gejala
                                                        </span>
                                                    @endforelse
                                                </div>
                                            </td>

                                            <td class="text-end">
                                                <a href="{{ route('admin.aturan.show', $penyakit->id) }}"
                                                    class="btn-icon btn-view" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.aturan.edit', $penyakit->id) }}"
                                                    class="btn-icon btn-edit" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form action="{{ route('admin.aturan.destroy', $penyakit->id) }}"
                                                    method="POST" class="d-inline" id="delete-form-{{ $penyakit->id }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button" class="btn-icon btn-delete delete-btn"
                                                        data-id="{{ $penyakit->id }}"
                                                        data-name="{{ $penyakit->nama_penyakit }}" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                Data penyakit tidak ditemukan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="card-footer card-footer-modern">
                        {{ $penyakits->appends(request()->query())->links() }}
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
