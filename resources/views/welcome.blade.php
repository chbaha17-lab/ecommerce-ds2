@extends('layouts.store')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <h1 class="display-6 fw-bold mb-3" style="color:#6b4f4f;">Bloom Café — E-commerce</h1>
            <p class="text-muted mb-4">
                Commandez en ligne, consultez le catalogue et suivez vos commandes.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="{{ route('menu') }}" class="btn btn-beige btn-lg">Voir le menu</a>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-dark btn-lg">Connexion</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-dark btn-lg">Créer un compte</a>
                @else
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark btn-lg">Produits</a>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-dark btn-lg">Mes commandes</a>
                @endguest
            </div>
        </div>
    </div>
</div>

@endsection
