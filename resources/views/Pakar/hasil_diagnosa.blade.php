@extends('pakar.layout.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/hasil_diagnosa.css') }}">
@endpush

@section('content')
    <main class="app-main">
        <!-- Header Konten -->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Hasil Diagnosis</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('pakar.dashboard') }}">Dasbor</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pakar.diagnosa.index') }}">Diagnosis</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hasil</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="app-content">
            <div class="container-fluid">
                <!-- Hasil Utama -->
                <div class="row">
                    <div class="col-12">
                        <div class="card result-card shadow-lg">
                            <div class="card-body p-4 p-md-5">
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center">
                                        <h4 class="text-muted mb-0">Kemungkinan Terbesar</h4>
                                        <div class="confidence-circle my-3">
                                            <span class="confidence-value">{{ number_format($confidence, 2) }}%</span>
                                        </div>
                                        <h2 class="disease-name">{{ $winner->nama_penyakit }}</h2>
                                        <span class="badge bg-danger fs-6">{{ $winner->kode }}</span>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        @if ($winner->gambar)
                                            <img src="{{ asset($winner->gambar) }}" alt="{{ $winner->nama_penyakit }}"
                                                class="img-fluid rounded shadow-sm disease-image">
                                        @endif
                                    </div>
                                    <div class="col-md-5">
                                        <h4><i class="bi bi-shield-check-fill text-success"></i> Solusi & Penanganan</h4>
                                        {{-- ... --}}
                                        <div class="solution-list">
                                            @forelse ($winner->solusis as $solusi)
                                                <div class="solution-item">
                                                    @if ($solusi->gambar_obat)
                                                        <img src="{{ asset($solusi->gambar_obat) }}"
                                                            alt="{{ $solusi->nama_obat }}"
                                                            class="solution-image solution-image-clickable">
                                                    @endif
                                                    <span>{{ $solusi->nama_obat }} ({{ $solusi->kode }})</span>
                                                </div>
                                            @empty
                                                <p>Belum ada data solusi untuk penyakit ini.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail & Gejala -->
                <div class="row">
                    <!-- Gejala yang Dipilih -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Gejala yang Anda Pilih</h3>
                            </div>
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

                    <!-- Grafik Probabilitas -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Grafik Probabilitas Semua Penyakit</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="probabilityChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- (Opsional) Detail Perhitungan Teknis -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Detail Perhitungan (Naive Bayes)</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Penyakit</th>
                                            <th>P(C) (Prior)</th>
                                            <th>P(X|C) (Likelihood)</th>
                                            <th>P(X|C) * P(C)</th>
                                            <th>P(C|X) (Hasil Akhir)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fullResults as $result)
                                            <tr
                                                class="{{ $result['penyakit']->id == $winner->id ? 'table-success' : '' }}">
                                                <td>{{ $result['penyakit']->kode }}</td>
                                                <td>{{ $result['penyakit']->nama_penyakit }}</td>
                                                <td>{{ number_format($result['penyakit']->p_c, 5) }}</td>
                                                <td>{{ number_format($result['p_x_c'], 10) }}</td>
                                                <td>{{ number_format($result['p_x_c'] * $result['penyakit']->p_c, 10) }}
                                                </td>
                                                <td><strong>{{ number_format($result['probabilitas'], 2) }} %</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-light">
                                            <td colspan="4" class="text-end"><strong>Total P(X) (Evidence)</strong></td>
                                            <td colspan="2"><strong>{{ number_format($P_X, 10) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
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
