<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\TingkatKelas;
use App\Models\MataPelajaran;
use App\Models\Jurusan;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AddUsersController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $tingkatKelas = TingkatKelas::all();
        $mataPelajarans = MataPelajaran::all();
        $jurusans = Jurusan::all();
        $roles = Role::where('name', '!=', 'admin')->get();
        $users = User::with(['kelas', 'tingkatKelas', 'mataPelajaran', 'jurusan', 'role'])
            ->whereHas('role', function ($query) {
                $query->where('name', '!=', 'admin');
            })
            ->get();
        return view('admin.admin.users.index', compact('users', 'kelas', 'tingkatKelas', 'mataPelajarans', 'jurusans', 'roles'));
    }

    public function store(Request $request)
    {
        // Log request data for debugging

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users',
            'password' => 'nullable|string|min:8',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tingkat_kelas_id' => 'nullable|exists:tingkat_kelas,id',
            'mata_pelajaran_id' => 'nullable|exists:mata_pelajarans,id',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = new User($request->all());

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('add-users.index')->with('success', 'User created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tingkat_kelas_id' => 'nullable|exists:tingkat_kelas,id',
            'mata_pelajaran_id' => 'nullable|exists:mata_pelajarans,id',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->fill($request->except('password'));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('add-users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('add-users.index')->with('success', 'User deleted successfully.');
    }
}
