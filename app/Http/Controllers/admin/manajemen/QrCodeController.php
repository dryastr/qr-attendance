<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function generate()
    {
        $date = Carbon::now()->format('Y-m-d');
        $token = Str::random(32);

        Cache::put('absensi_token_' . $token, $date, 24 * 60);

        $url = url('/absensi?token=' . $token);

        $filename = 'qrcode-' . $date . '.png';
        $path = public_path('qrcodes/' . $filename);

        QrCode::format('png')->size(300)->generate($url, $path);

        $qrCodeUrl = asset('qrcodes/' . $filename);

        return view('generate_qr', ['qrCodeUrl' => $qrCodeUrl]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
