<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CV. Agung - Inventory Management')</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f2027, #2c5364);
            color: white;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.9);
            font-weight: 500;
            padding: 10px 20px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #ffffff;
            background-color: rgba(0, 172, 193, 0.2);
            border-radius: 0.375rem;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
        }

        .stats-card {
            background: linear-gradient(135deg,rgb(73, 72, 73) 0%,rgb(147, 139, 148) 100%);
            color: white;
        }

        main {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }

        .alert {
            margin-top: 1rem;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-outline-primary {
            border-color: #4e73df;
            color: #4e73df;
        }

        .btn-outline-primary:hover {
            background-color: #4e73df;
            color: white;
        }

        .text-muted {
            color: #6c757d !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar py-4">
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
            <main class="col-md-9 ms-sm-auto col-lg-10">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom pb-2">
                    <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('page-actions')
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
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts')
</body>
</html>
