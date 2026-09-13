@extends('layouts.mainadmin')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --gold: #C9A84C;
        --gold-light: #F0D080;
        --gold-dim: rgba(201,168,76,0.12);
        --dark: #0A0A0A;
        --dark-2: #111111;
        --dark-3: #1A1A1A;
        --dark-4: #222222;
        --border: rgba(201,168,76,0.15);
        --text-muted: #888;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
    }
    body { background: var(--dark); font-family: 'DM Sans', sans-serif; color: #fff; }

    .lap-wrap { padding: 2rem 1.5rem; max-width: 1100px; }
    .lap-title {
        font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 800;
        color: #fff; margin-bottom: 1.5rem;
    }
    .lap-title .accent { color: var(--gold); }

    .lap-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 2rem; }
    .lap-card {
        background: var(--dark-2); border: 1px solid var(--border); border-radius: 16px;
        padding: 1.25rem; text-align: center;
    }
    .lap-card .num { font-size: 1.8rem; font-weight: 800; font-family: 'Syne', sans-serif; }
    .lap-card .label { font-size: .75rem; color: var(--text-muted); margin-top: .3rem; text-transform: uppercase; letter-spacing: .05em; }
    .lap-card.gold .num { color: var(--gold); }
    .lap-card.green .num { color: var(--success); }
    .lap-card.blue .num { color: var(--info); }
    .lap-card.red .num { color: var(--danger); }

    .lap-section {
        background: var(--dark-2); border: 1px solid var(--border); border-radius: 16px;
        padding: 1.5rem; margin-bottom: 1.5rem;
    }
    .lap-section h3 {
        font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700;
        color: var(--gold); margin-bottom: 1rem;
        display: flex; align-items: center; gap: .5rem;
    }

    .lap-table { width: 100%; border-collapse: collapse; }
    .lap-table th {
        text-align: left; padding: .6rem .8rem; font-size: .7rem;
        text-transform: uppercase; letter-spacing: .08em; color: var(--text-muted);
        border-bottom: 1px solid var(--border);
    }
    .lap-table td {
        padding: .65rem .8rem; font-size: .85rem; color: #ddd;
        border-bottom: 1px solid rgba(255,255,255,0.04);
    }
    .lap-table tr:hover td { background: rgba(201,168,76,0.04); }
    .lap-table .text-right { text-align: right; }

    .badge {
        padding: .2rem .55rem; border-radius: 6px; font-size: .7rem; font-weight: 600;
    }
    .badge-requested { background: rgba(245,158,11,0.12); color: var(--warning); }
    .badge-diterima { background: rgba(16,185,129,0.12); color: var(--success); }
    .badge-selesai { background: rgba(59,130,246,0.12); color: var(--info); }
    .badge-ditolak { background: rgba(239,68,68,0.12); color: var(--danger); }

    .gold-text { color: var(--gold); font-weight: 700; }

    @media (max-width: 768px) {
        .lap-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .lap-grid { grid-template-columns: 1fr; }
        .lap-wrap { padding: 1rem; }
    }
</style>
@endsection

@section('container')
<div class="lap-wrap">
    <div class="lap-title"><i class="fas fa-chart-pie" style="color: var(--gold);"></i> <span class="accent">Laporan</span> Transaksi</div>

    <!-- Summary Cards -->
    <div class="lap-grid">
        <div class="lap-card gold">
            <div class="num">{{ $totalAll }}</div>
            <div class="label">Total Transaksi</div>
        </div>
        <div class="lap-card green">
            <div class="num">Rp {{ number_format($pendapatanTotal / 1000000, 1, ',', '.') }}jt</div>
            <div class="label">Total Pendapatan</div>
        </div>
        <div class="lap-card blue">
            <div class="num">{{ $totalSelesai }}</div>
            <div class="label">Selesai</div>
        </div>
        <div class="lap-card red">
            <div class="num">{{ $totalDitolak }}</div>
            <div class="label">Ditolak</div>
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="lap-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="lap-card">
            <div class="num" style="color: var(--warning);">{{ $totalRequested }}</div>
            <div class="label">Menunggu Verifikasi</div>
        </div>
        <div class="lap-card">
            <div class="num" style="color: var(--success);">{{ $totalDiterima }}</div>
            <div class="label">Sedang Disewa</div>
        </div>
        <div class="lap-card">
            <div class="num" style="color: var(--info);">{{ $totalSelesai }}</div>
            <div class="label">Selesai</div>
        </div>
    </div>

    <!-- Pendapatan per Mobil -->
    @if($pendapatanPerMobil->isNotEmpty())
    <div class="lap-section">
        <h3><i class="fas fa-car"></i> Pendapatan per Mobil</h3>
        <table class="lap-table">
            <thead>
                <tr>
                    <th>Mobil</th>
                    <th>Jumlah Sewa</th>
                    <th class="text-right">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendapatanPerMobil as $pm)
                <tr>
                    <td><strong>{{ $pm->nama_mobil }}</strong></td>
                    <td>{{ $pm->jumlah }}x</td>
                    <td class="text-right gold-text">Rp {{ number_format($pm->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Pendapatan per Supir -->
    @if($pendapatanPerSupir->isNotEmpty())
    <div class="lap-section">
        <h3><i class="fas fa-user"></i> Pendapatan per Supir</h3>
        <table class="lap-table">
            <thead>
                <tr>
                    <th>Supir</th>
                    <th>Jumlah Sewa</th>
                    <th class="text-right">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendapatanPerSupir as $ps)
                <tr>
                    <td><strong>{{ $ps->nama_supir }}</strong></td>
                    <td>{{ $ps->jumlah }}x</td>
                    <td class="text-right gold-text">Rp {{ number_format($ps->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Transaksi Terbaru -->
    <div class="lap-section">
        <h3><i class="fas fa-history"></i> Transaksi Terbaru</h3>
        <table class="lap-table">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Customer</th>
                    <th>Mobil</th>
                    <th>Supir</th>
                    <th>Pickup</th>
                    <th>Return</th>
                    <th>Status</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiTerbaru as $t)
                <tr>
                    <td><strong>#{{ $t->no_invoice }}</strong></td>
                    <td>{{ $t->nama_customer }}</td>
                    <td>{{ $t->nama_mobil }}</td>
                    <td>{{ $t->nama_supir }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d/m/Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal_kembali)->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($t->verifikasi === 'Requested')
                            <span class="badge badge-requested">Menunggu</span>
                        @elseif($t->verifikasi === 'DITERIMA')
                            <span class="badge badge-diterima">Diterima</span>
                        @elseif($t->verifikasi === 'SELESAI')
                            <span class="badge badge-selesai">Selesai</span>
                        @elseif($t->verifikasi === 'DITOLAK')
                            <span class="badge badge-ditolak">Ditolak</span>
                        @else
                            <span class="badge">{{ $t->verifikasi }}</span>
                        @endif
                    </td>
                    <td class="text-right gold-text">Rp {{ number_format($t->total_biaya, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
