<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusansController extends Controller
{
    public function index()
    {
        $jurusans = Jurusan::all();
        return view('admin.admin.jurusans.index', compact('jurusans'));
    }

    public function create()
    {
        // No need to implement this if you're using modals on the index page
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Jurusan::create($request->all());

        return redirect()->route('jurusans.index')->with('success', 'Jurusan created successfully.');
    }

    public function show(string $id)
    {
        // Not needed for CRUD with modals
    }

    public function edit(string $id)
    {
        // Not needed for CRUD with modals
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update($request->all());

        return redirect()->route('jurusans.index')->with('success', 'Jurusan updated successfully.');
    }

    public function destroy(string $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('jurusans.index')->with('success', 'Jurusan deleted successfully.');
    }
}
