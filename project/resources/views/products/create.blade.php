@extends('layouts.store')

@section('content')

<div class="container py-4">

    <div class="card p-4">

        <h2 class="mb-4">➕ Add Product</h2>

        <form method="POST" action="{{ route('products.store') }}">
            @csrf

            <!-- NAME -->
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control">
            </div>

            <!-- DESCRIPTION -->
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <!-- PRICE -->
            <div class="mb-3">
                <label>Price</label>
                <input type="number" name="price" class="form-control">
            </div>

            <!-- STOCK -->
            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control">
            </div>

            <!-- CATEGORY (texte : nouvelle catégorie créée si le nom n’existe pas) -->
            <div class="mb-3">
                <label>Catégorie</label>
                <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                       value="{{ old('category') }}"
                       placeholder="Ex. Boissons, Pâtisseries…">
                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <p class="form-text small text-muted mb-0">
                    Tapez le nom de la catégorie. Si elle n’existe pas encore, elle sera créée. Le menu permet ensuite le filtrage par catégorie.
                </p>
            </div>

            <!-- IMAGE URL -->
            <div class="mb-3">
                <label>Image URL</label>
                <input type="text" name="image" class="form-control" placeholder="https://example.com/image.jpg">
            </div>

            <!-- BUTTON -->
            <button class="btn btn-primary w-100">
                Save Product
            </button>

        </form>

    </div>

</div>

@endsection