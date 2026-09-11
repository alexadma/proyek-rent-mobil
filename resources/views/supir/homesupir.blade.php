@extends('layouts.mainadmin')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --gold: #C9A84C; --gold-dim: rgba(201,168,76,0.1);
        --dark: #0A0A0A; --dark-2: #111; --dark-3: #1A1A1A;
        --border: rgba(201,168,76,0.15); --muted: #555;
    }
    body { background: var(--dark); font-family: 'DM Sans', sans-serif; }
    .page-wrap { max-width: 1600px; margin: 0 auto; padding: 2.5rem clamp(1rem, 3vw, 2.5rem); animation: fadeUp .5s ease both; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }

    /* HEADER */
    .page-top { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; margin-bottom:2rem; }
    .page-eyebrow { font-size:.62rem; font-weight:700; letter-spacing:.16em; color:var(--gold); text-transform:uppercase; margin-bottom:.4rem; display:flex; align-items:center; gap:.5rem; }
    .page-eyebrow::before { content:''; width:18px; height:1px; background:var(--gold); }
    .page-title { font-family:'Syne',sans-serif; font-size:clamp(1.4rem,4vw,2rem); font-weight:800; color:#fff; margin:0; }

    .btn-add {
        display:inline-flex; align-items:center; gap:.5rem;
        background:linear-gradient(135deg, var(--gold), #8a6010);
        color:#000; padding:.6rem 1.4rem; border-radius:50px;
        font-family:'Syne',sans-serif; font-size:.82rem; font-weight:700;
        text-decoration:none; transition:.2s; border:none; cursor:pointer;
        box-shadow:0 4px 20px rgba(201,168,76,0.25);
    }
    .btn-add:hover { transform:translateY(-2px); box-shadow:0 8px 28px rgba(201,168,76,0.35); color:#000; text-decoration:none; }

    /* GRID */
    .drivers-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:1.2rem; }

    /* CARD */
    .driver-card {
        background:var(--dark-2); border:1px solid var(--border);
        border-radius:20px; overflow:hidden; transition:.25s;
    }
    .driver-card:hover { border-color:rgba(201,168,76,0.35); transform:translateY(-3px); box-shadow:0 12px 40px rgba(0,0,0,0.4); }
    .driver-card:hover .card-img-wrap::after { opacity:1; }

    .card-img-wrap { position:relative; height:220px; overflow:hidden; }
    .card-img-wrap img { width:100%; height:100%; object-fit:cover; transition:transform .4s; }
    .driver-card:hover .card-img-wrap img { transform:scale(1.04); }
    .card-img-wrap::after {
        content:''; position:absolute; inset:0;
        background:linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 50%);
        opacity:.6; transition:.25s;
    }

    .card-body { padding:1.1rem 1.2rem; }
    .card-name { font-family:'Syne',sans-serif; font-size:1rem; font-weight:800; color:#fff; margin-bottom:.7rem; }
    .card-row { display:flex; align-items:flex-start; gap:.5rem; margin-bottom:.35rem; }
    .card-label { font-size:.7rem; color:var(--muted); min-width:62px; padding-top:1px; }
    .card-value { font-size:.8rem; color:#bbb; }

    .card-actions { display:flex; gap:.6rem; padding:.9rem 1.2rem; border-top:1px solid rgba(255,255,255,0.04); }
    .btn-edit {
        flex:1; text-align:center;
        background:rgba(201,168,76,0.1); border:1px solid rgba(201,168,76,0.2);
        color:var(--gold); padding:.45rem; border-radius:8px;
        font-size:.78rem; font-weight:600; text-decoration:none; transition:.17s;
        display:inline-flex; align-items:center; justify-content:center; gap:.3rem;
    }
    .btn-edit:hover { background:rgba(201,168,76,0.2); color:var(--gold); text-decoration:none; }
    .btn-delete {
        flex:1; text-align:center;
        background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.2);
        color:#f87171; padding:.45rem; border-radius:8px;
        font-size:.78rem; font-weight:600; transition:.17s; cursor:pointer;
        display:inline-flex; align-items:center; justify-content:center; gap:.3rem;
    }
    .btn-delete:hover { background:rgba(239,68,68,0.16); }

    /* EMPTY */
    .empty-state { text-align:center; padding:4rem 2rem; }
    .empty-icon { font-size:3rem; margin-bottom:1rem; opacity:.3; }
    .empty-text { color:var(--muted); font-size:.9rem; }

    @media(max-width:640px) { .page-wrap{padding:1.5rem 1rem;} }
</style>
@endsection

@section('container')
<div class="page-wrap">
    <div class="page-top">
        <div>
            <div class="page-eyebrow">Manajemen</div>
            <h1 class="page-title">Daftar Driver</h1>
            <p style="color:#777;font-size:.85rem;margin:.35rem 0 0;">Kelola driver yang mendukung perjalanan pelanggan</p>
        </div>
        <a href="{{ route('supir.create') }}" class="btn-add">+ Tambah Driver</a>
    </div>

    @if($supirs->count())
    <div class="drivers-grid">
        @foreach($supirs as $supir)
        <div class="driver-card">
            <div class="card-img-wrap">
                <img src="{{ asset('storage/' . $supir->image) }}" alt="{{ $supir->nama }}">
            </div>
            <div class="card-body">
                <div class="card-name">{{ $supir->nama }}</div>
                <div class="card-row">
                    <span class="card-label">No. KTP</span>
                    <span class="card-value">{{ $supir->noktp }}</span>
                </div>
                <div class="card-row">
                    <span class="card-label">Alamat</span>
                    <span class="card-value">{{ $supir->alamat }}</span>
                </div>
                <div class="card-row">
                    <span class="card-label">No. Telp</span>
                    <span class="card-value">{{ $supir->nohpsupir }}</span>
                </div>
            </div>
            <div class="card-actions">
                <a href="/supir/{{ $supir->noktp }}/edit" class="btn-edit">✏ Edit</a>
                <form action="/supir/{{ $supir->noktp }}" method="post" style="flex:1;display:flex;">
                    @method('delete') @csrf
                    <button type="submit" class="btn-delete" style="width:100%;"
                        onclick="return confirm('Hapus data supir {{ $supir->nama }}?')">
                        🗑 Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">👤</div>
        <div class="empty-text">Belum ada data driver. Klik "Tambah Driver" untuk memulai.</div>
    </div>
    @endif
</div>
@endsection