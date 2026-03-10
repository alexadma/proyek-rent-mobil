@extends('layouts.mainadmin')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --gold:#C9A84C; --gold-light:#F0D080;
        --dark:#0D0D0D; --dark-2:#161616; --dark-3:#1F1F1F; --dark-4:#2A2A2A;
        --border:rgba(201,168,76,0.2); --muted:#6B6B6B;
    }
    *{box-sizing:border-box;} body{background:var(--dark);font-family:'DM Sans',sans-serif;}
    .page-wrap{min-height:100vh;padding:2rem 1rem;display:flex;align-items:flex-start;justify-content:center;}
    .form-card{width:100%;max-width:600px;background:var(--dark-2);border:1px solid var(--border);border-radius:24px;overflow:hidden;box-shadow:0 0 80px rgba(201,168,76,0.06),0 40px 60px rgba(0,0,0,0.5);animation:fadeUp .5s ease both;}
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
    .fgroup{margin-bottom:1.3rem;}
    .fgroup label{display:block;font-size:.76rem;font-weight:500;color:#999;margin-bottom:.5rem;}
    .fcontrol{width:100%;background:var(--dark-3);border:1px solid rgba(255,255,255,0.07);border-radius:12px;color:#fff;padding:.7rem 1rem;font-family:'DM Sans',sans-serif;font-size:.88rem;transition:border-color .2s,box-shadow .2s;outline:none;-webkit-appearance:none;}
    .fcontrol:focus{border-color:var(--gold);box-shadow:0 0 0 3px rgba(201,168,76,0.1);}
    .fcontrol::placeholder{color:#444;}
    .invalid-feedback{color:#f87171;font-size:.76rem;margin-top:.35rem;}
    .fcontrol.is-invalid{border-color:#f87171;}
    .current-photo{display:flex;align-items:center;gap:1rem;background:var(--dark-3);border:1px solid var(--border);border-radius:12px;padding:.8rem 1rem;margin-bottom:.8rem;}
    .current-photo img{width:56px;height:56px;border-radius:8px;object-fit:cover;border:1px solid var(--border);}
    .current-photo-info{font-size:.76rem;color:#888;}
    .current-photo-name{font-size:.82rem;color:#ddd;font-weight:500;}
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
    @media(max-width:640px){.form-body{padding:1.25rem;}.form-header{padding:1.25rem;}}
</style>
@endsection

@section('container')
<div class="page-wrap">
    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <div class="header-icon">✏️</div>
                <div>
                    <p class="header-title">Edit Data Driver</p>
                    <p class="header-sub">{{ $supir->nama }}</p>
                </div>
            </div>
            <a href="{{ route('supir.index') }}" class="btn-back">← Kembali</a>
        </div>

        <div class="form-body">
            <form method="post" action="/supir/{{ $supir->noktp }}" enctype="multipart/form-data">
                @method('put') @csrf

                <div class="section-label">Data Identitas</div>
                <div class="fgroup">
                    <label>NIK / No. KTP</label>
                    <input type="text" class="fcontrol @error('noktp') is-invalid @enderror"
                        name="noktp" value="{{ $supir->noktp }}" placeholder="16 digit NIK">
                    @error('noktp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="fgroup">
                    <label>Nama Lengkap</label>
                    <input type="text" class="fcontrol @error('nama') is-invalid @enderror"
                        name="nama" value="{{ $supir->nama }}" placeholder="Nama sesuai KTP">
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="section-label">Kontak & Lokasi</div>
                <div class="fgroup">
                    <label>Alamat</label>
                    <input type="text" class="fcontrol @error('alamat') is-invalid @enderror"
                        name="alamat" value="{{ $supir->alamat }}" placeholder="Alamat lengkap">
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="fgroup">
                    <label>No. Handphone</label>
                    <input type="text" class="fcontrol @error('nohpsupir') is-invalid @enderror"
                        name="nohpsupir" value="{{ $supir->nohpsupir }}" placeholder="08xxxxxxxxxx">
                    @error('nohpsupir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="section-label">Foto Driver</div>
                <div class="fgroup">
                    @if($supir->image)
                    <div class="current-photo">
                        <img src="{{ asset('storage/' . $supir->image) }}" alt="Foto saat ini">
                        <div>
                            <div class="current-photo-name">Foto saat ini</div>
                            <div class="current-photo-info">Kosongkan jika tidak ingin mengganti</div>
                        </div>
                    </div>
                    @endif
                    <input type="hidden" name="oldimage" value="{{ $supir->image }}">
                    <div class="file-zone">
                        <input type="file" name="image" id="imageInput" accept="image/*" onchange="previewImage(this)">
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