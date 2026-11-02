<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'TWFood - Lezat dan Sehat')
    </title>


    <style>
        :root {
            --text-light: #FFF5F1;
            --text-dark: #3A001E;
            --main-color: #E01F20;
            --main-dark: #8F0E0E;

        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #333;
            background: #fff;
        }


        /* =========================
           NAVBAR
        ========================= */

        nav {
            padding: 20px 40px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--main-color);
            color: var(--text-light);
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
        }

        .logo a {
            text-decoration: none;
            color: inherit;
        }

        .nav-menu {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            color: inherit;
        }

        .nav-menu a:hover {
            text-decoration: underline;
        }


        /* =========================
           CONTAINER
        ========================= */

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }


        /* =========================
           HERO
        ========================= */

        .hero {
            padding: 100px 20px;
            text-align: center;
            background: #f5f5f5;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 20px;
            color: #666;
        }


        /* =========================
           BUTTON
        ========================= */

        .button {
            display: inline-block;

            margin-top: 20px;

            padding: 12px 20px;

            background: var(--main-color);
            color: var(--text-light);

            text-decoration: none;

            border-radius: 5px;
        }

        .button:hover {
            background-color: var(--main-dark);
            opacity: 0.85;
        }


        /* =========================
           SECTION
        ========================= */

        .section {
            padding: 70px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title h2 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .section-title p {
            color: #666;
        }


        /* =========================
           PRODUCT
        ========================= */

        .products {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }

        .product-image {
            display: block;
            align-content: center;
            align-items: center;
            text-align: center;
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: #f5f5f5;
        }

        .product-content {
            padding: 20px;
        }

        .product-content h3 {
            margin-top: 0;
        }

        .product-content p {
            color: #666;
            line-height: 1.5;
        }


        /* =========================
           CONTENT
        ========================= */

        .content-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .content-card {
            padding: 25px;

            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .content-card h3 {
            margin-top: 0;
        }


        /* =========================
           OUTLET
        ========================= */

        .outlet {
            padding: 30px;

            border: 1px solid #ddd;
            border-radius: 8px;
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            padding: 40px 0;
            background: #f5f5f5;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .products {
                grid-template-columns: repeat(2, 1fr);
            }

        }


        @media (max-width: 600px) {

            nav {
                flex-direction: column;
                gap: 15px;
            }

            .nav-menu {
                flex-wrap: wrap;
                justify-content: center;
                color: inherit
            }

            .products {
                grid-template-columns: 1fr;
            }

            .content-list {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 36px;
            }

        }


        /*=========================================
                          Resep
        ========================================= */

        .resep-deskripsi {
            text-align: left;
            max-width: 700px;
            margin: 0 auto 24px;
            line-height: 1.7;
        }

        .resep-deskripsi p {
            margin: 0 0 12px;
        }

        .resep-deskripsi ul,
        .resep-deskripsi ol {
            padding-left: 24px;
            margin: 0 0 12px;
        }

        .resep-deskripsi a {
            color: #206bc4;
            text-decoration: underline;
        }
    </style>

</head>


<body>


    {{-- =====================================================
         NAVBAR
    ====================================================== --}}

    <nav>

        <div class="logo">

            <a href="{{ route('home') }}">
                TWFood
            </a>

        </div>


        <div class="nav-menu">

            <a href="{{ route('home') }}">
                Home
            </a>

            <a href="{{ route('produk.public') }}">
                Produk
            </a>

            <a href="{{ route('resep.public') }}">
                Resep
            </a>

            <a href="{{ route('outlet.public') }}">
                Outlet
            </a>

            <a href="{{ route('kontak.public') }}">
                Kontak
            </a>

            <a href="https://play.google.com/">
                Download Aplikasi
            </a>

        </div>

    </nav>


    {{-- =====================================================
         CONTENT
    ====================================================== --}}

    @yield('content')


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <footer>

        <div class="container">

            <strong>
                TWFood
            </strong>

            <p>
                Lezat dan Sehat
            </p>

            <p>
                &copy; {{ date('Y') }} TWFood.
                All rights reserved.
            </p>

        </div>

    </footer>


</body>

</html>
