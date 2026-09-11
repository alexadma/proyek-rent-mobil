@extends('layouts.mainadmin')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root { --gold:#C9A84C; --gold-light:#F0D080; --dark:#0D0D0D; --dark-2:#161616; --dark-3:#1F1F1F; --border:rgba(201,168,76,.2); --muted:#6B6B6B; }
    * { box-sizing:border-box; }
    body { background:var(--dark); font-family:'DM Sans',sans-serif; }
    .page-wrap { min-height:100vh; padding:2rem 1rem; display:flex; justify-content:center; align-items:flex-start; }
    .form-card { width:100%; max-width:760px; background:var(--dark-2); border:1px solid var(--border); border-radius:24px; overflow:hidden; box-shadow:0 0 80px rgba(201,168,76,.06),0 40px 60px rgba(0,0,0,.5); animation:fadeUp .5s ease both; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
    .form-header { background:linear-gradient(135deg,#1a1506 0%,#0D0D0D 60%); border-bottom:1px solid var(--border); padding:1.6rem 2rem; display:flex; align-items:center; justify-content:space-between; gap:1rem; }
    .header-left { display:flex; align-items:center; gap:.9rem; }
    .header-icon { width:44px; height:44px; background:var(--gold); border-radius:12px; display:grid; place-items:center; font-size:1.3rem; color:var(--dark); box-shadow:0 0 18px rgba(201,168,76,.3); }
    .header-title { margin:0; color:#fff; font:800 1.2rem 'Syne',sans-serif; }
    .header-sub { margin:2px 0 0; color:var(--muted); font-size:.75rem; }
    .btn-back { display:flex; align-items:center; gap:.4rem; background:transparent; border:1px solid var(--border); color:var(--gold); padding:.45rem 1rem; border-radius:50px; font-size:.8rem; text-decoration:none; white-space:nowrap; }
    .btn-back:hover { background:var(--border); color:var(--gold-light); }
    .form-body { padding:2rem; }
    .section-label { display:flex; align-items:center; gap:.6rem; margin:0 0 1.1rem; color:var(--gold); font:700 .62rem 'Syne',sans-serif; letter-spacing:.12em; text-transform:uppercase; }
    .section-label::after { content:''; flex:1; height:1px; background:var(--border); }
    .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .fgroup { margin-bottom:1.3rem; }
    .fgroup label { display:block; margin-bottom:.5rem; color:#c7c7c7; font-size:.78rem; font-weight:600; }
    .fcontrol { width:100%; padding:.72rem 1rem; border:1px solid rgba(255,255,255,.09); border-radius:12px; outline:none; background:var(--dark-3); color:#fff; font:400 .88rem 'DM Sans',sans-serif; transition:border-color .2s,box-shadow .2s; }
    .fcontrol:focus { border-color:var(--gold); box-shadow:0 0 0 3px rgba(201,168,76,.1); }
    .fcontrol::placeholder { color:#555; }
    select.fcontrol option { background:var(--dark-3); color:#fff; }
    .invalid-feedback { margin-top:.35rem; color:#f87171; font-size:.76rem; }
    .fcontrol.is-invalid { border-color:#f87171; }
    .file-zone { position:relative; padding:1.3rem; border:1px dashed rgba(201,168,76,.3); border-radius:12px; background:var(--dark-3); text-align:center; cursor:pointer; }
    .file-zone:hover { border-color:var(--gold); background:rgba(201,168,76,.04); }
    .file-zone input { position:absolute; inset:0; width:100%; height:100%; opacity:0; cursor:pointer; }
    .file-zone-icon { margin-bottom:.3rem; font-size:1.5rem; }
    .file-zone-text { color:#777; font-size:.8rem; }
    .file-zone-text span { color:var(--gold); }
    .preview-wrap { margin-top:.8rem; }
    .img-preview { max-width:100%; max-height:180px; border:1px solid var(--border); border-radius:12px; object-fit:cover; }
    .divider { height:1px; margin:1.4rem 0; background:var(--border); }
    .btn-submit { width:100%; padding:.8rem 2.4rem; border:0; border-radius:50px; background:linear-gradient(135deg,var(--gold),#a07a20); color:var(--dark); font:700 .88rem 'Syne',sans-serif; cursor:pointer; box-shadow:0 6px 24px rgba(201,168,76,.25); }
    .btn-submit:hover { transform:translateY(-2px); box-shadow:0 12px 32px rgba(201,168,76,.35); }
    @media(max-width:640px) { .form-body { padding:1.25rem; } .form-header { padding:1.25rem; } .grid-2 { grid-template-columns:1fr; gap:0; } }
</style>
@endsection

@section('container')
<div class="page-wrap">
    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <div class="header-icon">🚗</div>
                <div>
                    <h1 class="header-title">Tambah Armada Mobil</h1>
                    <p class="header-sub">Masukkan informasi kendaraan dengan lengkap</p>
                </div>
            </div>
            <a href="{{ route('mobil.index') }}" class="btn-back">← Kembali</a>
        </div>

        <div class="form-body">
            @if($errors->any())
            <div class="invalid-feedback" style="margin-bottom:1.5rem; font-size:.84rem;">
                <strong>Periksa kembali data yang diisi:</strong>
                <ul style="margin:.5rem 0 0 1rem; padding:0;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="post" action="{{ route('mobil.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="section-label">Informasi Kendaraan</div>
                <div class="grid-2">
                    <div class="fgroup">
                        <label for="nama_mobil">Nama Mobil</label>
                        <input id="nama_mobil" name="nama_mobil" type="text" class="fcontrol @error('nama_mobil') is-invalid @enderror" value="{{ old('nama_mobil') }}" placeholder="Contoh: Toyota Avanza" required>
                        @error('nama_mobil')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label for="nopol">Nomor Polisi</label>
                        <input id="nopol" name="nopol" type="text" class="fcontrol @error('nopol') is-invalid @enderror" value="{{ old('nopol') }}" placeholder="Contoh: B 1234 XYZ" required>
                        @error('nopol')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="grid-2">
                    <div class="fgroup">
                        <label for="type">Tipe Mobil</label>
                        <select id="type" name="type" class="fcontrol @error('type') is-invalid @enderror" required>
                            <option value="" disabled {{ old('type') ? '' : 'selected' }}>Pilih tipe kendaraan</option>
                            @foreach(['MPV','SUV','Crossover','Hatchback','Sedan','Sport','Convertible','Station Wagon','Off road','Double Cabin','Pickup Truck','Elektrik','Hybrid','LCGC'] as $type)
                            <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label for="warna">Warna</label>
                        <input id="warna" name="warna" type="text" class="fcontrol @error('warna') is-invalid @enderror" value="{{ old('warna') }}" placeholder="Contoh: Hitam" required>
                        @error('warna')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="section-label">Harga & Pajak</div>
                <div class="grid-2">
                    <div class="fgroup">
                        <label for="sewa">Harga Sewa per Hari (Rp)</label>
                        <input id="sewa" name="sewa" type="number" min="0" class="fcontrol @error('sewa') is-invalid @enderror" value="{{ old('sewa') }}" placeholder="Contoh: 350000" required>
                        @error('sewa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label for="tgl_pjk">Tanggal Pajak Kendaraan</label>
                        <input id="tgl_pjk" name="tgl_pjk" type="date" class="fcontrol @error('tgl_pjk') is-invalid @enderror" value="{{ old('tgl_pjk') }}" required>
                        @error('tgl_pjk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="section-label">Foto Kendaraan</div>
                <div class="fgroup">
                    <div class="file-zone">
                        <input id="foto" name="foto" type="file" accept="image/*" onchange="previewImage(this)" required>
                        <div class="file-zone-icon">📷</div>
                        <div class="file-zone-text" id="fileLabel"><span>Klik untuk pilih foto</span> atau seret file ke sini</div>
                    </div>
                    <div class="preview-wrap" id="previewWrap" style="display:none;"><img class="img-preview" id="previewImg" src="" alt="Preview foto mobil"></div>
                    @error('foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="divider"></div>
                <button type="submit" class="btn-submit">✦ Simpan Armada</button>
            </form>
        </div>
    </div>
</div>
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = event => {
            document.getElementById('previewImg').src = event.target.result;
            document.getElementById('previewWrap').style.display = 'block';
            document.getElementById('fileLabel').innerHTML = '<span>' + input.files[0].name + '</span>';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
