<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Layanan - eDoc Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-900 text-white p-4 flex justify-between items-center shadow">
        <div class="flex items-center space-x-3">
            <h1 class="font-bold text-lg">Master Layanan Akademik</h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-blue-700 px-3 py-1 rounded text-xs hover:bg-blue-800 transition">Kembali ke Dashboard</a>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-red-600 px-3 py-1 rounded text-xs hover:bg-red-700 transition">Logout</button>
        </form>
    </nav>

    <main class="max-w-7xl mx-auto p-6 space-y-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded text-sm shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Tambah Layanan -->
        <div class="bg-white rounded shadow p-6">
            <h3 class="font-bold text-lg mb-4 text-gray-800">Tambah Jenis Layanan Baru</h3>
            <form action="{{ route('admin.layanan.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf
                <input type="text" name="nama_layanan" placeholder="Nama Layanan (Cth: Legalisir Rapor)" class="border rounded p-2 text-sm" required>
                <input type="text" name="deskripsi" placeholder="Deskripsi Singkat" class="border rounded p-2 text-sm">
                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 rounded text-sm hover:bg-blue-700 transition">Simpan Layanan</button>
            </form>
        </div>

        <!-- Tabel Daftar Layanan -->
        <div class="bg-white rounded shadow p-6">
            <h3 class="font-bold text-lg mb-4 text-gray-800">Daftar Layanan Tersedia</h3>
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left text-gray-600">
                        <th class="p-3">No</th>
                        <th class="p-3">Nama Layanan</th>
                        <th class="p-3">Deskripsi</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($layanans as $index => $item)
                    <tr>
                        <td class="p-3">{{ $index + 1 }}</td>
                        <td class="p-3 font-semibold text-gray-900">{{ $item->nama_layanan }}</td>
                        <td class="p-3 text-gray-600">{{ $item->deskripsi ?? '-' }}</td>
                        <td class="p-3 text-center">
                            <form action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan ini?')" class="inline">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500">Belum ada data layanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>