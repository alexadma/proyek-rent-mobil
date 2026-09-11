<?php

namespace App\Http\Controllers;

// importt model "Mobil"
use App\Models\Mobil;

class MobilController extends Controller
{
    public function index()
    {
        return view('daftarmobil', [
            'title' => 'Daftar Mobil',
            'mobil' => Mobil::all(),
        ]);
    }
}
