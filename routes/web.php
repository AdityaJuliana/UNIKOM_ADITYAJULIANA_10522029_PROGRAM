<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MotorController;
use App\Http\Controllers\Admin\KonsumenController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PenyewaanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Konsumen\KatalogController;
use App\Http\Controllers\Konsumen\RiwayatController;

// ── PUBLIC ────────────────────────────────────────────────
Route::get('/', function () {
    // Dikelompokkan per jenis (sama seperti katalog konsumen): 1 kartu per jenis,
    // tanpa plat nomor spesifik, cuma jenis + spesifikasi + harga + jumlah tersedia.
    $grouped = \App\Models\Motor::orderBy('kode')->get()->groupBy('model');

    $motors = $grouped->map(function ($units, $jenis) {
        $representatif = $units->first(fn ($u) => $u->statusEfektif() === 'OFTR') ?? $units->first();
        $representatif->jumlah_unit     = $units->count();
        $representatif->jumlah_tersedia = $units->filter(fn ($u) => $u->statusEfektif() === 'OFTR')->count();
        return $representatif;
    })->values();

    return view('landing', compact('motors'));
})->name('landing');

// ── AUTH ──────────────────────────────────────────────────
Route::post('/login',    [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update')->middleware('auth.user');
Route::post('/profil/update-admin', [ProfilController::class, 'update'])->name('profil.update.admin')->middleware('auth.admin');
Route::get('/logout',    [AuthController::class, 'logout'])->name('auth.logout');

// ── ADMIN ─────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('auth.admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Motor
    Route::get('/motor',                [MotorController::class, 'index'])->name('motor');
    Route::post('/motor',               [MotorController::class, 'store'])->name('motor.store');
    Route::put('/motor/{kode}',         [MotorController::class, 'update'])->name('motor.update');
    Route::patch('/motor/{kode}/status', [MotorController::class, 'setStatus'])->name('motor.status');
    Route::get('/motor/{kode}/riwayat',    [MotorController::class, 'riwayat'])->name('motor.riwayat');
    Route::post('/motor/{kode}/perawatan', [MotorController::class, 'simpanPerawatan'])->name('motor.perawatan.store');
    Route::patch('/perawatan/{id}/selesai', [MotorController::class, 'toggleSelesaiPerawatan'])->name('motor.perawatan.selesai');
    Route::delete('/perawatan/{id}',       [MotorController::class, 'hapusPerawatan'])->name('motor.perawatan.destroy');
    Route::delete('/motor/{kode}',      [MotorController::class, 'destroy'])->name('motor.destroy');

    // Konsumen
    Route::get('/konsumen',                       [KonsumenController::class, 'index'])->name('konsumen');
    Route::patch('/konsumen/{username}/validasi', [KonsumenController::class, 'toggleValidasi'])->name('konsumen.validasi');
    Route::get('/konsumen/{username}/riwayat',    [KonsumenController::class, 'riwayat'])->name('konsumen.riwayat');
    Route::get('/konsumen/{username}/ktp',        [KonsumenController::class, 'ktpDetail'])->name('konsumen.ktp');
    Route::delete('/konsumen/{username}',         [KonsumenController::class, 'destroy'])->name('konsumen.destroy');
    Route::patch('/konsumen/{username}/reset-password', [KonsumenController::class, 'resetPassword'])->name('konsumen.reset-password');

    // Transaksi (Booking & Perpanjangan)
    Route::get('/transaksi',                   [BookingController::class, 'index'])->name('transaksi');
    Route::patch('/booking/{id}/konfirmasi',   [BookingController::class, 'konfirmasi'])->name('booking.konfirmasi');
    Route::delete('/booking/{id}',             [BookingController::class, 'tolak'])->name('booking.tolak');
    Route::patch('/perpanjangan/{id}/izinkan', [BookingController::class, 'izinkanPerpanjangan'])->name('perpanjangan.izinkan');
    Route::patch('/perpanjangan/{id}/tolak',   [BookingController::class, 'tolakPerpanjangan'])->name('perpanjangan.tolak');
    Route::patch('/booking/{id}/serahkan',     [BookingController::class, 'serahkan'])->name('booking.serahkan');

    // Pengembalian
    Route::get('/pengembalian',                 [PenyewaanController::class, 'index'])->name('pengembalian');
    Route::post('/pengembalian/{id}/proses',    [PenyewaanController::class, 'prosesKembali'])->name('pengembalian.proses');
    Route::patch('/pengembalian/{id}/logistik', [PenyewaanController::class, 'toggleLogistik'])->name('pengembalian.logistik');
    Route::patch('/pengembalian/{id}/payment',  [PenyewaanController::class, 'togglePayment'])->name('pengembalian.payment');
    Route::delete('/penyewaan/{id}',            [PenyewaanController::class, 'destroy'])->name('penyewaan.destroy');
    Route::get('/pengembalian/{id}/struk',      [PenyewaanController::class, 'struk'])->name('pengembalian.struk');

    // Data Admin
    Route::get('/admin-akun',            [AdminController::class, 'index'])->name('akun.index');
    Route::post('/admin-akun',           [AdminController::class, 'store'])->name('akun.store');
    Route::delete('/admin-akun/{id}',    [AdminController::class, 'destroy'])->name('akun.destroy');

    // Laporan
    Route::get('/laporan',          [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/download', [LaporanController::class, 'download'])->name('laporan.download');
    Route::get('/laporan/download-perawatan', [LaporanController::class, 'downloadPerawatan'])->name('laporan.download.perawatan');
});

// ── KONSUMEN ──────────────────────────────────────────────
Route::prefix('konsumen')->name('konsumen.')->middleware('auth.user')->group(function () {
    Route::get('/katalog',          [KatalogController::class, 'index'])->name('katalog');
    Route::post('/booking',         [KatalogController::class, 'booking'])->name('booking');
    Route::get('/riwayat',          [RiwayatController::class, 'index'])->name('riwayat');
    Route::post('/perpanjang/{id}', [RiwayatController::class, 'perpanjang'])->name('perpanjang');
});
