@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Tugas</h1>

        {{-- Tombol Tambah hanya muncul kalau admin --}}
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('tasks.create') }}">+ Tambah Tugas</a>
        @endif

        @if (session('success'))
            <div>{{ session('success') }}</div>
        @endif

        <ul>
            @foreach ($tasks as $task)
                <li>
                    <strong>{{ $task->title }}</strong> - {{ $task->description }}

                    {{-- Tombol Edit dan Hapus hanya untuk admin --}}
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection
