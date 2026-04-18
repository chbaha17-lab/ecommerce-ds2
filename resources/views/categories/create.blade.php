@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h2>Add Category</h2>

    <form method="POST" action="/categories">
        @csrf

        <input type="text" name="name"
               class="form-control mb-3"
               placeholder="Category name">

        <button class="btn btn-primary">
            Save
        </button>

    </form>

</div>

@endsection