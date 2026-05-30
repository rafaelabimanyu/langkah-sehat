<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasyarakatController;
use App\Models\Perjalanan;
use Illuminate\Support\Facades\Route;

// Welcome / Landing Page (Accessible to guests)
Route::get('/', function () {
    $totalLogs = Perjalanan::count();
    return view('welcome', compact('totalLogs'));
})->name('welcome');

// Language Switcher Route
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

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
    
    // Unified Profile settings routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    // Masyarakat Roles
    Route::middleware('role:masyarakat')->group(function () {
        Route::get('/dashboard', [MasyarakatController::class, 'index'])->name('masyarakat.dashboard');
        Route::get('/perjalanan/catat', [MasyarakatController::class, 'create'])->name('perjalanan.create');
        Route::get('/perjalanan/riwayat', [MasyarakatController::class, 'riwayat'])->name('perjalanan.riwayat');
        Route::get('/perjalanan/print', [MasyarakatController::class, 'print'])->name('perjalanan.print');
        Route::post('/perjalanan', [MasyarakatController::class, 'store'])->name('perjalanan.store');
        Route::get('/perjalanan/{perjalanan}/edit', [MasyarakatController::class, 'edit'])->name('perjalanan.edit');
        Route::put('/perjalanan/{perjalanan}', [MasyarakatController::class, 'update'])->name('perjalanan.update');
        Route::delete('/perjalanan/{perjalanan}', [MasyarakatController::class, 'destroy'])->name('perjalanan.destroy');
    });

    // Admin Roles
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::delete('/admin/perjalanan/{perjalanan}', [AdminController::class, 'destroy'])->name('admin.perjalanan.destroy');
        
        // New Admin subsections
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        Route::get('/admin/print', [AdminController::class, 'print'])->name('admin.print');
    });
});
