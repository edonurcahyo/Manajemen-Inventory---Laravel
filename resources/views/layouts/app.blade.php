<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
            --topbar-height: 60px;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            transition: background-color 0.3s;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            z-index: 1040;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(0);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.2s ease;
            margin-bottom: 2px;
            border-radius: 4px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: linear-gradient(90deg, rgba(0,172,193,0.2) 0%, transparent 100%);
            border-left: 3px solid var(--accent-color);
            color: #fff;
        }

        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            background-color: #ffffff;
            min-height: 100vh;
            transition: all 0.3s ease;
            position: relative;
        }

        /* Topbar Styles */
        .topbar {
            position: sticky;
            top: 0;
            background: inherit;
            z-index: 1030;
            padding: 1rem 0;
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8);
            height: var(--topbar-height);
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        /* Burger Button */
        .burger-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: inherit;
            cursor: pointer;
            padding: 0.5rem;
            margin-right: 1rem;
            z-index: 1050;
        }

        /* Card Styles */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 8px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
        }

        /* Loading Overlay */
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

        /* Mobile Overlay for Sidebar */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1035;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }
            
            .sidebar.sidebar-mobile-show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            body.sidebar-open {
                overflow: hidden;
            }
            
            .burger-btn {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .sidebar-hidden .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar-hidden .main-content {
                margin-left: 0;
            }
            
            .burger-btn {
                display: none;
            }
        }

        /* Dark Mode Styles */
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

        body.dark-mode .main-content {
            background-color: var(--dark-bg);
            color: var(--dark-text);
        }

        body.dark-mode .topbar {
            background-color: rgba(30, 30, 30, 0.8);
            border-bottom: 1px solid var(--dark-border);
        }

        body.dark-mode .card {
            background-color: var(--dark-card);
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.2);
        }

        body.dark-mode #loading-overlay {
            background-color: rgba(30, 30, 30, 0.8);
        }

        /* Additional Dark Mode Styles (keep your existing dark mode styles) */
        /* ... */

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
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
        
        body.dark-mode ::-webkit-scrollbar-track {
            background: var(--dark-card);
        }
        
        body.dark-mode ::-webkit-scrollbar-thumb {
            background: #555;
        }
        
        body.dark-mode ::-webkit-scrollbar-thumb:hover {
            background: #777;
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

    <!-- Sidebar Overlay (Mobile Only) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

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
        <div class="main-content flex-grow-1" id="mainContent">
            <!-- Topbar -->
            <div class="topbar d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <button class="burger-btn" id="toggleSidebar">
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
                                <span class="visually-hidden">unread notifications</span>
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
                    <div class="alert alert-{{ $msg === 'error' ? 'danger' : $msg }} alert-dismissible fade show mb-3" role="alert">
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
        // Enhanced Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mainContent = document.getElementById('mainContent');
            const darkModeToggle = document.getElementById('darkModeToggle');
            
            // Initialize sidebar state
            let isMobile = window.innerWidth < 768;
            
            // Function to toggle sidebar
            function toggleSidebar() {
                if (isMobile) {
                    sidebar.classList.toggle('sidebar-mobile-show');
                    sidebarOverlay.classList.toggle('active');
                    document.body.classList.toggle('sidebar-open');
                } else {
                    document.body.classList.toggle('sidebar-hidden');
                }
            }
            
            // Toggle button click handler
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                });
            }
            
            // Close sidebar when clicking on overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    if (isMobile && sidebar.classList.contains('sidebar-mobile-show')) {
                        toggleSidebar();
                    }
                });
            }
            
            // Close sidebar when clicking on main content (mobile)
            if (mainContent) {
                mainContent.addEventListener('click', function() {
                    if (isMobile && sidebar.classList.contains('sidebar-mobile-show')) {
                        toggleSidebar();
                    }
                });
            }
            
            // Handle window resize
            function handleResize() {
                isMobile = window.innerWidth < 768;
                
                if (!isMobile) {
                    // Ensure sidebar is visible on desktop
                    sidebar.classList.remove('sidebar-mobile-show');
                    sidebarOverlay.classList.remove('active');
                    document.body.classList.remove('sidebar-open');
                }
            }
            
            window.addEventListener('resize', handleResize);
            
            // Dark Mode Toggle
            if (darkModeToggle) {
                // Check for saved preference
                if (localStorage.getItem('darkMode') === 'true') {
                    document.body.classList.add('dark-mode');
                    darkModeToggle.checked = true;
                }
                
                darkModeToggle.addEventListener('change', function() {
                    document.body.classList.toggle('dark-mode');
                    localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
                });
            }
            
            // Loading overlay
            const loadingOverlay = document.getElementById('loading-overlay');
            
            // Example: Show loading on form submission
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', () => {
                    if (loadingOverlay) {
                        loadingOverlay.style.display = 'flex';
                    }
                });
            });
            
            // Global functions
            window.showLoading = function() {
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'flex';
                }
            };
            
            window.hideLoading = function() {
                if (loadingOverlay) {
                    loadingOverlay.style.display = 'none';
                }
            };
        });
    </script>

    @yield('scripts')
</body>
</html>