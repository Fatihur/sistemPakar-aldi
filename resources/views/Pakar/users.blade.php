@extends('pakar.layout.dashboard')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Data Petani</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('pakar.dashboard') }}">Dasbor</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Petani</li>
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
                                <h3 class="card-title">Daftar Petani Terdaftar</h3>
                                <div class="card-tools">
                                    <form action="{{ route('pakar.users.index') }}" method="GET"
                                        class="input-group input-group-sm" style="width: 250px;">
                                        <input type="text" name="search" class="form-control float-right"
                                            placeholder="Cari nama petani..." value="{{ request('search') }}">
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
                                            <th>Nama Lengkap</th>
                                            <th>Peran</th>
                                            <th>Tanggal Bergabung</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $index => $user)
                                            <tr>
                                                <td>{{ $users->firstItem() + $index }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>
                                                    @foreach ($user->roles as $role)
                                                        <span
                                                            class="badge bg-success">{{ $role->display_name ?? ucfirst($role->name) }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    {{ $user->created_at->translatedFormat('d F Y') }}
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="bi bi-people display-4 d-block mb-2 opacity-50"></i>
                                                    Belum ada data petani yang ditemukan.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer clearfix">
                                {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
