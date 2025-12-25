@extends('pakar.layout.dashboard') 
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/media_queris_chat.css') }}">
@endpush
@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Ruang Konsultasi</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('pakar.chat.index') }}">Konsultasi Masuk</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Percakapan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card direct-chat direct-chat-primary">
                            <div class="card-header">
                                <h3 class="card-title">Percakapan dengan: {{ $participant->name }}</h3>
                            </div>

                            <div class="card-body">
                                <div class="direct-chat-messages" style="height: 60vh; overflow-y: auto;">
                                    @forelse ($conversation->messages->sortBy('created_at') as $message)
                                        @if ($message->sender_id == auth()->id())
                                            <div class="direct-chat-msg end">
                                                <div class="direct-chat-infos clearfix">
                                                    <span
                                                        class="direct-chat-name float-end">{{ auth()->user()->name }}</span>
                                                    <span
                                                        class="direct-chat-timestamp float-start">{{ $message->created_at->setTimezone('Asia/Makassar')->format('d M H:i') }}</span>
                                                </div>
                                                <img class="direct-chat-img"
                                                    src="{{ asset('lte/dist/assets/img/pakar.jpg') }}" alt="Pakar Avatar">
                                                <div class="direct-chat-text">{{ $message->message }}</div>
                                            </div>
                                        @else
                                            <div class="direct-chat-msg">
                                                <div class="direct-chat-infos clearfix">
                                                    <span
                                                        class="direct-chat-name float-start">{{ $participant->name }}</span>
                                                    <span
                                                        class="direct-chat-timestamp float-end">{{ $message->created_at->setTimezone('Asia/Makassar')->format('d M H:i') }}</span>
                                                </div>
                                                <img class="direct-chat-img"
                                                    src="{{ asset('lte/dist/assets/img/logo.jpg') }}" alt="Petani Avatar">
                                                <div class="direct-chat-text">{{ $message->message }}</div>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="text-center text-muted p-4">
                                            <p>Belum ada pesan dalam percakapan ini.</p>
                                        </div>
                                    @endempty
                            </div>
                        </div>

                        <div class="card-footer">
                            <form action="{{ route('chat.store', $conversation) }}" method="post">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="message" placeholder="Ketik balasan Anda ..."
                                        class="form-control" required autocomplete="off">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </span>
                                </div>
                            </form>
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
    document.addEventListener("DOMContentLoaded", function() {
        // Cari elemen container pesan
        var chatBox = document.querySelector('.direct-chat-messages');
        
        // Jika elemen ditemukan, scroll ke paling bawah
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });
</script>
@endpush
