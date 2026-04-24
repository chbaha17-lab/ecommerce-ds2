<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $reviews = Review::query()
            ->where('user_id', $request->user()->id)
            ->with('product')
            ->latest()
            ->paginate(12);

        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        Review::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
            ],
            [
                'rating' => (int) $request->input('rating'),
                'comment' => $request->input('comment'),
            ]
        );

        return back()->with('success', 'Avis enregistré.');
    }
}
