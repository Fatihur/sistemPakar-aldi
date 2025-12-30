@extends('admin.layout.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/create_aturan_admin.css') }}">
    <style>
        .section-title {
            font-weight: 600;
            font-size: 1.05rem;
        }

        .card-modern {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
        }
    </style>
@endpush

@section('content')
    <main class="app-main">

        <!-- HEADER -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h3 class="mb-1">Tambah Penyakit & Aturan</h3>
                        <p class="text-muted mb-0">
                            Lengkapi data penyakit, gejala, dan solusi penanganan
                        </p>
                    </div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.aturan.index') }}">Aturan</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="app-content">
            <div class="container-fluid">

                <form action="{{ route('admin.aturan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- INFORMASI PENYAKIT -->
                    <div class="card card-modern mb-4">
                        <div class="card-body">
                            <h6 class="section-title mb-3">
                                <i class="bi bi-bug-fill text-danger"></i>
                                Informasi Penyakit
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Kode Penyakit *</label>
                                    <input type="text" name="kode"
                                        class="form-control @error('kode') is-invalid @enderror"
                                        value="{{ old('kode') }}">
                                    @error('kode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">Nama Penyakit *</label>
                                    <input type="text" name="nama_penyakit"
                                        class="form-control @error('nama_penyakit') is-invalid @enderror"
                                        value="{{ old('nama_penyakit') }}">
                                    @error('nama_penyakit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Gambar Penyakit</label>
                                    <input type="file" name="gambar"
                                        class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- GEJALA -->
                    <div class="card card-modern mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="section-title mb-0">
                                    <i class="bi bi-clipboard2-pulse-fill text-primary"></i>
                                    Gejala (Aturan)
                                </h6>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahGejala">
                                    <i class="bi bi-plus-circle"></i> Gejala Baru
                                </button>
                            </div>

                            <div class="symptom-grid-wrapper @error('gejala_ids') is-invalid @enderror">
                                <div class="symptom-grid">
                                    @foreach ($semuaGejala as $gejala)
                                        <label class="symptom-card">
                                            <input type="checkbox" name="gejala_ids[]" value="{{ $gejala->id }}">
                                            <div class="symptom-content">
                                                <div class="symptom-code">{{ $gejala->kode }}</div>
                                                <div class="symptom-desc">{{ $gejala->gejala }}</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('gejala_ids')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- SOLUSI -->
                    <div class="card card-modern mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="section-title mb-0">
                                    <i class="bi bi-shield-check-fill text-success"></i>
                                    Solusi Penanganan
                                </h6>
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahSolusi">
                                    <i class="bi bi-plus-circle"></i> Obat Baru
                                </button>
                            </div>

                            <div class="symptom-grid-wrapper @error('solusi_ids') is-invalid @enderror">
                                <div class="symptom-grid">
                                    @foreach ($semuaSolusi as $solusi)
                                        <label class="symptom-card">
                                            <input type="checkbox" name="solusi_ids[]" value="{{ $solusi->id }}">
                                            <div class="symptom-content">
                                                <div class="symptom-code">{{ $solusi->kode }}</div>
                                                <div class="symptom-desc">{{ $solusi->nama_obat }}</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @error('solusi_ids')
                                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- ACTION -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.aturan.index') }}" class="btn btn-light px-4">
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save-fill"></i> Simpan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>
@endsection


@push('modals')
    <div class="modal fade" id="modalTambahSolusi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Solusi/Obat Baru (AJAX)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahSolusi" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="solusi_kode" class="form-label">Kode Solusi</label>
                            <input type="text" class="form-control" id="solusi_kode" name="kode">
                            <div class="invalid-feedback" id="error_solusi_kode"></div>
                        </div>

                        <div class="mb-3">
                            <label for="solusi_nama" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="solusi_nama" name="nama_obat">
                            <div class="invalid-feedback" id="error_solusi_nama"></div>
                        </div>

                        <div class="mb-3">
                            <label for="solusi_gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="solusi_gambar" name="gambar"
                                accept="image/*">
                            <div class="invalid-feedback" id="error_solusi_gambar"></div>
                            <div class="mt-2 d-none" id="preview-container">
                                <p class="text-muted small mb-1">Preview:</p>

                                <img src="" id="img-preview" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSimpanSolusi"
                        data-url="{{ route('admin.aturan.storeSolusiAjax') }}">
                        Simpan Obat
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush


@push('scripts')
    <script src="{{ asset('js/aturan_admin.js') }}"></script>
@endpush
