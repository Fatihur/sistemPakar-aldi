@extends('pakar.layout.dashboard') 
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/penyakit_pakar.css') }}">
@endpush

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Data Penyakit </h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Dasbor Pakar</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Penyakit</li>
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
                                <h3 class="card-title">Daftar Penyakit & Hama Padi</h3>
                                <div class="card-tools">
                                    <form action="{{ route('pakar.penyakit.index') }}" method="GET"
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
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th>Kode</th>
                                            <th>Gambar</th>
                                            <th>Nama Penyakit / Hama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($penyakits as $index => $penyakit)
                                            <tr class="align-middle">
                                                <td>{{ $penyakits->firstItem() + $index }}</td>
                                                <td><span class="badge bg-secondary">{{ $penyakit->kode }}</span></td>
                                                <td>
                                                    @if ($penyakit->gambar)
                                                        <img src="{{ asset($penyakit->gambar) }}"
                                                            alt="{{ $penyakit->nama_penyakit }}" class="disease-image-thumbnail">
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>{{ $penyakit->nama_penyakit }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">Data penyakit tidak
                                                    ditemukan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex justify-content-end custom-pagination">
                                {{ $penyakits->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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