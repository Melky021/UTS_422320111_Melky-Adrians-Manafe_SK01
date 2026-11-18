<aside class="sidebar">
    <a href="{{ route('dashboard') }}" class="brand">
        <span class="brand-mark">
            <svg viewBox="0 0 40 40" width="24" height="24" aria-hidden="true">
                <path d="M20 27V18" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" fill="none"/>
                <path d="M20 22C14 22 10.5 18 10.5 12.5 16 12.5 20 15.5 20 22Z" fill="currentColor"/>
                <path d="M20 18.5C20 12.5 24 9 29.5 9 29.5 14.5 25.5 18.5 20 18.5Z" fill="currentColor"/>
                <ellipse cx="20" cy="31" rx="5.5" ry="3.4" fill="#f2c14e"/>
            </svg>
        </span>
        <span>
            <strong>Bank Benih</strong>
            <small>Pusaka</small>
        </span>
    </a>

    <nav class="nav">
        <a href="{{ route('dashboard') }}" @class(['nav-link', 'is-active' => request()->routeIs('dashboard')])>Dashboard</a>
        <a href="{{ route('aksesi.index') }}" @class(['nav-link', 'is-active' => request()->routeIs('aksesi.*')])>Aksesi Benih</a>
        <a href="{{ route('kelompok-tanaman.index') }}" @class(['nav-link', 'is-active' => request()->routeIs('kelompok-tanaman.*')])>Kelompok Tanaman</a>
        <a href="{{ route('perlakuan.index') }}" @class(['nav-link', 'is-active' => request()->routeIs('perlakuan.*')])>Perlakuan Simpan</a>
    </nav>

    <p class="sidebar-note">Koleksi varietas lokal Nusantara.</p>
</aside>
