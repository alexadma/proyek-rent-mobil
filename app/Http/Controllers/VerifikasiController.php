<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Mobil;
use App\Models\Sewa;
use App\Models\Supir;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VerifikasiController extends Controller
{
    public function index()
    {
        return view('admin/verifikasi', [
            'title' => 'Verifikasi',
            'transaksi' => Sewa::where('verifikasi', 'Requested')->get(),
        ]);
    }

    public function approve_transaksi($id)
    {
        $transaksi = Sewa::find($id);

        if (! $transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        if ($transaksi->verifikasi !== 'Requested') {
            return redirect()->back()->with('error', 'Transaksi sudah diproses.');
        }

        try {
            DB::transaction(function () use ($id) {
                $sewa = Sewa::where('id', $id)->lockForUpdate()->first();

                if ($sewa->verifikasi !== 'Requested') {
                    throw ValidationException::withMessages(['transaksi' => 'Transaksi sudah diproses.']);
                }

                $mobil = Mobil::where('nama_mobil', $sewa->nama_mobil)->lockForUpdate()->first();
                if ($mobil && $mobil->status === 'MAINTENANCE') {
                    throw ValidationException::withMessages(['transaksi' => 'Mobil sedang dalam maintenance.']);
                }

                $hasConflict = Sewa::hasOverlap(
                    'mobil',
                    $sewa->nama_mobil,
                    $sewa->tanggal_pinjam,
                    $sewa->tanggal_kembali
                ) && Sewa::where('id', '!=', $sewa->id)
                    ->where('nama_mobil', $sewa->nama_mobil)
                    ->where('verifikasi', 'DITERIMA')
                    ->exists();

                if ($hasConflict) {
                    throw ValidationException::withMessages(['transaksi' => 'Mobil sudah dirental pada rentang waktu tersebut oleh transaksi lain.']);
                }

                if ($mobil) {
                    $mobil->status = 'DISEWA';
                    $mobil->save();
                }

                Supir::where('nama', $sewa->nama_supir)
                    ->where('status', '!=', 'MAINTENANCE')
                    ->update(['status' => 'DISEWA']);

                $sewa->verifikasi = 'DITERIMA';
                $sewa->save();
            });
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        ActivityLog::log('transaksi', 'approve', 'Menyetujui transaksi #' . $sewa->no_invoice . ' - ' . $sewa->nama_customer);

        return redirect()->back()->with('success', 'Transaksi Diterima');
    }

    public function reject_transaksi($id)
    {
        $status = Sewa::find($id);

        if (! $status) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        if ($status->verifikasi !== 'Requested') {
            return redirect()->back()->with('error', 'Transaksi sudah diproses.');
        }

        $status->verifikasi = 'DITOLAK';
        $status->save();

        ActivityLog::log('transaksi', 'reject', 'Menolak transaksi #' . $status->no_invoice . ' - ' . $status->nama_customer);

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
