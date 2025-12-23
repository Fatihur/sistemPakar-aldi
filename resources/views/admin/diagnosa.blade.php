@extends('admin.layout.dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/diagnosa.css') }}">
@endpush

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Mulai Diagnosis Hama & Penyakit</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dasbor Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Diagnosis</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card wizard-card">
                        
                        <div class="progress-container">
                            <div class="progress-bar" id="progressBar"></div>
                        </div>

                        <form id="diagnosa-form" action="{{ route('admin.diagnosa.calculate') }}" method="POST">
                            @csrf

                            <div class="wizard-step" data-step-name="Gejala Daun">
                                <h4 class="step-title"><i class="bi bi-person-circle"></i> Gejala pada Daun</h4>
                                <p class="step-subtitle">Pilih semua gejala yang Anda lihat pada daun tanaman padi Anda.</p>
                                <div class="symptom-grid">
                                    @foreach ($gejalaDaun as $gejala)
                                        <label class="symptom-card">
                                            <input type="checkbox" name="gejala[]" value="{{ $gejala->kode }}">
                                            <div class="symptom-content">
                                                <div class="symptom-icon"><i class="bi bi-border-style"></i></div>
                                                <div class="symptom-code">{{ $gejala->kode }}</div>
                                                <div class="symptom-desc">{{ Str::limit($gejala->gejala, 100) }}</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="wizard-navigation">
                                    <button type="button" class="btn btn-primary next-step">Berikutnya <i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>

                            <div class="wizard-step" data-step-name="Gejala Batang">
                                <h4 class="step-title"><i class="bi bi-person-circle"></i> Gejala pada Batang & Pucuk</h4>
                                <p class="step-subtitle">Periksa bagian batang dan pucuk tanaman.</p>
                                <div class="symptom-grid">
                                    @foreach ($gejalaBatang as $gejala)
                                        <label class="symptom-card">
                                            <input type="checkbox" name="gejala[]" value="{{ $gejala->kode }}">
                                            <div class="symptom-content">
                                                <div class="symptom-icon"><i class="bi bi-graph-down-arrow"></i></div>
                                                <div class="symptom-code">{{ $gejala->kode }}</div>
                                                <div class="symptom-desc">{{ Str::limit($gejala->gejala, 40) }}</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="wizard-navigation">
                                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Sebelumnya</button>
                                    <button type="button" class="btn btn-primary next-step">Berikutnya <i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>

                            <div class="wizard-step" data-step-name="Gejala Biji">
                                <h4 class="step-title"><i class="bi bi-person-circle"></i> Gejala pada Biji & Gabah</h4>
                                <p class="step-subtitle">Bagaimana kondisi biji atau gabah (jika sudah ada)?</p>
                                <div class="symptom-grid">
                                    @foreach ($gejalaBiji as $gejala)
                                        <label class="symptom-card">
                                            <input type="checkbox" name="gejala[]" value="{{ $gejala->kode }}">
                                            <div class="symptom-content">
                                                <div class="symptom-icon"><i class="bi bi-x-diamond"></i></div>
                                                <div class="symptom-code">{{ $gejala->kode }}</div>
                                                <div class="symptom-desc">{{ Str::limit($gejala->gejala, 40) }}</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="wizard-navigation">
                                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Sebelumnya</button>
                                    <button type="button" class="btn btn-primary next-step">Berikutnya <i class="bi bi-arrow-right"></i></button>
                                </div>
                            </div>

                            <div class="wizard-step" data-step-name="Gejala Umum">
                                <h4 class="step-title"><i class="bi bi-person-circle"></i> Gejala Umum Tanaman</h4>
                                <p class="step-subtitle">Bagaimana kondisi tanaman Anda secara keseluruhan?</p>
                                <div class="symptom-grid">
                                    @foreach ($gejalaUmum as $gejala)
                                        <label class="symptom-card">
                                            <input type="checkbox" name="gejala[]" value="{{ $gejala->kode }}">
                                            <div class="symptom-content">
                                                <div class="symptom-icon"><i class="bi bi-exclamation-triangle"></i></div>
                                                <div class="symptom-code">{{ $gejala->kode }}</div>
                                                <div class="symptom-desc">{{ Str::limit($gejala->gejala, 40) }}</div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="wizard-navigation">
                                    <button type="button" class="btn btn-secondary prev-step"><i class="bi bi-arrow-left"></i> Sebelumnya</button>
                                    <button type="submit" class="btn btn-success submit-btn"><i class="bi bi-search"></i> Diagnosa Sekarang!</button>
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