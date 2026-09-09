@extends('layouts.mainadmin')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root{--gold:#C9A84C;--gold-light:#F0D080;--dark:#0D0D0D;--dark-2:#161616;--dark-3:#1F1F1F;--dark-4:#2A2A2A;--border:rgba(201,168,76,0.2);--muted:#6B6B6B;}
    *{box-sizing:border-box;}body{background:var(--dark);font-family:'DM Sans',sans-serif;}
    .page-wrap{min-height:100vh;padding:2rem 1rem;display:flex;align-items:flex-start;justify-content:center;}
    .form-card{width:100%;max-width:720px;background:var(--dark-2);border:1px solid var(--border);border-radius:24px;overflow:hidden;box-shadow:0 0 80px rgba(201,168,76,0.06),0 40px 60px rgba(0,0,0,0.5);animation:fadeUp .5s ease both;}
    @keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
    .form-header{background:linear-gradient(135deg,#1a1506 0%,#0D0D0D 60%);border-bottom:1px solid var(--border);padding:1.6rem 2rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;}
    .header-left{display:flex;align-items:center;gap:.9rem;}
    .header-icon{width:44px;height:44px;background:var(--gold);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:var(--dark);flex-shrink:0;box-shadow:0 0 18px rgba(201,168,76,0.3);}
    .header-title{font-family:'Syne',sans-serif;font-size:1.2rem;font-weight:800;color:#fff;margin:0;}
    .header-sub{font-size:.75rem;color:var(--muted);margin:2px 0 0;}
    .btn-back{display:flex;align-items:center;gap:.4rem;background:transparent;border:1px solid var(--border);color:var(--gold);padding:.45rem 1rem;border-radius:50px;font-size:.8rem;text-decoration:none;transition:.2s;white-space:nowrap;}
    .btn-back:hover{background:var(--border);color:var(--gold-light);text-decoration:none;}
    .form-body{padding:2rem;}
    .section-label{font-family:'Syne',sans-serif;font-size:.62rem;font-weight:700;letter-spacing:.12em;color:var(--gold);text-transform:uppercase;margin-bottom:1.1rem;display:flex;align-items:center;gap:.6rem;}
    .section-label::after{content:'';flex:1;height:1px;background:var(--border);}
    .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;}
    .fgroup{margin-bottom:1.3rem;}
    .fgroup label{display:block;font-size:.76rem;font-weight:500;color:#999;margin-bottom:.5rem;}
    .fcontrol{width:100%;background:var(--dark-3);border:1px solid rgba(255,255,255,0.07);border-radius:12px;color:#fff;padding:.7rem 1rem;font-family:'DM Sans',sans-serif;font-size:.88rem;transition:border-color .2s,box-shadow .2s;outline:none;-webkit-appearance:none;}
    .fcontrol:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,168,76,0.1);}
    .fcontrol::placeholder{color:#444;}
    select.fcontrol option{background:var(--dark-3);color:#fff;}
    textarea.fcontrol{resize:vertical;min-height:90px;}
    .invalid-feedback{color:#f87171;font-size:.76rem;margin-top:.35rem;}
    .fcontrol.is-invalid{border-color:#f87171;}
    .input-prefix{display:flex;align-items:stretch;background:var(--dark-3);border:1px solid rgba(255,255,255,0.07);border-radius:12px;overflow:hidden;transition:border-color .2s,box-shadow .2s;}
    .input-prefix:focus-within{border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,168,76,0.1);}
    .prefix-text{padding:.7rem 1rem;background:var(--dark-4);color:var(--gold);font-size:.82rem;font-weight:600;border-right:1px solid rgba(255,255,255,0.07);white-space:nowrap;display:flex;align-items:center;}
    .prefix-input{flex:1;background:transparent;border:none;color:#fff;padding:.7rem 1rem;font-family:'DM Sans',sans-serif;font-size:.88rem;outline:none;}
    .prefix-input::placeholder{color:#444;}
    .current-photo{display:flex;align-items:center;gap:1rem;background:var(--dark-3);border:1px solid var(--border);border-radius:12px;padding:.8rem 1rem;margin-bottom:.8rem;}
    .current-photo img{width:72px;height:52px;border-radius:8px;object-fit:cover;border:1px solid var(--border);}
    .current-photo-name{font-size:.82rem;color:#ddd;font-weight:500;}
    .current-photo-info{font-size:.74rem;color:#666;margin-top:2px;}
    .file-zone{position:relative;background:var(--dark-3);border:1px dashed rgba(201,168,76,0.3);border-radius:12px;padding:1.1rem;text-align:center;cursor:pointer;transition:.2s;}
    .file-zone:hover{border-color:var(--gold);background:rgba(201,168,76,0.04);}
    .file-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .file-zone-text{font-size:.78rem;color:#777;}
    .file-zone-text span{color:var(--gold);}
    .preview-wrap{margin-top:.8rem;}
    .img-preview{max-width:100%;max-height:160px;border-radius:12px;border:1px solid var(--border);object-fit:cover;}
    .divider{height:1px;background:var(--border);margin:1.4rem 0;}
    .btn-submit{background:linear-gradient(135deg,var(--gold),#a07a20);color:var(--dark);border:none;border-radius:50px;padding:.8rem 2.4rem;font-family:'Syne',sans-serif;font-size:.88rem;font-weight:700;letter-spacing:.04em;cursor:pointer;transition:.25s;width:100%;box-shadow:0 6px 24px rgba(201,168,76,0.25);}
    .btn-submit:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(201,168,76,0.35);}
    @media(max-width:640px){.grid-2,.grid-3{grid-template-columns:1fr;}.form-body{padding:1.25rem;}.form-header{padding:1.25rem;}}
</style>
@endsection

@section('container')
<div class="page-wrap">
    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <div class="header-icon">✏️</div>
                <div>
                    <p class="header-title">Edit Armada</p>
                    <p class="header-sub">{{ $mobil->nama_mobil }}</p>
                </div>
            </div>
            <a href="{{ route('mobil.index') }}" class="btn-back">← Kembali</a>
        </div>

        <div class="form-body">
            <form method="post" action="/mobil/{{ $mobil->id }}" enctype="multipart/form-data">
                @method('put') @csrf

                <div class="section-label">Informasi Kendaraan</div>
                <div class="grid-2">
                    <div class="fgroup">
                        <label>Nama Mobil</label>
                        <input type="text" class="fcontrol @error('nama_mobil') is-invalid @enderror"
                            name="nama_mobil" value="{{ old('nama_mobil', $mobil->nama_mobil) }}" placeholder="Toyota Avanza">
                        @error('nama_mobil')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Plat Nomor</label>
                        <input type="text" class="fcontrol @error('nopol') is-invalid @enderror"
                            name="nopol" value="{{ old('nopol', $mobil->nopol) }}" placeholder="B 1234 XYZ">
                        @error('nopol')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="grid-2">
                    <div class="fgroup">
                        <label>Tipe Mobil</label>
                        <input type="text" class="fcontrol @error('type') is-invalid @enderror"
                            name="type" value="{{ old('type', $mobil->type) }}" placeholder="SUV / Sedan / MPV">
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Warna</label>
                        <input type="text" class="fcontrol @error('warna') is-invalid @enderror"
                            name="warna" value="{{ old('warna', $mobil->warna) }}" placeholder="Putih">
                        @error('warna')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="section-label">Harga & Status</div>
                <div class="grid-2">
                    <div class="fgroup">
                        <label>Harga Sewa (Per Hari)</label>
                        <div class="input-prefix">
                            <span class="prefix-text">Rp</span>
                            <input type="number" class="prefix-input" name="sewa"
                                value="{{ old('sewa', $mobil->sewa) }}" placeholder="0">
                        </div>
                    </div>
                    <div class="fgroup">
                        <label>Status</label>
                        <select class="fcontrol" name="status">
                            @foreach(['TERSEDIA','DISEWA','MAINTENANCE'] as $opt)
                            <option {{ old('status', $mobil->status) == $opt ? 'selected' : '' }} value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="section-label">Foto Kendaraan</div>
                <div class="fgroup">
                    @if($mobil->foto)
                    <div class="current-photo">
                        <img src="{{ asset('storage/' . $mobil->foto) }}" alt="Foto saat ini">
                        <div>
                            <div class="current-photo-name">Foto saat ini</div>
                            <div class="current-photo-info">Kosongkan jika tidak ingin mengganti</div>
                        </div>
                    </div>
                    @endif
                    <input type="hidden" name="oldfoto" value="{{ $mobil->foto }}">
                    <div class="file-zone">
                        <input type="file" name="foto" accept="image/*" onchange="previewImage(this)">
                        <div class="file-zone-text"><span>Klik untuk ganti foto</span> (opsional)</div>
                    </div>
                    <div class="preview-wrap" id="previewWrap" style="display:none;">
                        <img class="img-preview" id="previewImg" src="" alt="Preview baru">
                    </div>
                </div>

                <div class="divider"></div>
                <button type="submit" class="btn-submit">✦ Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewWrap').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection