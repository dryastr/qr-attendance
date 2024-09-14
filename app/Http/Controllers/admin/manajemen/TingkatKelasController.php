<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\TingkatKelas;
use Illuminate\Http\Request;

class TingkatKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tingkatKelas = TingkatKelas::all();
        return view('admin.admin.tingkat-kelas.index', compact('tingkatKelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // No need to implement this if you're using modals on the index page
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        TingkatKelas::create($request->all());

        return redirect()->route('tingkat-kelas.index')->with('success', 'Tingkat Kelas created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Not needed for CRUD with modals
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Not needed for CRUD with modals
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tingkatKelas = TingkatKelas::findOrFail($id);
        $tingkatKelas->update($request->all());

        return redirect()->route('tingkat-kelas.index')->with('success', 'Tingkat Kelas updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tingkatKelas = TingkatKelas::findOrFail($id);
        $tingkatKelas->delete();

        return redirect()->route('tingkat-kelas.index')->with('success', 'Tingkat Kelas deleted successfully.');
    }
}
