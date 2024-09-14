<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\manajemen\AddUsersController;
use App\Http\Controllers\admin\manajemen\AttendanceController;
use App\Http\Controllers\admin\manajemen\JurusansController;
use App\Http\Controllers\admin\manajemen\KelasController;
use App\Http\Controllers\admin\manajemen\MataPelajaransController;
use App\Http\Controllers\admin\manajemen\QrCodeController;
use App\Http\Controllers\admin\manajemen\TingkatKelasController;
use App\Http\Controllers\admin\TeacherConctroller;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role->name === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role->name === 'teacher') {
            return redirect()->route('teacher.dashboard');
        } else {
            return redirect()->route('home');
        }
    }
    return redirect()->route('login');
})->name('home');

Auth::routes(['middleware' => ['redirectIfAuthenticated']]);


Route::middleware(['auth', 'role.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // manajemen
    Route::resource('jurusans', JurusansController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('tingkat-kelas', TingkatKelasController::class);
    Route::resource('mata-pelajarans', MataPelajaransController::class);
    Route::resource('add-users', AddUsersController::class);
});

Route::middleware(['auth', 'role.teacher'])->group(function () {
    Route::get('/teacher', [TeacherConctroller::class, 'index'])->name('teacher.dashboard');

    Route::get('/students', [AttendanceController::class, 'index'])->name('students.index');
});

Route::middleware(['auth', 'role.user'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('home');
});

Route::get('/generate-qr', [QrCodeController::class, 'generate'])->name('generate.qr');
Route::get('/absensi', [AttendanceController::class, 'show'])->name('absensi');
Route::post('/absensi', [AttendanceController::class, 'store'])->name('absensi.store');

// Contoh
// Route::get('/', function () {
//     if (Auth::check()) {
//         $user = Auth::user();
//         if ($user->role->name === 'super_admin') {
//             return redirect()->route('super_admin.dashboard');
//         } elseif ($user->role->name === 'admin') {
//             return redirect()->route('admin.dashboard');
//         } elseif ($user->role->name === 'kaprog') {
//             return redirect()->route('kaprog.dashboard');
//         } elseif ($user->role->name === 'pemray') {
//             return redirect()->route('pemray.dashboard');
//         } else {
//             return redirect()->route('home');
//         }
//     }
//     return redirect()->route('login');
// })->name('home');
