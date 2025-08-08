<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            // Admin lihat semua task
            $tasks = Task::all();
        } else {
            // User biasa lihat semua task (bukan cuma miliknya)
            $tasks = Task::all();
        }
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        // Hanya admin yang bisa create
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
        ]);

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
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'Akses ditolak!');
        }

        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
