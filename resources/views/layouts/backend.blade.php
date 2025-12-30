<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Maripos Outlet') - {{ setting('website_name', 'Maripos Outlet') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png"
        href="{{ setting('website_favicon') ? Storage::url(setting('website_favicon')) : asset('assets/backend/img/favicon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet">

    <!-- Toastr -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #64748b;
            --success: #22c55e;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
            --dark: #1e293b;
            --light: #f8fafc;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark) 0%, #0f172a 100%);
            color: #fff;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.25rem;
        }

        .sidebar-brand img {
            height: 40px;
            width: auto;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 1rem;
        }

        .nav-item {
            padding: 0 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .nav-link.active {
            background: var(--primary);
        }

        .nav-link i {
            font-size: 1.1rem;
            width: 1.5rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Top Navbar */
        .top-navbar {
            background: #fff;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: none;
            border: none;
            color: var(--dark);
            font-weight: 500;
        }

        .user-dropdown .dropdown-toggle::after {
            display: none;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Page Content */
        .page-content {
            padding: 1.5rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border-radius: 1rem 1rem 0 0 !important;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Stats Cards */
        .stat-card {
            background: #fff;
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.primary {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary);
        }

        .stat-icon.success {
            background: rgba(34, 197, 94, 0.1);
            color: var(--success);
        }

        .stat-icon.warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }

        .stat-icon.danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }

        .stat-icon.info {
            background: rgba(6, 182, 212, 0.1);
            color: var(--info);
        }

        .stat-info h3 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
        }

        .stat-info p {
            margin: 0;
            color: var(--secondary);
            font-size: 0.875rem;
        }

        /* Buttons */
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Form Styles */
        .form-control,
        .form-select {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .input-group-text {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }

        /* Tables */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: var(--secondary);
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
        }

        /* Badge */
        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
            border-radius: 0.375rem;
        }

        /* Mobile */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Image Preview */
        .image-preview {
            width: 150px;
            height: 150px;
            border: 2px dashed #e2e8f0;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f8fafc;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Subscription Banner */
        .subscription-banner {
            background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
            color: #fff;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .subscription-banner.expired {
            background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                @if(setting('website_logo'))
                <img src="{{ Storage::url(setting('website_logo')) }}" alt="Logo">
                @else
                <i class="bi bi-shop"></i>
                @endif
                <span>{{ setting('website_name', 'Maripos Outlet') }}</span>
            </a>
        </div>

        <nav class="sidebar-nav">
            @yield('sidebar')
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link d-lg-none text-dark p-0" id="sidebarToggle">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
            </div>

            <div class="dropdown user-dropdown">
                <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('assets/backend/img/default-user.png') }}"
                        alt="{{ auth()->user()->name }}" class="user-avatar">
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Toastr config
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 5000
        };

        // Flash messages
        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if(session('error'))
            toastr.error('{{ session('error') }}');
        @endif

        @if(session('warning'))
            toastr.warning('{{ session('warning') }}');
        @endif

        @if(session('info'))
            toastr.info('{{ session('info') }}');
        @endif

        // Sidebar toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Initialize Select2
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        });

        // Image preview
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    @stack('scripts')
</body>

</html>