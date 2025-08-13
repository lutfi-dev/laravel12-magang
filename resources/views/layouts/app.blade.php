<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Magang DB') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @vite(['resources/sashttps://github.com/lutfi-dev/laravel12-magang/pull/5/conflict?name=resources%252Fviews%252Flayouts%252Fapp.blade.php&ancestor_oid=a6970da996516b51b3edae32ccb2b4dfb2265dc5&base_oid=f9bb2cead4ce878b71a43867acb59f5d3b7d3dbf&head_oid=fb6d0573fb9a921b7c0e11da322e18b1905f85bcs/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'Magang DB') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <ul class="navbar-nav ms-auto">
        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('about') }}">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('services') }}">Service</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products') }}">Our Product</a>
            </li>
        @endauth

        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tasks.index') }}">Dashboard</a>
            </li>
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
            </li>
        @endguest
    </ul>
</div>

            </div>
        </nav>

        <main class="py-4">
            @if (session('success'))
                <div class="container">
                    <div class="alert alert-success">{{ session('success') }}</div>
                </div>
            @endif
            @if (session('error'))
                <div class="container">
                    <div class="alert alert-danger">{{ session('error') }}</div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    @yield('scripts')
    <!-- Tambahan Bootstrap JS jika Vite bermasalah -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
