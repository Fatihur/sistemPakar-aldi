@extends('petani.layout.dashboard')

@section('content')
    <!--begin::App Main-->
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Dashboard</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3>Diagnosa</h3>
                                <p>Cek Kesehatan Tanaman</p>
                            </div>
                            <i class="bi bi-clipboard2-pulse-fill small-box-icon"
                                style="font-size: 4rem; position: absolute; right: 10px; top: 10px; opacity: 0.4;"></i>

                            <a href="{{ route('petani.diagnosa.index') }}"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Mulai Sekarang <i class="bi bi-arrow-right-circle"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3>{{ \App\Models\Gejala::count() }}</h3>
                                <p>Info Gejala</p>
                            </div>
                            <i class="bi bi-activity small-box-icon"
                                style="font-size: 4rem; position: absolute; right: 10px; top: 10px; opacity: 0.4;"></i>

                            <a href="{{ route('petani.gejala.index') }}"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Lihat Gejala <i class="bi bi-arrow-right-circle"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-warning text-white">
                            <div class="inner">
                                <h3>Tanya</h3>
                                <p>Konsultasi Penyuluh</p>
                            </div>
                            <i class="bi bi-chat-dots-fill small-box-icon"
                                style="font-size: 4rem; position: absolute; right: 10px; top: 10px; opacity: 0.4;"></i>

                            <a href="{{ route('petani.chat.start') }}"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Hubungi Pakar <i class="bi bi-arrow-right-circle"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-danger">
                            <div class="inner">
                                <h3>{{ \App\Models\Penyakit::count() }}</h3>
                                <p>Info Penyakit</p>
                            </div>
                            <i class="bi bi-bug-fill small-box-icon"
                                style="font-size: 4rem; position: absolute; right: 10px; top: 10px; opacity: 0.4;"></i>

                            <a href="{{ route('petani.penyakit.index') }}"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Lihat Penyakit <i class="bi bi-arrow-right-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row ">
                    <!-- Start col -->
                    <div class="col-lg-7 connectedSortable">
                        <div class="card mb-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-header bg-white border-0 pt-4 px-4">
                                            <h4 class="card-title text-success fw-bold">
                                                <i class="bi bi-geo-alt-fill me-2"></i> Lokasi Balai Penyuluhan Pertanian
                                            </h4> &nbsp;
                                            <p class="text-muted mb-0">Kec. Moyo Hulu, Kabupaten Sumbawa</p>
                                        </div>
                                        <div class="card-body p-4">
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->

                        <!-- DIRECT CHAT -->

                        <!-- /.direct-chat -->
                    </div>
                    <!-- /.Start col -->

                    <!-- Start col -->
                    <div class="col-lg-5 connectedSortable">
                        <!-- Weather Card for Sumbawa -->
                        <div class="card mb-4" id="weather-card">
                            <div class="card-header">
                                <h3 class="card-title">Cuaca Saat Ini – Sumbawa, NTB</h3>
                            </div>
                            <div class="card-body">
                                <div id="weather-content" class="d-flex align-items-center">
                                    <div id="weather-icon" style="margin-right:20px;">
                                        <!-- Ikon cuaca akan dimasukkan lewat JS -->
                                    </div>
                                    <div id="weather-info">
                                        <h4 id="weather-location">Sumbawa, NTB</h4>
                                        <p id="weather-description">Memuat...</p>
                                        <p id="weather-temp">-- °C</p>
                                        <p id="weather-details">Kelembapan: -- %, Angin: -- m/s</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.Start col -->
                </div>
                <!-- /.row (main row) -->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
    <!--end::App Main-->
@endsection
