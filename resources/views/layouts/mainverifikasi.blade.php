<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DVJR Rent Cars | Verifikasi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')

    <style>
        :root {
            --sidebar-w: 255px;
            --gold: #C9A84C;
            --dark: #0A0A0A;
            --dark-2: #111111;
            --dark-3: #1A1A1A;
            --border: rgba(201,168,76,0.15);
            --topbar-h: 56px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { background: var(--dark); min-height: 100vh; font-family: 'DM Sans', sans-serif; color: #fff; }
        .sidebar { position: fixed; top: 0; left: 0; width: var(--sidebar-w); height: 100vh; background: var(--dark-2); border-right: 1px solid var(--border); z-index: 200; transition: transform .28s cubic-bezier(.4,0,.2,1); overflow-y: auto; overflow-x: hidden; scrollbar-width: thin; scrollbar-color: rgba(201,168,76,0.15) transparent; }
        .sidebar::-webkit-scrollbar { width: 3px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(201,168,76,0.15); }
        .main-content { margin-left: var(--sidebar-w); min-height: 100vh; transition: margin-left .28s; }
        .session-alert { margin: 1rem 1.5rem 0; border-radius: 12px; font-size: .85rem; }
        .mobile-topbar { display: none; position: fixed; top: 0; left: 0; right: 0; height: var(--topbar-h); background: var(--dark-2); border-bottom: 1px solid var(--border); align-items: center; padding: 0 1rem; gap: .8rem; z-index: 199; }
        .mobile-menu-btn { background: none; border: 1px solid var(--border); cursor: pointer; color: var(--gold); padding: .4rem .5rem; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .mobile-brand { font-family: 'Syne', sans-serif; font-size: .95rem; font-weight: 800; color: #fff; }
        .mobile-brand span { color: var(--gold); }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); backdrop-filter: blur(3px); z-index: 199; opacity: 0; transition: opacity .28s ease; }
        .sidebar-overlay.open { display: block; opacity: 1; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .mobile-topbar { display: flex; }
            .main-content { margin-left: 0; padding-top: var(--topbar-h); }
        }
    </style>
    @yield('head')
</head>
<body>
    <div class="mobile-topbar">
        <button class="mobile-menu-btn" id="sidebarToggle">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <span class="mobile-brand">DVJR <span>Admin</span></span>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    @include('partials.navbaradmin')
    <div class="main-content">
        @if(session('success'))
        <div class="session-alert alert alert-success alert-dismissible fade show">
            <strong>✓</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @yield('container')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');
        const sidebar = document.querySelector('.sidebar');
        function openSidebar() { sidebar.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }
        toggleBtn?.addEventListener('click', () => sidebar.classList.contains('open') ? closeSidebar() : openSidebar());
        overlay?.addEventListener('click', closeSidebar);
        window.addEventListener('resize', () => { if (window.innerWidth > 768) closeSidebar(); });
    </script>
    @yield('scripts')
</body>
</html>