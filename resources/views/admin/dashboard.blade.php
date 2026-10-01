<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Dashboard Admin</title> 

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-dark text-light"> {{-- Menambahkan default bg-dark agar sinkron dengan modal --}}

<div class="container py-4">

    {{-- HEADER DASHBOARD --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-info">Dashboard Admin</h2> 
        <a href="/logout" class="btn btn-outline-danger">Logout</a>
    </div>

    {{-- NOTIFIKASI BERHASIL/GAGAL --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- TABEL DATA USER --}}
        <div class="col-md-12 mb-4">
            <div class="card bg-dark border-secondary shadow">
                <div class="card-header border-bottom border-secondary d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-white">📋 Daftar Users</h5> 
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        + Tambah User
                    </button>
                </div>

                <div class="table-responsive p-3">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td>{{ $u->nama }}</td>
                                <td>{{ $u->username }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    <span class="badge {{ $u->role == 'admin' ? 'bg-info' : 'bg-secondary' }}">
                                        {{ ucfirst($u->role) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUser{{ $u->id }}">
                                        Edit
                                    </button>

                                    <form action="/admin/user/{{ $u->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TABEL DATA PESAN --}}
        <div class="col-md-12">
            <div class="card bg-dark border-secondary shadow">
                <div class="card-header border-bottom border-secondary">
                    <h5 class="text-white">💬 Pesan dari Tamu</h5>
                </div>

                <div class="table-responsive p-3">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Nama Tamu</th>
                                <th>Pesan</th>
                                <th>Tanggal Kirim</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesans as $p)
                            <tr>
                                <td><strong>{{ $p->user->nama }}</strong></td>
                                <td>{{ $p->pesan }}</td>
                                <td>{{ $p->created_at->format('d M Y') }}</td> 
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="/pesan/{{ $p->id }}/edit" class="btn btn-sm btn-outline-warning">Edit</a>
                                        
                                        <form action="/pesan/{{ $p->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus pesan?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT USER --}}
@foreach($users as $u)
<div class="modal fade" id="editUser{{ $u->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form action="/admin/user/{{ $u->id }}" method="POST" class="modal-content bg-dark text-white border-secondary">
            @csrf
            @method('PUT')
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Edit Data: {{ $u->nama }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" value="{{ $u->nama }}" class="form-control bg-secondary text-white border-0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" value="{{ $u->username }}" class="form-control bg-secondary text-white border-0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ $u->email }}" class="form-control bg-secondary text-white border-0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select bg-secondary text-white border-0">
                        <option value="tamu" {{ $u->role == 'tamu' ? 'selected' : '' }}>Tamu</option>
                        <option value="admin" {{ $u->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-warning w-100">Update Data User</button>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- MODAL TAMBAH USER --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="/admin/user" method="POST" class="modal-content bg-dark text-white border-secondary">
            @csrf
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control bg-secondary text-white border-0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control bg-secondary text-white border-0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control bg-secondary text-white border-0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control bg-secondary text-white border-0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select bg-secondary text-white border-0" required>
                        <option value="tamu">Tamu</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-success w-100">Simpan User</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>