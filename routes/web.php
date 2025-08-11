<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;

// Redirect halaman root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Routing untuk fitur login, register, dll
Auth::routes();
Route::get('/home', function () {
    return redirect()->route('tasks.index');
});

// Route untuk user (hanya melihat daftar tugas)
Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
});

// Route untuk admin (daftar tugas + CRUD)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/tasks', [TaskController::class, 'adminIndex'])->name('admin.tasks');
    Route::resource('tasks', TaskController::class)->except(['index']); // CRUD untuk admin, kecuali index
});
