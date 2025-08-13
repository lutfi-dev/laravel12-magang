<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Redirect halaman root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Login & Logout (manual, pakai RateLimiter di LoginController)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register bawaan (manual supaya tidak bentrok dengan Auth::routes())
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Route untuk user (hanya melihat daftar tugas)
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
});

// Route untuk admin (daftar tugas + CRUD)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/tasks', [TaskController::class, 'adminIndex'])->name('admin.tasks');
    Route::resource('tasks', TaskController::class)->except(['index']);
});
