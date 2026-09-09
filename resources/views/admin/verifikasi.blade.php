@extends('layouts.mainverifikasi')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<style>
    :root {
        --gold: #C9A84C;
        --green: #22c55e;
        --red: #ef4444;
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

    /* PENDING BADGE */
    .pending-badge {
        display: inline-flex; align-items: center; gap: .5rem;
        background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.25);
        color: #fca5a5; border-radius: 50px; padding: .3rem .9rem;
        font-size: .78rem; font-weight: 600; margin-top: .8rem;
    }
    .pending-dot {
        width: 6px; height: 6px; background: #ef4444; border-radius: 50%;
        animation: blink 1.2s ease-in-out infinite;
    }
    @keyframes blink { 0%,100% { opacity:1; } 50% { opacity:.2; } }

    /* TABLE CARD */
    .table-card {
        background: var(--dark-2); border: 1px solid var(--border);
        border-radius: 24px; overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    }
    .table-card-header {
        padding: 1.4rem 1.8rem; border-bottom: 1px solid var(--border);
        background: linear-gradient(135deg, #0d0a00, var(--dark-2));
        display: flex; align-items: center; justify-content: space-between;
    }
    .table-card-title { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: #fff; }

    /* DATATABLES */
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
    #verifikasiTable { width: 100% !important; border-collapse: collapse; }
    #verifikasiTable thead th {
        background: var(--dark-3); color: #666; font-size: .68rem; font-weight: 700;
        letter-spacing: .08em; text-transform: uppercase;
        padding: .9rem 1rem; border-bottom: 1px solid var(--border); white-space: nowrap;
    }
    #verifikasiTable tbody tr { border-bottom: 1px solid rgba(255,255,255,0.04); transition: .15s; }
    #verifikasiTable tbody tr:hover { background: rgba(201,168,76,0.03); }
    #verifikasiTable tbody td { padding: .85rem 1rem; color: #bbb; font-size: .84rem; vertical-align: middle; }

    .invoice-tag {
        font-size: .75rem; color: #60a5fa; background: rgba(96,165,250,0.1);
        padding: .25rem .6rem; border-radius: 6px; font-family: monospace; display: inline-block;
    }
    .customer-main { color: #fff; font-weight: 500; }
    .customer-phone { font-size: .73rem; color: #555; margin-top: 2px; }
    .car-info { color: #ddd; font-weight: 500; }
    .car-plate { font-size: .73rem; color: #555; font-weight: 600; }
    .amount-text { color: #22c55e; font-weight: 600; }

    /* BUKTI */
    .bukti-thumb {
        width: 52px; height: 40px; object-fit: cover;
        border-radius: 8px; border: 1px solid var(--border);
        cursor: pointer; transition: .2s;
    }
    .bukti-thumb:hover { transform: scale(1.1); border-color: var(--gold); }

    /* STATUS PILL */
    .status-pill { padding: .28rem .75rem; border-radius: 50px; font-size: .72rem; font-weight: 600; white-space: nowrap; }
    .status-approved { background: rgba(34,197,94,.12); color: #4ade80; }
    .status-pending  { background: rgba(234,179,8,.12); color: #fbbf24; }
    .status-rejected { background: rgba(239,68,68,.12); color: #f87171; }

    /* ACTION BUTTONS */
    .btn-group-action { display: flex; gap: .5rem; align-items: center; flex-wrap: nowrap; }
    .btn-terima {
        display: inline-flex; align-items: center; gap: .3rem;
        background: linear-gradient(135deg, #16a34a, #166534);
        color: #fff; padding: .35rem .85rem; border-radius: 50px;
        font-size: .74rem; font-weight: 700; text-decoration: none; transition: .2s;
        white-space: nowrap;
    }
    .btn-terima:hover { transform: scale(1.05); color: #fff; text-decoration: none; box-shadow: 0 4px 16px rgba(22,163,74,.3); }
    .btn-tolak {
        display: inline-flex; align-items: center; gap: .3rem;
        background: linear-gradient(135deg, #dc2626, #991b1b);
        color: #fff; padding: .35rem .85rem; border-radius: 50px;
        font-size: .74rem; font-weight: 700; text-decoration: none; transition: .2s;
        white-space: nowrap;
    }
    .btn-tolak:hover { transform: scale(1.05); color: #fff; text-decoration: none; box-shadow: 0 4px 16px rgba(220,38,38,.3); }

    @media(max-width: 768px) { .page-wrap { padding: 1.5rem 1rem; } }

    @keyframes fadeUp {
        from { opacity:0; transform: translateY(16px); }
        to   { opacity:1; transform: translateY(0); }
    }
</style>
@endsection

@section('container')
<div class="page-wrap">
    <div class="page-header">
        <div class="page-eyebrow">Admin</div>
        <h1 class="page-title">Verifikasi Transaksi</h1>
        <p class="page-sub">Tinjau dan konfirmasi setiap permintaan sewa yang masuk</p>
        <div class="pending-badge">
            <span class="pending-dot"></span>
            {{ $transaksi->count() }} menunggu verifikasi
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">🔍 Antrian Verifikasi</div>
        </div>
        <div style="overflow-x: auto;">
            <table id="verifikasiTable">
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
                        <th>Bukti TF</th>
                        <th>Status</th>
                        <th>Terima</th>
                        <th>Tolak</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi as $data)
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
                        <td style="color:#aaa;">{{ $data->tanggal_pinjam }}</td>
                        <td style="color:#aaa;">{{ $data->tanggal_kembali }}</td>
                        <td>{{ $data->jaminan }}</td>
                        <td><span class="amount-text">Rp {{ number_format($data->total_biaya, 0, ',', '.') }}</span></td>
                        <td>
                            @if($data->bukti)
                            <a href="{{ asset('storage/' . $data->bukti) }}" target="_blank">
                                <img src="{{ asset('storage/' . $data->bukti) }}" alt="Bukti" class="bukti-thumb">
                            </a>
                            @else
                            <span style="color:#555;">Belum upload</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $v = strtolower($data->verifikasi ?? '');
                                $cls = in_array($v, ['diterima', 'approved', 'selesai']) ? 'status-approved' : (in_array($v, ['ditolak', 'rejected']) ? 'status-rejected' : 'status-pending');
                            @endphp
                            <span class="status-pill {{ $cls }}">{{ $data->verifikasi }}</span>
                        </td>
                        <td>
                            <a onclick="return confirm('Yakin TERIMA transaksi ini?')"
                               href="{{ url('approve_transaksi', $data->id) }}"
                               class="btn-terima">✓ Terima</a>
                        </td>
                        <td>
                            <a onclick="return confirm('Yakin TOLAK transaksi ini?')"
                               href="{{ url('reject_transaksi', $data->id) }}"
                               class="btn-tolak">✕ Tolak</a>
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
    $('#verifikasiTable').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        "language": {
            "lengthMenu": "Tampilkan _MENU_",
            "zeroRecords": "Tidak ada data menunggu verifikasi",
            "info": "_START_–_END_ dari _TOTAL_",
            "search": "Cari:",
            "paginate": { "previous": "‹", "next": "›" }
        }
    });
});
</script>
@endsection