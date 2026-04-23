<?php

use App\Enums\RolesEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BukuController as AdminBukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\UserPetugasController;
use App\Http\Controllers\Admin\LogAktifitasController;
use App\Http\Controllers\Admin\PengembalianController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Petugas\ApprovalPeminjamanController;
use App\Http\Controllers\Petugas\ApprovalPengembalianController;
use App\Http\Controllers\Petugas\AlatController as PetugasAlatController;
// use App\Http\Controllers\Peminjam\AlatController as PeminjamAlatController;
use App\Http\Controllers\Siswa\BukuController;
use App\Http\Controllers\Siswa\SiswaPeminjamanController;
use App\Http\Controllers\Siswa\SiswaPengembalianController;

Route::get('/', function () {
    return view('auth.login');
});

// Redirect /dashboard ke dashboard sesuai role
Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }

    return match ($user->role->value) {
        RolesEnum::ADMIN->value => redirect()->route('admin.dashboard'),
        // RolesEnum::PETUGAS->value => redirect()->route('petugas.dashboard'),
        RolesEnum::SISWA->value => redirect()->route('siswa.dashboard'),
        default => redirect()->route('login'),
    };
})->middleware(['auth'])->name('dashboard');

// Routes untuk Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('/buku', AdminBukuController::class);
    Route::resource('/kategori', KategoriController::class);
    Route::patch('/kategori/{kategori}/toggle-status', [KategoriController::class, 'toggleStatus'])->name('kategori.toggleStatus');
    Route::resource('/user-petugas', UserPetugasController::class);
    Route::patch('/siswa/{id}/toggle-status', [SiswaController::class, 'toggleStatus'])->name('admin.siswa.toggleStatus');
    Route::resource('/siswa', SiswaController::class);
    // Route::patch('/user-petugas/{id}/toggle-status', [UserPetugasController::class, 'toggleStatus'])->name('admin.user-petugas.toggleStatus');
    Route::resource('/peminjaman', PeminjamanController::class);
    Route::resource('/pengembalian', PengembalianController::class);
    Route::resource('/log', LogAktifitasController::class);

    // Tambahkan routes admin lainnya di sini
});

// Routes untuk Petugas
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', function () {
        return view('petugas.dashboard');
    })->name('dashboard');

    Route::resource('/alat', PetugasAlatController::class);
    Route::resource('/approve-peminjaman', ApprovalPeminjamanController::class);
    Route::post('/approve-peminjaman/{id}/approve', [ApprovalPeminjamanController::class, 'approve'])->name('approve-peminjaman.approve');
    Route::post('/approve-peminjaman/{id}/reject', [ApprovalPeminjamanController::class, 'reject'])->name('approve-peminjaman.reject');
    Route::post('/peminjaman/scan-proses', [ApprovalPeminjamanController::class, 'scanProcess'])->name('peminjaman.scan-proses');
    Route::get('/peminjaman/export', [ApprovalPeminjamanController::class, 'export'])->name('peminjaman.export');
    Route::resource('/approve-pengembalian', ApprovalPengembalianController::class);
    Route::post('/pengembalian/scan-proses', [ApprovalPengembalianController::class, 'scanProcess'])->name('pengembalian.scan-proses');
    Route::post('/pengembalian/proses', [ApprovalPengembalianController::class, 'processReturn'])->name('pengembalian.proses');
    Route::get('/pengembalian/export', [ApprovalPengembalianController::class, 'export'])->name('pengembalian.export');

    // Tambahkan routes petugas lainnya di sini
});

// Routes untuk Peminjam
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('dashboard');

    Route::resource('/buku', BukuController::class);
    Route::resource('/peminjaman', SiswaPeminjamanController::class);
    Route::resource('/pengembalian', SiswaPengembalianController::class);

    // Tambahkan routes peminjam lainnya di sini
});

// Profile routes (accessible by all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
