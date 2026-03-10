<aside class="sidebar" id="adminSidebar">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap');

    .sidebar { display: flex; flex-direction: column; }

    .sb-brand {
        padding: 1.5rem 1.2rem 1.1rem;
        border-bottom: 1px solid rgba(201,168,76,0.12);
        flex-shrink: 0;
    }
    .sb-brand-logo { display: flex; align-items: center; gap: .7rem; text-decoration: none; }
    .sb-brand-icon {
        width: 40px; height: 40px;
        background: linear-gradient(135deg, #C9A84C, #8a6010);
        border-radius: 11px; display: flex; align-items: center;
        justify-content: center; font-size: 1.15rem; flex-shrink: 0;
        box-shadow: 0 0 18px rgba(201,168,76,0.28);
    }
    .sb-brand-name {
        font-family: 'Syne', sans-serif; font-size: 1.05rem;
        font-weight: 800; color: #fff; line-height: 1.1;
    }
    .sb-brand-name span { color: #C9A84C; }
    .sb-brand-sub { font-size: .62rem; color: #444; letter-spacing: .07em; text-transform: uppercase; margin-top: 2px; }

    .sb-user {
        margin: .9rem .8rem .4rem;
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(201,168,76,0.1);
        border-radius: 12px; padding: .75rem .9rem;
        display: flex; align-items: center; gap: .7rem;
    }
    .sb-user-avatar {
        width: 32px; height: 32px;
        background: linear-gradient(135deg, #C9A84C, #7a5c10);
        border-radius: 50%; display: flex; align-items: center;
        justify-content: center; font-size: .8rem; font-weight: 700;
        color: #000; flex-shrink: 0; font-family: 'Syne', sans-serif;
    }
    .sb-user-name { font-size: .82rem; font-weight: 600; color: #ddd; }
    .sb-user-role { font-size: .62rem; color: #444; text-transform: uppercase; letter-spacing: .06em; }

    .sb-nav { flex: 1; padding: .4rem .7rem; overflow-y: auto; }
    .sb-nav::-webkit-scrollbar { width: 3px; }
    .sb-nav::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.12); }

    .sb-section {
        font-size: .58rem; font-weight: 700; letter-spacing: .14em;
        color: #333; text-transform: uppercase;
        padding: .9rem .5rem .35rem;
    }

    .sb-item {
        display: flex; align-items: center; gap: .7rem;
        padding: .6rem .85rem; border-radius: 10px;
        color: #555; font-size: .83rem; font-weight: 500;
        text-decoration: none; transition: all .17s;
        margin-bottom: 2px; position: relative;
    }
    .sb-item:hover { background: rgba(201,168,76,0.08); color: #C9A84C; text-decoration: none; }
    .sb-item.active {
        background: rgba(201,168,76,0.1); color: #C9A84C;
        border: 1px solid rgba(201,168,76,0.18);
    }
    .sb-item.active::before {
        content: ''; position: absolute; left: -1px; top: 22%; bottom: 22%;
        width: 3px; background: #C9A84C; border-radius: 0 3px 3px 0;
    }
    .sb-icon { font-size: .95rem; width: 18px; text-align: center; flex-shrink: 0; }

    .sb-footer { padding: .7rem; border-top: 1px solid rgba(201,168,76,0.08); flex-shrink: 0; }
    .sb-logout {
        display: flex; align-items: center; gap: .7rem;
        padding: .6rem .85rem; border-radius: 10px;
        color: #444; font-size: .83rem; text-decoration: none; transition: all .17s;
    }
    .sb-logout:hover { background: rgba(239,68,68,0.08); color: #f87171; text-decoration: none; }
</style>

    <!-- BRAND -->
    <div class="sb-brand">
        <a href="{{ route('home.admin') }}" class="sb-brand-logo">
            <div class="sb-brand-icon">🚗</div>
            <div>
                <div class="sb-brand-name">DVJR <span>Rent</span></div>
                <div class="sb-brand-sub">Admin Panel</div>
            </div>
        </a>
    </div>

    <!-- USER -->
    @auth('admin')
    <div class="sb-user">
        <div class="sb-user-avatar">{{ strtoupper(substr(auth('admin')->user()->username ?? 'A', 0, 1)) }}</div>
        <div>
            <div class="sb-user-name">{{ auth('admin')->user()->username ?? 'Admin' }}</div>
            <div class="sb-user-role">Administrator</div>
        </div>
    </div>
    @endauth

    <!-- NAV -->
    <nav class="sb-nav">
        <div class="sb-section">Utama</div>
        <a href="{{ route('home.admin') }}" class="sb-item {{ request()->routeIs('home.admin') ? 'active' : '' }}">
            <span class="sb-icon">🏠</span> Dashboard
        </a>
        <a href="{{ route('mobil.index') }}" class="sb-item {{ request()->routeIs('mobil.*') ? 'active' : '' }}">
            <span class="sb-icon">🚙</span> Armada Mobil
        </a>
        <a href="{{ route('supir.index') }}" class="sb-item {{ request()->routeIs('supir.*') ? 'active' : '' }}">
            <span class="sb-icon">👤</span> Driver
        </a>

        <div class="sb-section">Transaksi</div>
        <a href="{{ route('transaksi') }}" class="sb-item {{ request()->is('transaksi') ? 'active' : '' }}">
            <span class="sb-icon">🔍</span> Verifikasi
        </a>
        <a href="{{ route('pengembalian') }}" class="sb-item {{ request()->is('pengembalian') ? 'active' : '' }}">
            <span class="sb-icon">📋</span> Pengembalian
        </a>
        <a href="{{ route('keuangan') }}" class="sb-item {{ request()->is('keuangan') ? 'active' : '' }}">
            <span class="sb-icon">💰</span> Keuangan
        </a>
    </nav>

    <!-- LOGOUT -->
    <div class="sb-footer">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();"
           class="sb-logout">
            <span class="sb-icon">🚪</span> Keluar
        </a>
        <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>
</aside>