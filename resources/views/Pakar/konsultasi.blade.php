@extends('pakar.layout.dashboard')

@push('styles')
    <style>
        .contacts-list-name {
            font-weight: 600;
        }

        .contacts-list-msg {
            color: #6c757d;
        }

        .contacts-list>li>a {
            padding: 1rem 0.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .contacts-list>li:last-child>a {
            border-bottom: none;
        }
    </style>
@endpush

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Konsultasi Masuk</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('pakar.dashboard') }}">Dasbor</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Konsultasi</li>
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
                                <h3 class="card-title">Daftar Percakapan dari Petani</h3>
                                <div class="card-tools">
                                    <form action="{{ route('pakar.chat.index') }}" method="GET">
                                        <div class="input-group input-group-sm" style="width: 250px;">
                                            <input type="text" name="search" class="form-control float-right"
                                                placeholder="Cari nama petani..." value="{{ $search ?? '' }}">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="contacts-list">

                                    @forelse ($conversations as $conversation)
                                        @php
                                            // Ambil petani dari relasi 'participants'
                                            // Controller sudah memfilter, ini HANYA akan berisi petani
                                            $farmer = $conversation->participants->first();
                                            $lastMessage = $conversation->messages->last();
                                        @endphp

                                        @if ($farmer)
                                            <li>
                                                <a href="{{ route('chat.show', $conversation) }}">
                                                    <img class="contacts-list-img"
                                                        src="{{ asset('lte/dist/assets/img/logo.jpg') }}"
                                                        alt="Petani Avatar">
                                                    <div class="contacts-list-info">
                                                        <span class="contacts-list-name">

                                                            {{ $farmer->name }}

                                                            <small class="contacts-list-date float-end">
                                                                {{ $lastMessage ? $lastMessage->created_at->diffForHumans() : '' }}
                                                            </small>
                                                        </span>
                                                        <span class="contacts-list-msg">
                                                            {{ Str::limit($lastMessage->message ?? 'Belum ada pesan', 60) }}
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>
                                        @endif
                                    @empty
                                        <li class="p-4 text-center text-muted">
                                            Belum ada konsultasi yang masuk.
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        // Skrip sederhana untuk filter pencarian (opsional)
        document.getElementById('conversation-search').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('.contacts-list > li');

            items.forEach(item => {
                let nameElement = item.querySelector('.contacts-list-name');
                if (nameElement) {
                    let name = nameElement.textContent || nameElement.innerText;
                    if (name.toLowerCase().indexOf(filter) > -1) {
                        item.style.display = "";
                    } else {
                        item.style.display = "none";
                    }
                }
            });
        });
    </script>
@endpush
