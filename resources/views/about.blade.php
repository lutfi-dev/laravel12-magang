@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tentang Kami</h1>
        <p>Kami adalah perusahaan teknologi yang berfokus pada solusi manajemen tugas untuk meningkatkan efisiensi tim.</p>
        <h3>Visi</h3>
        <p>Menjadi platform manajemen tugas terdepan di dunia.</p>
        <h3>Misi</h3>
        <ul>
            <li>Menyediakan alat yang mudah digunakan.</li>
            <li>Mendukung kolaborasi tim.</li>
        </ul>
        <h3>Sistem Manajemen Tugas Kami</h3>
        <p>Coba sistem kami yang memungkinkan unggah dokumen, filter tugas, dan manajemen berbasis role.</p>
        <a href="{{ Auth::check() ? route('tasks.index') : route('login') }}" class="btn btn-primary">Coba Sekarang</a>
    </div>
@endsection
