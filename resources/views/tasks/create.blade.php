@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Tugas</h1>
        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Judul:</label>
                <input type="text" name="title" class="form-control" required><br>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi:</label>
                <textarea name="description" class="form-control"></textarea><br>
            </div>

            <div class="mb-3">
                <label class="form-label">Unggah File (Foto, Dokumen, dll):</label>
                <input type="file" name="attachments[]" class="form-control" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                <small class="text-muted">Pilih beberapa file jika perlu (JPG, PNG, PDF, DOC, DOCX)</small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
