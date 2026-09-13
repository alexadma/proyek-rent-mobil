<?php

namespace App\Services;

use App\Models\Sewa;
use Illuminate\Support\Facades\DB;

class LaporanService
{
    /**
     * Get all dashboard data for laporan page.
     */
    public function getDashboardData(): array
    {
        return [
            'totalAll' => Sewa::count(),
            'totalRequested' => Sewa::where('verifikasi', 'Requested')->count(),
            'totalDiterima' => Sewa::where('verifikasi', 'DITERIMA')->count(),
            'totalSelesai' => Sewa::where('verifikasi', 'SELESAI')->count(),
            'totalDitolak' => Sewa::where('verifikasi', 'DITOLAK')->count(),
            'pendapatanTotal' => $this->getPendapatan(),
            'pendapatanDiterima' => $this->getPendapatan('DITERIMA'),
            'pendapatanSelesai' => $this->getPendapatan('SELESAI'),
            'pendapatanPerMobil' => $this->getPendapatanPerMobil(),
            'pendapatanPerSupir' => $this->getPendapatanPerSupir(),
            'transaksiTerbaru' => Sewa::orderBy('created_at', 'desc')->limit(10)->get(),
            'pendapatanBulanan' => $this->getPendapatanBulanan(),
        ];
    }

    private function getPendapatan(?string $status = null): float
    {
        $query = Sewa::whereIn('verifikasi', ['DITERIMA', 'SELESAI']);

        if ($status) {
            $query = Sewa::where('verifikasi', $status);
        }

        return (float) $query->sum('total_biaya');
    }

    private function getPendapatanPerMobil()
    {
        return Sewa::whereIn('verifikasi', ['DITERIMA', 'SELESAI'])
            ->select('nama_mobil', DB::raw('SUM(total_biaya) as total'), DB::raw('COUNT(*) as jumlah'))
            ->groupBy('nama_mobil')
            ->orderByDesc('total')
            ->get();
    }

    private function getPendapatanPerSupir()
    {
        return Sewa::whereIn('verifikasi', ['DITERIMA', 'SELESAI'])
            ->where('nama_supir', '!=', 'TANPA SUPIR')
            ->select('nama_supir', DB::raw('SUM(total_biaya) as total'), DB::raw('COUNT(*) as jumlah'))
            ->groupBy('nama_supir')
            ->orderByDesc('total')
            ->get();
    }

    private function getPendapatanBulanan()
    {
        return Sewa::whereIn('verifikasi', ['DITERIMA', 'SELESAI'])
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
    }
}
