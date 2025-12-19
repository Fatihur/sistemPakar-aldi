@extends('petani.layout.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pilih_pakar.css') }}">
@endpush

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Mulai Konsultasi</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('petani.dashboard') }}">Dasbor</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pilih Penyuluh Pertanian</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    @forelse ($penyuluh as $penyuluh)
                        <div class="col-md-6 col-lg-4">
                            <div class="card pakar-card">
                                <div class="card-body text-center">
                                    <img src="{{ asset('lte/dist/assets/img/pakar.jpg') }}" alt="Avatar Pakar"
                                        class="pakar-avatar">
                                    <h4 class="pakar-name mt-3">{{ $penyuluh->name }}</h4>
                                    <p class="text-muted">Pakar Sistem</p>

                                    @if (isset($penyuluhConvMap[$penyuluh->id]))
                                        <a href="{{ route('chat.show', $penyuluhConvMap[$penyuluh->id]) }}"
                                            class="btn btn-success">
                                            <i class="bi bi-chat-dots-fill"></i> Lanjutkan Obrolan
                                        </a>
                                    @else
                                        <a href="{{ route('chat.create', $penyuluh->id) }}" class="btn btn-primary">
                                            <i class="bi bi-plus-circle-fill"></i> Mulai Obrolan Baru
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning text-center" role="alert">
                                Saat ini belum ada penyuluh yang tersedia.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection
