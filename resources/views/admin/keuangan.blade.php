@extends('layouts.mainkeuangan')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
    :root {
        --gold: #C9A84C;
        --gold-light: #F0D080;
        --green: #22c55e;
        --blue: #60a5fa;
        --dark: #0A0A0A;
        --dark-2: #111111;
        --dark-3: #1A1A1A;
        --border: rgba(201,168,76,0.15);
        --text-muted: #555;
    }
    body { background: var(--dark); font-family: 'DM Sans', sans-serif; }

    .page-wrap { padding: 2rem 1.5rem 2rem 1.5rem; animation: fadeUp .5s ease both; }

    /* HEADER */
    .page-header { margin-bottom: 2rem; }
    .page-eyebrow {
        font-size: .65rem; font-weight: 700; letter-spacing: .16em;
        color: var(--gold); text-transform: uppercase; margin-bottom: .5rem;
        display: flex; align-items: center; gap: .5rem;
    }
    .page-eyebrow::before { content: ''; width: 20px; height: 1px; background: var(--gold); }
    .page-title {
        font-family: 'Syne', sans-serif; font-size: clamp(1.6rem, 4vw, 2.4rem);
        font-weight: 800; color: #fff; margin: 0;
    }
    .page-sub { color: var(--text-muted); font-size: .88rem; margin-top: .4rem; }

    /* SUMMARY CARDS */
    .summary-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 2rem; }
    .summary-card {
        background: var(--dark-2); border: 1px solid var(--border);
        border-radius: 20px; padding: 1.6rem; position: relative; overflow: hidden;
        transition: .25s;
    }
    .summary-card:hover { border-color: rgba(201,168,76,0.4); transform: translateY(-2px); }
    .summary-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    }
    .summary-card.green::before { background: linear-gradient(90deg, transparent, var(--green), transparent); }
    .summary-card.blue::before  { background: linear-gradient(90deg, transparent, var(--blue), transparent); }

    .summary-label {
        font-size: .68rem; font-weight: 700; letter-spacing: .12em;
        text-transform: uppercase; color: var(--text-muted); margin-bottom: .8rem;
    }
    .summary-value {
        font-family: 'Syne', sans-serif; font-weight: 800; font-size: clamp(1.2rem, 3vw, 1.8rem); line-height: 1;
    }
    .summary-card.green .summary-value { color: var(--green); }
    .summary-card.blue  .summary-value { color: var(--blue); }
    .summary-icon {
        position: absolute; right: 1.4rem; top: 50%; transform: translateY(-50%);
        font-size: 2.4rem; opacity: .12;
    }

    /* TABLE CARD */
    .table-card {
        background: var(--dark-2); border: 1px solid var(--border);
        border-radius: 24px; overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    }
    .table-card-header {
        padding: 1.5rem 1.8rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
    }
    .table-card-title {
        font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; color: #fff;
    }

    /* DATATABLES OVERRIDES — hide sort arrows */
    table.dataTable thead th { position: relative !important; }
    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead th.sorting::after,
    table.dataTable thead th.sorting_asc::after,
    table.dataTable thead th.sorting_desc::after { display: none !important; }
    table.dataTable thead .sorting,
    table.dataTable thead .sorting_asc,
    table.dataTable thead .sorting_desc { background-image: none !important; }
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        background: var(--dark-3) !important; color: #fff !important;
        border: 1px solid var(--border) !important; border-radius: 8px !important;
        padding: .3rem .6rem; outline: none;
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate { color: #888 !important; padding: 1rem 1.8rem; }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #888 !important; border-radius: 8px !important;
        border: 1px solid transparent !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--gold) !important; color: #000 !important;
        border-color: var(--gold) !important;
    }

    /* TABLE */
    #rentalTable { width: 100% !important; border-collapse: collapse; }
    #rentalTable thead tr {
        background: var(--dark-3);
    }
    #rentalTable thead th {
        color: #777; font-size: .72rem; font-weight: 700; letter-spacing: .08em;
        text-transform: uppercase; padding: 1rem 1.2rem;
        border-bottom: 1px solid var(--border); white-space: nowrap;
    }
    #rentalTable tbody tr {
        border-bottom: 1px solid rgba(255,255,255,0.04);
        transition: background .15s;
    }
    #rentalTable tbody tr:hover { background: rgba(201,168,76,0.04); }
    #rentalTable tbody td { padding: .9rem 1.2rem; color: #ccc; font-size: .88rem; vertical-align: middle; }

    .invoice-badge {
        font-family: 'DM Sans', monospace; font-size: .8rem;
        color: var(--blue); background: rgba(96,165,250,0.1);
        padding: .3rem .7rem; border-radius: 6px; display: inline-block;
    }
    .customer-name { color: #fff; font-weight: 500; font-size: .88rem; }
    .car-name { font-size: .75rem; color: #666; margin-top: 2px; }
    .amount { color: var(--green); font-weight: 600; font-family: 'Syne', sans-serif; }

    @media(max-width: 640px) {
        .page-wrap { padding: 1.5rem 1rem; }
        .summary-grid { grid-template-columns: 1fr 1fr; gap: .75rem; }
        .summary-value { font-size: 1rem; }
        .table-card-header { flex-direction: column; align-items: flex-start; }
    }

    @keyframes fadeUp {
        from { opacity:0; transform: translateY(16px); }
        to   { opacity:1; transform: translateY(0); }
    }
</style>
@endsection

@section('container')
<div class="page-wrap">
    <!-- HEADER -->
    <div class="page-header">
        <div class="page-eyebrow">Keuangan</div>
        <h1 class="page-title">Laporan Keuangan</h1>
        <p class="page-sub">Ringkasan pendapatan dari seluruh transaksi yang telah selesai</p>
    </div>

    <!-- SUMMARY -->
    <div class="summary-grid">
        <div class="summary-card green">
            <div class="summary-label">Total Pendapatan</div>
            <div class="summary-value">Rp {{ number_format($status->sum('total_biaya'), 0, ',', '.') }}</div>
            <div class="summary-icon">💰</div>
        </div>
        <div class="summary-card blue">
            <div class="summary-label">Total Transaksi</div>
            <div class="summary-value">{{ $status->count() }}</div>
            <div class="summary-icon">📊</div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">Riwayat Transaksi Selesai</div>
        </div>
        <div style="overflow-x: auto;">
            <table id="rentalTable">
                <thead>
                    <tr>
                        <th>No. Invoice</th>
                        <th>Customer / Mobil</th>
                        <th>Tanggal Selesai</th>
                        <th>Total Biaya</th>
                        @if(Request::is('*verifikasi*'))<th>Aksi</th>@endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($status as $data)
                    <tr>
                        <td><span class="invoice-badge">{{ $data->no_invoice }}</span></td>
                        <td>
                            <div class="customer-name">{{ $data->nama_customer }}</div>
                            <div class="car-name">{{ $data->nama_mobil }} · {{ $data->nopol }}</div>
                        </td>
                        <td>{{ $data->tanggal_kembali }}</td>
                        <td><span class="amount">Rp {{ number_format($data->total_biaya, 0, ',', '.') }}</span></td>
                        @if(Request::is('*verifikasi*'))
                        <td>
                            <a onclick="return confirm('Mobil sudah kembali?')"
                               href="{{ url('pengembalian', $data->id) }}"
                               class="btn-selesai">
                                ✓ Selesai
                            </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.btn-selesai {
    display: inline-block; background: linear-gradient(135deg, #eab308, #a16207);
    color: #000; padding: .35rem .85rem; border-radius: 50px;
    font-size: .75rem; font-weight: 700; text-decoration: none;
    transition: .2s; white-space: nowrap;
}
.btn-selesai:hover { transform: scale(1.05); text-decoration: none; color: #000; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#rentalTable').DataTable({
        "lengthMenu": [10, 25, 50, 100],
        "pageLength": 10,
        "ordering": false,
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data",
            "zeroRecords": "Tidak ada data",
            "info": "Menampilkan _START_-_END_ dari _TOTAL_",
            "infoEmpty": "Tidak ada data",
            "search": "Cari:",
            "paginate": { "previous": "‹", "next": "›" }
        }
    });
});
</script>
@endsection