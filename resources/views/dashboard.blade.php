@extends('layouts.app')

@section('content')

<div class="container py-5">

    <!-- HEADER -->
    <div class="mb-4">
        <h2 class="fw-bold" style="color:#6b4f4f;">
            ☕ Café Admin Dashboard
        </h2>
        <p class="text-muted">
            Manage your menu, categories and orders
        </p>
    </div>

    <!-- STATS CARDS -->
    <div class="row g-4 mb-5">

        <!-- PRODUCTS -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 text-center"
                 style="border-radius:18px; background:#fdf7f2;">

                <h6 class="text-muted">Products</h6>
                <h2 style="color:#6b4f4f;">
                    {{ $productsCount ?? 0 }}
                </h2>

                <small class="text-muted">Items in menu</small>
            </div>
        </div>

        <!-- CATEGORIES -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 text-center"
                 style="border-radius:18px; background:#fdf7f2;">

                <h6 class="text-muted">Categories</h6>
                <h2 style="color:#6b4f4f;">
                    {{ $categoriesCount ?? 0 }}
                </h2>

                <small class="text-muted">Menu sections</small>
            </div>
        </div>

        <!-- ORDERS (STATIC FOR NOW) -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 text-center"
                 style="border-radius:18px; background:#fdf7f2;">

                <h6 class="text-muted">Orders</h6>
                <h2 style="color:#6b4f4f;">0</h2>

                <small class="text-muted">Customer activity</small>
            </div>
        </div>

    </div>

    <!-- ACTION PANEL -->
    <div class="card border-0 shadow-sm p-4"
         style="border-radius:18px; background:#fff;">

        <h5 class="mb-3" style="color:#6b4f4f;">
            Quick Actions
        </h5>

        <div class="d-flex flex-wrap gap-3">

            <a href="/products/create"
               class="btn"
               style="background:#e6d3b3; color:#4b3a2f; border-radius:12px;">
                + Add Product
            </a>

            <a href="/categories/create"
               class="btn"
               style="background:#d8bfa8; color:#4b3a2f; border-radius:12px;">
                + Add Category
            </a>

            <a href="/products"
               class="btn btn-outline-dark"
               style="border-radius:12px;">
                View Products
            </a>

            <a href="/menu"
               class="btn btn-outline-dark"
               style="border-radius:12px;">
                View Menu
            </a>

        </div>

    </div>

</div>

@endsection