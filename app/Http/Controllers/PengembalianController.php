<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Mobil;
use App\Models\Sewa;
use App\Models\Supir;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index()
    {
        $status = Sewa::where('verifikasi', 'DITERIMA')->get();

        return view('admin/pengembalian', compact('status'));
    }

    public function pengembalian_selesai($id)
    {
        $transaksi = Sewa::find($id);

        if (! $transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        if ($transaksi->verifikasi !== 'DITERIMA') {
            return redirect()->back()->with('error', 'Transaksi tidak dalam status disewakan.');
        }

        DB::transaction(function () use ($id) {
            $sewa = Sewa::where('id', $id)->lockForUpdate()->first();

            if ($sewa->verifikasi !== 'DITERIMA') {
                return;
            }

            Mobil::where('nama_mobil', $sewa->nama_mobil)->update(['status' => 'TERSEDIA']);

            Supir::where('nama', $sewa->nama_supir)->update(['status' => 'TERSEDIA']);

            $sewa->verifikasi = 'SELESAI';
            $sewa->save();

            ActivityLog::log('transaksi', 'return', 'Pengembalian selesai: #' . $sewa->no_invoice . ' - ' . $sewa->nama_customer);
        });

        return redirect()->back()->with('success', 'Transaksi Selesai');
    }
}
