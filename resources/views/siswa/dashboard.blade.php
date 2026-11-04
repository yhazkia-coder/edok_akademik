<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - eDoc Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen font-sans text-slate-800">
    <!-- Navbar Siswa -->
    <nav class="bg-blue-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-700 text-white font-bold text-xs px-2.5 py-1 rounded-lg">eDoc</div>
                <div>
                    <h1 class="font-bold text-sm sm:text-base leading-tight">Dashboard Siswa</h1>
                    <p class="text-[10px] text-blue-200">SMKN 5 Surakarta</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('profile.edit') }}" class="bg-blue-800 hover:bg-blue-700 active:scale-95 text-white px-3 py-1.5 rounded-xl text-xs font-medium transition duration-150">Profil</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 active:scale-95 text-white px-3.5 py-1.5 rounded-xl text-xs font-medium transition duration-150 shadow-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6 animate-fade-in">
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl text-sm shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-r-xl text-sm shadow-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Banner Multimedia Hero -->
        <div class="relative bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl overflow-hidden flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="relative z-10 space-y-2 text-center md:text-left max-w-xl">
                <span class="bg-blue-700/60 text-blue-200 text-[11px] px-3 py-1 rounded-full font-bold uppercase tracking-wider">Sistem Digital Sekolah</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-xs sm:text-sm text-blue-100 leading-relaxed">Ajukan dokumen akademik pilihan Anda secara praktis tanpa perlu mengantre lama.</p>
            </div>
            
            <div class="relative z-10 w-full sm:w-auto flex justify-center">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=300&q=80" alt="Ilustrasi" class="w-40 sm:w-48 h-28 sm:h-32 object-cover rounded-2xl shadow-lg border-2 border-white/20 transform hover:rotate-1 hover:scale-105 transition duration-300">
            </div>
        </div>

        <!-- Form Pengajuan Baru -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6">
            <h3 class="font-bold text-base text-slate-800 mb-4 flex items-center gap-2">
                ➕ Buat Pengajuan Dokumen Baru
            </h3>
            <form action="{{ route('siswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Layanan</label>
                    <select name="jenis_layanan_id" class="w-full border border-slate-200 rounded-xl p-2.5 text-xs sm:text-sm bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($jenisLayanans as $layanan)
                            <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Keterangan (Opsional)</label>
                    <input type="text" name="keterangan" placeholder="Contoh: Keperluan Lomba" class="w-full border border-slate-200 rounded-xl p-2.5 text-xs sm:text-sm bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Lampiran (PDF/JPG Max 2MB)</label>
                    <input type="file" name="file_lampiran" class="w-full border border-slate-200 rounded-xl p-1.5 text-xs bg-slate-50 text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:bg-blue-100 file:text-blue-700 font-semibold cursor-pointer">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-semibold py-2.5 rounded-xl text-xs sm:text-sm transition duration-150 shadow-md shadow-blue-500/20">
                    Kirim Pengajuan
                </button>
            </form>
        </div>

        <!-- Tabel Riwayat Siswa -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6">
            <h3 class="font-bold text-base text-slate-800 mb-4">Riwayat Pengajuan Saya</h3>
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-slate-100 text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-semibold uppercase text-[11px] tracking-wider">
                            <th class="p-3">No. Pengajuan</th>
                            <th class="p-3">Layanan</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-center">Cetak Bukti</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pengajuans as $item)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <td class="p-3 font-mono text-xs font-semibold text-slate-600 whitespace-nowrap">{{ $item->no_pengajuan }}</td>
                            <td class="p-3 font-semibold text-slate-800 whitespace-nowrap">{{ $item->jenisLayanan->nama_layanan ?? '-' }}</td>
                            <td class="p-3 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full 
                                    {{ $item->status == 'Pending' ? 'bg-amber-100 text-amber-800' : ($item->status == 'Diproses' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800') }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="p-3 text-center whitespace-nowrap">
                                @if($item->status == 'Selesai')
                                    <a href="{{ route('siswa.pengajuan.cetak', $item->id) }}" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition duration-150 shadow-sm inline-block">
                                        🖨️ Cetak
                                    </a>
                                @else
                                    <span class="text-slate-400 text-xs italic">Diproses</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400 text-sm">Belum ada pengajuan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>