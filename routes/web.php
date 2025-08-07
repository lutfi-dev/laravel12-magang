<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController; // ← Tambahkan ini

Route::get('/selamat-datang', function () {
    return 'Selamat datang di proyek Magang!';
});

Route::resource('tasks', TaskController::class); // ← Dan ini
