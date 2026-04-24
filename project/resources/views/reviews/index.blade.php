@extends('layouts.store')

@section('content')
<div class="container py-4">
    <h2 class="mb-4" style="color:#6b4f4f;">Mes commentaires</h2>

    @if($reviews->isEmpty())
        <div class="alert alert-info">Vous n'avez pas encore ajoute de commentaire.</div>
    @else
        <div class="row g-3">
            @foreach($reviews as $review)
                <div class="col-12">
                    <div class="card p-3">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <h6 class="mb-1">{{ $review->product?->name ?? 'Produit supprime' }}</h6>
                                <div class="text-warning mb-2">
                                    @for($i = 0; $i < (int) $review->rating; $i++)★@endfor
                                </div>
                                <p class="mb-0 text-muted">{{ $review->comment ?: 'Sans commentaire' }}</p>
                            </div>
                            @if($review->product)
                                <a href="{{ route('products.show', $review->product) }}" class="btn btn-sm btn-outline-secondary">Voir produit</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection
