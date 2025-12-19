@extends('admin.layout.dashboard')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="{{ asset('css/aturan_admin.css') }}">
@endpush

@section('content')
    <main class="app-main">
        {{-- ... (Header Konten) ... --}}
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit Aturan</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dasbor Admin</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.aturan.index') }}">Aturan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Edit Aturan untuk: <span class="fw-bold text-danger">{{ $penyakit->kode }} -
                                        {{ $penyakit->nama_penyakit }}</span>
                                </h3>
                            </div>

                            <form action="{{ route('admin.aturan.update', $penyakit->id) }}" method="POST"
                                enctype="multipart/form-data">@csrf

                                @method('PUT') <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label for="kode" class="form-label">Kode Penyakit <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                                id="kode" name="kode" value="{{ old('kode', $penyakit->kode) }}"
                                                >
                                            @error('kode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-5 mb-3">
                                            <label for="nama_penyakit" class="form-label">Nama Penyakit <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('nama_penyakit') is-invalid @enderror"
                                                id="nama_penyakit" name="nama_penyakit"
                                                value="{{ old('nama_penyakit', $penyakit->nama_penyakit) }}" >
                                            @error('nama_penyakit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="gambar" class="form-label">Upload Gambar Baru (Opsional)</label>
                                            <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                                id="gambar" name="gambar" accept="image/*">
                                            <small class="text-muted">Kosongkan jika tidak ingin mengubah.</small>
                                            @error('gambar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            @if ($penyakit->gambar)
                                                <div class="mt-2">
                                                    <label class="form-label d-block">Gambar Saat Ini:</label>
                                                    <img src="{{ asset($penyakit->gambar) }}"
                                                        alt="{{ $penyakit->nama_penyakit }}"
                                                        style="width: 100px; height: 60px; object-fit: cover; border-radius: 5px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pilih Gejala (Aturan) <span
                                                    class="text-danger">*</span></label>
                                            <button type="button" class="btn btn-success btn-sm float-end mb-2"
                                                data-bs-toggle="modal" data-bs-target="#modalTambahGejala"
                                                data-url="{{ route('admin.aturan.storeGejalaAjax') }}">
                                                <i class="bi bi-plus-circle"></i> Gejala Baru
                                            </button>

                                            <div class="symptom-grid-wrapper @error('gejala_ids') is-invalid @enderror">
                                                <div id="gejala-grid-container" class="symptom-grid">
                                                    @foreach ($semuaGejala as $gejala)
                                                        @php $isChecked = in_array($gejala->id, $gejalaDimiliki); @endphp
                                                        <label class="symptom-card {{ $isChecked ? 'checked' : '' }}">
                                                            <input type="checkbox" name="gejala_ids[]"
                                                                value="{{ $gejala->id }}"
                                                                {{ $isChecked ? 'checked' : '' }}>
                                                            <div class="symptom-content">
                                                                <div class="symptom-code">{{ $gejala->kode }}</div>
                                                                <div class="symptom-desc">{{ $gejala->gejala }}</div>
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @error('gejala_ids')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pilih Solusi Penanganan <span
                                                    class="text-danger">*</span></label>
                                            <button type="button" class="btn btn-success btn-sm float-end mb-2"
                                                data-bs-toggle="modal" data-bs-target="#modalTambahSolusi"
                                                data-url="{{ route('admin.aturan.storeSolusiAjax') }}">
                                                <i class="bi bi-plus-circle"></i> Obat Baru
                                            </button>

                                            <div class="symptom-grid-wrapper @error('solusi_ids') is-invalid @enderror">
                                                <div id="solusi-grid-container" class="symptom-grid">
                                                    @foreach ($semuaSolusi as $solusi)
                                                        @php $isChecked = in_array($solusi->id, $solusiDimiliki); @endphp
                                                        <label class="symptom-card {{ $isChecked ? 'checked' : '' }}">
                                                            <input type="checkbox" name="solusi_ids[]"
                                                                value="{{ $solusi->id }}"
                                                                {{ $isChecked ? 'checked' : '' }}>
                                                            <div class="symptom-content">
                                                                <div class="symptom-code">{{ $solusi->kode }}</div>
                                                                <div class="symptom-desc">{{ $solusi->nama_obat }}</div>
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @error('solusi_ids')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill"></i> Simpan
                                        Perubahan</button>
                                    <a href="{{ route('admin.aturan.index') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modalTambahGejala" tabindex="-1" aria-labelledby="modalTambahGejalaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahGejalaLabel">Tambah Gejala Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahGejala">
                        @csrf
                        <!-- Input Kode Gejala -->
                        <div class="mb-3">
                            <label for="gejala_kode" class="form-label">Kode Gejala (cth: G28)</label>
                            <input type="text" class="form-control" id="gejala_kode" name="kode" 
                                placeholder="Masukkan kode">
                            <div class="invalid-feedback" id="error_gejala_kode"></div>
                        </div>

                        <!-- Input Nama Gejala -->
                        <div class="mb-3">
                            <label for="gejala_nama" class="form-label">Nama Gejala</label>
                            <input type="text" class="form-control" id="gejala_nama" name="gejala" 
                                placeholder="Masukkan nama gejala">
                            <div class="invalid-feedback" id="error_gejala_nama"></div>
                        </div>

                        <!-- Input Kategori (Bagian Tanaman) - BARU -->
                        <div class="mb-3">
                            <label for="gejala_bagian" class="form-label">Bagian Tanaman / Kategori</label>
                            <select class="form-select" id="gejala_bagian" name="bagian" >
                                <option value="" selected disabled>-- Pilih Kategori Gejala --</option>
                                <option value="daun">Gejala pada daun</option>
                                <option value="batang_pucuk">Gejala pada batang & pucuk</option>
                                <option value="biji_gabah">Gejala pada biji dan gabah</option>
                                <option value="umum">Gejala umum pada tanaman</option>
                            </select>
                            <div class="invalid-feedback" id="error_gejala_bagian"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <!-- Pastikan data-url diisi dengan route yang sesuai -->
                    <button type="button" class="btn btn-primary" id="btnSimpanGejala"
                        data-url="{{ route('admin.gejala.store.ajax') }}">
                        Simpan Gejala
                    </button>
                </div>
            </div>
        </div>
    </div>
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
                            <input type="text" class="form-control" id="solusi_kode" name="kode" >
                            <div class="invalid-feedback" id="error_solusi_kode"></div>
                        </div>

                        <div class="mb-3">
                            <label for="solusi_nama" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="solusi_nama" name="nama_obat" >
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/aturan_admin.js') }}"></script>
@endpush
