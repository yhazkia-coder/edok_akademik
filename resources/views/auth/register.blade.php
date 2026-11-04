<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - eDoc Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4 font-sans">
    <div class="max-w-4xl w-full bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 md:grid-cols-2 border border-slate-200/80 animate-fade-in">
        
        <!-- Sisi Form Register -->
        <div class="p-6 sm:p-10 md:p-12 flex flex-col justify-center space-y-5">
            <div>
                <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full font-bold tracking-wide uppercase">Pendaftaran Siswa</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-800 mt-3">Buat Akun Baru</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Daftarkan diri Anda untuk mengakses layanan dokumen akademik.</p>
            </div>

            @if($errors->any())
                <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-3 rounded-r-lg text-xs animate-pulse">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-3.5">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Siswa" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full border border-slate-200 rounded-xl p-3 text-sm bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition" required>
                </div>
                
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white font-semibold py-3 rounded-xl text-sm transition shadow-md shadow-blue-500/20">
                    Daftar Sekarang
                </button>
            </form>

            <div class="text-center text-xs text-slate-500 pt-1">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk di sini</a>
            </div>
        </div>

        <!-- Sisi Visual Banner Samping -->
        <div class="relative hidden md:flex flex-col justify-between bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 p-10 text-white overflow-hidden">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80" alt="Workspace" class="w-full h-full object-cover opacity-20 transform hover:scale-105 transition duration-700">
            </div>
            <div class="relative z-10 flex items-center space-x-2">
                <div class="w-3 h-3 bg-blue-400 rounded-full animate-ping"></div>
                <span class="text-xs font-semibold tracking-wider uppercase text-blue-200">Bergabung Bersama Kami</span>
            </div>
            <div class="relative z-10 space-y-3">
                <h3 class="text-2xl font-bold leading-tight">Mulai Pengajuan Dokumenmu dengan Mudah</h3>
                <p class="text-xs text-blue-200 leading-relaxed">Buat akun siswa dalam hitungan detik dan nikmati kemudahan layanan administrasi akademik digital.</p>
            </div>
            <div class="relative z-10 text-xs text-blue-300">
                eDoc Akademik &copy; 2026
            </div>
        </div>

    </div>
</body>
</html>