<?php

use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresensiController;

Route::get('/lihat-tabel', [App\Http\Controllers\TabelController::class, 'index']);

// Route untuk guest (belum login)
Route::middleware('guest:karyawan')->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/proseslogin', [AuthController::class, 'prosesLogin'])->name('login.proses');
});

// Route untuk guest user
Route::middleware('guest:user')->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/prosesloginadmin', [AuthController::class, 'prosesLoginadmin'])->name('loginadmin.proses');
});

// Route untuk karyawan yang sudah login
Route::middleware(['auth:karyawan'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/proseslogout', [AuthController::class, 'proseslogout'])->name('logout');

    // Presensi
    Route::get('/presensi/create', [PresensiController::class, 'create'])->name('presensi.create');
    Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');

    // Profile
    // Form edit profile
    Route::get('/editprofile', [PresensiController::class, 'editprofile'])->name('profile.edit');
    // Update profile via POST
    Route::get('/updateprofile', function () {
    return redirect()->route('profile.edit');
});
Route::post('/updateprofile', [PresensiController::class, 'updateprofile'])->name('profile.update');
});

Route::middleware(['auth:user'])->group(function () {
Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin'])->name('dashboardadmin');;
Route::get('proseslogoutadmin', [AuthController::class, 'proseslogoutadmin'])->name('logoutadmin');

Route::get('/karyawan',[KaryawanController::class, 'index']);

});