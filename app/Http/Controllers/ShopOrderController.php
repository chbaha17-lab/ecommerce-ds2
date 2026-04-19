<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopOrderController extends Controller
{
    public function index(Request $request): View
    {
        $sellerId = $request->user()->id;

        $orders = Order::query()
            ->whereHas('items.product', fn ($query) => $query->where('user_id', $sellerId))
            ->with(['user', 'items.product'])
            ->latest()
            ->paginate(15);

        return view('orders.manage', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $sellerId = $request->user()->id;

        $isSellerOrder = $order->items()
            ->whereHas('product', fn ($query) => $query->where('user_id', $sellerId))
            ->exists();

        abort_unless($isSellerOrder, 403);

        $data = $request->validate([
            'status' => 'required|in:'.implode(',', [
                Order::STATUS_PENDING,
                Order::STATUS_VALIDATED,
                Order::STATUS_CANCELLED,
            ]),
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Statut de la commande mis à jour.');
    }
}
