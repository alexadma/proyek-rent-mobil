@extends('layouts.mainadmin')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --gold: #C9A84C;
        --gold-light: #F0D080;
        --gold-dim: rgba(201,168,76,0.12);
        --gold-glow: rgba(201,168,76,0.25);
        --dark: #0A0A0A;
        --dark-2: #111111;
        --dark-3: #1A1A1A;
        --dark-4: #222222;
        --border: rgba(201,168,76,0.15);
        --border-light: rgba(201,168,76,0.08);
        --text-muted: #888;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
    }

    body {
        background: var(--dark);
        font-family: 'DM Sans', sans-serif;
        margin: 0;
        color: #fff;
    }

    .log-wrap {
        min-height: 100vh;
        background: var(--dark);
        padding: 2.5rem 1.5rem;
    }

    /* HEADER */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.8rem;
        font-weight: 800;
        color: #fff;
        display: flex;
        align-items: center;
        gap: .7rem;
    }
    .page-title i {
        color: var(--gold);
        font-size: 1.5rem;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .6rem 1.2rem;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 12px;
        color: var(--gold);
        font-size: .85rem;
        text-decoration: none;
        transition: .25s;
    }
    .btn-back:hover {
        background: var(--gold-dim);
        border-color: var(--gold);
    }

    /* FILTER CARD */
    .filter-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
    }
    .filter-title {
        font-family: 'Syne', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--gold);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: .5rem;
    }
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }
    .filter-group label {
        display: block;
        font-size: .75rem;
        color: var(--text-muted);
        margin-bottom: .35rem;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .filter-group select,
    .filter-group input {
        width: 100%;
        padding: .6rem .9rem;
        background: var(--dark-3);
        border: 1px solid var(--border);
        border-radius: 10px;
        color: #fff;
        font-size: .85rem;
        outline: none;
        transition: .25s;
    }
    .filter-group select:focus,
    .filter-group input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 2px var(--gold-dim);
    }
    .filter-group select option {
        background: var(--dark-3);
        color: #fff;
    }
    .filter-actions {
        display: flex;
        gap: .6rem;
        align-items: end;
    }
    .btn-filter {
        padding: .6rem 1.4rem;
        background: var(--gold);
        color: var(--dark);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: .85rem;
        cursor: pointer;
        transition: .25s;
        white-space: nowrap;
    }
    .btn-filter:hover {
        background: var(--gold-light);
        transform: translateY(-1px);
    }
    .btn-reset {
        padding: .6rem 1rem;
        background: transparent;
        color: var(--text-muted);
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: .85rem;
        cursor: pointer;
        transition: .25s;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-reset:hover {
        color: #fff;
        border-color: var(--text-muted);
    }

    /* ACTIVITIES TABLE */
    .log-card {
        background: var(--dark-2);
        border: 1px solid var(--border);
        border-radius: 20px;
        overflow: hidden;
    }
    .log-card-header {
        padding: 1.2rem 2rem;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .log-card-header h3 {
        font-family: 'Syne', sans-serif;
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        color: #fff;
    }
    .log-count {
        font-size: .8rem;
        color: var(--text-muted);
    }

    .log-table {
        width: 100%;
        border-collapse: collapse;
    }
    .log-table th {
        text-align: left;
        padding: .9rem 1.5rem;
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-light);
        background: var(--dark-3);
    }
    .log-table td {
        padding: 1rem 1.5rem;
        font-size: .85rem;
        border-bottom: 1px solid var(--border-light);
        vertical-align: middle;
    }
    .log-table tr:last-child td {
        border-bottom: none;
    }
    .log-table tr:hover td {
        background: rgba(201,168,76,0.03);
    }

    /* BADGES */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .3rem .7rem;
        border-radius: 20px;
        font-size: .72rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .badge-success { background: rgba(16,185,129,0.15); color: var(--success); }
    .badge-info { background: rgba(59,130,246,0.15); color: var(--info); }
    .badge-warning { background: rgba(245,158,11,0.15); color: var(--warning); }
    .badge-danger { background: rgba(239,68,68,0.15); color: var(--danger); }
    .badge-secondary { background: rgba(136,136,136,0.15); color: var(--text-muted); }

    .type-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        flex-shrink: 0;
    }
    .type-mobil { background: rgba(201,168,76,0.12); color: var(--gold); }
    .type-supir { background: rgba(59,130,246,0.12); color: var(--info); }
    .type-transaksi { background: rgba(16,185,129,0.12); color: var(--success); }

    .log-desc { color: #ddd; line-height: 1.4; }
    .log-desc strong { color: #fff; }
    .log-time { color: var(--text-muted); font-size: .78rem; }
    .log-user { color: var(--text-muted); font-size: .78rem; }

    /* EMPTY STATE */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--border);
    }
    .empty-state p {
        font-size: .9rem;
    }

    /* PAGINATION */
    .pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        gap: .3rem;
    }
    .pagination-wrap a,
    .pagination-wrap span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 .6rem;
        border-radius: 10px;
        font-size: .82rem;
        font-weight: 500;
        text-decoration: none;
        transition: .25s;
    }
    .pagination-wrap a {
        background: var(--dark-3);
        border: 1px solid var(--border);
        color: #ccc;
    }
    .pagination-wrap a:hover {
        background: var(--gold-dim);
        border-color: var(--gold);
        color: var(--gold);
    }
    .pagination-wrap .active span {
        background: var(--gold);
        color: var(--dark);
        font-weight: 700;
    }
    .pagination-wrap .disabled span {
        color: var(--text-muted);
        opacity: .4;
    }

    @media (max-width: 768px) {
        .log-wrap { padding: 1.5rem 1rem; }
        .page-title { font-size: 1.3rem; }
        .filter-grid { grid-template-columns: 1fr; }
        .log-table { font-size: .8rem; }
        .log-table th, .log-table td { padding: .7rem 1rem; }
    }
</style>
@endsection

@section('container')
<div class="log-wrap">
    <!-- HEADER -->
    <div class="page-header">
        <div class="page-title">
            <i class="fas fa-clipboard-list"></i>
            Log Aktivitas
        </div>
        <a href="{{ route('home.admin') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- FILTER -->
    <div class="filter-card">
        <div class="filter-title">
            <i class="fas fa-filter"></i> Filter Aktivitas
        </div>
        <form action="{{ route('activity-log') }}" method="GET">
            <div class="filter-grid">
                <div class="filter-group">
                    <label>Cari</label>
                    <input type="text" name="search" placeholder="Cari aktivitas..." value="{{ request('search') }}">
                </div>
                <div class="filter-group">
                    <label>Tipe</label>
                    <select name="type">
                        <option value="">Semua Tipe</option>
                        <option value="mobil" {{ request('type') === 'mobil' ? 'selected' : '' }}>🚗 Mobil</option>
                        <option value="supir" {{ request('type') === 'supir' ? 'selected' : '' }}>👤 Supir</option>
                        <option value="transaksi" {{ request('type') === 'transaksi' ? 'selected' : '' }}>📄 Transaksi</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Aksi</label>
                    <select name="action">
                        <option value="">Semua Aksi</option>
                        <option value="create" {{ request('action') === 'create' ? 'selected' : '' }}>Tambah</option>
                        <option value="update" {{ request('action') === 'update' ? 'selected' : '' }}>Update</option>
                        <option value="delete" {{ request('action') === 'delete' ? 'selected' : '' }}>Hapus</option>
                        <option value="approve" {{ request('action') === 'approve' ? 'selected' : '' }}>Setujui</option>
                        <option value="reject" {{ request('action') === 'reject' ? 'selected' : '' }}>Tolak</option>
                        <option value="return" {{ request('action') === 'return' ? 'selected' : '' }}>Pengembalian</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="filter-group">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('activity-log') }}" class="btn-reset">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- ACTIVITY LIST -->
    <div class="log-card">
        <div class="log-card-header">
            <h3><i class="fas fa-history" style="color:var(--gold);margin-right:.5rem;"></i> Semua Aktivitas</h3>
            <span class="log-count">Menampilkan {{ $activities->count() }} dari {{ $activities->total() }} aktivitas</span>
        </div>

        @if($activities->isEmpty())
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>Belum ada aktivitas yang cocok dengan filter.</p>
            </div>
        @else
            <table class="log-table">
                <thead>
                    <tr>
                        <th style="width:50px;"></th>
                        <th>Aktivitas</th>
                        <th style="width:120px;">Tipe</th>
                        <th style="width:120px;">Aksi</th>
                        <th style="width:180px;">Waktu</th>
                        <th style="width:100px;">User</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $log)
                        @php
                            $type = $log->type;
                            $action = $log->action;

                            // Icon class
                            if ($type === 'mobil') {
                                $typeIcon = 'fa-car';
                                $typeClass = 'type-mobil';
                                $typeName = 'Mobil';
                            } elseif ($type === 'supir') {
                                $typeIcon = 'fa-user';
                                $typeClass = 'type-supir';
                                $typeName = 'Supir';
                            } else {
                                $typeIcon = 'fa-file-invoice';
                                $typeClass = 'type-transaksi';
                                $typeName = 'Transaksi';
                            }

                            // Badge
                            if ($action === 'create') {
                                $badgeClass = 'badge-success';
                                $actionText = 'Tambah';
                                $actionIcon = 'fa-plus';
                            } elseif ($action === 'update') {
                                $badgeClass = 'badge-info';
                                $actionText = 'Update';
                                $actionIcon = 'fa-pen';
                            } elseif ($action === 'delete') {
                                $badgeClass = 'badge-danger';
                                $actionText = 'Hapus';
                                $actionIcon = 'fa-trash';
                            } elseif ($action === 'approve') {
                                $badgeClass = 'badge-success';
                                $actionText = 'Setujui';
                                $actionIcon = 'fa-check';
                            } elseif ($action === 'reject') {
                                $badgeClass = 'badge-danger';
                                $actionText = 'Tolak';
                                $actionIcon = 'fa-times';
                            } elseif ($action === 'return') {
                                $badgeClass = 'badge-warning';
                                $actionText = 'Pengembalian';
                                $actionIcon = 'fa-undo';
                            } else {
                                $badgeClass = 'badge-secondary';
                                $actionText = ucfirst($action);
                                $actionIcon = 'fa-info';
                            }

                            $timeDiff = $log->created_at->diffForHumans();
                            $fullDate = $log->created_at->format('d M Y, H:i');
                        @endphp
                        <tr>
                            <td>
                                <div class="type-icon {{ $typeClass }}">
                                    <i class="fas {{ $typeIcon }}"></i>
                                </div>
                            </td>
                            <td>
                                <div class="log-desc">{{ $log->description }}</div>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $typeName }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $badgeClass }}">
                                    <i class="fas {{ $actionIcon }}"></i> {{ $actionText }}
                                </span>
                            </td>
                            <td>
                                <div class="log-time" title="{{ $fullDate }}">
                                    <i class="far fa-clock"></i> {{ $timeDiff }}
                                </div>
                            </td>
                            <td>
                                <div class="log-user">
                                    <i class="fas fa-user-shield"></i> {{ $log->user ?? 'Admin' }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="pagination-wrap">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
