@extends('layouts.mainverifikasi')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<style>
    :root {
        --gold: #C9A84C;
        --yellow: #eab308;
        --dark: #0A0A0A;
        --dark-2: #111111;
        --dark-3: #1A1A1A;
        --border: rgba(201,168,76,0.15);
        --text-muted: #555;
    }
    body { background: var(--dark); font-family: 'DM Sans', sans-serif; }

    .page-wrap { padding: 2rem 1.5rem; animation: fadeUp .5s ease both; }
    
    .page-header { margin-bottom: 2rem; }
    .page-eyebrow {
        font-size: .65rem; font-weight: 700; letter-spacing: .16em;
        color: var(--gold); text-transform: uppercase; margin-bottom: .5rem;
        display: flex; align-items: center; gap: .5rem;
    }
    .page-eyebrow::before { content: ''; width: 20px; height: 1px; background: var(--gold); }
    .page-title {
        font-family: 'Syne', sans-serif; font-size: clamp(1.5rem, 4vw, 2.2rem);
        font-weight: 800; color: #fff; margin: 0;
    }
    .page-sub { color: var(--text-muted); font-size: .88rem; margin-top: .4rem; }

    /* Count badge */
    .count-badge {
        display: inline-flex; align-items: center; gap: .5rem;
        background: rgba(234,179,8,0.1); border: 1px solid rgba(234,179,8,0.25);
        color: var(--yellow); border-radius: 50px; padding: .3rem .9rem;
        font-size: .78rem; font-weight: 600; margin-top: .8rem;
    }
    .count-dot { width: 6px; height: 6px; background: var(--yellow); border-radius: 50%; }

    /* TABLE CARD */
    .table-card {
        background: var(--dark-2); border: 1px solid var(--border);
        border-radius: 24px; overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    }
    .table-card-header {
        padding: 1.4rem 1.8rem; border-bottom: 1px solid var(--border);
        background: linear-gradient(135deg, #141201, var(--dark-2));
    }
    .table-card-title {
        font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: #fff;
    }

    /* DATATABLES OVERRIDES */
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter { padding: 1rem 1.4rem 0; color: #888 !important; }
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate { padding: .8rem 1.4rem; color: #888 !important; }
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        background: var(--dark-3) !important; color: #fff !important;
        border: 1px solid var(--border) !important; border-radius: 8px !important; padding: .3rem .7rem;
    }
    .dataTables_wrapper .paginate_button { border-radius: 8px !important; color: #888 !important; }
    .dataTables_wrapper .paginate_button.current,
    .dataTables_wrapper .paginate_button:hover {
        background: var(--gold) !important; border-color: var(--gold) !important; color: #000 !important;
    }

    /* TABLE */
    #pengembalianTable { width: 100% !important; border-collapse: collapse; }
    #pengembalianTable thead th {
        background: var(--dark-3); color: #666; font-size: .7rem; font-weight: 700;
        letter-spacing: .08em; text-transform: uppercase;
        padding: .9rem 1rem; border-bottom: 1px solid var(--border); white-space: nowrap;
    }
    #pengembalianTable tbody tr { border-bottom: 1px solid rgba(255,255,255,0.04); transition: .15s; }
    #pengembalianTable tbody tr:hover { background: rgba(201,168,76,0.04); }
    #pengembalianTable tbody td { padding: .85rem 1rem; color: #bbb; font-size: .85rem; vertical-align: middle; }

    .invoice-tag {
        font-size: .78rem; color: #60a5fa;
        background: rgba(96,165,250,0.1); padding: .25rem .6rem;
        border-radius: 6px; display: inline-block; font-family: monospace;
    }
    .customer-main { color: #fff; font-weight: 500; }
    .customer-phone { font-size: .75rem; color: #555; margin-top: 1px; }
    .car-info { color: #ddd; }
    .car-plate { font-size: .75rem; color: #666; font-weight: 600; }
    .amount-text { color: #22c55e; font-weight: 600; }
    .date-text { color: #aaa; }

    /* BUKTI */
    .bukti-thumb {
        width: 52px; height: 40px; object-fit: cover;
        border-radius: 8px; border: 1px solid var(--border);
        cursor: pointer; transition: .2s;
    }
    .bukti-thumb:hover { transform: scale(1.1); border-color: var(--gold); }

    /* STATUS */
    .status-pill {
        padding: .28rem .75rem; border-radius: 50px; font-size: .72rem; font-weight: 600;
        display: inline-block; white-space: nowrap;
    }
    .status-approved  { background: rgba(34,197,94,.12); color: #4ade80; }
    .status-pending   { background: rgba(234,179,8,.12); color: #fbbf24; }
    .status-rejected  { background: rgba(239,68,68,.12); color: #f87171; }

    /* ACTION BUTTON */
    .btn-done {
        display: inline-block;
        background: linear-gradient(135deg, #eab308, #a16207);
        color: #000; padding: .35rem .9rem; border-radius: 50px;
        font-size: .75rem; font-weight: 700; text-decoration: none;
        transition: .2s; white-space: nowrap;
    }
    .btn-done:hover { transform: scale(1.05); color: #000; text-decoration: none; }

    @media(max-width: 768px) {
        .page-wrap { padding: 1.5rem 1rem; }
    }
    @keyframes fadeUp {
        from { opacity:0; transform: translateY(16px); }
        to   { opacity:1; transform: translateY(0); }
    }
</style>
@endsection

@section('container')
<div class="page-wrap">
    <div class="page-header">
        <div class="page-eyebrow">Manajemen</div>
        <h1 class="page-title">Pengembalian Kendaraan</h1>
        <p class="page-sub">Daftar transaksi aktif yang menunggu konfirmasi kembali</p>
        <div class="count-badge">
            <span class="count-dot"></span>
            {{ $status->count() }} kendaraan belum kembali
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">📋 Daftar Pengembalian</div>
        </div>
        <div style="overflow-x: auto;">
            <table id="pengembalianTable">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Kendaraan</th>
                        <th>Driver</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Jaminan</th>
                        <th>Total</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($status as $data)
                    <tr>
                        <td><span class="invoice-tag">{{ $data->no_invoice }}</span></td>
                        <td>
                            <div class="customer-main">{{ $data->nama_customer }}</div>
                            <div class="customer-phone">📞 {{ $data->nohp }}</div>
                        </td>
                        <td>
                            <div class="car-info">{{ $data->nama_mobil }}</div>
                            <div class="car-plate">{{ $data->nopol }}</div>
                        </td>
                        <td>{{ $data->nama_supir }}</td>
                        <td class="date-text">{{ $data->tanggal_pinjam }}</td>
                        <td class="date-text">{{ $data->tanggal_kembali }}</td>
                        <td>{{ $data->jaminan }}</td>
                        <td><span class="amount-text">Rp {{ number_format($data->total_biaya, 0, ',', '.') }}</span></td>
                        <td>
                            <a href="{{ asset('storage/' . $data->bukti) }}" target="_blank">
                                <img src="{{ asset('storage/' . $data->bukti) }}" alt="Bukti" class="bukti-thumb">
                            </a>
                        </td>
                        <td>
                            @php
                                $v = strtolower($data->verifikasi ?? '');
                                $cls = $v == 'approved' ? 'status-approved' : ($v == 'rejected' ? 'status-rejected' : 'status-pending');
                            @endphp
                            <span class="status-pill {{ $cls }}">{{ $data->verifikasi }}</span>
                        </td>
                        <td>
                            <a onclick="return confirm('Konfirmasi kendaraan sudah kembali?')"
                               href="{{ url('pengembalian', $data->id) }}"
                               class="btn-done">✓ Selesai</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#pengembalianTable').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        "language": {
            "lengthMenu": "Tampilkan _MENU_",
            "zeroRecords": "Tidak ada data",
            "info": "_START_–_END_ dari _TOTAL_",
            "search": "Cari:",
            "paginate": { "previous": "‹", "next": "›" }
        }
    });
});
</script>
@endsection