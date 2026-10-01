<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 
    //  HALAMAN LOGIN
    // 
    public function login()
    {
        return view('login');
    }

    // 
    //  PROSES LOGIN
    // 
    public function loginProses(Request $request)
    {
        $user = User::where('username', $request->username)->first();  // Mencari user berdasarkan username yang diinputkan
        if ($user && Hash::check($request->password, $user->password)) {   // cek user dan password
            if ($user->role == 'admin') {
                session(['admin' => $user]); // Menyimpan data user ke dalam session admin
                return redirect('/admin');
            }

            session(['user' => $user]); // Jika role bukan admin, maka dianggap user biasa/tamu
            return redirect('/tamu');
        }

        return back()->with('error', 'Login gagal! Username atau Password salah.');
    }

    // 
    // HALAMAN REGISTER
    // 
    public function register()
    {
        return view('auth.register');
    }

    //
    // PROSES REGISTER
    //
    public function registerProses(Request $request)
    {
        // validasi Memastikan input sesuai aturan sebelum masuk ke database
        $request->validate([
            'nama'     => 'required', 
            'username' => 'required',    
            'email'    => 'required', 
            'password' => 'required'
        ]);

        // user create Membuat baris baru di tabel users
        User::create([
            'nama'     => $request->nama,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => bcrypt($request->password), // bcrypt merubah teks password menjadi kode acak Hashing demi keamanan.
            'role'     => 'tamu' 
        ]);

        return redirect()->back()->with('success', 'Berhasil register, silakan login');
    }

    // 
    // LOGOUT 
    // 
    public function logout()
    {
        session()->flush();
        return redirect('/home');
    }
}