<?php

namespace App\Http\Controllers;

use App\Models\Verifikasi;
use App\Models\Mobil;
use App\Models\Supir;

use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $status = Verifikasi::where('verifikasi','DITERIMA')->get();
        return view('admin/pengembalian',compact('status')); 
    }

    public function pengembalian_selesai($id)
    {
        $status = Verifikasi::find($id);
        $mobil = Mobil::where('nama_mobil', $status->nama_mobil)->first();
        $supir = Supir::where('nama', $status->nama_supir)->first();

        if ($mobil) {
            $mobil->status = 'TERSEDIA';
            $mobil->save();
        }

        if ($supir) {
            $supir->status = 'TERSEDIA';
            $supir->save();
        }

        $status->verifikasi = 'SELESAI';
        $status->save();
        return redirect()->back()->with('success', 'Transaksi Selesai');
    }
}