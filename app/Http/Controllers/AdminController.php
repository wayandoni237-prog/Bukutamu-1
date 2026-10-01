<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesan;
use App\Models\User;

class AdminController extends Controller
{
    // 
    // Dashboard Admin
    // 
    public function dashboard()
    {
        // Cek apakah yang login adalah admin
        if (!session('admin')) {
            return redirect('/login')->with('error', 'Halaman ini khusus admin.');
        }

        // Ambil semua data
        $users = User::all();
        $pesans = Pesan::with('user')->latest()->get();

        return view('admin.dashboard', compact('users', 'pesans'));
    }

    
    // 
    // tambah User Baru
    // 
    public function storeUser(Request $request)
    {
        // untuk Validasi data
        $request->validate([
            'nama'     => 'required',  
            'username' => 'required', 
            'email'    => 'required',
            'password' => 'required',
            'role'     => 'required'
        ]);

        User::create([
            'nama'     => $request->nama,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => bcrypt($request->password), // bcrypt adalah fungsi enkripsi Hashing untuk keamanan
            'role'     => $request->role
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    // 
    // Update Data User
    // 
    public function updateUser(Request $request, $id)
    { 
        // Cari user berdasarkan id
        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        // Validasi input
        $request->validate([
            'nama'     => 'required',
            'username' => 'required',
            'email'    => 'required',
            'role'     => 'required'
        ]);

        // Update
        $user->nama     = $request->nama;
        $user->username = $request->username;
        $user->email    = $request->email;
        $user->role     = $request->role;
        $user->save();

        return back()->with('success', 'Data user berhasil diubah.');
    }

    // 
    // Hapus User
    // 
    public function hapusUser($id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return back()->with('error', 'User gagal dihapus, ID salah.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

     // 
    // Halaman Tamu Menampilkan Pesan
    // 
    public function tamu()
    {
        // Cek login 
        if (!session('user')) {
            return redirect('/login')->with('error', 'Silakan login dulu.');
        }

        $pesans = Pesan::with('user')->latest()->get();
        return view('tamu.index', compact('pesans'));
    }

    // 
    // Kirim Pesan Baru
    // 
    public function kirimPesan(Request $request)
    {
        if (!session('user')) {
            return redirect('/login');
        }

        $request->validate(['pesan' => 'required']);

        // Simpan/kirim pesan baru ke database
        Pesan::create([
            'user_id' => session('user')->id,
            'nama'    => session('user')->nama,
            'pesan'   => $request->pesan,
        ]);

        return back()->with('success', 'Pesan berhasil dikirim.');
    }

    // 
    // Edit Pesan
    // 
    public function edit($id)
    {
        $pesan = Pesan::find($id);

        if (!$pesan) {
            return redirect('/tamu')->with('error', 'Pesan tidak ada.');
        }

        // Hanya admin atau pemilik yang bisa edit,selain itu tidak boleh edit/hapus
        if (!session('admin') && $pesan->user_id != session('user')->id) {
            return redirect('/tamu')->with('error', 'Hanya pemilik yang bisa.');
        }

        return view('pesan.edit', compact('pesan'));
    }

    // 
    // Hapus Pesan
    //
    public function hapusPesan($id)
    {
        $pesan = Pesan::find($id);

        if (!$pesan) {
            return back()->with('error', 'Data pesan sudah tidak ada.');
        }

        // Admin boleh hapus semua pesan
        if (session('admin') || (session('user') && $pesan->user_id == session('user')->id)) {
            $pesan->delete();
            return back()->with('success', 'Pesan dihapus.');
        }

        return redirect('/tamu')->with('error', 'Hanya pemilik yang bisa.');
    }

    // 
    // Update Pesan
    // 
    public function update(Request $request, $id)
    {
        $request->validate(['pesan' => 'required']);

        $pesan = Pesan::find($id);

        if (!$pesan) {
            return redirect('/tamu')->with('error', 'Gagal update, data tidak ditemukan.');
        }

        // Ubah isi pesan
        $pesan->pesan = $request->pesan;
        $pesan->save();

        // Kalau admin kembali ke dashboard admin
        if (session('admin')) {
            return redirect('/admin')->with('success', 'Pesan berhasil diubah.');
        }

        // Kalau user biasa kembali ke halaman tamu
        return redirect('/tamu')->with('success', 'Pesan berhasil diperbarui.');
    }
}