<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\JenisLayanan;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::with('jenisLayanan')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();
        $jenisLayanans = JenisLayanan::all();

        return view('siswa.dashboard', compact('pengajuans', 'jenisLayanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_layanan_id' => 'required|exists:jenis_layanans,id',
            'keterangan'       => 'nullable|string',
            'file_lampiran'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_lampiran')) {
            $filePath = $request->file('file_lampiran')->store('lampiran_pengajuan', 'public');
        }

        $noPengajuan = 'REQ-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        Pengajuan::create([
            'no_pengajuan'     => $noPengajuan,
            'user_id'          => Auth::id(),
            'jenis_layanan_id' => $request->jenis_layanan_id,
            'keterangan'       => $request->keterangan,
            'file_lampiran'    => $filePath,
            'status'           => 'Pending',
        ]);

        return back()->with('success', 'Pengajuan dokumen beserta lampiran berhasil dikirim!');
    }

    public function cetakBukti($id)
    {
        $pengajuan = Pengajuan::with(['user', 'jenisLayanan'])
                        ->where('user_id', Auth::id())
                        ->findOrFail($id);
                        
        return view('siswa.cetak', compact('pengajuan'));
    }
}