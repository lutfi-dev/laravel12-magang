@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Layanan Kami</h1>
        <p>Kami menyediakan berbagai layanan untuk mendukung efisiensi dan produktivitas bisnis Anda.</p>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manajemen Tugas</h5>
                        <p class="card-text">Kelola tugas tim Anda dengan fitur unggah dokumen, filter status, dan akses berbasis role (admin/user).</p>
                        <a href="{{ Auth::check() ? route('tasks.index') : route('login') }}" class="btn btn-primary">Coba Sekarang</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Konsultasi IT</h5>
                        <p class="card-text">Solusi teknologi inovatif untuk mengoptimalkan operasi bisnis Anda.</p>
                        <a href="{{ route('contact') }}" class="btn btn-primary">Hubungi Kami</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dukungan 24/7</h5>
                        <p class="card-text">Tim kami siap membantu Anda kapan saja untuk memastikan kelancaran sistem.</p>
                        <a href="{{ route('contact') }}" class="btn btn-primary">Kontak Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
