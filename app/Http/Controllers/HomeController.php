<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Mobil;
use App\Models\Sewa;
use App\Models\Supir;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('customer.home');
    }

    /**
     * Show the admin dashboard with real data.
     *
     * @return Renderable
     */
    public function adminHome()
    {
        // Stats
        $totalMobil = Mobil::count();
        $mobilTersedia = Mobil::where('status', 'TERSEDIA')->count();
        $totalSupir = Supir::where('status', 'TERSEDIA')->count();
        $totalTransaksi = Sewa::count();
        $transaksiPending = Sewa::where('verifikasi', 'Requested')->count();
        $transaksiDiterima = Sewa::whereIn('verifikasi', ['DITERIMA', 'SELESAI'])->count();
        $totalPendapatan = Sewa::whereIn('verifikasi', ['DITERIMA', 'SELESAI'])->sum('total_biaya');

        // Recent activities — 8 aktivitas terbaru (gabungan transaksi + CRUD)
        $recentActivities = ActivityLog::orderBy('created_at', 'desc')->limit(8)->get();

        return view('admin.home', [
            'totalMobil' => $totalMobil,
            'mobilTersedia' => $mobilTersedia,
            'totalSupir' => $totalSupir,
            'totalTransaksi' => $totalTransaksi,
            'transaksiPending' => $transaksiPending,
            'transaksiDiterima' => $transaksiDiterima,
            'totalPendapatan' => $totalPendapatan,
            'recentActivities' => $recentActivities,
        ]);
    }
}
