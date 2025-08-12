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
    // Ganti admin.tasks ke tasks.index jika adminIndex tidak ada
    Route::get('/admin/tasks', [TaskController::class, 'index'])->name('admin.tasks');
    Route::resource('tasks', TaskController::class)->except(['index']); // CRUD untuk admin, kecuali index
    // Tambahan route untuk menghapus file tertentu
    Route::delete('/tasks/{id}/attachments/{index}', [TaskController::class, 'removeAttachment'])->name('tasks.removeAttachment');
});
