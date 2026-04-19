<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        if ($order->user_id === $user->id) {
            return true;
        }

        return $order->items()
            ->whereHas('product', fn ($query) => $query->where('user_id', $user->id))
            ->exists();
    }
}
