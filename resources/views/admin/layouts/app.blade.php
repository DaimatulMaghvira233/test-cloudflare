<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin TWFood')</title>

    {{-- Tabler Core CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/tabler/css/tabler.min.css') }}">

    {{-- Tabler Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/tabler/icons/tabler-icons.min.css') }}">

    <style>
        body {
            margin: 0;
            background: #f5f7fb;
            color: #182433;
            font-family: Arial, sans-serif;
        }

        /* Layout utama */
        .admin-wrapper {
            min-height: 100vh;
        }

        /* Sidebar tetap di sebelah kiri */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            box-sizing: border-box;
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid #e6e8eb;
            padding: 24px 16px;
            z-index: 1030;
        }

        .sidebar-brand {
            display: block;
            margin: 0 12px 28px;
            color: #206bc4;
            font-size: 25px;
            font-weight: 700;
            text-decoration: none;
        }

        .sidebar-label {
            margin: 20px 12px 8px;
            color: #8a97a6;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 6px;
            color: #354052;
            font-size: 14px;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }

        .sidebar-menu a:hover {
            background: #f0f6ff;
            color: #206bc4;
        }

        .sidebar-menu a.active {
            background: #eaf2fc;
            color: #206bc4;
            font-weight: 600;
        }

        .sidebar-menu a.active i {
            color: #206bc4;
        }

        .sidebar-menu a i {
            flex-shrink: 0;
            font-size: 19px;
        }

        /* Konten utama bergeser mengikuti lebar sidebar */
        .main-content {
            min-width: 0;
            margin-left: 250px;
        }

        /* Topbar tetap di bagian atas */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 1020;
            min-height: 72px;
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            background: #fff;
            border-bottom: 1px solid #e6e8eb;
        }

        .topbar h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .page-content {
            min-width: 0;
            padding: 28px;
        }

        /* Tombol logout */
        .logout-button {
            border: 1px solid #d63939;
            border-radius: 6px;
            padding: 8px 14px;
            background: #d63939;
            color: #fff;
            cursor: pointer;
            transition: background 0.15s;
        }

        .logout-button:hover {
            background: #b52b2b;
        }

        /* Kompatibilitas halaman CRUD lama */
        .page-content .card {
            border: 1px solid #e6e8eb;
            border-radius: 8px;
            background: #fff;
        }

        .page-content img {
            max-width: 100%;
        }

        /* Tabel produk */
        .produk-table {
            width: 100%;
            min-width: 1050px;
        }

        .produk-table th,
        .produk-table td {
            padding: 12px 16px;
            vertical-align: middle;
        }

        .produk-table .produk-name {
            min-width: 160px;
        }

        .produk-table .produk-description {
            min-width: 240px;
            max-width: 340px;
        }

        .produk-table .produk-action-column {
            min-width: 330px;
            text-align: center;
        }

        /* Tombol aksi produk */
        .produk-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 8px;
            min-width: 310px;
        }

        .produk-actions .btn {
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* Tablet dan layar kecil */
        @media (max-width: 768px) {
            .sidebar {
                position: static;
                width: 100%;
                max-height: none;
                overflow-y: visible;
                border-right: 0;
                border-bottom: 1px solid #e6e8eb;
                padding: 16px;
            }

            .sidebar-brand {
                margin-bottom: 16px;
            }

            .sidebar-menu {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                min-height: 64px;
                padding: 12px 16px;
            }

            .topbar-user {
                gap: 8px;
            }

            .page-content {
                padding: 16px;
            }
        }

        /* Ponsel */
        @media (max-width: 480px) {
            .topbar {
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .topbar-user {
                flex-wrap: wrap;
            }

            .sidebar-menu {
                grid-template-columns: 1fr;
            }

            .page-content {
                padding: 12px;
            }
        }
    </style>

    @stack('styles')

</head>

<body>
    <div class="admin-wrapper">

        {{-- SIDEBAR --}}
        <aside class="sidebar">

            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="ti ti-leaf"></i>
                TWFood
            </a>

            <div class="sidebar-label">Menu Utama</div>

            <nav class="sidebar-menu">

                {{-- 1. Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="ti ti-dashboard"></i>
                    <span>Dashboard</span>
                </a>

                {{-- Verifikasi Pelanggan Toko dan Horeca --}}
                <a href="{{ route('admin.verifikasi-pelanggan.index') }}"
                    class="{{ request()->routeIs('admin.verifikasi-pelanggan.*') ? 'active' : '' }}">
                    <i class="ti ti-user-check"></i>
                    <span>Verifikasi Pelanggan</span>
                </a>

                {{-- 3. Produk (termasuk Varian, Harga, Stok, Pre-order) --}}
                <a href="{{ route('admin.produk.index') }}"
                    class="{{ request()->routeIs('admin.produk.*') || request()->routeIs('admin.varian.*') || request()->routeIs('admin.harga.*') ? 'active' : '' }}">
                    <i class="ti ti-package"></i>
                    <span>Produk</span>
                </a>

                {{-- 4. Pesanan --}}
                <a href="{{ route('admin.pesanan.index') }}"
                    class="{{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                    <i class="ti ti-shopping-cart"></i>
                    <span>Pesanan</span>
                </a>

                {{-- 5. Pembayaran --}}
                <a href="#">
                    <i class="ti ti-credit-card"></i>
                    <span>Pembayaran</span>
                </a>

                {{-- 6. Retur --}}
                <a href="#">
                    <i class="ti ti-package-export"></i>
                    <span>Retur</span>
                </a>

                {{-- 7. Promosi --}}
                <a href="#">
                    <i class="ti ti-discount-2"></i>
                    <span>Promosi</span>
                </a>

                {{-- 8. Keuangan --}}
                {{-- <a href="#">
                    <i class="ti ti-report-money"></i>
                    <span>Keuangan</span>
                </a> --}}

                {{-- 9. Laporan --}}
                <a href="#">
                    <i class="ti ti-file-report"></i>
                    <span>Laporan</span>
                </a>

                {{-- 10. Analitik --}}
                {{-- <a href="#">
                    <i class="ti ti-chart-bar"></i>
                    <span>Analitik</span>
                </a> --}}

                {{-- 11. Resep --}}
                <a href="{{ route('admin.resep.index') }}"
                    class="{{ request()->routeIs('admin.resep.*') ? 'active' : '' }}">
                    <i class="ti ti-book-2"></i>
                    <span>Resep</span>
                </a>

                {{-- 12. Konten Beranda --}}
                {{-- <a href="{{ route('admin.konten-beranda.index') }}"
                    class="{{ request()->routeIs('admin.konten-beranda.*') ? 'active' : '' }}">
                    <i class="ti ti-layout-dashboard"></i>
                    <span>Konten Beranda</span>
                </a> --}}

                {{-- 13. Outlet (termasuk Jam Operasional) --}}
                <a href="{{ route('admin.outlet.index') }}"
                    class="{{ request()->routeIs('admin.outlet.*') || request()->routeIs('admin.jam-operasional.*') ? 'active' : '' }}">
                    <i class="ti ti-building-store"></i>
                    <span>Outlet</span>
                </a>

                {{-- 14. Pengaturan Mitra --}}
                <a href="{{ route('admin.pengaturan-mitra.index') }}"
                    class="{{ request()->routeIs('admin.pengaturan-mitra.*') ? 'active' : '' }}">
                    <i class="ti ti-settings"></i>
                    <span>Pengaturan Mitra</span>
                </a>

            </nav>

        </aside>
        {{-- KONTEN UTAMA --}}
        <main class="main-content">

            <header class="topbar">
                <h3>@yield('page-title', 'Dashboard')</h3>

                <div class="topbar-user">
                    <span>{{ auth()->user()->nama }}</span>

                    <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                        @csrf

                        <button type="submit" class="logout-button">
                            <i class="ti ti-logout"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <section class="page-content">
                @yield('content')
            </section>

        </main>
    </div>

    <script src="{{ asset('assets/tabler/js/tabler.min.js') }}"></script>

    @stack('scripts')

</body>

</html>
