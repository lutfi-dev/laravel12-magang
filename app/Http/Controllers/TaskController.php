<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        // Jika user adalah admin, tampilkan semua task
        if (Auth::user()->role === 'admin') {
            $tasks = Task::all();
        } else {
            // User biasa hanya lihat task miliknya
            $tasks = Task::where('user_id', Auth::id())->get();
        }
        return view('tasks.index', compact('tasks'));
    }

    public function adminIndex()
    {
        // Halaman khusus admin, tampilkan semua task
        $tasks = Task::all();
        return view('tasks.admin', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Simpan task dengan user_id dari user yang login
        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);

        // Hanya admin atau pemilik task yang bisa melihat
        if (Auth::user()->role !== 'admin' && $task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Akses ditolak!');
        }

        return view('tasks.show', compact('task'));
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);

        // Hanya admin atau pemilik task yang bisa edit
        if (Auth::user()->role !== 'admin' && $task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Akses ditolak!');
        }

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = Task::findOrFail($id);

        // Hanya admin atau pemilik task yang bisa update
        if (Auth::user()->role !== 'admin' && $task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Akses ditolak!');
        }

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        // Hanya admin atau pemilik task yang bisa hapus
        if (Auth::user()->role !== 'admin' && $task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'Akses ditolak!');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
