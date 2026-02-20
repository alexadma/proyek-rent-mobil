<?php

namespace App\Http\Controllers;

use App\Models\Verifikasi;


use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $status = Verifikasi::where('verifikasi','SELESAI')->get();
        return view('admin/keuangan',compact('status')); 
    }
    
}