<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherConctroller extends Controller
{
    public function index()
    {
        $kelasId = Auth::user()->kelas_id;

        $today = Carbon::now()->startOfDay();

        $students = User::where('kelas_id', $kelasId)->whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->get();

        $lateCount = 0;
        $onTimeCount = 0;
        $noAttendanceCount = 0;

        foreach ($students as $student) {
            $latestAttendance = Attendance::where('nis', $student->nis)
                ->whereDate('absen_at', $today)
                ->latest('absen_at')
                ->first();

            if ($latestAttendance) {
                if (Carbon::parse($latestAttendance->absen_at)->gt(Carbon::parse($today->format('Y-m-d') . ' 07:00'))) {
                    $lateCount++;
                } else {
                    $onTimeCount++;
                }
            } else {
                $noAttendanceCount++;
            }
        }

        $chartData = [
            'late' => $lateCount,
            'onTime' => $onTimeCount,
            'noAttendance' => $noAttendanceCount,
        ];

        return view('admin.teacher.dashboard', [
            'lateCount' => $lateCount,
            'onTimeCount' => $onTimeCount,
            'noAttendanceCount' => $noAttendanceCount,
            'chartData' => $chartData,
        ]);
    }
}
