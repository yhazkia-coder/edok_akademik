<?php
 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\JenisLayananController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
 
// Redirect halaman utama ke login
Route::get('/', function () {
    return redirect()->route('login');
});
 
// Guest Routes (Hanya bisa diakses jika belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
 
    // Tambahkan route untuk halaman registrasi jika diperlukan
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});
 
// Authenticated Routes (Harus login terlebih dahulu)
Route::middleware('auth')->group(function () {
    
    // Profil Pengguna (Edit & Update Profil, Password, dan Avatar)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
 
    // Admin Routes (Dashboard, Filter, Pencarian, Validasi, Serahkan, dan Ekspor Excel/CSV)
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/export-excel', [AdminController::class, 'exportExcel'])->name('admin.export');
    Route::put('/admin/pengajuan/{id}/validasi', [AdminController::class, 'validasi'])->name('admin.pengajuan.validasi');
    Route::put('/admin/pengajuan/{id}/serahkan', [AdminController::class, 'serahkan'])->name('admin.pengajuan.serahkan');
 
    // Admin Routes (Master Layanan CRUD)
    Route::get('/admin/layanan', [JenisLayananController::class, 'index'])->name('admin.layanan.index');
    Route::post('/admin/layanan', [JenisLayananController::class, 'store'])->name('admin.layanan.store');
    Route::put('/admin/layanan/{id}', [JenisLayananController::class, 'update'])->name('admin.layanan.update');
    Route::delete('/admin/layanan/{id}', [JenisLayananController::class, 'destroy'])->name('admin.layanan.destroy');
 
    // Siswa Routes (Dashboard, Upload Pengajuan Dokumen, dan Cetak Bukti Resi)
    Route::get('/siswa/dashboard', [StudentController::class, 'index'])->name('siswa.dashboard');
    Route::post('/siswa/pengajuan', [StudentController::class, 'store'])->name('siswa.pengajuan.store');
    Route::get('/siswa/pengajuan/{id}/cetak', [StudentController::class, 'cetakBukti'])->name('siswa.pengajuan.cetak');

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});