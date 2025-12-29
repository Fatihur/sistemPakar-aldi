@extends('petani.layout.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/gejala.css') }}">
@endpush

@section('content')
    <main class="app-main bg-light">

        <!-- HEADER -->
        <div class="app-content-header py-4">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h3 class="page-header-title mb-1">Data Gejala Penyakit</h3>
                        <p class="text-muted mb-0">
                            Daftar referensi gejala untuk diagnosa sistem pakar
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="app-content">
            <div class="container-fluid">

                <div class="card custom-card">
                    <div class="card-body">

                        <!-- TITLE + SEARCH -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                            <h5 class="card-title fw-semibold text-dark mb-0">
                                <i class="bi bi-clipboard-data me-2 text-primary"></i>
                                Semua Gejala
                            </h5>

                            <form action="{{ route('petani.gejala.index') }}" method="GET" class="search-box">
                                <i class="bi bi-search"></i>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari kode atau nama gejala..." value="{{ request('search') }}"
                                    autocomplete="off">
                            </form>
                        </div>

                        <!-- TABLE -->
                        <div class="table-responsive">
                            <table class="table modern-table align-middle">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Kode</th>
                                        <th>Nama Gejala</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($gejalas as $index => $gejala)
                                        <tr class="fade-in-row" style="animation-delay: {{ $index * 0.05 }}s">
                                            <td class="text-center text-muted fw-semibold">
                                                {{ $gejalas->firstItem() + $index }}
                                            </td>
                                            <td>
                                                <span class="code-badge">{{ $gejala->kode }}</span>
                                            </td>
                                            <td class="gejala-text">
                                                {{ $gejala->gejala }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="bi bi-folder-x"></i>
                                                    <p>Data gejala tidak ditemukan</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- PAGINATION -->
                    <div class="card-footer custom-pagination">
                        {{ $gejalas->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection


@push('scripts')
    <script>
        /**
         * Fungsi Dummy untuk memberikan efek interaktif
         * karena fitur CRUD dimatikan sesuai permintaan.
         */
        function showDummyAlert(action) {
            Swal.fire({
                title: 'Mode Tampilan',
                text: `Tombol '${action}' ditekan. Fitur ini dinonaktifkan dalam mode demo/view-only.`,
                icon: 'info',
                confirmButtonColor: '#667eea',
                confirmButtonText: 'Mengerti'
            });
        }

        // Efek hover tambahan pada baris tabel
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.modern-table tbody tr');
            rows.forEach(row => {
                row.addEventListener('mouseenter', () => {
                    row.style.transform = 'scale(1.01) translateY(-3px)';
                });
                row.addEventListener('mouseleave', () => {
                    row.style.transform = 'scale(1) translateY(0)';
                });
            });
        });
    </script>
@endpush
