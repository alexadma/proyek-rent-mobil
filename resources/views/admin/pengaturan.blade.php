@extends('layouts.mainadmin')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --gold: #C9A84C;
        --gold-dim: rgba(201,168,76,0.12);
        --dark: #0A0A0A;
        --dark-2: #111111;
        --dark-3: #1A1A1A;
        --border: rgba(201,168,76,0.15);
        --text-muted: #888;
        --danger: #ef4444;
    }
    body { background: var(--dark); font-family: 'DM Sans', sans-serif; color: #fff; }

    .set-wrap { padding: 2rem 1.5rem; max-width: 800px; }
    .set-title {
        font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 800;
        color: #fff; margin-bottom: 1.5rem;
    }
    .set-title .accent { color: var(--gold); }

    .set-card {
        background: var(--dark-2); border: 1px solid var(--border); border-radius: 16px;
        padding: 1.75rem; margin-bottom: 1.5rem;
    }
    .set-card h3 {
        font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700;
        color: var(--gold); margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: .5rem;
        padding-bottom: 1rem; border-bottom: 1px solid var(--border);
    }

    .set-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .set-group { display: flex; flex-direction: column; gap: .35rem; }
    .set-group.full { grid-column: 1 / -1; }
    .set-group label {
        font-size: .75rem; font-weight: 600; color: var(--text-muted);
        text-transform: uppercase; letter-spacing: .04em;
    }
    .set-input {
        width: 100%; padding: .65rem .85rem; background: var(--dark-3);
        border: 1px solid var(--border); border-radius: 8px; color: #fff;
        font-size: .9rem; outline: none; transition: border-color .2s;
    }
    .set-input:focus { border-color: var(--gold); }
    .set-input:read-only { opacity: .6; cursor: not-allowed; }
    .set-input.error { border-color: var(--danger); }

    .set-error { color: var(--danger); font-size: .78rem; margin-top: .2rem; }

    .set-btn {
        margin-top: 1.25rem; padding: .7rem 2rem;
        background: linear-gradient(135deg, var(--gold), #a07a18);
        border: none; border-radius: 10px; color: #000;
        font-weight: 700; font-size: .9rem; cursor: pointer;
        transition: all .25s; display: inline-flex; align-items: center; gap: .4rem;
    }
    .set-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(201,168,76,0.3); }

    @media (max-width: 600px) {
        .set-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('container')
<div class="set-wrap">
    <div class="set-title"><i class="fas fa-cog" style="color: var(--gold);"></i> <span class="accent">Pengaturan</span> Akun</div>

    <!-- Profile Form -->
    <div class="set-card">
        <h3><i class="fas fa-user-edit"></i> Profil Admin</h3>
        <form action="{{ route('pengaturan.profile') }}" method="POST">
            @csrf
            <div class="set-grid">
                <div class="set-group">
                    <label for="username">Username</label>
                    <input class="set-input @error('username') error @enderror" type="text" id="username" name="username"
                        value="{{ old('username', $admin->username ?? '') }}" required>
                    @error('username')
                        <div class="set-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                    @enderror
                </div>
                <div class="set-group">
                    <label for="nama">Nama Lengkap</label>
                    <input class="set-input @error('nama') error @enderror" type="text" id="nama" name="nama"
                        value="{{ old('nama', $admin->nama ?? '') }}" required>
                    @error('nama')
                        <div class="set-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                    @enderror
                </div>
                <div class="set-group full">
                    <label for="alamat">Alamat</label>
                    <input class="set-input" type="text" id="alamat" name="alamat"
                        value="{{ old('alamat', $admin->alamat ?? '') }}" placeholder="Opsional">
                </div>
            </div>
            <button type="submit" class="set-btn">
                <i class="fas fa-save"></i> Simpan Profil
            </button>
        </form>
    </div>

    <!-- Password Form -->
    <div class="set-card">
        <h3><i class="fas fa-lock"></i> Ganti Password</h3>
        <form action="{{ route('pengaturan.password') }}" method="POST">
            @csrf
            <div class="set-grid">
                <div class="set-group full">
                    <label for="current_password">Password Saat Ini</label>
                    <input class="set-input @error('current_password') error @enderror" type="password" id="current_password"
                        name="current_password" placeholder="Masukkan password saat ini" required>
                    @error('current_password')
                        <div class="set-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                    @enderror
                </div>
                <div class="set-group">
                    <label for="password">Password Baru</label>
                    <input class="set-input @error('password') error @enderror" type="password" id="password"
                        name="password" placeholder="Minimal 6 karakter" required>
                    @error('password')
                        <div class="set-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                    @enderror
                </div>
                <div class="set-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input class="set-input" type="password" id="password_confirmation"
                        name="password_confirmation" placeholder="Ulangi password baru" required>
                </div>
            </div>
            <button type="submit" class="set-btn">
                <i class="fas fa-key"></i> Ganti Password
            </button>
        </form>
    </div>
</div>
@endsection
