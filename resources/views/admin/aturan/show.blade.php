@extends('admin.layout.dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/aturan_show.css') }}">
@endpush

@section('content')
<main class="app-main">

    <!-- HEADER -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="detail-header">
                <div>
                    <span class="badge badge-kode-lg">{{ $penyakit->kode }}</span>
                    <h2 class="detail-title">{{ $penyakit->nama_penyakit }}</h2>
                    <p class="text-muted mb-0">
                        Detail basis pengetahuan penyakit & aturan terkait
                    </p>
                </div>

                <div class="detail-actions">
                    <a href="{{ route('admin.aturan.edit', $penyakit->id) }}" class="btn btn-primary btn-modern">
                        <i class="bi bi-pencil-square"></i> Edit Aturan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row g-4">

                <!-- LEFT -->
                <div class="col-lg-4">
                    <div class="card card-modern text-center">
                        <div class="card-body">

                            @if ($penyakit->gambar)
                                <img src="{{ asset($penyakit->gambar) }}"
                                    class="disease-image-modern"
                                    alt="{{ $penyakit->nama_penyakit }}">
                            @else
                                <div class="image-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif

                            <hr>

                            <div class="probability-box">
                                <span>Probabilitas Penyakit</span>
                                <h3>{{ number_format($penyakit->p_c * 100, 4) }}%</h3>
                                <small class="text-muted">
                                    Nilai P(c): {{ $penyakit->p_c }}
                                </small>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="col-lg-8">

                    <!-- GEJALA -->
                    <div class="card card-modern mb-4">
                        <div class="card-header-modern">
                            <i class="bi bi-clipboard2-pulse"></i>
                            Gejala Terhubung
                        </div>
                        <div class="card-body">
                            <div class="gejala-pills">
                                @forelse ($penyakit->gejalas->sortBy('kode') as $gejala)
                                    <span class="gejala-pill">
                                        <span class="kode">{{ $gejala->kode }}</span>
                                        {{ $gejala->gejala }}
                                    </span>
                                @empty
                                    <p class="text-muted fst-italic">
                                        Belum ada gejala terhubung.
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- SOLUSI -->
                    <div class="card card-modern">
                        <div class="card-header-modern success">
                            <i class="bi bi-shield-check"></i>
                            Solusi & Penanganan
                        </div>
                        <div class="card-body">
                            <div class="solution-modern-list">
                                @forelse ($penyakit->solusis->sortBy('kode') as $solusi)
                                    <div class="solution-modern-item">
                                        @if ($solusi->gambar_obat)
                                            <img src="{{ asset($solusi->gambar_obat) }}"
                                                alt="{{ $solusi->nama_obat }}">
                                        @else
                                            <div class="solution-placeholder">
                                                <i class="bi bi-capsule"></i>
                                            </div>
                                        @endif

                                        <div>
                                            <h6>{{ $solusi->nama_obat }}</h6>
                                            <span class="badge badge-solusi">
                                                {{ $solusi->kode }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted fst-italic">
                                        Belum ada solusi terhubung.
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</main>
@endsection
