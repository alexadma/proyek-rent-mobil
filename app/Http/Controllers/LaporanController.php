<?php

namespace App\Http\Controllers;

use App\Services\LaporanService;

class LaporanController extends Controller
{
    public function __construct(
        private LaporanService $laporanService
    ) {}

    public function index()
    {
        return view('admin.laporan', array_merge(
            ['title' => 'Laporan'],
            $this->laporanService->getDashboardData()
        ));
    }
}
