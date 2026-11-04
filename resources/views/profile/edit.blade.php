<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Profil - eDoc Akademik</title>
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
    <!-- Navbar Responsif -->
    <nav class="bg-blue-900 text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <span class="bg-blue-700 text-white font-bold text-xs px-2.5 py-1 rounded-lg">eDoc</span>
                <h1 class="font-bold text-sm sm:text-base">Pengaturan Profil</h1>
            </div>
            <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('siswa.dashboard') }}" class="bg-blue-800 hover:bg-blue-700 active:scale-95 text-white px-3.5 py-1.5 rounded-xl text-xs font-medium transition duration-150">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="max-w-2xl mx-auto px-4 sm:px-6 py-8 animate-fade-in">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden p-6 sm:p-8">
            
            <!-- Header Multimedia Profil -->
            <div class="flex flex-col sm:flex-row items-center gap-4 pb-6 mb-6 border-b border-slate-100 text-center sm:text-left">
                <div class="relative">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="w-20 h-20 rounded-full object-cover shadow-md border-2 border-blue-500">
                    @else
                        <div class="w-20 h-20 rounded-full bg-blue-100 text-blue-700 font-bold text-2xl flex items-center justify-center shadow-inner">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div>
                    <span class="bg-blue-50 text-blue-700 text-[11px] px-2.5 py-1 rounded-full font-bold uppercase tracking-wider">Akun Aktif</span>
                    <h2 class="text-xl font-extrabold text-slate-800 mt-1.5">{{ Auth::user()->name }}</h2>
                    <p class="text-xs text-slate-500">{{ Auth::user()->email }} &bull; <span class="capitalize font-semibold text-blue-600">{{ Auth::user()->role }}</span></p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl text-sm shadow-sm mb-6">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded-r-xl text-sm shadow-sm mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Form Update Profil & Foto -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf 
                @method('PUT')
                
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Foto Profil Baru (Opsional)</label>
                    <input type="file" name="avatar" class="w-full border border-slate-200 rounded-xl p-2 text-xs bg-slate-50 text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:bg-blue-100 file:text-blue-700 font-semibold cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1">Format: JPG, JPEG, PNG (Maksimal 2MB).</p>
                </div>

                <hr class="border-slate-100 my-4">
                
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-4">
                    <p class="text-xs text-slate-500 font-medium">⚠️ Kosongkan bagian password di bawah ini jika Anda tidak ingin mengubah sandi.</p>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Password Baru</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white font-semibold py-3 rounded-xl text-sm transition shadow-md shadow-blue-500/20">
                    Simpan Perubahan Profil
                </button>
            </form>
        </div>
    </main>
</body>
</html>