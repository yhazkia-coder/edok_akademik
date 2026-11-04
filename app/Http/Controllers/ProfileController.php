<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profil pengguna.
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Perbarui data profil, sandi, dan foto profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input data profil
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Siapkan data dasar yang akan diperbarui
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        // Jika kolom password diisi, enkripsi dan masukkan ke data update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Jika ada file foto profil (avatar) yang diunggah
        if ($request->hasFile('avatar')) {
            // Hapus foto profil lama jika ada untuk menghemat penyimpanan
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan foto profil baru ke folder 'avatars' di storage/app/public
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        // Eksekusi pembaruan data user ke database
        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}