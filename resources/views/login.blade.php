<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}"> {{-- Custom CSS --}}
</head>
<body>
<div class="container-fluid vh-100 d-flex justify-content-center align-items-center">
    <div class="card dark-card border-0 shadow-lg">
        <div class="card-header border-0 bg-transparent text-center">
            <h3 class="fw-bold text-info">LOGIN</h3>
        </div>
        <div class="card-body">

            {{-- Notifikasi Error (jika ada) --}}
            @if(session('error'))
                <div class="alert alert-danger text-center py-2 small">
                    {{ session('error') }}
                </div>
            @endif

            
            {{-- Form Login --}}
            <form method="POST" action="/login">
                @csrf

                {{-- Input Username --}}
                <div class="mb-3">
                    <label class="form-label text-white fw-bold">Username</label>
                    <input name="username" class="form-control" placeholder="Masukkan username..." required>
                </div>
                
                {{-- Input Password --}}
                <div class="mb-3">
                    <label class="form-label text-white fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
                </div>
                
                {{-- Tombol Login --}}
                <button type="submit" class="btn btn-info w-100 mb-3 text-white fw-bold">
                    LOGIN
                </button>
            </form>
            
            {{-- Link Register --}}
            <p class="text-center mb-0 text-white-50 small">
                Belum punya akun?
                <a href="/register" class="text-info text-decoration-none fw-bold">
                    Register dulu
                </a>
            </p>

        </div>
    </div>
</div>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
