<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', fn () => view('admin'));
    Route::get('/manajemen-pengguna', fn () => 'Halaman Manajemen Pengguna');
});

// Route khusus Dosen
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen', fn () => 'Dashboard Dosen');
});

// Route khusus Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa', fn () => 'Dashboard Mahasiswa');
});

// Route yang bisa diakses Admin & Dosen
Route::middleware(['auth', 'role:admin,dosen'])->group(function () {
    Route::get('/kelola-materi', fn () => 'Halaman Kelola Materi (Admin & Dosen)');
});

require __DIR__.'/auth.php';

