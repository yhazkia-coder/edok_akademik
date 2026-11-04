<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - eDoc Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen font-sans text-slate-800">
    <!-- Navbar Admin -->
    <nav class="bg-blue-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex flex-wrap justify-between items-center gap-3">
            <div class="flex items-center space-x-3">
                <span class="bg-blue-700 text-white font-bold text-xs px-2.5 py-1 rounded-lg uppercase tracking-wider">Admin</span>
                <h1 class="font-bold text-base sm:text-lg tracking-tight">eDoc Admin Control</h1>
            </div>
            
            <div class="flex items-center space-x-2 sm:space-x-3">
                <a href="{{ route('admin.layanan.index') }}" class="bg-blue-800 hover:bg-blue-700 active:scale-95 text-white px-3 py-1.5 rounded-xl text-xs font-medium transition">Master Layanan</a>
                <a href="{{ route('admin.export') }}" class="bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white px-3 py-1.5 rounded-xl text-xs font-medium transition flex items-center gap-1">📊 Ekspor Data</a>
                <a href="{{ route('profile.edit') }}" class="bg-blue-800 hover:bg-blue-700 active:scale-95 text-white px-3 py-1.5 rounded-xl text-xs font-medium transition">Profil</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 active:scale-95 text-white px-3.5 py-1.5 rounded-xl text-xs font-medium transition shadow-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6 animate-fade-in">
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl text-sm shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Widget Statistik Kartu Ringkas -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase">Total Pengajuan</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $stats['total'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold">📋</div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-xs text-amber-500 font-semibold uppercase">Pending</p>
                    <h3 class="text-2xl font-extrabold text-amber-600 mt-1">{{ $stats['pending'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center font-bold">⏳</div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-xs text-blue-500 font-semibold uppercase">Diproses</p>
                    <h3 class="text-2xl font-extrabold text-blue-600 mt-1">{{ $stats['diproses'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold">⚙️</div>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-xs text-emerald-500 font-semibold uppercase">Selesai</p>
                    <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $stats['selesai'] }}</h3>
                </div>
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-bold">✅</div>
            </div>
        </div>

        <!-- Bagian Filter & Pencarian (Live Search) -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Form Pencarian -->
            <form action="{{ route('admin.dashboard') }}" method="GET" class="w-full md:w-80 flex items-center gap-2">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari No. / Nama Siswa..." class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-semibold transition">Cari</button>
            </form>

            <!-- Filter Status Tab -->
            <div class="w-full md:w-auto overflow-x-auto pb-1 md:pb-0">
                <div class="inline-flex space-x-1 bg-slate-100 p-1 rounded-xl">
                    <a href="{{ route('admin.dashboard', ['search' => request('search')]) }}" class="px-3 py-1.5 text-xs rounded-lg font-semibold transition whitespace-nowrap {{ request('status') == '' ? 'bg-white text-blue-900 shadow-sm' : 'text-slate-600' }}">Semua</a>
                    <a href="{{ route('admin.dashboard', ['status' => 'Pending', 'search' => request('search')]) }}" class="px-3 py-1.5 text-xs rounded-lg font-semibold transition whitespace-nowrap {{ request('status') == 'Pending' ? 'bg-amber-500 text-white shadow-sm' : 'text-slate-600' }}">Pending</a>
                    <a href="{{ route('admin.dashboard', ['status' => 'Diproses', 'search' => request('search')]) }}" class="px-3 py-1.5 text-xs rounded-lg font-semibold transition whitespace-nowrap {{ request('status') == 'Diproses' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600' }}">Diproses</a>
                    <a href="{{ route('admin.dashboard', ['status' => 'Selesai', 'search' => request('search')]) }}" class="px-3 py-1.5 text-xs rounded-lg font-semibold transition whitespace-nowrap {{ request('status') == 'Selesai' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600' }}">Selesai</a>
                </div>
            </div>
        </div>

        <!-- Tabel Pengajuan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-6 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-slate-100 text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-semibold uppercase text-[11px] tracking-wider">
                            <th class="p-3">No. Pengajuan</th>
                            <th class="p-3">Siswa</th>
                            <th class="p-3">Layanan</th>
                            <th class="p-3">Lampiran & Catatan</th>
                            <th class="p-3">Status</th>
                            <th class="p-3 text-center">Aksi / Validasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pengajuans as $item)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3 font-mono text-xs font-semibold text-slate-600 whitespace-nowrap">{{ $item->no_pengajuan }}</td>
                            <td class="p-3 font-semibold text-slate-800 whitespace-nowrap">{{ $item->user->name ?? '-' }}</td>
                            <td class="p-3 text-slate-600 whitespace-nowrap">{{ $item->jenisLayanan->nama_layanan ?? '-' }}</td>
                            <td class="p-3 space-y-1">
                                @if($item->file_lampiran)
                                    <div><a href="{{ asset('storage/' . $item->file_lampiran) }}" target="_blank" class="text-blue-600 hover:underline text-xs font-semibold">📄 Unduh Berkas</a></div>
                                @else
                                    <div class="text-slate-400 text-xs italic">Tanpa Berkas</div>
                                @endif
                                <div class="text-[11px] text-slate-500 bg-slate-50 p-1.5 rounded border border-slate-100">
                                    <span class="font-bold">Catatan:</span> {{ $item->catatan_admin ?? 'Belum ada catatan.' }}
                                </div>
                            </td>
                            <td class="p-3 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full 
                                    {{ $item->status == 'Pending' ? 'bg-amber-100 text-amber-800' : ($item->status == 'Diproses' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800') }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="p-3 text-center whitespace-nowrap">
                                @if($item->status == 'Pending')
                                    <form action="{{ route('admin.pengajuan.validasi', $item->id) }}" method="POST" class="space-y-2">
                                        @csrf @method('PUT')
                                        <input type="text" name="catatan_admin" placeholder="Catatan proses..." class="w-full text-[11px] border rounded px-2 py-1 bg-slate-50" required>
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold transition">Validasi (Proses)</button>
                                    </form>
                                @elseif($item->status == 'Diproses')
                                    <form action="{{ route('admin.pengajuan.serahkan', $item->id) }}" method="POST" class="space-y-2">
                                        @csrf @method('PUT')
                                        <input type="text" name="catatan_admin" placeholder="Catatan selesai..." class="w-full text-[11px] border rounded px-2 py-1 bg-slate-50" required>
                                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded text-xs font-semibold transition">Serahkan (Selesai)</button>
                                    </form>
                                @else
                                    <span class="text-emerald-700 font-bold text-xs bg-emerald-50 px-2.5 py-1 rounded-md block">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 text-sm">Tidak ada data pengajuan yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>