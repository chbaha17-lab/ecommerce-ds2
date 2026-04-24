<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bloom Café</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5efe6; font-family: Arial, sans-serif; }
        .navbar { background: white; border-bottom: 1px solid #e6d3b3; }
        .nav-link { color: #6b4f4f !important; }
        .btn-beige { background: #e6d3b3; color: #6b4f4f; border: none; }
        .btn-beige:hover { background: #d9c2a0; }
        .card { border-radius: 16px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg px-3 py-2" style="background:white; border-bottom:1px solid #e6d3b3;">
    <a class="navbar-brand fw-semibold" href="{{ url('/') }}" style="color:#6b4f4f;">☕ Bloom Café</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="{{ route('menu') }}">Menu</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">Panier</a></li>
            @auth
                <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Produits</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Mes commandes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('orders.manage.index') }}">Gestion commandes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('messages.index') }}">Messages</a></li>
            @endauth
        </ul>
        <ul class="navbar-nav ms-auto">
            @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Inscription</a></li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Profil</a></li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Déconnexion</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>

<div class="container mt-4 mb-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
