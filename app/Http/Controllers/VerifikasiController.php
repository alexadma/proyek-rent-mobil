<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Supir;
use App\Models\Verifikasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VerifikasiController extends Controller
{
    public function index()
    {
        return view('admin/verifikasi', [
            'title' => 'Verifikasi',
            'transaksi' => Verifikasi::where('verifikasi', 'Requested')->get(),
        ]);
    }

    public function approve_transaksi($id)
    {
        $transaksi = Verifikasi::find($id);

        if (! $transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        if ($transaksi->verifikasi !== 'Requested') {
            return redirect()->back()->with('error', 'Transaksi sudah diproses.');
        }

        try {
            DB::transaction(function () use ($id) {
                $sewa = Verifikasi::where('id', $id)->lockForUpdate()->first();

                if ($sewa->verifikasi !== 'Requested') {
                    throw ValidationException::withMessages(['transaksi' => 'Transaksi sudah diproses.']);
                }

                $mobil = Mobil::where('nama_mobil', $sewa->nama_mobil)->lockForUpdate()->first();
                if ($mobil && $mobil->status === 'MAINTENANCE') {
                    throw ValidationException::withMessages(['transaksi' => 'Mobil sedang dalam maintenance.']);
                }

                $hasConflict = Verifikasi::where('id', '!=', $sewa->id)
                    ->where('nama_mobil', $sewa->nama_mobil)
                    ->whereIn('verifikasi', ['DITERIMA'])
                    ->where(function ($q) use ($sewa) {
                        $q->whereBetween('tanggal_pinjam', [$sewa->tanggal_pinjam, $sewa->tanggal_kembali])
                            ->orWhereBetween('tanggal_kembali', [$sewa->tanggal_pinjam, $sewa->tanggal_kembali])
                            ->orWhere(function ($q2) use ($sewa) {
                                $q2->where('tanggal_pinjam', '<=', $sewa->tanggal_pinjam)
                                    ->where('tanggal_kembali', '>=', $sewa->tanggal_kembali);
                            });
                    })->exists();

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

        return redirect()->back()->with('success', 'Transaksi Diterima');
    }

    public function reject_transaksi($id)
    {
        $status = Verifikasi::find($id);

        if (! $status) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        if ($status->verifikasi !== 'Requested') {
            return redirect()->back()->with('error', 'Transaksi sudah diproses.');
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
