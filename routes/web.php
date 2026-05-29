<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasyarakatController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Masyarakat Roles
    Route::middleware('role:masyarakat')->group(function () {
        Route::get('/dashboard', [MasyarakatController::class, 'index'])->name('masyarakat.dashboard');
        Route::get('/perjalanan/create', [MasyarakatController::class, 'create'])->name('perjalanan.create');
        Route::post('/perjalanan', [MasyarakatController::class, 'store'])->name('perjalanan.store');
        Route::get('/perjalanan/{perjalanan}/edit', [MasyarakatController::class, 'edit'])->name('perjalanan.edit');
        Route::put('/perjalanan/{perjalanan}', [MasyarakatController::class, 'update'])->name('perjalanan.update');
        Route::delete('/perjalanan/{perjalanan}', [MasyarakatController::class, 'destroy'])->name('perjalanan.destroy');
    });

    // Admin Roles
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::delete('/admin/perjalanan/{perjalanan}', [AdminController::class, 'destroy'])->name('admin.perjalanan.destroy');
    });
});
