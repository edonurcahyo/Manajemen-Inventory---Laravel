<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CV. Agung - Inventory Management')</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

    <style>
        :root {
            --primary-color: #0f2027;
            --secondary-color: #2c5364;
            --accent-color: #00acc1;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            transition: background-color 0.3s;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            transition: transform 0.3s ease-in-out;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.2s ease;
            margin-bottom: 2px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(0,172,193,0.2) 0%, transparent 100%);
            border-left: 3px solid var(--accent-color);
            color: #fff;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            background-color: #ffffff;
            min-height: 100vh;
            transition: all 0.3s;
        }

        body.dark-mode .main-content {
            background-color: #1e1e1e;
            color: #f8f9fa;
        }

        .sidebar-hidden .sidebar {
            transform: translateX(-100%);
        }

        .sidebar-hidden .main-content {
            margin-left: 0;
        }

        .burger-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: inherit;
        }

        .topbar {
            position: sticky;
            top: 0;
            background: inherit;
            z-index: 1020;
            padding: 1rem 0;
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8);
        }

        body.dark-mode .topbar {
            background-color: rgba(30, 30, 30, 0.8);
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            transition: transform 0.2s;
        }

        body.dark-mode .card {
            background-color: #2d2d2d;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.2);
        }

        .card:hover {
            transform: translateY(-2px);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Loading overlay */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
        }

        body.dark-mode #loading-overlay {
            background-color: rgba(30, 30, 30, 0.8);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1030;
            }
            .sidebar.sidebar-mobile-show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }

        @media (min-width: 769px) {
            .sidebar-hidden .sidebar {
                transform: translateX(0);
            }
            .sidebar-hidden .main-content {
                margin-left: var(--sidebar-width);
            }
        }

                /* Dark Mode Styles - Updated Version */
        body.dark-mode {
            --dark-bg: #121212;
            --dark-card: #1e1e1e;
            --dark-element: #23272b;
            --dark-border: #444;
            --dark-text: #f8f9fa;
            --dark-hover: #2d2d2d;
            --dark-accent: #00acc1;
            --dark-header: #1a1d20;
            --dark-disabled: #2d2d2d;
        }

        /* Base Elements */
        body.dark-mode .card,
        body.dark-mode .form-control,
        body.dark-mode .form-select,
        body.dark-mode .alert,
        body.dark-mode .breadcrumb,
        body.dark-mode .dropdown-menu,
        body.dark-mode .modal-content,
        body.dark-mode .list-group-item {
            background-color: var(--dark-element) !important;
            color: var(--dark-text) !important;
            border-color: var(--dark-border) !important;
        }

        /* Tables - Improved Visibility */
        body.dark-mode .table {
            --bs-table-bg: var(--dark-element);
            --bs-table-color: var(--dark-text);
            --bs-table-border-color: var(--dark-border);
            color: var(--dark-text) !important;
        }

        body.dark-mode .table th,
        body.dark-mode .table td {
            color: inherit !important;
            border-color: var(--dark-border) !important;
            background-color: var(--dark-element) !important;
        }

        body.dark-mode .table thead th,
        body.dark-mode .table tfoot th {
            background-color: var(--dark-header) !important;
            color: var(--dark-text) !important;
        }

        body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) {
            --bs-table-accent-bg: var(--dark-card);
            color: var(--dark-text);
        }

        body.dark-mode .table-hover > tbody > tr:hover {
            --bs-table-accent-bg: var(--dark-hover);
            color: var(--dark-text);
        }

        /* Form Elements */
        body.dark-mode .form-control,
        body.dark-mode .form-select,
        body.dark-mode textarea {
            background-color: var(--dark-element) !important;
            color: var(--dark-text) !important;
            border-color: var(--dark-border) !important;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            border-color: var(--dark-accent);
            box-shadow: 0 0 0 0.25rem rgba(0, 172, 193, 0.25);
        }

        body.dark-mode .form-control:disabled,
        body.dark-mode .form-select:disabled {
            background-color: var(--dark-disabled) !important;
            color: #aaa !important;
        }

        /* Interactive Elements */
        body.dark-mode .dropdown-menu {
            background-color: var(--dark-element) !important;
        }

        body.dark-mode .dropdown-item {
            color: var(--dark-text) !important;
        }

        body.dark-mode .dropdown-item:hover,
        body.dark-mode .dropdown-item:focus {
            background-color: var(--dark-hover) !important;
        }

        /* Badges */
        body.dark-mode .badge.bg-success {
            background-color: #198754 !important;
        }
        body.dark-mode .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #23272b !important;
        }
        body.dark-mode .badge.bg-danger {
            background-color: #dc3545 !important;
        }
        body.dark-mode .badge.bg-secondary {
            background-color: #6c757d !important;
        }

        /* Text Elements */
        body.dark-mode .text-muted {
            color: #aaa !important;
        }

        body.dark-mode a {
            color: #7ab4ff !important;
        }

        body.dark-mode a:hover {
            color: #9ec6ff !important;
            text-decoration: underline;
        }

        /* Transitions */
        body.dark-mode,
        body.dark-mode .card,
        body.dark-mode .table,
        body.dark-mode .form-control,
        body.dark-mode .form-select,
        body.dark-mode .alert,
        body.dark-mode .dropdown-menu,
        body.dark-mode .list-group-item {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Additional Components */
        body.dark-mode .nav-tabs .nav-link.active {
            background-color: var(--dark-element);
            border-color: var(--dark-border) var(--dark-border) var(--dark-element);
            color: var(--dark-accent);
        }

        body.dark-mode .pagination .page-item .page-link {
            background-color: var(--dark-element);
            border-color: var(--dark-border);
            color: var(--dark-text);
        }

        body.dark-mode .pagination .page-item.active .page-link {
            background-color: var(--dark-accent);
            border-color: var(--dark-accent);
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar d-flex flex-column p-3" id="sidebar" aria-label="Main navigation">
            <div class="text-center mb-4">
                <h4 class="fw-bold">CV. Agung</h4>
                <small class="text-white-50">Inventory System</small>
            </div>

            <ul class="nav flex-column px-2 mb-auto">
                @php
                    $routes = [
                        ['route' => 'dashboard', 'icon' => 'fa-tachometer-alt', 'label' => 'Dashboard'],
                        ['route' => 'products.index', 'icon' => 'fa-box', 'label' => 'Produk'],
                        ['route' => 'purchases.index', 'icon' => 'fa-shopping-cart', 'label' => 'Pembelian'],
                        ['route' => 'sales.index', 'icon' => 'fa-cash-register', 'label' => 'Penjualan'],
                        ['route' => 'reports.index', 'icon' => 'fa-chart-bar', 'label' => 'Laporan'],
                        ['route' => 'suppliers.index', 'icon' => 'fa-truck', 'label' => 'Pemasok'],
                        ['route' => 'users.index', 'icon' => 'fa-users', 'label' => 'Pengguna'],
                    ];
                @endphp

                @foreach($routes as $item)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                           href="{{ route($item['route']) }}">
                            <i class="fas {{ $item['icon'] }} me-2"></i> {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="mt-auto">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="darkModeToggle">
                    <label class="form-check-label text-white" for="darkModeToggle">Dark Mode</label>
                </div>
                <div class="text-center text-white-50 small">
                    &copy; {{ date('Y') }} CV. Agung
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Topbar -->
            <div class="topbar d-flex flex-wrap justify-content-between align-items-center mb-3 border-bottom pb-2 gap-2">
                <div class="d-flex align-items-center">
                    <button class="burger-btn me-3" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@yield('page-title', 'Dashboard')</li>
                        </ol>
                    </nav>
                </div>

                <div class="d-flex align-items-center gap-3">
                    @hasSection('page-actions')
                        <div>
                            @yield('page-actions')
                        </div>
                    @endif

                    <a href="{{ route('notifications.index') }}" class="position-relative text-decoration-none text-dark">
                        <i class="fas fa-bell fs-5"></i>
                        @if(auth()->user()->unreadNotificationsCount() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ auth()->user()->unreadNotificationsCount() }}
                            </span>
                        @endif
                    </a>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2 fs-5"></i>
                            <span>{{ Auth::user()->nama ?? 'User' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user me-2"></i> Profil Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @foreach (['success', 'error', 'warning', 'info'] as $msg)
                @if(session($msg))
                    <div class="alert alert-{{ $msg === 'error' ? 'danger' : $msg }} alert-dismissible fade show" role="alert">
                        {{ session($msg) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            <!-- Page Content -->
            <div class="container-fluid py-3">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="mt-auto py-3 text-center text-muted small border-top">
                &copy; {{ date('Y') }} CV. Agung - Inventory System v1.0
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        const toggleBtn = document.getElementById('toggleSidebar');
        const appWrapper = document.getElementById('appWrapper');
        const sidebar = document.getElementById('sidebar');

        toggleBtn?.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                sidebar.classList.toggle('sidebar-mobile-show');
            } else {
                document.body.classList.toggle('sidebar-hidden');
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 768 && 
                !e.target.closest('#sidebar') && 
                !e.target.closest('#toggleSidebar') &&
                sidebar.classList.contains('sidebar-mobile-show')) {
                sidebar.classList.remove('sidebar-mobile-show');
            }
        });

        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        
        // Check for saved preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
            darkModeToggle.checked = true;
        }

        darkModeToggle?.addEventListener('change', () => {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        });

        // Loading overlay
        document.addEventListener('DOMContentLoaded', function() {
            // Example: Show loading on form submission
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', () => {
                    document.getElementById('loading-overlay').style.display = 'flex';
                });
            });
        });

        // You can call this function manually when needed
        function showLoading() {
            document.getElementById('loading-overlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loading-overlay').style.display = 'none';
        }
    </script>

    @yield('scripts')
</body>
</html>
