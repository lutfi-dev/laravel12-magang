<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $tasks = Task::all();
        } else {
            $tasks = Task::all();
        }
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'Akses ditolak!');
        }
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Validasi file
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'status' => $request->input('status', 'pending'),
        ]);

        // Handle upload file
        if ($request->hasFile('attachments')) {
            $attachmentPaths = [];
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('tasks', $fileName, 'public'); // Simpan di storage/app/public/tasks
                $attachmentPaths[] = 'storage/tasks/' . $fileName;
            }
            $task->update(['attachments' => json_encode($attachmentPaths)]); // Simpan path di kolom attachments
        }

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'Akses ditolak!');
        }

        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'Akses ditolak!');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // Validasi file
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->input('status', $task->status),
        ]);

        // Handle upload file dan pertahankan file lama
        $attachmentPaths = json_decode($task->attachments, true) ?? []; // Ambil file lama jika ada
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('tasks', $fileName, 'public'); // Simpan di storage/app/public/tasks
                $attachmentPaths[] = 'storage/tasks/' . $fileName; // Tambahkan ke array file lama
            }
            $task->update(['attachments' => json_encode($attachmentPaths)]); // Update kolom attachments
        }

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    // Method baru (opsional): Untuk menghapus file tertentu dari array attachments
    public function removeAttachment($id, $index)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'Akses ditolak!');
        }

        $task = Task::findOrFail($id);
        $attachmentPaths = json_decode($task->attachments, true) ?? [];

        if (isset($attachmentPaths[$index])) {
            // Hapus file dari storage
            $filePath = str_replace('storage/', 'public/', $attachmentPaths[$index]);
            Storage::delete($filePath);

            // Hapus dari array dan re-index
            unset($attachmentPaths[$index]);
            $task->update(['attachments' => json_encode(array_values($attachmentPaths))]);
        }

        return redirect()->back()->with('success', 'File berhasil dihapus.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'Akses ditolak!');
        }

        $task = Task::findOrFail($id);

        // (Opsional) Hapus semua file terkait sebelum menghapus tugas
        if ($task->attachments) {
            $attachmentPaths = json_decode($task->attachments, true);
            foreach ($attachmentPaths as $path) {
                $filePath = str_replace('storage/', 'public/', $path);
                Storage::delete($filePath);
            }
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
