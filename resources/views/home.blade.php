<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home</title>

    {{-- Custom CSS untuk halaman home --}}
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

{{-- Hero --}}
<div class="hero">
    {{-- Overlay untuk efek gelap background --}}
    <div class="overlay"></div>

    <div class="content">
        <div class="title-box">
            <h1>BUKU TAMU</h1>
            <p>
                Selamat datang di layanan Buku Tamu Digital.<br>
                Tinggalkan pesan, kesan, dan isi hati mu di sini.
            </p>
        </div>

        {{-- Tombol menuju halaman login --}}
        <a href="{{ route('login') }}" class="btn-login">
            MASUK & ISI BUKU TAMU
        </a>

    </div>

</div>

</body>
</html>
