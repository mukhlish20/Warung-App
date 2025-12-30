<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Warung App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#7367f0">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/x-icon" href="/build/favicon.ico">

    <style>
        /* =====================
           DESIGN SYSTEM (SNEAT-LIKE)
        ====================== */
        :root {
            --primary: #7367f0;
            --primary-soft: #e9e7fd;
            --success: #28c76f;
            --danger: #ea5455;
            --warning: #ff9f43;
            --bg: #f4f5fa;
            --card: #ffffff;
            --text: #4b4b4b;
            --muted: #9e9e9e;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* =====================
           BUTTON
        ====================== */
        .btn {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn.secondary {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .btn.danger {
            background: var(--danger);
            color: #fff;
        }

        .btn.warning {
            background: var(--warning);
            color: #fff;
        }

        .btn.success {
            background: var(--success);
            color: #fff;
        }

        /* =====================
           HEADER / TOP BAR
        ====================== */
        header {
            background: var(--card);
            padding: 14px 24px;
            border-bottom: 1px solid #eaeaea;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand {
            font-weight: 700;
            font-size: 18px;
            color: var(--primary);
        }

        nav {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        nav a {
            text-decoration: none;
            font-weight: 500;
            color: var(--text);
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        nav a:hover {
            color: var(--primary);
            background: var(--primary-soft);
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 10px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: bold;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            padding: 8px;
            color: var(--text);
        }

        .mobile-nav {
            display: none;
        }

        /* =====================
           MAIN CONTAINER
        ====================== */
        .container {
            max-width: 1200px;
            margin: 24px auto;
            padding: 0 16px;
        }

        h2 {
            margin: 0 0 6px;
        }

        .subtitle {
            color: var(--muted);
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* =====================
           CARD
        ====================== */
        .card {
            background: var(--card);
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
        }

        .card-title {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .card-value {
            font-size: 22px;
            font-weight: 700;
        }

        /* =====================
           TABLE
        ====================== */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #eee;
            font-size: 14px;
        }

        .table th {
            background: #fafafa;
            text-transform: uppercase;
            font-size: 12px;
            color: var(--muted);
            text-align: left;
        }

        .table tr:hover {
            background: #f9f9ff;
        }

        /* =====================
           DASHBOARD GRID
        ====================== */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-bottom: 24px;
        }

        .grid-full {
            grid-column: 1 / -1;
        }

        /* =====================
           FORM ELEMENTS
        ====================== */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border-radius: 6px;
            border: 1px solid #d8d6de;
            font-size: 14px;
            color: #6e6b7b;
            background: #fff;
            font-family: inherit;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(115, 103, 240, 0.1);
        }

        label {
            display: block;
            font-size: 13px;
            color: #6e6b7b;
            margin-bottom: 8px;
            font-weight: 500;
        }

        /* =====================
           MOBILE UTILITIES
        ====================== */
        .desktop-only {
            display: block;
        }

        .mobile-only {
            display: none;
        }

        /* =====================
           RESPONSIVE
        ====================== */
        @media (max-width: 768px) {
            header {
                padding: 12px 16px;
            }

            .brand {
                font-size: 16px;
            }

            /* Hide desktop nav, show mobile toggle */
            nav {
                display: none;
                position: fixed;
                top: 60px;
                left: 0;
                right: 0;
                background: var(--card);
                flex-direction: column;
                align-items: stretch;
                gap: 0;
                padding: 8px;
                border-bottom: 1px solid #eaeaea;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }

            nav.active {
                display: flex;
            }

            nav a {
                padding: 12px 16px;
                border-radius: 8px;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .container {
                padding: 0 12px;
                margin: 16px auto;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 14px;
            }

            h2 {
                font-size: 20px;
            }

            .card-value {
                font-size: 20px;
            }

            /* Table responsive */
            .desktop-only {
                display: none;
            }

            .mobile-only {
                display: block;
            }

            .table {
                font-size: 12px;
            }

            .table th,
            .table td {
                padding: 8px 6px;
            }

            /* User dropdown on mobile */
            .user-dropdown .dropdown-menu {
                right: -10px;
                min-width: 160px;
            }

            .user-name {
                display: none;
            }

            /* Buttons */
            .btn {
                width: 100%;
                padding: 10px 16px;
            }

            /* Form grid responsive */
            .form-grid-2,
            .form-grid-3 {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 8px;
            }

            header {
                padding: 10px 12px;
            }

            .card {
                padding: 12px;
                border-radius: 10px;
            }

            h2 {
                font-size: 18px;
            }

            .subtitle {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="brand">Warung App</div>

    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
        ☰
    </button>

    <nav id="mainNav">
        @auth
            {{-- OWNER MENU --}}
            @if(auth()->user()->role === 'owner')
                <a href="{{ route('owner.dashboard') }}">Dashboard</a>
                <a href="{{ route('owner.rekap') }}">Rekap Bulanan</a>
                <a href="{{ route('owner.warung.index') }}">Cabang</a>
                <a href="{{ route('owner.penjaga.index') }}">Penjaga</a>
                <a href="{{ route('owner.whatsapp.setting') }}">WhatsApp Alert</a>
            @endif

            {{-- PENJAGA MENU --}}
            @if(auth()->user()->role === 'penjaga')
                <a href="{{ route('penjaga.dashboard') }}">Dashboard</a>
                <a href="{{ route('penjaga.omset.index') }}">Input Omset</a>
            @endif

            <style>
            /* =====================
            USER DROPDOWN
            ===================== */
            .user-dropdown {
                position: relative;
            }

            .user-trigger {
                display: flex;
                align-items: center;
                gap: 8px;
                cursor: pointer;
                padding: 6px 10px;
                border-radius: 8px;
            }

            .user-trigger:hover {
                background: #f4f5fa;
            }

            .user-name {
                font-weight: 500;
            }

            .dropdown-menu {
                position: absolute;
                right: 0;
                top: 48px;
                background: #fff;
                border-radius: 10px;
                min-width: 180px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.08);
                display: none;
                overflow: hidden;
                z-index: 999;
            }

            .dropdown-menu a,
            .dropdown-menu button {
                display: block;
                width: 100%;
                padding: 10px 14px;
                text-align: left;
                border: none;
                background: none;
                font-size: 14px;
                color: #4b4b4b;
                cursor: pointer;
                text-decoration: none;
            }

            .dropdown-menu a:hover,
            .dropdown-menu button:hover {
                background: #f4f5fa;
            }

            /* Show on hover */
            .user-dropdown:hover .dropdown-menu {
                display: block;
            }
            </style>

            <div class="user-dropdown">

                <div class="user-trigger">
                    <span class="user-name">
                        {{ auth()->user()->role === 'owner' ? 'Owner' : 'Penjaga' }}
                    </span>

                    <div class="avatar">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/'.auth()->user()->avatar) }}"
                                style="width:36px;height:36px;border-radius:50%;object-fit:cover">
                        @else
                            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                        @endif
                    </div>
                </div>

                <div class="dropdown-menu">
                    <a href="{{ route('profile.index') }}">
                        ✏️ Edit Profil
                    </a>

                    <a href="{{ route('profile.index') }}">
                        🔒 Ganti Password
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">
                            🚪 Logout
                        </button>
                    </form>
                </div>

            </div>

        @endauth
    </nav>
</header>

<div class="container">
    @yield('content')
</div>

<script>
    function toggleMobileMenu() {
        const nav = document.getElementById('mainNav');
        nav.classList.toggle('active');
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const nav = document.getElementById('mainNav');
        const toggle = document.querySelector('.mobile-menu-toggle');

        if (nav && toggle && !nav.contains(event.target) && !toggle.contains(event.target)) {
            nav.classList.remove('active');
        }
    });

    // Close mobile menu when clicking a link
    document.querySelectorAll('#mainNav a').forEach(link => {
        link.addEventListener('click', function() {
            document.getElementById('mainNav').classList.remove('active');
        });
    });
</script>

</body>
</html>
