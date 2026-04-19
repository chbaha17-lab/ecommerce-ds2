@extends('layouts.store')

@section('content')

<div class="container py-4">
    <h2 class="mb-3" style="color:#6b4f4f;">Commande #{{ $order->id }}</h2>
    <p class="text-muted">Statut : <strong>{{ \App\Models\Order::statusLabel($order->status) }}</strong></p>
    <p>Total : <strong>{{ $order->total_price }} DT</strong></p>

    <h5 class="mt-4">Articles</h5>
    <ul class="list-group">
        @foreach($order->items as $item)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $item->product->name ?? 'Produit supprimé' }} × {{ $item->quantity }}</span>
                <span>{{ number_format((float)$item->price * $item->quantity, 2) }} DT</span>
            </li>
        @endforeach
    </ul>

    <a href="{{ route('orders.index') }}" class="btn btn-link mt-3">← Retour</a>
</div>

@endsection
