<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPERSURAT - DPRD Prov. Sumsel</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #1B5E20;
            --secondary-green: #2E7D32;
            --accent-gold: #C9A227;
            --light-bg: #f8f9fa;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-bg);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Playfair Display', serif;
        }

        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            transition: all 0.25s ease;
        }

        /* Overlay */
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            cursor: pointer;
        }

        /* Sidebar Styling */
        #sidebar-wrapper {
            min-height: 100vh;
            width: var(--sidebar-width);
            margin-left: 0; /* Visible by default on desktop */
            transition: margin 0.25s ease-out;
            background: linear-gradient(180deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        /* Custom Scrollbar for Sidebar */
        #sidebar-wrapper::-webkit-scrollbar {
            width: 6px;
        }
        #sidebar-wrapper::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }
        #sidebar-wrapper::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }
        #sidebar-wrapper::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 2rem 1.5rem;
            text-align: center;
            background: rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }

        #sidebar-wrapper .list-group {
            width: var(--sidebar-width);
            padding: 0 1rem;
        }

        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            color: rgba(255,255,255,0.8);
            border: none;
            padding: 0.8rem 1.2rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        #sidebar-wrapper .list-group-item i {
            font-size: 1.2rem;
            margin-right: 12px;
            transition: transform 0.3s ease;
        }

        #sidebar-wrapper .list-group-item:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            padding-left: 1.5rem;
            transform: translateX(5px);
        }

        #sidebar-wrapper .list-group-item:hover i {
            transform: scale(1.1);
            color: var(--accent-gold);
        }

        #sidebar-wrapper .list-group-item.active {
            background: rgba(255,255,255,0.2);
            color: var(--accent-gold);
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            backdrop-filter: blur(5px);
            border-left: none; /* Removed border-left */
        }

        #sidebar-wrapper .list-group-item.active i {
            color: var(--accent-gold);
        }


        /* Content Wrapper */
        #page-content-wrapper {
            width: 100%;
            margin-left: var(--sidebar-width); /* Push content to right */
            transition: margin 0.25s ease-out;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Toggled State (Desktop - Hide Sidebar) */
        #wrapper.toggled #sidebar-wrapper {
            margin-left: calc(var(--sidebar-width) * -1);
        }

        #wrapper.toggled #page-content-wrapper {
            margin-left: 0;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: calc(var(--sidebar-width) * -1); /* Hidden by default on mobile */
            }

            #page-content-wrapper {
                margin-left: 0; /* Full width by default */
            }

            /* Toggled State (Mobile - Show Sidebar) */
            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
                box-shadow: 0 0 15px rgba(0,0,0,0.5);
            }

            #wrapper.toggled #page-content-wrapper {
                margin-left: 0; /* Content stays underneath */
            }
            
            /* Show Overlay when toggled on mobile */
            #wrapper.toggled #overlay {
                display: block;
            }
        }

        /* Navbar */
        .navbar-custom {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border-bottom: 3px solid var(--accent-gold);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .text-custom-gold {
            color: var(--accent-gold) !important;
        }

        /* Cards */
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .card-custom:hover {
            transform: translateY(-5px);
        }
        .card-header-custom {
            background-color: var(--primary-green);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }

        /* Buttons */
        .btn-gold {
            background-color: var(--accent-gold);
            color: white;
            border: none;
        }
        .btn-gold:hover {
            background-color: #b08d21;
            color: white;
        }
        .btn-outline-gold {
            border-color: var(--accent-gold);
            color: var(--primary-green);
        }
        .btn-outline-gold:hover {
            background-color: var(--accent-gold);
            color: white;
        }

        /* Badges */
        .badge-status {
            font-weight: 500;
            padding: 0.5em 0.8em;
        }
    </style>
</head>
<body>

    <div class="d-flex" id="wrapper">
        <!-- Overlay for Mobile -->
        <div id="overlay"></div>

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-center">
                <a href="{{ route('dashboard') }}" class="text-decoration-none">
                    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                        <img src="{{ asset('img/logo.jpg') }}" alt="Logo" style="max-height: 50px; max-width: 50px;">
                    </div>
                    <div style="font-size: 0.9rem; font-family: 'Playfair Display', serif; color: var(--accent-gold); letter-spacing: 1px; font-weight: bold;">DPRD PROV. SUMSEL</div>
                </a>
            </div>
            <div class="list-group list-group-flush mt-2">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('surat-masuk') }}" class="list-group-item list-group-item-action {{ request()->routeIs('surat-masuk*') ? 'active' : '' }}">
                    <i class="bi bi-inbox-fill"></i> <span>Surat Masuk</span>
                </a>
                <a href="{{ route('surat-keluar') }}" class="list-group-item list-group-item-action {{ request()->routeIs('surat-keluar*') ? 'active' : '' }}">
                    <i class="bi bi-send-fill"></i> <span>Surat Keluar</span>
                </a>
                <a href="{{ route('arsip') }}" class="list-group-item list-group-item-action {{ request()->routeIs('arsip') ? 'active' : '' }}">
                    <i class="bi bi-archive-fill"></i> <span>Arsip Digital</span>
                </a>
            </div>
            <div class="mt-auto p-3 m-3 rounded" style="background: rgba(0,0,0,0.2);">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-person-circle fs-3 text-white-50"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <small class="text-white-50 d-block" style="font-size: 0.75rem;">Logged in as</small>
                        <strong class="text-white" style="font-size: 0.9rem;">{{ session('user_role', 'Guest') }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-custom px-4 py-3">
                <div class="d-flex align-items-center w-100 justify-content-between">
                    <button class="btn btn-outline-gold" id="menu-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    
                    <a href="{{ route('dashboard') }}" class="navbar-brand mb-0 h1 ms-3 text-custom-gold d-none d-md-block text-decoration-none">
                        Sistem Informasi Persuratan
                    </a>

                    <div class="dropdown">
                        <button class="btn btn-link text-dark text-decoration-none dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5 me-1" style="color: var(--primary-green)"></i> {{ session('user_name', 'User') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid py-4 px-4">
                @yield('content')
            </div>
            
            <footer class="text-center py-4 text-muted small">
                &copy; 2026 DPRD Provinsi Sumatera Selatan. All Rights Reserved.
            </footer>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");
        var overlay = document.getElementById("overlay");

        function toggleMenu() {
            el.classList.toggle("toggled");
        }

        toggleButton.onclick = toggleMenu;
        overlay.onclick = toggleMenu;

        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    @stack('scripts')
</body>
</html>
