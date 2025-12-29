@extends('pakar.layout.dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/penyakit_pakar.css') }}">
@endpush

@section('content')
<main class="app-main bg-light">

    <!-- HEADER -->
    <div class="app-content-header py-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h3 class="page-header-title mb-1">Data Penyakit</h3>
                    <p class="text-muted mb-0">
                        Daftar penyakit dan hama padi pada sistem pakar
                    </p>
                </div>

                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pakar.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Penyakit</li>
                </ol>
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
                        <h5 class="card-title fw-semibold mb-0">
                            <i class="bi bi-bug-fill text-danger me-2"></i>
                            Daftar Penyakit & Hama
                        </h5>

                        <form action="{{ route('pakar.penyakit.index') }}" method="GET" class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari kode atau nama penyakit..."
                                value="{{ request('search') }}">
                        </form>
                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table modern-table align-middle">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="12%">Kode</th>
                                    <th width="18%">Gambar</th>
                                    <th>Nama Penyakit / Hama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($penyakits as $index => $penyakit)
                                    <tr class="fade-in-row" style="animation-delay: {{ $index * 0.05 }}s">
                                        <td class="text-center text-muted fw-semibold">
                                            {{ $penyakits->firstItem() + $index }}
                                        </td>

                                        <td>
                                            <span class="code-badge">{{ $penyakit->kode }}</span>
                                        </td>

                                        <td>
                                            @if ($penyakit->gambar)
                                                <img src="{{ asset($penyakit->gambar) }}"
                                                     alt="{{ $penyakit->nama_penyakit }}"
                                                     class="disease-thumb open-image-modal"
                                                     data-caption="{{ $penyakit->nama_penyakit }}">
                                            @else
                                                <span class="text-muted small">Tidak ada</span>
                                            @endif
                                        </td>

                                        <td class="disease-name">
                                            {{ $penyakit->nama_penyakit }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="bi bi-folder-x"></i>
                                                <p>Data penyakit tidak ditemukan</p>
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
                    {{ $penyakits->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
</main>

<!-- IMAGE MODAL -->
<div id="image-modal-overlay" class="image-modal-overlay">
    <span class="close-image-modal">&times;</span>
    <div class="image-modal-content">
        <img id="modal-image" class="modal-image">
        <div id="modal-caption"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/penyakit_pakar.js') }}"></script>
@endpush
