<?php

use App\Http\Controllers\AuthController; // Mengimpor controller otentikasi
use App\Http\Controllers\DashboardController; // Mengimpor controller dashboard
use App\Http\Controllers\ConsoleController; // Mengimpor controller konsol
use App\Http\Controllers\GameController; // Mengimpor controller game
use App\Http\Controllers\CustomerController; // Mengimpor controller customer
use App\Http\Controllers\RentalController; // Mengimpor controller rental
use Illuminate\Support\Facades\Route; // Mengimpor facade Route untuk mendefinisikan rute

// Auth Routes (Guest)
Route::middleware(['guest'])->group(function () { // Grup rute untuk pengguna yang belum login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); // Menampilkan halaman login
    Route::post('/login', [AuthController::class, 'login']); // Memproses form login
});

// App Routes (Authenticated Staff/Admin)
Route::middleware(['auth'])->group(function () { // Grup rute untuk pengguna yang sudah login
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); // Menampilkan dashboard utama
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Proses logout pengguna

    Route::resource('consoles', ConsoleController::class); // Membuat semua rute CRUD untuk konsol
    Route::resource('games', GameController::class); // Membuat semua rute CRUD untuk game
    Route::resource('customers', CustomerController::class); // Membuat semua rute CRUD untuk customer
    
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index'); // Menampilkan daftar rental
    Route::get('/rentals/create', [RentalController::class, 'create'])->name('rentals.create'); // Menampilkan form tambah rental baru
    Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store'); // Menyimpan data rental baru
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show'); // Menampilkan detail rental tertentu
    Route::post('/rentals/{rental}/complete', [RentalController::class, 'complete'])->name('rentals.complete'); // Menandai rental selesai
    Route::delete('/rentals/{rental}', [RentalController::class, 'destroy'])->name('rentals.destroy'); // Menghapus rental
});
