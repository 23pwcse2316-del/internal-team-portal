<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ITCP') }} - Internal Team Portal</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap Icons (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- 🔥 Alpine.js - Required for dropdowns! -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <!-- ============================================
         ALL CUSTOM CSS
         ============================================ -->
    <style>
        /* ── Global Styles ── */
        body {
            background: #f0f2f5;
            font-family: 'Figtree', sans-serif;
        }

        /* ── Card Hover Effects ── */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }

        /* ── Gradient Text ── */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ── Workspace Card ── */
        .workspace-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            border: 1px solid rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        .workspace-card:hover {
            box-shadow: 0 8px 30px rgba(0,0,0,0.10);
            border-color: #667eea40;
        }
        .workspace-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        /* ── Channel Badge ── */
        .channel-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .channel-badge.public {
            background: #dbeafe;
            color: #1d4ed8;
        }
        .channel-badge.private {
            background: #fef3c7;
            color: #b45309;
        }

        /* ── Message Bubbles ── */
        .message-bubble {
            background: white;
            border-radius: 12px;
            padding: 16px 20px;
            border: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }
        .message-bubble:hover {
            border-color: #667eea60;
            box-shadow: 0 2px 12px rgba(102, 126, 234, 0.08);
        }
        .message-bubble.pinned {
            border-left: 4px solid #f59e0b;
            background: #fffbeb;
        }

        /* ── User Avatar ── */
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 13px;
        }
        .avatar-xs {
            width: 28px;
            height: 28px;
            font-size: 11px;
        }

        /* ── Navbar ── */
        .navbar-custom {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        /* ── Primary Button ── */
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
            color: white;
        }

        /* ── Status Badge ── */
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-badge.open { background: #fef3c7; color: #92400e; }
        .status-badge.in-progress { background: #dbeafe; color: #1e40af; }
        .status-badge.completed { background: #d1fae5; color: #065f46; }

        /* ── Empty State ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        .empty-state .icon {
            font-size: 64px;
            color: #d1d5db;
            margin-bottom: 16px;
        }

        /* ── Footer ── */
        .footer-custom {
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 20px 0;
            color: #6b7280;
            font-size: 14px;
        }

        /* ── Custom Scrollbar ── */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #5a6fd1;
        }

        /* ── Dropdown animation ── */
        .dropdown-menu {
            transform-origin: top right;
            transition: all 0.15s ease;
        }
        .dropdown-menu.open {
            opacity: 1 !important;
            transform: scale(1) !important;
            visibility: visible !important;
        }

        @media (max-width: 640px) {
            .workspace-card {
                padding: 16px;
            }
            .gradient-text {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow-sm border-b border-gray-100">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="footer-custom mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p>© {{ date('Y') }} Internal Team Communication Portal • Built with ❤️</p>
            </div>
        </footer>
    </div>
</body>
</html>