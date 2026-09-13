<?php

namespace App\Http\Controllers;

use App\Models\Sewa;

class KeuanganController extends Controller
{
    public function index()
    {
        $status = Sewa::where('verifikasi', 'SELESAI')->get();

        return view('admin/keuangan', compact('status'));
    }
}
