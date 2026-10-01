<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Tamu</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tamu.css') }}"> {{-- Memanggil CSS --}}
</head>
<body class="bg-blue">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-info">
                    Buku Tamu <br>
                    <small style="font-size: 0.9rem;">
                        Tuliskan pesanmu di sini.
                    </small>
                </h2>
                <a href="/logout" class="btn btn-outline-danger btn-sm">Logout</a>
            </div>

            {{-- Form Input --}}
            <div class="card dark-card mb-4">
                <div class="card-body">
                    <h5 class="mb-3 text-white">Isi Buku Tamu</h5>
                    <form action="/pesan" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="mb-1 text-white">Nama Akun</label>
                            <input type="text" class="form-control" 
                                   value="{{ session('user')->nama }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="mb-1 text-white">Pesan</label>
                            <textarea name="pesan" 
                                      class="form-control" 
                                      rows="4" 
                                      placeholder="Tulis pesan..." 
                                      required></textarea>
                        </div>
                        <button type="submit" 
                                class="btn btn-info w-100 text-white fw-bold">
                            SUBMIT PESAN
                        </button>
                    </form>
                </div>
            </div>

            {{-- DATA PESAN --}}
            <div class="col-md-12">
                <div class="card dark-card">
                    <div class="card-header border-bottom border-secondary">
                        <h5 class="text-white">💬 Pesan dari Tamu</h5>
                    </div>

                    <div class="table-responsive p-3">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th>Nama Tamu</th>
                                    <th>Pesan</th>
                                    <th>Tanggal Kirim</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pesans as $p)
                                <tr>
                                    <td>{{ $p->user->nama }}</td>
                                    <td>{{ $p->pesan }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}
                                    </td>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>