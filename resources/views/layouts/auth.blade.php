<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - {{ setting('website_name', 'Maripos Outlet') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
        }

        .auth-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .auth-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            padding: 2rem;
            text-align: center;
        }

        .auth-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            opacity: 0.9;
            margin: 0;
        }

        .auth-body {
            padding: 2rem;
        }

        .form-floating {
            margin-bottom: 1rem;
        }

        .form-floating .form-control {
            border-radius: 0.75rem;
            border: 2px solid #e2e8f0;
            padding: 1rem 1rem 1rem 3rem;
            height: auto;
        }

        .form-floating .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .form-floating label {
            padding-left: 3rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 5;
        }

        .form-floating-icon {
            position: relative;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 0.75rem;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            width: 100%;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #94a3b8;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider span {
            padding: 0 1rem;
            font-size: 0.875rem;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.75rem;
            border: 2px solid #e2e8f0;
            background: #fff;
            color: #374151;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            margin-bottom: 0.75rem;
        }

        .btn-social:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-social img {
            width: 20px;
            height: 20px;
        }

        .auth-footer {
            text-align: center;
            padding: 1.5rem 2rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 0.75rem;
            margin-bottom: 1rem;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
    </style>
</head>

<body>
    <div class="auth-container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>