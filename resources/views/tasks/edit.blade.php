@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Tugas</h1>
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Judul:</label>
            <input type="text" name="title" value="{{ $task->title }}" required><br>

            <label>Deskripsi:</label>
            <textarea name="description">{{ $task->description }}</textarea><br>

            <button type="submit">Update</button>
        </form>
    </div>
@endsection
