<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $query = Pengajuan::with(['user', 'jenisLayanan'])->latest();

        // Fitur Filter Status
        if ($status) {
            $query->where('status', $status);
        }

        // Fitur Pencarian (Live Search) berdasarkan nomor pengajuan atau nama siswa
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('no_pengajuan', 'like', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                });
            });
}

        $pengajuans = $query->get();

        // Hitung Statistik Dashboard
        $stats = [
            'total'    => Pengajuan::count(),
            'pending'  => Pengajuan::where('status', 'Pending')->count(),
            'diproses' => Pengajuan::where('status', 'Diproses')->count(),
            'selesai'  => Pengajuan::where('status', 'Selesai')->count(),
        ];

        return view('admin.dashboard', compact('pengajuans', 'status', 'search', 'stats'));
    }

    public function validasi(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update([
            'status'        => 'Diproses',
            'catatan_admin' => $request->catatan_admin ?? 'Pengajuan telah diverifikasi dan sedang diproses.',
        ]);

        return back()->with('success', 'Pengajuan berhasil divalidasi dan mulai diproses!');
    }

    public function serahkan(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update([
            'status'        => 'Selesai',
            'catatan_admin' => $request->catatan_admin ?? 'Dokumen telah selesai dan siap diunduh/diambil.',
        ]);

        return back()->with('success', 'Dokumen berhasil diserahkan dan dinyatakan selesai!');
    }

    // Fitur Ekspor Rekapitulasi Sederhana (Format CSV untuk Excel)
    public function exportExcel()
    {
        $fileName = 'rekap-pengajuan-edoc-' . date('Y-m-d') . '.csv';
        $pengajuans = Pengajuan::with(['user', 'jenisLayanan'])->latest()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($pengajuans) {
            $file = fopen('php://output', 'w');
            // Header kolom CSV
            fputcsv($file, ['No Pengajuan', 'Nama Siswa', 'Jenis Layanan', 'Status', 'Catatan Admin', 'Tanggal Pengajuan']);

            foreach ($pengajuans as $item) {
                fputcsv($file, [
                    $item->no_pengajuan,
                    $item->user->name ?? '-',
                    $item->jenisLayanan->nama_layanan ?? '-',
                    $item->status,
                    $item->catatan_admin ?? '-',
                    $item->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}