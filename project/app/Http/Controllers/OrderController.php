<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->where('user_id', $request->user()->id)
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        $this->authorize('view', $order);

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = session('cart', []);

        if ($cart === []) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        try {
            DB::transaction(function () use ($request, $cart) {
                $total = 0;
                $lines = [];

                foreach ($cart as $productId => $row) {
                    $product = Product::query()->lockForUpdate()->findOrFail($productId);
                    $qty = (int) $row['quantity'];

                    if ($qty < 1) {
                        continue;
                    }

                    if ($product->stock < $qty) {
                        throw new \RuntimeException("Stock insuffisant pour « {$product->name} » (disponible : {$product->stock}).");
                    }

                    $lineTotal = (float) $product->price * $qty;
                    $total += $lineTotal;

                    $lines[] = [
                        'product' => $product,
                        'quantity' => $qty,
                        'unit_price' => (float) $product->price,
                    ];
                }

                if ($lines === []) {
                    throw new \RuntimeException('Panier invalide.');
                }

                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'total_price' => $total,
                    'status' => Order::STATUS_PENDING,
                ]);

                foreach ($lines as $line) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $line['product']->id,
                        'quantity' => $line['quantity'],
                        'price' => $line['unit_price'],
                    ]);

                    $line['product']->decrement('stock', $line['quantity']);
                }
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Commande enregistrée (statut : en attente).');
    }
}
