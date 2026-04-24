@extends('layouts.store')

@section('content')

<div class="container py-4">
    <h2 class="mb-4" style="color:#6b4f4f;">Gestion des commandes</h2>

    <div class="table-responsive">
        <table class="table table-sm align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}<br><small class="text-muted">{{ $order->user->email }}</small></td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $order->total_price }} DT</td>
                        <td>
                            <form method="POST" action="{{ route('orders.manage.update', $order) }}" class="d-flex gap-2 align-items-center">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select form-select-sm" style="width:auto;">
                                    <option value="{{ \App\Models\Order::STATUS_PENDING }}" @selected($order->status === \App\Models\Order::STATUS_PENDING)>En attente</option>
                                    <option value="{{ \App\Models\Order::STATUS_VALIDATED }}" @selected($order->status === \App\Models\Order::STATUS_VALIDATED)>Validée</option>
                                    <option value="{{ \App\Models\Order::STATUS_CANCELLED }}" @selected($order->status === \App\Models\Order::STATUS_CANCELLED)>Annulée</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">OK</button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">Voir</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $orders->links() }}
</div>

@endsection
