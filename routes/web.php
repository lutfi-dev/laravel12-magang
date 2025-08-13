<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Auth;

// Halaman publik untuk company profile
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/products', function () {
    return view('products');
})->name('products');

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
    Route::get('/admin/tasks', [TaskController::class, 'index'])->name('admin.tasks');
    Route::resource('tasks', TaskController::class)->except(['index']);
    Route::delete('/tasks/{id}/attachments/{index}', [TaskController::class, 'removeAttachment'])->name('tasks.removeAttachment');
});
