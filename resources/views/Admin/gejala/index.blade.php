@extends('admin.layout.dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/gejala.css') }}">
@endpush

@section('content')
<main class="app-main" style="background-color: #f4f6f9;">
    <div class="app-content-header pt-4 pb-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <h3 class="mb-0 page-header-title">Data Gejala Penyakit</h3>
                    <p class="text-muted mb-0">Daftar referensi gejala untuk diagnosa sistem pakar</p>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    
                    <div class="card custom-card p-4">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title fw-bold mb-0 text-secondary">
                                <i class="bi bi-list-ul me-2"></i> Semua Gejala
                            </h5>
                            
                            <form action="{{ route('admin.gejala.index') }}" method="GET" class="search-box">
                                <i class="bi bi-search"></i>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari kode atau nama..." 
                                       value="{{ request('search') }}" autocomplete="off">
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Kode</th>
                                        <th width="80%">Nama Gejala</th> 
                                        </tr>
                                </thead>
                                <tbody>
                                    @forelse ($gejalas as $index => $gejala)
                                        <tr class="fade-in-row" style="animation-delay: {{ $index * 0.05 }}s">
                                            <td class="text-center text-muted fw-bold">{{ $gejalas->firstItem() + $index }}</td>
                                            <td>
                                                <span class="code-badge">{{ $gejala->kode }}</span>
                                            </td>
                                            <td class="fw-500 text-dark" style="font-size: 1.05rem;">
                                                {{ $gejala->gejala }}
                                            </td>
                                            </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="bi bi-folder-x display-4 d-block mb-3 opacity-50"></i>
                                                    Data gejala tidak ditemukan.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="card-footer d-flex justify-content-end custom-pagination">
                            {{ $gejalas->links('pagination::bootstrap-5') }}
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