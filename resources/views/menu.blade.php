@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- TITLE -->
    <h2 class="mb-4" style="color:#6b4f4f;">
        🍰 Our Menu
    </h2>

    <!-- CATEGORY FILTER -->
    <div class="d-flex gap-2 flex-wrap mb-4">

        <!-- ALL -->
        <a href="/menu"
           class="btn btn-outline-dark btn-sm">
            All
        </a>

        <!-- CATEGORIES -->
        @foreach($categories as $category)

            <a href="/menu?category={{ $category->id }}"
               class="btn btn-sm"
               style="background:#e6d3b3; color:#4b3a2f; border-radius:20px;">
                {{ $category->name }}
            </a>

        @endforeach

    </div>

    <!-- PRODUCTS GRID -->
    <div class="row g-4">

        @foreach($products as $product)

        <div class="col-md-4">

            <div class="card h-100 border-0 shadow-sm p-3"
                 style="border-radius:18px; background:#fffaf6;">

                <!-- IMAGE -->
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}"
                         class="img-fluid rounded mb-2"
                         style="height:180px; object-fit:cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded mb-2"
                         style="height:180px;">
                        No Image
                    </div>
                @endif

                <!-- NAME -->
                <h5 class="mt-2" style="color:#6b4f4f;">
                    {{ $product->name }}
                </h5>

                <!-- DESCRIPTION -->
                <p class="text-muted small">
                    {{ $product->description }}
                </p>

                <!-- CATEGORY -->
                <span class="badge mb-2"
                      style="background:#e6d3b3; color:#6b4f4f; width:fit-content;">
                    {{ $product->category->name ?? 'No category' }}
                </span>

                <!-- PRICE + BUTTON -->
                <div class="d-flex justify-content-between align-items-center mt-auto">

                    <strong style="color:#6b4f4f;">
                        {{ $product->price }} DT
                    </strong>

                    <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf

                        <button class="btn btn-sm"
                                style="background:#e6d3b3; color:#4b3a2f; border-radius:12px;">
                            Add 🛒
                        </button>

                    </form>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection