@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Tugas</h1>

        <!-- Tombol Tambah hanya muncul kalau admin -->
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('tasks.create') }}" class="btn btn-success mb-3">+ Tambah Tugas</a>
        @endif

        <!-- Form Pencarian dan Filter -->
        <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari title atau description..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">Filter Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" placeholder="From Date">
                </div>
                <div class="col-md-2">
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" placeholder="To Date">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>

        <!-- Pesan Sukses -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Pesan Error -->
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Daftar Tugas -->
        <ul class="list-group">
            @forelse ($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div>
                        <strong>{{ $task->title }}</strong> - {{ $task->description }}
                        <br>
                        <small>Status: {{ ucfirst($task->status) }} | Dibuat: {{ $task->created_at->format('d-m-Y') }}</small>

                        <!-- Tampilkan file yang diupload -->
                        @if ($task->attachments)
                            <div class="mt-2">
                                <strong>File Terlampir:</strong>
                                @foreach (json_decode($task->attachments, true) as $attachment)
                                    <a href="{{ asset($attachment) }}" target="_blank" class="btn btn-info btn-sm ms-2">{{ basename($attachment) }}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Tombol Edit dan Hapus untuk admin -->
                    @if (auth()->user()->role === 'admin')
                        <div class="mt-2 d-flex gap-2">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </div>
                    @endif
                </li>
            @empty
                <li class="list-group-item">Tidak ada tugas.</li>
            @endforelse
        </ul>
    </div>
@endsection
