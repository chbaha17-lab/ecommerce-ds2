<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->get();

        return view('products.index', compact('products'));
    }

    public function menu(Request $request): View
    {
        $categories = Category::query()->orderBy('name')->get();

        $productsQuery = Product::query()
            ->with([
                'category',
                'reviews' => fn ($q) => $q->with('user')->latest(),
            ])
            ->withAvg('reviews', 'rating');

        if ($request->filled('category')) {
            $productsQuery->where('category_id', $request->integer('category'));
        }

        if ($request->filled('q')) {
            $q = $request->input('q');
            $productsQuery->where(function ($sub) use ($q) {
                $sub->where('name', 'like', '%'.$q.'%')
                    ->orWhere('description', 'like', '%'.$q.'%');
            });
        }

        $sort = $request->input('sort', 'latest');
        match ($sort) {
            'price_asc' => $productsQuery->orderBy('price'),
            'price_desc' => $productsQuery->orderByDesc('price'),
            'oldest' => $productsQuery->oldest(),
            default => $productsQuery->latest(),
        };

        $products = $productsQuery->get();
        $myReviews = collect();

        if ($request->user()) {
            $myReviews = Review::query()
                ->where('user_id', $request->user()->id)
                ->whereIn('product_id', $products->pluck('id'))
                ->get()
                ->keyBy('product_id');
        }

        return view('menu', compact('products', 'categories', 'myReviews'));
    }

    public function show(Product $product): View
    {
        $product->load([
            'category',
            'reviews' => fn ($q) => $q->with('user')->latest(),
        ]);

        return view('products.show', compact('product'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:2048',
        ]);

        Product::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'category_id' => $this->resolveCategoryIdFromName($request->input('category')),
            'image' => $request->image,
        ]);

        return redirect()->route('products.index')->with('success', 'Produit créé.');
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'category_id' => $this->resolveCategoryIdFromName($request->input('category')),
            'image' => $request->image,
        ]);

        return redirect()->route('products.index')->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produit supprimé.');
    }

    /**
     * Texte libre : crée la catégorie si elle n’existe pas encore (même nom exact), sinon réutilise l’existante.
     */
    private function resolveCategoryIdFromName(mixed $category): ?int
    {
        if (! is_string($category)) {
            return null;
        }

        $name = trim($category);
        if ($name === '') {
            return null;
        }

        return Category::firstOrCreate(['name' => $name])->id;
    }
}
