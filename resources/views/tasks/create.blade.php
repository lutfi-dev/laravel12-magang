@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Tugas</h1>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <label>Judul:</label>
            <input type="text" name="title" required><br>

            <label>Deskripsi:</label>
            <textarea name="description"></textarea><br>

            <button type="submit">Simpan</button>
        </form>
    </div>
@endsection
