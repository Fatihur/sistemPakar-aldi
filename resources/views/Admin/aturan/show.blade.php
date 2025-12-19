@extends('admin.layout.dashboard')

@push('styles')
    <style>
        .detail-card .card-header {
            background-color: #f8f9fa;
        }
        .disease-image-detail {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #dee2e6;
        }
        .list-group-item .badge {
            font-size: 0.9rem;
            width: 60px; /* Ratakan badge */
            text-align: center;
        }
        .solution-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .solution-item:last-child {
            border-bottom: none;
        }
        .solution-image {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 5px;
            background: #fff;
            border: 1px solid #eee;
        }
    </style>
@endpush

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Detail Basis Pengetahuan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dasbor Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.aturan.index') }}">Aturan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">
                    <div class="card detail-card">
                        <div class="card-header">
                            <h3 class="card-title">Detail Penyakit</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.aturan.edit', $penyakit->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($penyakit->gambar)
                                <img src="{{ asset($penyakit->gambar) }}" alt="{{ $penyakit->nama_penyakit }}" class="disease-image-detail mb-3">
                            @endif
                            
                            <h3>
                                <span class="badge bg-danger">{{ $penyakit->kode }}</span>
                                {{ $penyakit->nama_penyakit }}
                            </h3>
                            <hr>
                            <strong><i class="bi bi-calculator-fill"></i> Probabilitas (P(c)):</strong>
                            <p class="text-muted fs-5">
                                {{ number_format($penyakit->p_c * 100, 4) }} % 
                                (Nilai: {{ $penyakit->p_c }})
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card detail-card mb-4">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-clipboard2-pulse-fill text-primary"></i> Gejala Terhubung (Aturan)</h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($penyakit->gejalas->sortBy('kode') as $gejala)
                                    <li class="list-group-item">
                                        <span class="badge bg-secondary me-2">{{ $gejala->kode }}</span>
                                        {{ $gejala->gejala }}
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">Belum ada gejala terhubung.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="card detail-card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="bi bi-shield-check-fill text-success"></i> Solusi Terhubung</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="solution-list">
                                @forelse ($penyakit->solusis->sortBy('kode') as $solusi)
                                    <div class="solution-item">
                                        @if ($solusi->gambar_obat)
                                            <img src="{{ asset($solusi->gambar_obat) }}" alt="{{ $solusi->nama_obat }}" class="solution-image">
                                        @endif
                                        <div>
                                            <strong>{{ $solusi->nama_obat }}</strong>
                                            (<span class="text-primary">{{ $solusi->kode }}</span>)
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-3 text-muted">Belum ada solusi terhubung.</div>
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