<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;

// Redirect halaman root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Proteksi semua route 'tasks' agar hanya bisa diakses setelah login
Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
});

// Routing untuk fitur login, register, dll
Auth::routes();

// Setelah login, langsung arahkan ke /tasks daripada /home
Route::get('/home', function () {
    return redirect('/tasks');
});

Route::get('/tasks', [TaskController::class, 'index'])
    ->middleware('auth')
    ->name('tasks');

Route::get('/admin/tasks', [TaskController::class, 'adminIndex'])
    ->middleware(['auth', 'admin'])
    ->name('admin.tasks');
