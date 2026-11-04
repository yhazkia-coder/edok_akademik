<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisLayanan;

class JenisLayananController extends Controller
{
    // Tampilkan daftar jenis layanan
    public function index()
    {
        $layanans = JenisLayanan::latest()->get();
        return view('admin.layanan.index', compact('layanans'));
    }

    // Simpan layanan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
        ]);

        JenisLayanan::create([
            'nama_layanan' => $request->nama_layanan,
            'deskripsi'    => $request->deskripsi,
        ]);

        return back()->with('success', 'Jenis layanan berhasil ditambahkan!');
    }

    // Update layanan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
        ]);

        $layanan = JenisLayanan::findOrFail($id);
        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'deskripsi'    => $request->deskripsi,
        ]);

        return back()->with('success', 'Jenis layanan berhasil diperbarui!');
    }

    // Hapus layanan
    public function destroy($id)
    {
        $layanan = JenisLayanan::findOrFail($id);
        $layanan->delete();

        return back()->with('success', 'Jenis layanan berhasil dihapus!');
    }
}