@extends('layouts.store')

@section('content')

@php
    $img = $product->image;
    $imgUrl = $img ? (\Illuminate\Support\Str::startsWith($img, ['http://', 'https://']) ? $img : asset('storage/'.$img)) : null;
@endphp

<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('menu') }}">Menu</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-md-5">
            @if($imgUrl)
                <img src="{{ $imgUrl }}" class="img-fluid rounded shadow-sm" alt="">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="min-height:280px;">Pas d’image</div>
            @endif
        </div>
        <div class="col-md-7">
            <h2 style="color:#6b4f4f;">{{ $product->name }}</h2>
            <p class="lead">{{ $product->price }} DT</p>
            <p>{{ $product->description }}</p>
            <span class="badge mb-3" style="background:#e6d3b3; color:#4b3a2f;">{{ $product->category->name ?? 'Sans catégorie' }}</span>
            <p class="small text-muted">Stock : {{ $product->stock }}</p>

            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-beige">Ajouter au panier</button>
            </form>
        </div>
    </div>
</div>

@endsection
