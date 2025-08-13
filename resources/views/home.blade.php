@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron text-center">
            <h1>Solusi Manajemen Tugas Terbaik</h1>
            <p>Kelola tugas tim Anda dengan mudah dan efisien menggunakan sistem kami.</p>
            <a href="{{ Auth::check() ? route('tasks.index') : route('login') }}" class="btn btn-primary btn-lg">Dashboard</a>
        </div>
        <div class="row text-center">
            <div class="col-md-4">
                <h3>100+ Klien</h3>
                <p>Percaya pada solusi kami.</p>
            </div>
            <div class="col-md-4">
                <h3>5 Tahun</h3>
                <p>Pengalaman di industri.</p>
            </div>
            <div class="col-md-4">
                <h3>Dukungan 24/7</h3>
                <p>Siap membantu kapan saja.</p>
            </div>
        </div>
        <div class="mt-4">
            <h3>Testimoni</h3>
            <p>"Meningkatkan produktivitas tim kami secara signifikan!" - Klien A</p>
        </div>
    </div>
@endsection
