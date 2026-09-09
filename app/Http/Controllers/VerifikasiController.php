<?php

namespace App\Http\Controllers;

use App\Models\Verifikasi;
use App\Models\Mobil;
use App\Models\Supir;

use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        return view('admin/verifikasi', [
            "title" => "Verifikasi",
            "transaksi" => Verifikasi::where('verifikasi', 'Requested')->get()
        ]);
    }

    public function approve_transaksi($id)
    {
        $status = Verifikasi::find($id);

        if (!$status) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $mobil = Mobil::where('nama_mobil', $status->nama_mobil)->first();
        $supir = Supir::where('nama', $status->nama_supir)->first();

        if ($mobil) {
            $mobil->status = 'TIDAK TERSEDIA';
            $mobil->save();
        }
        if ($supir) {
            $supir->status = 'TIDAK TERSEDIA';
            $supir->save();
        }

        $status->verifikasi = 'DITERIMA';
        $status->save();
        return redirect()->back()->with('success', 'Transaksi Diterima');
    }

    public function reject_transaksi($id)
    {
        $status = Verifikasi::find($id);

        if (!$status) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $status->verifikasi = 'DITOLAK';
        $status->save();
        return redirect()->back()->with('success', 'Transaksi Ditolak');
    }
    // public function pengembalian($id)
    // {
    //     $status = Verifikasi::find($id);
    //     $mobil = Mobil::where('nama_mobil', $status->nama_mobil)->first();

    //     if ($mobil) {
    //         $mobil->status = 'Tersedia';
    //         $mobil->save();
    //     }

    //     $status->verifikasi = 'SELESAI';
    //     $status->save();
    //     return redirect()->back()->with('success', 'Transaksi Selesai');
    // }
}
