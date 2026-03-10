@extends('layouts.mainadmin')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --gold:#C9A84C; --gold-dim:rgba(201,168,76,0.1);
        --dark:#0A0A0A; --dark-2:#111; --dark-3:#1A1A1A;
        --border:rgba(201,168,76,0.15); --muted:#555; --green:#22c55e;
    }
    body{background:var(--dark);font-family:'DM Sans',sans-serif;}
    .page-wrap{padding:2rem 1.5rem;animation:fadeUp .5s ease both;}
    @keyframes fadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}

    .page-top{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:2rem;}
    .page-eyebrow{font-size:.62rem;font-weight:700;letter-spacing:.16em;color:var(--gold);text-transform:uppercase;margin-bottom:.4rem;display:flex;align-items:center;gap:.5rem;}
    .page-eyebrow::before{content:'';width:18px;height:1px;background:var(--gold);}
    .page-title{font-family:'Syne',sans-serif;font-size:clamp(1.4rem,4vw,2rem);font-weight:800;color:#fff;margin:0;}
    .total-badge{display:inline-flex;align-items:center;gap:.4rem;background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.2);color:var(--gold);border-radius:50px;padding:.25rem .8rem;font-size:.75rem;font-weight:600;margin-top:.5rem;}

    .btn-add{display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,var(--gold),#8a6010);color:#000;padding:.6rem 1.4rem;border-radius:50px;font-family:'Syne',sans-serif;font-size:.82rem;font-weight:700;text-decoration:none;transition:.2s;box-shadow:0 4px 20px rgba(201,168,76,0.25);}
    .btn-add:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(201,168,76,0.35);color:#000;text-decoration:none;}

    /* GRID */
    .cars-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.2rem;}

    /* CARD */
    .car-card{background:var(--dark-2);border:1px solid var(--border);border-radius:20px;overflow:hidden;transition:.25s;}
    .car-card:hover{border-color:rgba(201,168,76,0.35);transform:translateY(-3px);box-shadow:0 12px 40px rgba(0,0,0,0.5);}

    .car-img-wrap{position:relative;height:180px;overflow:hidden;}
    .car-img-wrap img{width:100%;height:100%;object-fit:cover;transition:transform .4s;}
    .car-card:hover .car-img-wrap img{transform:scale(1.04);}
    .car-img-wrap::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.6) 0%,transparent 55%);opacity:.7;}

    /* STATUS badge overlay */
    .status-overlay{position:absolute;top:.75rem;right:.75rem;z-index:2;}
    .status-pill{padding:.2rem .65rem;border-radius:50px;font-size:.65rem;font-weight:700;letter-spacing:.04em;}
    .status-tersedia{background:rgba(34,197,94,.2);color:#4ade80;border:1px solid rgba(34,197,94,.3);}
    .status-disewa{background:rgba(239,68,68,.2);color:#f87171;border:1px solid rgba(239,68,68,.3);}
    .status-other{background:rgba(234,179,8,.2);color:#fbbf24;border:1px solid rgba(234,179,8,.3);}

    .car-body{padding:1rem 1.2rem;}
    .car-name{font-family:'Syne',sans-serif;font-size:.95rem;font-weight:800;color:#fff;margin-bottom:.6rem;}
    .car-row{display:flex;align-items:center;gap:.5rem;margin-bottom:.3rem;}
    .car-label{font-size:.68rem;color:var(--muted);min-width:70px;}
    .car-value{font-size:.78rem;color:#bbb;}
    .car-price{font-size:.9rem;font-weight:700;color:var(--green);font-family:'Syne',sans-serif;}

    .car-actions{display:flex;gap:.6rem;padding:.85rem 1.2rem;border-top:1px solid rgba(255,255,255,0.04);}
    .btn-edit{flex:1;text-align:center;background:rgba(201,168,76,0.1);border:1px solid rgba(201,168,76,0.2);color:var(--gold);padding:.45rem;border-radius:8px;font-size:.76rem;font-weight:600;text-decoration:none;transition:.17s;display:inline-flex;align-items:center;justify-content:center;gap:.3rem;}
    .btn-edit:hover{background:rgba(201,168,76,0.2);color:var(--gold);text-decoration:none;}
    .btn-delete{flex:1;text-align:center;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);color:#f87171;padding:.45rem;border-radius:8px;font-size:.76rem;font-weight:600;transition:.17s;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:.3rem;}
    .btn-delete:hover{background:rgba(239,68,68,0.16);}

    .empty-state{text-align:center;padding:4rem 2rem;}
    .empty-icon{font-size:3rem;margin-bottom:1rem;opacity:.3;}
    .empty-text{color:var(--muted);font-size:.9rem;}

    @media(max-width:640px){.page-wrap{padding:1.5rem 1rem;}}
</style>
@endsection

@section('container')
<div class="page-wrap">
    <div class="page-top">
        <div>
            <div class="page-eyebrow">Manajemen</div>
            <h1 class="page-title">Armada Mobil</h1>
            <div class="total-badge">🚗 {{ $mobils->count() }} kendaraan terdaftar</div>
        </div>
        <a href="{{ route('mobil.create') }}" class="btn-add">+ Tambah Armada</a>
    </div>

    @if($mobils->count())
    <div class="cars-grid">
        @foreach($mobils as $mobil)
        <div class="car-card">
            <div class="car-img-wrap">
                <img src="{{ asset('storage/' . $mobil->foto) }}" alt="{{ $mobil->nama_mobil }}">
                <div class="status-overlay">
                    @php
                        $s = strtolower($mobil->status ?? '');
                        $cls = str_contains($s,'tersedia') ? 'status-tersedia' : (str_contains($s,'sewa') ? 'status-disewa' : 'status-other');
                    @endphp
                    <span class="status-pill {{ $cls }}">{{ $mobil->status }}</span>
                </div>
            </div>
            <div class="car-body">
                <div class="car-name">{{ $mobil->nama_mobil }}</div>
                <div class="car-row">
                    <span class="car-label">Plat</span>
                    <span class="car-value">{{ $mobil->nopol }}</span>
                </div>
                <div class="car-row">
                    <span class="car-label">Tipe</span>
                    <span class="car-value">{{ $mobil->type }}</span>
                </div>
                <div class="car-row">
                    <span class="car-label">Warna</span>
                    <span class="car-value">{{ $mobil->warna }}</span>
                </div>
                <div class="car-row" style="margin-top:.5rem;">
                    <span class="car-label">Sewa/hari</span>
                    <span class="car-price">Rp {{ number_format($mobil->sewa, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="car-actions">
                <a href="/mobil/{{ $mobil->id }}/edit" class="btn-edit">✏ Edit</a>
                <form action="/mobil/{{ $mobil->id }}" method="post" style="flex:1;display:flex;">
                    @method('delete') @csrf
                    <button type="submit" class="btn-delete" style="width:100%;"
                        onclick="return confirm('Hapus {{ $mobil->nama_mobil }} dari armada?')">
                        🗑 Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">🚗</div>
        <div class="empty-text">Belum ada armada terdaftar. Klik "Tambah Armada" untuk memulai.</div>
    </div>
    @endif
</div>
@endsection