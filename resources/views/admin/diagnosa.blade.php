@extends('admin.layout.dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/diagnosa.css') }}">
@endpush

@section('content')
<main class="app-main">
    <!-- HEADER -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="fw-bold mb-0">Mulai Diagnosis</h3>
                    <small class="text-muted">Deteksi Hama & Penyakit Tanaman Padi</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dasbor Admin</a></li>
                        <li class="breadcrumb-item active">Diagnosis</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="app-content">
        <div class="container-fluid">

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="diagnosa-wizard-card">

                        <!-- PROGRESS -->
                        <div class="wizard-progress">
                            <div class="wizard-progress-bar" id="progressBar">0%</div>
                        </div>

                        <form id="diagnosa-form" action="{{ route('admin.diagnosa.calculate') }}" method="POST">
                            @csrf

                            <!-- STEP 1 -->
                            <div class="wizard-step active" data-step-name="Daun">
                                <h4 class="step-title">
                                    <i class="bi bi-leaf me-2"></i> Gejala pada Daun
                                </h4>
                                <p class="step-subtitle">Pilih gejala yang muncul pada daun tanaman.</p>

                                <div class="symptom-grid">
                                    @foreach ($gejalaDaun as $gejala)
                                        <label class="symptom-card">
                                            <input type="checkbox" name="gejala[]" value="{{ $gejala->kode }}">
                                            <div class="symptom-body">
                                                <div class="icon"><i class="bi bi-border-style"></i></div>
                                                <span class="code">{{ $gejala->kode }}</span>
                                                <p>{{ Str::limit($gejala->gejala, 90) }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="wizard-nav">
                                    <button type="button" class="btn btn-primary next-step">
                                        Lanjut <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- STEP 2 -->
                            <div class="wizard-step" data-step-name="Batang">
                                <h4 class="step-title">
                                    <i class="bi bi-tree me-2"></i> Gejala Batang & Pucuk
                                </h4>
                                <p class="step-subtitle">Perhatikan batang dan pucuk tanaman.</p>

                                <div class="symptom-grid">
                                    @foreach ($gejalaBatang as $gejala)
                                        <label class="symptom-card">
                                            <input type="checkbox" name="gejala[]" value="{{ $gejala->kode }}">
                                            <div class="symptom-body">
                                                <div class="icon"><i class="bi bi-graph-down-arrow"></i></div>
                                                <span class="code">{{ $gejala->kode }}</span>
                                                <p>{{ Str::limit($gejala->gejala, 70) }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="wizard-nav">
                                    <button type="button" class="btn btn-light prev-step">
                                        <i class="bi bi-arrow-left"></i> Kembali
                                    </button>
                                    <button type="button" class="btn btn-primary next-step">
                                        Lanjut <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- STEP 3 -->
                            <div class="wizard-step" data-step-name="Biji">
                                <h4 class="step-title">
                                    <i class="bi bi-grid-3x3-gap me-2"></i> Gejala Biji / Gabah
                                </h4>
                                <p class="step-subtitle">Kondisi biji jika sudah terbentuk.</p>

                                <div class="symptom-grid">
                                    @foreach ($gejalaBiji as $gejala)
                                        <label class="symptom-card">
                                            <input type="checkbox" name="gejala[]" value="{{ $gejala->kode }}">
                                            <div class="symptom-body">
                                                <div class="icon"><i class="bi bi-x-diamond"></i></div>
                                                <span class="code">{{ $gejala->kode }}</span>
                                                <p>{{ Str::limit($gejala->gejala, 70) }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="wizard-nav">
                                    <button type="button" class="btn btn-light prev-step">
                                        <i class="bi bi-arrow-left"></i> Kembali
                                    </button>
                                    <button type="button" class="btn btn-primary next-step">
                                        Lanjut <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- STEP 4 -->
                            <div class="wizard-step" data-step-name="Umum">
                                <h4 class="step-title">
                                    <i class="bi bi-exclamation-triangle me-2"></i> Gejala Umum
                                </h4>
                                <p class="step-subtitle">Kondisi tanaman secara keseluruhan.</p>

                                <div class="symptom-grid">
                                    @foreach ($gejalaUmum as $gejala)
                                        <label class="symptom-card">
                                            <input type="checkbox" name="gejala[]" value="{{ $gejala->kode }}">
                                            <div class="symptom-body">
                                                <div class="icon"><i class="bi bi-exclamation-circle"></i></div>
                                                <span class="code">{{ $gejala->kode }}</span>
                                                <p>{{ Str::limit($gejala->gejala, 70) }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <div class="wizard-nav">
                                    <button type="button" class="btn btn-light prev-step">
                                        <i class="bi bi-arrow-left"></i> Kembali
                                    </button>
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="bi bi-search"></i> Diagnosa Sekarang
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="{{ asset('js/diagnosa.js') }}"></script>
@endpush
