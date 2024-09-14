<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name !== 'teacher') {
            abort(403, 'Unauthorized action.');
        }

        $students = User::with(['attendances' => function ($query) {
            $query->whereDate('absen_at', now()->toDateString())
                ->latest();
        }])->whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->where('kelas_id', $user->kelas_id)->get();

        return view('admin.teacher.student-lists.index', ['students' => $students]);
    }

    public function generateQrCode()
    {
        $qrCode = QrCode::size(300)->generate(url('/absensi'));
        return view('generate_qr', ['qrCode' => $qrCode]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show(Request $request)
    {
        $date = $request->query('date');

        return view('user.absensi.show', ['date' => $date]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user = User::where('nis', $request->nis)->first();

        if (!$user) {
            return back()->withErrors(['nis' => 'NIS tidak ditemukan.']);
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        Attendance::create([
            'nis' => $request->nis,
            'photo' => $photoPath,
            'absen_at' => now(),
        ]);

        return redirect()->route('absensi')->with('success', 'Absensi berhasil.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
