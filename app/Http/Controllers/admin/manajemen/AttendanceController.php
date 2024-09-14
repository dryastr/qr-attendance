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

        // Cek apakah user adalah teacher
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
        // Ambil parameter date dari URL
        $date = $request->query('date');

        // Logika untuk menampilkan halaman absensi sesuai tanggal
        return view('user.absensi.show', ['date' => $date]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nis' => 'required|string',
            'photo' => 'nullable|image|max:2048', // Validasi untuk foto
        ]);

        // Cari pengguna berdasarkan NIS
        $user = User::where('nis', $request->nis)->first();

        // Jika pengguna tidak ditemukan, kembalikan dengan pesan kesalahan
        if (!$user) {
            return back()->withErrors(['nis' => 'NIS tidak ditemukan.']);
        }

        // Jika ada file foto, simpan di folder 'photos' dalam disk 'public'
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Simpan data absensi ke database
        Attendance::create([
            'nis' => $request->nis,
            'photo' => $photoPath,
            'absen_at' => now(),
        ]);

        // Redirect kembali dengan pesan sukses
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
