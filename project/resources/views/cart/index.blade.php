@extends('layouts.store')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>🛒 Your Cart</h2>

        <a href="{{ route('menu') }}" class="btn btn-sm"
           style="background:#e6d3b3; color:#6b4f4f;">
            ← Menu
        </a>

    </div>

    @php $total = 0; @endphp

    @if(session('cart') && count(session('cart')) > 0)

        @foreach(session('cart') as $id => $item)

            @php
                $total += $item['price'] * $item['quantity'];
            @endphp

            <div class="card p-3 mb-3 shadow-sm border-0">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h5 class="mb-1">{{ $item['name'] }}</h5>
                        <small class="text-muted">
                            {{ $item['price'] }} DT each
                        </small>
                    </div>

                    <!-- QUANTITY CONTROLS -->
                    <div class="d-flex align-items-center gap-2">

                        <!-- - BUTTON -->
                        <form method="POST" action="{{ route('cart.decrease', $id) }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-secondary">-</button>
                        </form>

                        <!-- QTY -->
                        <span class="px-2">
                            {{ $item['quantity'] }}
                        </span>

                        <!-- + BUTTON -->
                        <form method="POST" action="{{ route('cart.increase', $id) }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-secondary">+</button>
                        </form>

                    </div>

                    <!-- TOTAL PER ITEM -->
                    <div class="text-end">

                        <strong style="color:#6b4f4f;">
                            {{ $item['price'] * $item['quantity'] }} DT
                        </strong>

                        <form method="POST" action="{{ route('cart.remove', $id) }}">
                            @csrf
                            <button class="btn btn-sm btn-danger mt-1">
                                Remove
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        @endforeach

        <!-- TOTAL -->
        <div class="card p-3 border-0 shadow-sm mt-4">

            <div class="d-flex justify-content-between">

                <h5>Total</h5>

                <h4 style="color:#6b4f4f;">
                    {{ $total }} DT
                </h4>

            </div>

        </div>

        <div class="card p-4 border-0 shadow-sm mt-3">
            <h5 class="mb-3">Passer la commande</h5>
            @guest
                <p class="text-muted mb-2"><a href="{{ route('login') }}">Connectez-vous</a> pour valider votre panier.</p>
            @else
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <button type="submit" class="btn btn-beige">Confirmer la commande</button>
                </form>
                <p class="small text-muted mt-2 mb-0">Statut initial : en attente de validation.</p>
            @endguest
        </div>

    @else

        <div class="text-center p-5">

            <h4>🛒 Your cart is empty</h4>

            <a href="{{ route('menu') }}" class="btn mt-3"
               style="background:#e6d3b3; color:#6b4f4f;">
                Menu
            </a>

        </div>

    @endif

</div>

@endsection