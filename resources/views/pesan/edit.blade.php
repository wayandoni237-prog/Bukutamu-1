<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>

     {{-- Memanggil CSS yang sudah dipisah tadi --}}
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
</head>
<body>
    <form action="/pesan/{{ $pesan->id }}" method="POST">
    @csrf
    @method('PUT') {{-- WAJIB ADA agar terbaca oleh Route::put di web.php --}}

    <div class="mb-3">
        <label class="text-white">Edit Pesan</label>
        <textarea name="pesan" class="form-control" rows="5" required>{{ $pesan->pesan }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary w-100">Update Pesan</button>
</form>
</body>
</html>

