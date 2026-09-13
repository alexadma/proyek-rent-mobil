@extends('layouts.mainadmin')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --gold: #C9A84C;
        --gold-light: #F0D080;
        --gold-dim: rgba(201,168,76,0.12);
        --gold-glow: rgba(201,168,76,0.25);
        --dark: #0A0A0A;
        --dark-2: #111111;
        --dark-3: #1A1A1A;
        --dark-4: #222222;
        --border: rgba(201,168,76,0.15);
        --border-light: rgba(201,168,76,0.08);
        --text-muted: #888;
        --text-muted-light: #aaa;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #3b82f6;
    }
    
    body { 
        background: var(--dark); 
        font-family: 'DM Sans', sans-serif; 
        margin: 0;
        color: #fff;
    }

    .home-wrap {
        min-height: 100vh;
        background: var(--dark);
        padding: 2.5rem 1.5rem;
    }

    /* HERO SECTION */
    .hero-card {
        position: relative; 
        overflow: hidden;
        background: linear-gradient(135deg, var(--dark-2) 0%, var(--dark-3) 100%);
        border: 1px solid var(--border);
        border-radius: 32px; 
        padding: 3rem 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
    
    .hero-card::before {
        content: ''; 
        position: absolute;
        top: -100px; 
        right: -100px;
        width: 400px; 
        height: 400px;
        background: radial-gradient(circle, var(--gold-glow) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
        animation: float 10s ease-in-out infinite;
    }
    
    .hero-card::after {
        content: ''; 
        position: absolute;
        bottom: -80px; 
        left: 30%;
        width: 300px; 
        height: 300px;
        background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
        animation: floatReverse 15s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-20px, 20px); }
    }

    @keyframes floatReverse {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(20px, -20px); }
    }

    .logo-wrap {
        margin-bottom: 2rem;
        position: relative;
        z-index: 1;
    }
    
    .logo-wrap img {
        max-width: 220px; 
        width: 100%;
        filter: drop-shadow(0 8px 24px var(--gold-glow));
        transition: transform .3s;
    }
    
    .logo-wrap img:hover { 
        transform: scale(1.02) rotate(-1deg); 
    }

    .hero-eyebrow {
        font-size: .75rem; 
        font-weight: 600; 
        letter-spacing: .2em;
        color: var(--gold); 
        text-transform: uppercase; 
        margin-bottom: 1rem;
        display: flex; 
        align-items: center; 
        gap: .8rem;
        position: relative;
        z-index: 1;
    }
    
    .hero-eyebrow::before {
        content: ''; 
        width: 32px; 
        height: 2px; 
        background: linear-gradient(90deg, var(--gold), transparent);
    }

    .hero-title {
        font-family: 'Syne', sans-serif;
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 800; 
        color: #fff; 
        line-height: 1.1;
        margin: 0 0 .5rem;
        position: relative;
        z-index: 1;
    }
    
    .hero-title .accent { 
        color: var(--gold);
        position: relative;
        display: inline-block;
    }
    
    .hero-title .accent::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 100%;
        height: 8px;
        background: var(--gold-dim);
        z-index: -1;
        border-radius: 4px;
    }

    .hero-sub {
        color: var(--text-muted-light); 
        font-size: 1rem; 
        margin-top: 1rem;
        max-width: 520px; 
        line-height: 1.7;
        position: relative;
        z-index: 1;
    }

    /* STATS CARDS - ENHANCED */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem; 
        margin-top: 3rem;
        position: relative;
        z-index: 1;
    }
    
    .stat-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--border-light);
        border-radius: 20px; 
        padding: 1.5rem 1.2rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative; 
        overflow: hidden;
        backdrop-filter: blur(10px);
    }
    
    .stat-card::before {
        content: ''; 
        position: absolute;
        top: 0; 
        left: 0; 
        right: 0; 
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--gold), transparent);
        transform: translateX(-100%);
        transition: transform 0.5s ease;
    }
    
    .stat-card:hover { 
        background: rgba(201,168,76,0.08); 
        border-color: var(--gold);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(201,168,76,0.15);
    }
    
    .stat-card:hover::before { 
        transform: translateX(100%); 
    }

    .stat-icon { 
        font-size: 1.8rem; 
        margin-bottom: 1rem;
        color: var(--gold);
        transition: transform 0.3s;
    }
    
    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .stat-value {
        font-family: 'Syne', sans-serif; 
        font-weight: 800;
        font-size: 1.8rem; 
        color: #fff; 
        margin-bottom: 0.25rem;
        line-height: 1.2;
    }
    
    .stat-label { 
        font-size: 0.8rem; 
        color: var(--text-muted); 
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }

    .stat-trend {
        font-size: 0.75rem;
        margin-top: 0.5rem;
        color: var(--success);
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .stat-trend.negative { color: var(--danger); }

    /* SECTION TITLE */
    .section-title {
        font-family: 'Syne', sans-serif; 
        font-size: 0.9rem; 
        font-weight: 700;
        letter-spacing: 0.15em; 
        color: var(--gold); 
        text-transform: uppercase;
        margin: 2.5rem 0 1.5rem; 
        display: flex; 
        align-items: center; 
        gap: 1rem;
    }
    
    .section-title::before { 
        content: ''; 
        width: 40px; 
        height: 2px; 
        background: var(--gold); 
    }
    
    .section-title::after { 
        content: ''; 
        flex: 1; 
        height: 1px; 
        background: linear-gradient(90deg, var(--border), transparent); 
    }

    /* QUICK ACTIONS - ENHANCED */
    .actions-grid {
        display: grid; 
        grid-template-columns: repeat(4, 1fr); 
        gap: 1.2rem;
    }
    
    .action-btn {
        background: linear-gradient(135deg, var(--dark-2), var(--dark-3));
        border: 1px solid var(--border-light);
        border-radius: 24px; 
        padding: 2rem 1.5rem; 
        text-decoration: none;
        display: flex; 
        flex-direction: column; 
        gap: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative; 
        overflow: hidden;
    }
    
    .action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at top right, var(--gold-dim), transparent 70%);
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .action-btn:hover {
        border-color: var(--gold);
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(201,168,76,0.2);
        text-decoration: none;
    }
    
    .action-btn:hover::before {
        opacity: 1;
    }
    
    .action-icon { 
        font-size: 2.2rem;
        color: var(--gold);
        transition: transform 0.3s;
        position: relative;
        z-index: 1;
    }
    
    .action-btn:hover .action-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .action-title {
        font-family: 'Syne', sans-serif; 
        font-size: 1.1rem;
        font-weight: 700; 
        color: #fff;
        position: relative;
        z-index: 1;
    }
    
    .action-desc { 
        font-size: 0.85rem; 
        color: var(--text-muted);
        line-height: 1.5;
        position: relative;
        z-index: 1;
    }

    /* STATUS BAR - ENHANCED */
    .status-bar {
        background: linear-gradient(135deg, var(--dark-2), var(--dark-3));
        border: 1px solid var(--border);
        border-radius: 60px; 
        padding: 1rem 1.8rem;
        margin-top: 2.5rem;
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        gap: 1rem;
        flex-wrap: wrap;
        backdrop-filter: blur(10px);
    }
    
    .status-dot {
        width: 10px; 
        height: 10px; 
        background: var(--success);
        border-radius: 50%; 
        display: inline-block;
        box-shadow: 0 0 15px var(--success);
        animation: pulse 2s ease-in-out infinite;
        margin-right: 0.75rem;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); } 
        50% { opacity: 0.5; transform: scale(1.2); }
    }
    
    .status-text { 
        font-size: 0.9rem; 
        color: var(--text-muted-light);
        display: flex;
        align-items: center;
    }

    .status-badge {
        background: var(--gold-dim);
        color: var(--gold);
        padding: 0.25rem 1rem;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        border: 1px solid var(--border);
    }

    /* RECENT ACTIVITIES */
    .activities-card {
        background: linear-gradient(135deg, var(--dark-2), var(--dark-3));
        border: 1px solid var(--border);
        border-radius: 24px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .activities-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .activities-title {
        font-family: 'Syne', sans-serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .activities-title i {
        color: var(--gold);
    }

    .view-all {
        color: var(--gold);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: gap 0.3s;
    }

    .view-all:hover {
        gap: 0.75rem;
        color: var(--gold-light);
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-light);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        background: var(--gold-dim);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold);
        font-size: 1.2rem;
    }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        color: #fff;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .activity-time {
        color: var(--text-muted);
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .activity-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-success { background: rgba(16, 185, 129, 0.1); color: var(--success); }
    .badge-warning { background: rgba(245, 158, 11, 0.1); color: var(--warning); }
    .badge-info { background: rgba(59, 130, 246, 0.1); color: var(--info); }
    .badge-danger { background: rgba(239, 68, 68, 0.1); color: var(--danger); }
    .badge-secondary { background: rgba(136, 136, 136, 0.1); color: var(--text-muted); }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 640px) {
        .home-wrap { 
            padding: 1.5rem 1rem; 
        }
        
        .hero-card { 
            padding: 2rem 1.5rem; 
        }
        
        .stats-grid { 
            grid-template-columns: repeat(2, 1fr); 
            gap: 0.75rem; 
        }
        
        .stat-card { 
            padding: 1.2rem 1rem; 
        }
        
        .stat-value { 
            font-size: 1.3rem; 
        }
        
        .actions-grid { 
            grid-template-columns: 1fr; 
        }
        
        .action-btn {
            padding: 1.5rem;
        }
        
        .status-bar {
            flex-direction: column;
            align-items: flex-start;
            border-radius: 20px;
        }
    }
    
    @media (max-width: 380px) {
        .stats-grid { 
            grid-template-columns: 1fr; 
        }
    }
</style>
@endsection

@section('container')
<div class="home-wrap">
    <!-- HERO SECTION -->
    <div class="hero-card" style="animation: fadeUp .5s ease both;">
        <div class="logo-wrap">
            <img src="{{ asset('image/DVJR.png') }}" alt="Logo DVJR">
        </div>

        <div class="hero-eyebrow">
            <i class="fas fa-crown"></i>
            Admin Dashboard
        </div>
        
        <h1 class="hero-title">
            @if(auth('admin')->check())
                Selamat Datang,<br><span class="accent">{{ auth('admin')->user()->username }}</span>
            @else
                Selamat Datang,<br><span class="accent">Admin</span>
            @endif
        </h1>
        
        <p class="hero-sub">
            <i class="fas fa-quote-left" style="color: var(--gold); opacity: 0.5; margin-right: 0.5rem;"></i>
            Kelola armada dan transaksi Anda dengan lebih efisien. Semua yang Anda butuhkan tersedia di sini.
        </p>

        <!-- STATISTICS CARDS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value">{{ $transaksiPending ?? 0 }}</div>
                <div class="stat-label">Pesanan Baru</div>
                <div class="stat-trend">
                    <i class="fas fa-clock"></i> Menunggu verifikasi
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-car"></i>
                </div>
                <div class="stat-value">{{ $mobilTersedia ?? 0 }}</div>
                <div class="stat-label">Armada Tersedia</div>
                <div class="stat-trend">
                    <i class="fas fa-check-circle"></i> dari {{ $totalMobil ?? 0 }} total
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ $totalSupir ?? 0 }}</div>
                <div class="stat-label">Supir Aktif</div>
                <div class="stat-trend">
                    <i class="fas fa-user-check"></i> Siap melayani
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-value">Rp {{ number_format(($totalPendapatan ?? 0) / 1000000, 1, ',', '.') }}jt</div>
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-trend">
                    <i class="fas fa-receipt"></i> {{ $transaksiDiterima ?? 0 }} transaksi aktif
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK ACTIONS SECTION -->
    <div class="section-title">
        <i class="fas fa-bolt"></i>
        AKSI CEPAT
    </div>
    
    <div class="actions-grid" style="animation: fadeUp .6s .1s ease both; opacity:0; animation-fill-mode: forwards;">
        <a href="{{ route('mobil.index') }}" class="action-btn">
            <div class="action-icon">
                <i class="fas fa-car-side"></i>
            </div>
            <div class="action-title">Kelola Armada</div>
            <div class="action-desc">
                <i class="fas fa-plus-circle" style="font-size: 0.7rem; margin-right: 0.25rem;"></i>
                Tambah, edit, atau hapus kendaraan
            </div>
        </a>
        
        <a href="#" class="action-btn">
            <div class="action-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="action-title">Transaksi</div>
            <div class="action-desc">
                <i class="fas fa-clock" style="font-size: 0.7rem; margin-right: 0.25rem;"></i>
                Lihat & verifikasi 12 pesanan baru
            </div>
        </a>
        
        <a href="#" class="action-btn">
            <div class="action-icon">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div class="action-title">Laporan</div>
            <div class="action-desc">
                <i class="fas fa-file-pdf" style="font-size: 0.7rem; margin-right: 0.25rem;"></i>
                Ringkasan keuangan & statistik
            </div>
        </a>
        
        <a href="#" class="action-btn">
            <div class="action-icon">
                <i class="fas fa-sliders-h"></i>
            </div>
            <div class="action-title">Pengaturan</div>
            <div class="action-desc">
                <i class="fas fa-user-cog" style="font-size: 0.7rem; margin-right: 0.25rem;"></i>
                Konfigurasi sistem & profil
            </div>
        </a>
    </div>

    <!-- RECENT ACTIVITIES -->
    <div class="activities-card" style="animation: fadeUp .6s .2s ease both; opacity:0; animation-fill-mode: forwards;">
        <div class="activities-header">
            <div class="activities-title">
                <i class="fas fa-history"></i>
                Aktivitas Terbaru
            </div>
            <a href="#" class="view-all">
                Lihat Semua <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        @if($recentActivities->isEmpty())
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <div class="activity-content">
                    <div class="activity-text">Belum ada aktivitas terbaru</div>
                    <div class="activity-time">
                        <i class="far fa-clock"></i> —
                    </div>
                </div>
            </div>
        @else
            @foreach($recentActivities as $akt)
                @php
                    $verif = $akt->verifikasi;
                    if ($verif === 'Requested') {
                        $badgeClass = 'badge-warning';
                        $badgeText = 'Menunggu';
                        $icon = 'fa-clock';
                    } elseif ($verif === 'DITERIMA') {
                        $badgeClass = 'badge-success';
                        $badgeText = 'Diterima';
                        $icon = 'fa-check-circle';
                    } elseif ($verif === 'SELESAI') {
                        $badgeClass = 'badge-info';
                        $badgeText = 'Selesai';
                        $icon = 'fa-flag-checkered';
                    } elseif ($verif === 'DITOLAK') {
                        $badgeClass = 'badge-danger';
                        $badgeText = 'Ditolak';
                        $icon = 'fa-times-circle';
                    } else {
                        $badgeClass = 'badge-secondary';
                        $badgeText = $verif;
                        $icon = 'fa-info-circle';
                    }

                    $timeDiff = $akt->created_at->diffForHumans();
                    $durasiJam = \Carbon\Carbon::parse($akt->tanggal_pinjam)->diffInHours(\Carbon\Carbon::parse($akt->tanggal_kembali));
                    $hari = floor($durasiJam / 24);
                    $jam = $durasiJam % 24;
                    $durasiText = $hari > 0 ? $hari.' Hari' : '';
                    $durasiText .= $jam > 0 ? ($hari > 0 ? ' '.$jam.' Jam' : $jam.' Jam') : '';
                @endphp
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-text">
                            <strong>#{{ $akt->no_invoice }}</strong> — {{ $akt->nama_customer }} menyewa <strong>{{ $akt->nama_mobil }}</strong>
                            @if($akt->nama_supir !== 'TANPA SUPIR')
                                dengan supir {{ $akt->nama_supir }}
                            @endif
                        </div>
                        <div class="activity-time">
                            <i class="far fa-clock"></i> {{ $akt->tanggal_pinjam }} → {{ $akt->tanggal_kembali }} ({{ $durasiText }})
                        </div>
                    </div>
                    <span class="activity-badge {{ $badgeClass }}">{{ $badgeText }}</span>
                </div>
            @endforeach
        @endif
    </div>

    <!-- STATUS BAR -->
    <div class="status-bar" style="animation: fadeUp .6s .3s ease both; opacity:0; animation-fill-mode: forwards;">
        <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
            <span class="status-text">
                <span class="status-dot"></span>
                <i class="fas fa-check-circle" style="color: var(--success); margin-right: 0.5rem;"></i>
                Sistem berjalan normal
            </span>
            <span class="status-badge">
                <i class="fas fa-database"></i> Backup terakhir: 2 jam lalu
            </span>
        </div>
        
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <i class="far fa-calendar-alt" style="color: var(--gold);"></i>
            <span class="status-text">{{ now()->format('d F Y, H:i') }} WIB</span>
        </div>
    </div>
</div>

<style>
@keyframes fadeUp {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

/* Custom scrollbar untuk activities */
.activities-card::-webkit-scrollbar {
    width: 4px;
}

.activities-card::-webkit-scrollbar-track {
    background: var(--dark-3);
}

.activities-card::-webkit-scrollbar-thumb {
    background: var(--gold);
    border-radius: 4px;
}
</style>

<script>
// Animasi smooth untuk hover cards
document.querySelectorAll('.stat-card, .action-btn').forEach(card => {
    card.addEventListener('mouseenter', function(e) {
        this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    });
});

// Update waktu real-time (opsional)
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleString('id-ID', { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit' 
    }) + ' WIB';
    
    const timeElement = document.querySelector('.status-bar span:last-child');
    if (timeElement) {
        timeElement.textContent = timeString;
    }
}

// Uncomment untuk update real-time setiap menit
// setInterval(updateTime, 60000);
</script>
@endsection