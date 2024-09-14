<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $kelasCount = Kelas::count();

        $studentCount = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->count();

        $teacherCount = User::whereHas('role', function ($query) {
            $query->where('name', 'teacher');
        })->count();

        $today = Carbon::now()->format('Y-m-d');

        $lateCount = Attendance::whereDate('absen_at', $today)
            ->whereTime('absen_at', '>', '07:00:00')
            ->count();

        $onTimeCount = Attendance::whereDate('absen_at', $today)
            ->whereTime('absen_at', '<=', '07:00:00')
            ->count();

        $studentIdsWithAttendance = Attendance::whereDate('absen_at', $today)->pluck('nis');
        $noAttendanceCount = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->whereNotIn('nis', $studentIdsWithAttendance)->count();

        return view('admin.admin.dashboard', [
            'kelasCount' => $kelasCount,
            'studentCount' => $studentCount,
            'teacherCount' => $teacherCount,
            'lateCount' => $lateCount,
            'onTimeCount' => $onTimeCount,
            'noAttendanceCount' => $noAttendanceCount,
        ]);
    }
}
