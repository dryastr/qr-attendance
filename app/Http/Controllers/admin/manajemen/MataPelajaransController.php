<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaransController extends Controller
{
    public function index()
    {
        $mataPelajarans = MataPelajaran::all();
        return view('admin.admin.mata-pelajarans.index', compact('mataPelajarans'));
    }

    public function create()
    {
        // Not used with modals
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        MataPelajaran::create($request->all());

        return redirect()->route('mata-pelajarans.index')->with('success', 'Mata Pelajaran created successfully.');
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

        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->update($request->all());

        return redirect()->route('mata-pelajarans.index')->with('success', 'Mata Pelajaran updated successfully.');
    }

    public function destroy(string $id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->delete();

        return redirect()->route('mata-pelajarans.index')->with('success', 'Mata Pelajaran deleted successfully.');
    }
}
