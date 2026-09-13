<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DVJR Rent Cars | Riwayat Transaksi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --gold: #C9A84C;
            --green: #22c55e;
            --red: #ef4444;
            --blue: #60a5fa;
            --yellow: #eab308;
            --dark: #0A0A0A;
            --dark-2: #111111;
            --dark-3: #1A1A1A;
            --border: rgba(201,168,76,0.15);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: var(--dark); color: #e5e5e5; font-family: 'DM Sans', sans-serif; min-height: 100vh; }

        /* NAVBAR */
        .topbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(10,10,10,0.85); backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border); padding: 1rem 2rem;
            display: flex; align-items: center; justify-content: space-between;
        }
        .topbar-brand { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.1rem; color: #fff; text-decoration: none; }
        .topbar-brand span { color: var(--gold); }
        .topbar-nav { display: flex; gap: .5rem; }
        .topbar-nav a {
            color: #999; text-decoration: none; font-size: .82rem; font-weight: 500;
            padding: .5rem 1rem; border-radius: 10px; transition: .2s;
        }
        .topbar-nav a:hover, .topbar-nav a.active { color: var(--gold); background: rgba(201,168,76,0.08); }

        /* MAIN */
        .page-wrap { max-width: 1100px; margin: 0 auto; padding: 2rem clamp(1rem, 3vw, 2.5rem); }
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
        .page-sub { color: #666; font-size: .88rem; margin-top: .4rem; }

        /* SUMMARY */
        .summary-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin: 1.5rem 0; }
        .summary-card {
            background: var(--dark-2); border: 1px solid var(--border); border-radius: 16px;
            padding: 1.2rem 1.4rem; position: relative; overflow: hidden;
        }
        .summary-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; }
        .summary-card.gold::before { background: linear-gradient(90deg, transparent, var(--gold), transparent); }
        .summary-card.green::before { background: linear-gradient(90deg, transparent, var(--green), transparent); }
        .summary-card.blue::before { background: linear-gradient(90deg, transparent, var(--blue), transparent); }
        .summary-card.yellow::before { background: linear-gradient(90deg, transparent, var(--yellow), transparent); }
        .summary-label { font-size: .65rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #666; margin-bottom: .5rem; }
        .summary-value { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.5rem; }
        .summary-card.gold .summary-value { color: var(--gold); }
        .summary-card.green .summary-value { color: var(--green); }
        .summary-card.blue .summary-value { color: var(--blue); }
        .summary-card.yellow .summary-value { color: var(--yellow); }

        /* TRANSACTION CARD */
        .tx-list { display: flex; flex-direction: column; gap: 1rem; margin-top: 1.5rem; }
        .tx-card {
            background: var(--dark-2); border: 1px solid var(--border); border-radius: 20px;
            padding: 1.5rem 1.8rem; transition: .25s; position: relative; overflow: hidden;
        }
        .tx-card:hover { border-color: rgba(201,168,76,0.35); transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,0.3); }
        .tx-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: linear-gradient(90deg, transparent, var(--gold), transparent); }

        .tx-header { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap; }
        .tx-invoice {
            font-family: monospace; font-size: .82rem; font-weight: 700;
            color: var(--gold); background: rgba(201,168,76,0.1);
            padding: .3rem .8rem; border-radius: 8px;
        }
        .tx-date { font-size: .75rem; color: #666; }

        .tx-status {
            padding: .3rem .9rem; border-radius: 50px; font-size: .72rem; font-weight: 700;
            white-space: nowrap; text-transform: uppercase; letter-spacing: .04em;
        }
        .tx-status.requested { background: rgba(234,179,8,.12); color: #fbbf24; border: 1px solid rgba(234,179,8,.2); }
        .tx-status.diterima { background: rgba(34,197,94,.12); color: #4ade80; border: 1px solid rgba(34,197,94,.2); }
        .tx-status.selesai { background: rgba(96,165,250,.12); color: #60a5fa; border: 1px solid rgba(96,165,250,.2); }
        .tx-status.ditolak { background: rgba(239,68,68,.12); color: #f87171; border: 1px solid rgba(239,68,68,.2); }

        .tx-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: .8rem; }
        .tx-field { }
        .tx-field-label { font-size: .65rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #555; margin-bottom: .2rem; }
        .tx-field-value { font-size: .88rem; color: #ddd; font-weight: 500; }
        .tx-field-value.amount { color: var(--green); font-weight: 700; font-family: 'Syne', sans-serif; font-size: 1rem; }
        .tx-field-value.pickup { color: var(--blue); }
        .tx-field-value.return { color: var(--red); }

        .tx-footer { display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.04); flex-wrap: wrap; gap: .5rem; }
        .tx-btn {
            display: inline-flex; align-items: center; gap: .4rem;
            padding: .45rem 1rem; border-radius: 50px; font-size: .78rem; font-weight: 600;
            text-decoration: none; transition: .2s;
        }
        .tx-btn.gold { background: linear-gradient(135deg, var(--gold), #a17c2e); color: #000; }
        .tx-btn.gold:hover { transform: scale(1.05); box-shadow: 0 4px 16px rgba(201,168,76,.3); }
        .tx-btn.outline { background: transparent; border: 1px solid var(--border); color: #999; }
        .tx-btn.outline:hover { border-color: var(--gold); color: var(--gold); }

        /* EMPTY STATE */
        .empty-state {
            text-align: center; padding: 5rem 2rem;
            background: var(--dark-2); border: 1px dashed rgba(201,168,76,0.2);
            border-radius: 24px; margin-top: 1.5rem;
        }
        .empty-icon {
            width: 80px; height: 80px; margin: 0 auto 1.5rem;
            background: rgba(201,168,76,0.06); border: 1px solid rgba(201,168,76,0.15);
            border-radius: 20px; display: grid; place-items: center;
            font-size: 2rem; color: var(--gold);
        }
        .empty-title { font-family: 'Syne', sans-serif; font-size: 1.3rem; font-weight: 800; color: #fff; margin-bottom: .5rem; }
        .empty-desc { color: #666; font-size: .88rem; max-width: 400px; margin: 0 auto 1.5rem; line-height: 1.6; }
        .empty-btn {
            display: inline-flex; align-items: center; gap: .5rem;
            padding: .7rem 1.8rem; border-radius: 50px; font-size: .85rem; font-weight: 700;
            text-decoration: none; background: linear-gradient(135deg, var(--gold), #a17c2e);
            color: #000; transition: .2s;
        }
        .empty-btn:hover { transform: scale(1.05); box-shadow: 0 6px 24px rgba(201,168,76,.3); }

        @media(max-width: 768px) {
            .topbar { padding: .8rem 1rem; flex-wrap: wrap; gap: .5rem; }
            .topbar-nav { display: none; }
            .page-wrap { padding: 1.5rem 1rem; }
            .tx-header { flex-direction: column; align-items: flex-start; }
            .tx-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <div class="topbar">
        <a href="{{ url('/home') }}" class="topbar-brand"><span>DVJR</span> Rent Cars</a>
        <div class="topbar-nav">
            <a href="{{ url('/home') }}">Beranda</a>
            <a href="{{ url('/sewa') }}">Sewa</a>
            <a href="{{ url('/riwayat') }}" class="active">Riwayat</a>
            <a href="{{ url('/profile') }}">Profil</a>
        </div>
    </div>

    <div class="page-wrap">
        <!-- HEADER -->
        <div class="page-eyebrow">Customer</div>
        <h1 class="page-title">Riwayat Transaksi</h1>
        <p class="page-sub">Semua pesanan sewa kendaraan Anda di satu tempat</p>

        @if($transaksis->count() > 0)

        <!-- TRANSACTION LIST -->
        <div class="tx-list">
            @foreach($transaksis as $t)
            @php
                $v = strtolower($t->verifikasi ?? '');
                $statusClass = match($v) {
                    'requested' => 'requested',
                    'diterima' => 'diterima',
                    'selesai' => 'selesai',
                    'ditolak' => 'ditolak',
                    default => 'requested',
                };
                $statusLabel = match($v) {
                    'requested' => 'Menunggu',
                    'diterima' => 'Diterima',
                    'selesai' => 'Selesai',
                    'ditolak' => 'Ditolak',
                    default => ucfirst($t->verifikasi),
                };
            @endphp
            <div class="tx-card">
                <div class="tx-header">
                    <div style="display:flex; align-items:center; gap:.8rem; flex-wrap:wrap;">
                        <span class="tx-invoice">{{ $t->no_invoice }}</span>
                        <span class="tx-date"><i class="fas fa-calendar-alt" style="margin-right:.3rem;"></i>Dipesan {{ $t->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <span class="tx-status {{ $statusClass }}">{{ $statusLabel }}</span>
                </div>

                <div class="tx-grid">
                    <div class="tx-field">
                        <div class="tx-field-label">Kendaraan</div>
                        <div class="tx-field-value">{{ $t->nama_mobil }} <span style="color:#666; font-size:.78rem;">({{ $t->nopol }})</span></div>
                    </div>
                    <div class="tx-field">
                        <div class="tx-field-label">Supir</div>
                        <div class="tx-field-value">{{ $t->nama_supir }}</div>
                    </div>
                    <div class="tx-field">
                        <div class="tx-field-label">Tanggal Ambil</div>
                        <div class="tx-field-value pickup">{{ $t->tanggal_pinjam ? \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d M Y, H:i') : '-' }}</div>
                    </div>
                    <div class="tx-field">
                        <div class="tx-field-label">Tanggal Kembali</div>
                        <div class="tx-field-value return">{{ $t->tanggal_kembali ? \Carbon\Carbon::parse($t->tanggal_kembali)->format('d M Y, H:i') : '-' }}</div>
                    </div>
                    <div class="tx-field">
                        <div class="tx-field-label">Jaminan</div>
                        <div class="tx-field-value">{{ $t->jaminan ?? '-' }}</div>
                    </div>
                    <div class="tx-field">
                        <div class="tx-field-label">Total Biaya</div>
                        <div class="tx-field-value amount">Rp {{ number_format($t->total_biaya, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="tx-footer">
                    <div>
                        @if($v === 'requested')
                            <span style="font-size:.75rem;color:#fbbf24;"><i class="fas fa-clock"></i> Menunggu verifikasi admin</span>
                        @elseif($v === 'diterima')
                            <span style="font-size:.75rem;color:#4ade80;"><i class="fas fa-check-circle"></i> Sedang disewa</span>
                        @elseif($v === 'selesai')
                            <span style="font-size:.75rem;color:#60a5fa;"><i class="fas fa-flag-checkered"></i> Transaksi selesai</span>
                        @elseif($v === 'ditolak')
                            <span style="font-size:.75rem;color:#f87171;"><i class="fas fa-times-circle"></i> Ditolak oleh admin</span>
                        @endif
                    </div>
                    <div style="display:flex;gap:.5rem;">
                        @if($v === 'requested' && !$t->bukti)
                            <a href="{{ url('/invoice') }}" class="tx-btn gold"><i class="fas fa-upload"></i> Upload Bukti</a>
                        @elseif($v === 'requested' && $t->bukti)
                            <span class="tx-btn outline" style="cursor:default;"><i class="fas fa-receipt"></i> Bukti terkirim</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- EMPTY STATE -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-car"></i>
            </div>
            <div class="empty-title">Belum Ada Transaksi</div>
            <div class="empty-desc">
                Anda belum pernah melakukan pemesanan sewa kendaraan. Mulai sewa sekarang untuk melihat riwayat transaksi Anda di sini.
            </div>
            <a href="{{ url('/sewa') }}" class="empty-btn">
                <i class="fas fa-plus-circle"></i> Sewa Sekarang
            </a>
        </div>
        @endif
    </div>
</body>
</html>