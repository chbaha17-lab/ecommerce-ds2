@extends('layouts.app')

@section('content')

<h2 class="mb-4">📦 Products List</h2>

<div class="row g-4">

@foreach($products as $product)

    <div class="col-md-4">

        <div class="card p-3 shadow-sm">

            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="card-img-top"
                     style="height:180px; object-fit:cover;">
            @endif

            <div class="card-body">

                <h5>{{ $product->name }}</h5>

                <p>{{ $product->price }} DT</p>

                <p class="text-muted">
                    @if($product->category)
    <span class="badge bg-secondary">
        {{ $product->category->name }}
    </span>
@else
    <span class="badge bg-light text-dark">
        No category
    </span>
@endif
                </p>

                <div class="d-flex gap-2">

                    <a href="/products/{{ $product->id }}/edit"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="/products/{{ $product->id }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            Delete
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

@endforeach

</div>

@endsection