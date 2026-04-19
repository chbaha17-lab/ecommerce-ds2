@extends('layouts.store')

@section('content')

<div class="container py-4">

    <div class="card p-4">

        <h2 class="mb-4">✏️ Edit Product</h2>

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- NAME -->
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" value="{{ $product->name }}" class="form-control">
            </div>

            <!-- DESCRIPTION -->
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            </div>

            <!-- PRICE -->
            <div class="mb-3">
                <label>Price</label>
                <input type="number" name="price" value="{{ $product->price }}" class="form-control">
            </div>

            <!-- STOCK -->
            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" value="{{ $product->stock }}" class="form-control">
            </div>

            <!-- CATEGORY -->
            <div class="mb-3">
                <label>Catégorie</label>
                <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                       value="{{ old('category', $product->category?->name) }}"
                       placeholder="Ex. Boissons…">
                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <p class="form-text small text-muted mb-0">Même principe qu’à la création : nom libre, catégorie créée si besoin.</p>
            </div>

            <!-- IMAGE URL -->
            <div class="mb-3">
                <label>Image URL</label>
                <input type="text" name="image" value="{{ $product->image }}" class="form-control">
            </div>

            <!-- BUTTON -->
            <button class="btn btn-primary w-100">
                Update Product
            </button>

        </form>

    </div>

</div>

@endsection