@extends('layouts.store')

@section('content')

@php
    $imageUrl = function ($product) {
        if (!$product->image) return null;
        if (\Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://'])) {
            return $product->image;
        }
        return asset('storage/'.$product->image);
    };
@endphp

<div class="container py-4">

    <h2 class="mb-4" style="color:#6b4f4f;">Notre catalogue</h2>

    <form method="GET" action="{{ route('menu') }}" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label class="form-label small text-muted">Recherche</label>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Mot-clé…">
        </div>
        <div class="col-md-3">
            <label class="form-label small text-muted">Tri</label>
            <select name="sort" class="form-select" onchange="this.form.submit()">
                <option value="latest" @selected(request('sort','latest')==='latest')>Plus récents</option>
                <option value="oldest" @selected(request('sort')==='oldest')>Plus anciens</option>
                <option value="price_asc" @selected(request('sort')==='price_asc')>Prix croissant</option>
                <option value="price_desc" @selected(request('sort')==='price_desc')>Prix décroissant</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-beige w-100">Filtrer</button>
        </div>
        @if(request()->hasAny(['q','category','sort']))
            <div class="col-md-2">
                <a href="{{ route('menu') }}" class="btn btn-outline-secondary w-100">Réinitialiser</a>
            </div>
        @endif
        @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
    </form>

    @if($categories->isNotEmpty())
        <div class="card border-0 shadow-sm p-4 mb-4" style="background:#fffaf6;">
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <a href="{{ route('menu', array_filter(['q' => request('q'), 'sort' => request('sort')])) }}"
                   class="btn btn-outline-dark btn-sm {{ !request('category') ? 'active' : '' }}">Tout</a>
                @foreach($categories as $category)
                    <a href="{{ route('menu', array_filter(['category' => $category->id, 'q' => request('q'), 'sort' => request('sort')])) }}"
                       class="btn btn-sm {{ (string)request('category') === (string)$category->id ? 'btn-dark' : '' }}"
                       style="{{ (string)request('category') !== (string)$category->id ? 'background:#e6d3b3; color:#4b3a2f; border-radius:20px; border:none;' : '' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-4">
                @php
                    $avg = (float) ($product->reviews_avg_rating ?? 0);
                    $myReview = auth()->check() ? ($myReviews[$product->id] ?? null) : null;
                @endphp
                <div class="card h-100 border-0 shadow-sm p-3" style="border-radius:18px; background:#fffaf6;">
                    @if($url = $imageUrl($product))
                        <img src="{{ $url }}" class="img-fluid rounded mb-2" style="height:180px; object-fit:cover;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded mb-2" style="height:180px;">Pas d’image</div>
                    @endif

                    <h5 class="mt-2" style="color:#6b4f4f;">{{ $product->name }}</h5>
                    <p class="text-muted small mb-1">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                    <p class="small mb-2">
                        <span class="badge" style="background:#e6d3b3; color:#6b4f4f;">{{ $product->category?->name ?? 'Sans catégorie' }}</span>
                    </p>
                    <p class="small mb-2" style="color:#6b4f4f;">
                        <span class="text-warning">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= round($avg) ? '★' : '☆' }}
                            @endfor
                        </span>
                        <span class="text-muted">({{ number_format($avg, 1) }})</span>
                    </p>
                    <div class="mb-2">
                        @forelse($product->reviews->take(2) as $review)
                            <div class="small text-muted mb-1">
                                <strong>{{ $review->user->name ?? 'Client' }}:</strong>
                                {{ \Illuminate\Support\Str::limit($review->comment ?: 'Sans commentaire', 60) }}
                            </div>
                        @empty
                            <div class="small text-muted">Pas encore de commentaires.</div>
                        @endforelse
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <strong style="color:#6b4f4f;">{{ $product->price }} DT</strong>
                        <form method="POST" action="{{ route('cart.add', $product->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="background:#e6d3b3; color:#4b3a2f; border-radius:12px;">Ajouter</button>
                        </form>
                    </div>

                    @auth
                        <div class="mt-3">
                            <button class="btn btn-sm btn-outline-secondary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#review-{{ $product->id }}" aria-expanded="false">
                                {{ $myReview ? 'Modifier mon commentaire' : 'Ajouter commentaire et note' }}
                            </button>
                            <div class="collapse mt-2" id="review-{{ $product->id }}">
                                <form method="POST" action="{{ route('reviews.store', $product) }}">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="form-label small text-muted">Note</label>
                                        <select name="rating" class="form-select form-select-sm" required>
                                            @for($i = 5; $i >= 1; $i--)
                                                <option value="{{ $i }}" @selected((int) old('rating', $myReview->rating ?? 5) === $i)>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small text-muted">Commentaire</label>
                                        <textarea name="comment" rows="2" class="form-control form-control-sm" placeholder="Votre commentaire...">{{ old('comment', $myReview->comment ?? '') }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-beige w-100">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <p class="small mt-3 mb-0 text-muted">
                            <a href="{{ route('login') }}">Connectez-vous</a> pour commenter et noter.
                        </p>
                    @endauth
                </div>
            </div>
        @empty
            <p class="text-muted">
                @if(request()->hasAny(['q', 'category']) || request('sort') && request('sort') !== 'latest')
                    Aucun produit ne correspond à votre recherche ou à la catégorie choisie.
                @else
                    Aucun produit pour le moment.
                @endif
            </p>
        @endforelse
    </div>

</div>

@endsection
