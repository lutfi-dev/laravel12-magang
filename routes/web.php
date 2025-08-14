<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

    Route::get('/admin/tasks', [TaskController::class, 'index'])->name('admin.tasks');
    Route::resource('tasks', TaskController::class)->except(['index']);
    Route::delete('/tasks/{id}/attachments/{index}', [TaskController::class, 'removeAttachment'])->name('tasks.removeAttachment');

});
