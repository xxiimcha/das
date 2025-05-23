<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title', 'UNC DAS')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <style>
        .bg-body { background-color: #f8f9fa !important; }
        .app-sidebar { background-color: #dc3545 !important; color: #ffffff !important; }
        .app-sidebar .sidebar-brand a { color: #ffffff !important; }
        .sidebar-menu .nav-link { color: #ffffff !important; }
        .sidebar-menu .nav-link:hover, .sidebar-menu .nav-link.active {
            background-color: #b02a37 !important; color: #ffffff !important;
        }
        .brand-text { color: #ffffff !important; }
        .app-footer { background-color: #343a40 !important; color: #ffffff !important; }
        .app-footer a { color: #dc3545 !important; }
        .nav-link.active { background-color: #dc3545; color: white; }
    </style>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body">
    <div class="app-wrapper">
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="user-header text-bg-primary">
                                <p>{{ Auth::user()->name }}</p>
                                <p>{{ Auth::user()->email }}</p>
                                <p>
                                    @if(Auth::user()->role === 'admin')
                                        Administrator
                                    @elseif(Auth::user()->role === 'committee')
                                        Accreditation Committee
                                    @elseif(Auth::user()->role === 'owner')
                                        Dormitory Owner
                                    @else
                                        {{ ucfirst(Auth::user()->role) }}
                                    @endif
                                </p>
                            </li>
                            <li class="user-footer">
                                <a href="{{ route('profile.index') }}" class="btn btn-default btn-flat">Profile</a>
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end">Sign out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <aside class="app-sidebar">
            <div class="sidebar-brand">
                <a href="#" class="brand-link">
                    <img src="{{ asset('images/unc-logo.png') }}" alt="UNC Logo" class="brand-image opacity-75 shadow" />
                    <span class="brand-text fw-light">UNC DAS</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-speedometer"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('criteria.index') }}" class="nav-link {{ request()->routeIs('criteria.index') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-gear"></i>
                                    <p>Set Criteria</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-people-fill"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('committee.dormitories') }}" class="nav-link {{ request()->routeIs('owner.edit.dormitory') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-pencil"></i>
                                    <p>Dormitories</p>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'committee')
                            <li class="nav-item">
                                <a href="{{ route('committee.dashboard') }}" class="nav-link {{ request()->routeIs('committee.dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-speedometer2"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('committee.dormitories') }}" class="nav-link {{ request()->routeIs('committee.dormitories') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-house-door"></i>
                                    <p>Dormitories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('evaluation.schedules') }}" class="nav-link">
                                    <i class="nav-icon bi bi-search"></i>
                                    <p>Evaluation</p>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'owner')
                            <li class="nav-item">
                                <a href="{{ route('owner.dashboard') }}" class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-person-circle"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('owner.inspection') }}" class="nav-link {{ request()->routeIs('owner.inspection') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-clipboard"></i>
                                    <p>Inspection Details</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('evaluation.index') }}" class="nav-link {{ request()->routeIs('evaluation.index') ? 'active' : '' }}">
                                    <i class="nav-icon bi bi-search"></i>
                                    <p>View Evaluation</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6"><h3 class="mb-0"></h3></div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>

        <footer class="app-footer">
            <strong>Copyright &copy; 2024
                <a href="https://adminlte.io">UNC Dormitory Accreditation System</a>.
            </strong>
            All rights reserved.
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
</body>
</html>
