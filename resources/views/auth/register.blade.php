<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>Register Akun</title> 

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> 
     <link rel="stylesheet" href="{{ asset('css/register.css') }}"> {{--  CSS khusus register --}}
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center"> {{-- Posisi ke tengah --}}
        <div class="col-md-5"> {{-- Lebar form --}}
            <div class="card dark-card shadow-lg border-0"> {{-- Card pembungkus form --}}
                
                <div class="card-header border-0 bg-transparent text-center pt-4">
                    <h3 class="fw-bold text-info">REGISTER AKUN</h3> {{-- Judul form --}}
                </div>

                <div class="card-body px-4 pb-4">

                    {{-- Menampilkan notifikasi jika registrasi berhasil --}}
                    @if(session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }} {{-- Pesan dari controller --}}
                        </div>
                    @endif

                    {{-- Form registrasi akun --}}
                    <form action="/register" method="POST">
                        @csrf {{-- Token keamanan Laravel --}}

                        <div class="mb-3">
                            <label class="form-label text-white fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama..." required>
                            {{-- Input nama user --}}
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Buat username..." required>
                            {{-- Input username login --}}
                        </div>

                        
                        <div class="mb-3">
                            <label class="form-label text-white fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
                            {{-- Input email user --}}
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-white fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Buat password..." required>
                            {{-- Input password akun --}}
                        </div>
                        
                        <button type="submit" class="btn btn-info w-100 mb-3 text-white fw-bold">
                            REGISTER
                        </button> {{-- Tombol kirim data --}}
                        
                        <p class="text-center mb-0">
                            <span class="text-white">Sudah punya akun?</span> 
                            <a href="/login" class="text-info text-decoration-none fw-bold">
                                Login di sini
                            </a> {{-- Link ke halaman login --}}
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>