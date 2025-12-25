@extends('admin.layout.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/hasil_diagnosa.css') }}">
@endpush

@section('content')
    <main class="app-main">

        <!-- HEADER -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h3 class="fw-bold mb-0">Hasil Diagnosa</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dasbor</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.diagnosa.index') }}">Diagnosis</a></li>
                            <li class="breadcrumb-item active">Hasil</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="app-content">
            <div class="container-fluid">

                <!-- RESULT CARD -->
                <div class="card result-card mb-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="row align-items-center g-4">

                            <!-- LEFT -->
                            <div class="col-md-3 text-center">
                                <h6 class="text-muted">Kemungkinan Terbesar</h6>

                                <div class="confidence-circle" style="--confidence: {{ $confidence }}%">
                                    <span class="confidence-value">{{ number_format($confidence, 2) }}%</span>
                                </div>

                                <h2 class="disease-name mt-3">{{ $winner->nama_penyakit }}</h2>
                                <span class="badge bg-danger fs-6">{{ $winner->kode }}</span>
                            </div>

                            <!-- CENTER -->
                            <div class="col-md-4 text-center">
                                @if ($winner->gambar)
                                    <img src="{{ asset($winner->gambar) }}" class="img-fluid disease-image"
                                        alt="{{ $winner->nama_penyakit }}">
                                @endif
                            </div>

                            <!-- RIGHT -->
                            <div class="col-md-5">
                                <h4 class="mb-3">
                                    <i class="bi bi-shield-check text-success"></i>
                                    Solusi & Penanganan
                                </h4>

                                <div class="solution-list">
                                    @forelse ($winner->solusis as $solusi)
                                        <div class="solution-item">
                                            <img src="{{ asset($solusi->gambar_obat) }}"
                                                class="solution-image solution-image-clickable"
                                                alt="{{ $solusi->nama_obat }}">
                                            <div>
                                                <strong>{{ $solusi->nama_obat }}</strong><br>
                                                <small class="text-muted">{{ $solusi->kode }}</small>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted">Belum ada solusi.</p>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- DETAIL -->
                <div class="row">

                    <!-- GEJALA -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header fw-bold">Gejala Dipilih</div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    @foreach ($gejalaTerpilih as $gejala)
                                        <li class="list-group-item">
                                            <span class="badge bg-primary me-2">{{ $gejala->kode }}</span>
                                            {{ $gejala->gejala }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- GRAFIK -->
                    <div class="col-md-8 mb-4">
                        <div class="card h-100">
                            <div class="card-header fw-bold">Grafik Probabilitas</div>
                            <div class="card-body">
                                <canvas id="probabilityChart"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- MODAL ZOOM OBAT -->
    <div class="obat-modal-overlay" id="obatModal">
        <div class="obat-modal-content">
            <span class="close-obat-modal" id="closeObatModal">&times;</span>
            <img id="modal-obat-image">
            <div id="modal-obat-caption"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Menghubungkan file JS kustom -->
    <script src="{{ asset('js/hasil_diagnosa.js') }}"></script>

    <!-- Data untuk Chart.js -->
    <script>
        // Kirim data probabilitas dari PHP ke JavaScript
        const chartData = {
            labels: [
                @foreach ($fullResults as $result)
                    '{{ $result['penyakit']->kode }}',
                @endforeach
            ],
            probabilities: [
                @foreach ($fullResults as $result)
                    {{ $result['probabilitas'] }},
                @endforeach
            ]
        };
    </script>
@endpush
