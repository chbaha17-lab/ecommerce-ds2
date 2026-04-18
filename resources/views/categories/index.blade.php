@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h2>Categories</h2>

    <a href="/categories/create" class="btn btn-primary mb-3">
        + Add Category
    </a>

    @foreach($categories as $category)

        <div class="card p-3 mb-2 d-flex justify-content-between flex-row">

            <span>{{ $category->name }}</span>

            <form method="POST" action="/categories/{{ $category->id }}">
                @csrf
                @method('DELETE')

                <button class="btn btn-danger btn-sm">
                    Delete
                </button>
            </form>

        </div>

    @endforeach

</div>

@endsection