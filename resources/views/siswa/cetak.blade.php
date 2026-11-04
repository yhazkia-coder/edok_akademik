<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pengajuan - {{ $pengajuan->no_pengajuan }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800 p-8" onload="window.print()">
    <div class="max-w-xl mx-auto border p-6 rounded shadow-sm space-y-4">
        <div class="text-center border-b pb-4">
            <h2 class="font-bold text-xl uppercase text-blue-900">Bukti Pengajuan Dokumen Akademik</h2>
            <p class="text-xs text-gray-500">eDoc Akademik - SMKN 5 Surakarta</p>
        </div>
        <div class="text-sm space-y-3">
            <div class="flex justify-between border-b pb-2"><span class="font-semibold text-gray-600">No. Pengajuan:</span> <span class="font-mono font-bold">{{ $pengajuan->no_pengajuan }}</span></div>
            <div class="flex justify-between border-b pb-2"><span class="font-semibold text-gray-600">Nama Siswa:</span> <span>{{ $pengajuan->user->name }}</span></div>
            <div class="flex justify-between border-b pb-2"><span class="font-semibold text-gray-600">Jenis Layanan:</span> <span>{{ $pengajuan->jenisLayanan->nama_layanan }}</span></div>
            <div class="flex justify-between border-b pb-2"><span class="font-semibold text-gray-600">Tanggal Pengajuan:</span> <span>{{ $pengajuan->created_at->format('d-m-Y H:i') }}</span></div>
            <div class="flex justify-between border-b pb-2"><span class="font-semibold text-gray-600">Status Terakhir:</span> <span class="font-bold text-green-600">{{ $pengajuan->status }}</span></div>
            <div class="flex justify-between"><span class="font-semibold text-gray-600">Keterangan:</span> <span>{{ $pengajuan->keterangan ?? '-' }}</span></div>
        </div>
        <div class="pt-8 text-center text-xs text-gray-400 border-t">
            <p>Dokumen ini dicetak secara otomatis oleh sistem dan sah sebagai bukti permohonan.</p>
        </div>
    </div>
</body>
</html>