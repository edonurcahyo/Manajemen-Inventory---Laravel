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
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #0f2027, #2c5364);
            color: white;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            padding: 10px 20px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(0, 172, 193, 0.2);
            border-radius: 0.375rem;
            color: #fff;
        }

        .main-content {
            flex-grow: 1;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            margin-top: 1rem;
            min-height: 100vh;
        }

        .sidebar-hidden .sidebar {
            transform: translateX(-100%);
            position: absolute;
            z-index: 1030;
        }

        .burger-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #333;
        }

        @media (min-width: 768px) {
            .sidebar-hidden .sidebar {
                transform: translateX(0);
                position: relative;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex" id="appWrapper">
        <!-- Sidebar -->
        <nav class="sidebar d-flex flex-column p-3" id="sidebar">
            <div class="text-center mb-4">
                <h4 class="fw-bold">CV. Agung</h4>
                <small class="text-white-50">Inventory System</small>
            </div>

            <ul class="nav flex-column px-2">
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
        </nav>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Topbar -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 border-bottom pb-2 gap-2">
                <div class="d-flex align-items-center">
                    <button class="burger-btn d-md-none me-3" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="h2 mb-0">@yield('page-title', 'Dashboard')</h1>
                </div>

                @hasSection('page-actions')
                    <div>
                        @yield('page-actions')
                    </div>
                @endif

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

            <!-- Flash Messages -->
            @foreach (['success', 'error'] as $msg)
                @if(session($msg))
                    <div class="alert alert-{{ $msg === 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                        {{ session($msg) }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            @endforeach

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const appWrapper = document.getElementById('appWrapper');

        toggleBtn?.addEventListener('click', () => {
            appWrapper.classList.toggle('sidebar-hidden');
        });
    </script>

    @yield('scripts')
</body>
</html>
