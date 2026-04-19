@extends('layouts.store')

@section('content')

<div class="container py-4">
    <h2 class="mb-4" style="color:#6b4f4f;">Mes commandes</h2>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $order->total_price }} DT</td>
                        <td>
                            <span class="badge bg-secondary">{{ \App\Models\Order::statusLabel($order->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-dark">Détails</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted">Aucune commande pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $orders->links() }}
</div>

@endsection
