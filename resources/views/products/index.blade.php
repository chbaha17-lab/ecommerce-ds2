@extends('layouts.store')

@section('content')

<h2 class="mb-4">Produits</h2>

<div class="mb-3">
    <a href="{{ route('products.create') }}" class="btn btn-beige">+ Nouveau produit</a>
</div>

<div class="row g-4">

@foreach($products as $product)

    <div class="col-md-4">

        <div class="card p-3 shadow-sm">

            @if($product->image)
                @php $u = \Illuminate\Support\Str::startsWith($product->image, ['http://','https://']) ? $product->image : asset('storage/'.$product->image); @endphp
                <img src="{{ $u }}" class="card-img-top" style="height:180px; object-fit:cover;">
            @endif

            <div class="card-body">

                <h5>{{ $product->name }}</h5>
                <p>{{ $product->price }} DT — Stock : {{ $product->stock }}</p>
                <p class="text-muted">
                    @if($product->category)
                        <span class="badge bg-secondary">{{ $product->category->name }}</span>
                    @else
                        <span class="badge bg-light text-dark">Sans catégorie</span>
                    @endif
                </p>

                <div class="d-flex gap-2 flex-wrap">
                    @can('update', $product)
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Modifier</a>
                    @endcan
                    @can('delete', $product)
                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    @endcan
                </div>

            </div>

        </div>

    </div>

@endforeach

</div>

@endsection
