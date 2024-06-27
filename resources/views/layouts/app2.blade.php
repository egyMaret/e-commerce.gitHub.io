<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <title>MOZAIQ COLLECTION</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .nav-icons {
            display: flex;
            gap: 1rem;
            padding-top: 10px;
        }

        .nav-icons a {
            text-decoration: none;
            color: black;
        }

        .nav-icons a i {
            font-size: 1.2rem;
        }

        .nav-icons li {
            list-style: none;
        }

        ion-icon {
            font-size: 20px;
        }

        .search-form {
            display: none;
            position: absolute;
            right: 2rem;
            top: 3rem;
            background-color: white;
            border: 1px solid #ccc;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background-color: #84563c;
            /* Warna latar belakang yang mirip dengan gambar */
            color: #ffffff;
            /* Warna teks yang kontras */
            padding: 20px;
            text-align: center;
        }

        .footer a {
            color: #ffffff;
            /* Warna tautan yang kontras */
            text-decoration: none;
        }

        .footer p {
            margin: 0;
            padding: 0;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchIcon = document.getElementById("search-icon");
            const searchForm = document.getElementById("search-form");

            searchIcon.addEventListener("click", function(event) {
                event.preventDefault();
                searchForm.style.display = searchForm.style.display === "none" ? "block" : "none";
            });
        });
    </script>

</head>

<body class="d-flex flex-column min-vh-100">
    <div id="app2">
        <nav class="navbar navbar-expand-md" style="box-shadow: 0 4px 2px -2px #84563c;">
            <div class="container d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Moziq Collection
                </a>
                <div class="nav-icons">
                    <a href="#" id="search-icon"><ion-icon name="search-outline"></ion-icon></i></a>
                    <a href="{{ route('cart.show') }}"><ion-icon name="cart-outline"></ion-icon></a>
                    @guest
                        <a href="{{ route('login') }}"><ion-icon name="person-circle-outline"></ion-icon></a>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </div>
            </div>
        </nav>
        <div id="search-form" class="search-form">
            <form action="{{ route('products.search') }}" method="GET" class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                    aria-label="Cari produk">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-success">Cari</button>
                </div>
            </form>
        </div>

        <main class="">
            @yield('content')
        </main>
    </div>

    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <p>Contact</p>
            <a href="https://wa.me/6282154228424"><ion-icon name="logo-whatsapp" style="padding-top: 6px; padding-right: 16px;"></ion-icon></a>
            <a href="https://www.instagram.com/egy_maret/"><ion-icon name="logo-instagram"></ion-icon></a>
            <p>Powered by Mozaiq Collection</p>
        </div>
    </footer>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
