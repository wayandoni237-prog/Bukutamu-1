<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// HOME
// Redirect halaman utama ke route home
Route::get('/', fn() => redirect()->route('home'));

// Menampilkan halaman home (landing page)
Route::get('/home', function () {
    return view('home');
})->name('home');



// AUTH (LOGIN & REGISTER)
// Menampilkan halaman login
Route::get('/login', [AuthController::class, 'login'])->name('login');

// Proses login (POST dari form login)
Route::post('/login', [AuthController::class, 'loginProses'])->name('login.proses');

// Menampilkan halaman register
Route::get('/register', [AuthController::class, 'register'])->name('register');

// Proses register (POST dari form register)
Route::post('/register', [AuthController::class, 'registerProses'])->name('register.proses');

// Logout user dan hapus session
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



// ADMIN
// Dashboard admin (menampilkan data user & pesan)
Route::get('/admin', [AdminController::class, 'dashboard'])
     ->name('admin.dashboard');

// Menghapus user berdasarkan ID
Route::delete('/admin/user/{id}', [AdminController::class, 'hapusUser'])
     ->name('admin.user.delete');

// Update data user berdasarkan ID
Route::put('/admin/user/{id}', [AdminController::class, 'updateUser'])
     ->name('admin.user.update');
     
// Menambah data user baru
Route::post('/admin/user', [AdminController::class, 'storeUser']);

// TAMU
// Halaman buku tamu (form isi pesan)
Route::get('/tamu', [AdminController::class, 'tamu'])
     ->name('tamu');

// Mengirim pesan dari tamu
Route::post('/pesan', [AdminController::class, 'kirimPesan'])
     ->name('pesan.kirim');

// Menghapus pesan (biasanya oleh admin)
Route::delete('/pesan/{id}', [AdminController::class, 'hapusPesan'])
     ->name('pesan.hapus');

// Route untuk menampilkan halaman edit
Route::get('/pesan/{id}/edit', [AdminController::class, 'edit']);

// Route untuk memproses update dri edit (URL ini harus sama dengan action di form edit)
Route::put('/pesan/{id}', [AdminController::class, 'update']);