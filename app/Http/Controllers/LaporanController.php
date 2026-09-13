<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Sewa;
use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        // Total transaksi per status
        $totalAll = Sewa::count();
        $totalRequested = Sewa::where('verifikasi', 'Requested')->count();
        $totalDiterima = Sewa::where('verifikasi', 'DITERIMA')->count();
        $totalSelesai = Sewa::where('verifikasi', 'SELESAI')->count();
        $totalDitolak = Sewa::where('verifikasi', 'DITOLAK')->count();

        // Pendapatan
        $pendapatanTotal = Sewa::whereIn('verifikasi', ['DITERIMA', 'SELESAI'])->sum('total_biaya');
        $pendapatanDiterima = Sewa::where('verifikasi', 'DITERIMA')->sum('total_biaya');
        $pendapatanSelesai = Sewa::where('verifikasi', 'SELESAI')->sum('total_biaya');

        // Pendapatan per mobil
        $pendapatanPerMobil = Sewa::whereIn('verifikasi', ['DITERIMA', 'SELESAI'])
            ->select('nama_mobil', DB::raw('SUM(total_biaya) as total'), DB::raw('COUNT(*) as jumlah'))
            ->groupBy('nama_mobil')
            ->orderByDesc('total')
            ->get();

        // Pendapatan per supir
        $pendapatanPerSupir = Sewa::whereIn('verifikasi', ['DITERIMA', 'SELESAI'])
            ->where('nama_supir', '!=', 'TANPA SUPIR')
            ->select('nama_supir', DB::raw('SUM(total_biaya) as total'), DB::raw('COUNT(*) as jumlah'))
            ->groupBy('nama_supir')
            ->orderByDesc('total')
            ->get();

        // Transaksi terbaru
        $transaksiTerbaru = Sewa::orderBy('created_at', 'desc')->limit(10)->get();

        // Pendapatan bulanan (6 bulan terakhir)
        $pendapatanBulanan = Sewa::whereIn('verifikasi', ['DITERIMA', 'SELESAI'])
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan"),
                DB::raw('SUM(total_biaya) as total'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('bulan')
            ->orderByDesc('bulan')
            ->limit(6)
            ->get()
            ->reverse();

        return view('admin.laporan', [
            'title' => 'Laporan',
            'totalAll' => $totalAll,
            'totalRequested' => $totalRequested,
            'totalDiterima' => $totalDiterima,
            'totalSelesai' => $totalSelesai,
            'totalDitolak' => $totalDitolak,
            'pendapatanTotal' => $pendapatanTotal,
            'pendapatanDiterima' => $pendapatanDiterima,
            'pendapatanSelesai' => $pendapatanSelesai,
            'pendapatanPerMobil' => $pendapatanPerMobil,
            'pendapatanPerSupir' => $pendapatanPerSupir,
            'transaksiTerbaru' => $transaksiTerbaru,
            'pendapatanBulanan' => $pendapatanBulanan,
        ]);
    }
}
