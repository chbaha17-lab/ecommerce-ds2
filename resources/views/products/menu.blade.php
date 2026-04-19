@extends('layouts.store')

@section('content')

<div class="text-center mb-6">
    <h1 class="text-3xl font-bold text-[#5a4636]">Bloom Café Menu ☕</h1>
    <p class="text-gray-500">Fresh desserts & coffee made with love</p>
</div>

<!-- CATEGORY FILTER -->
<div class="flex gap-2 justify-center mb-6 flex-wrap">

    <a href="{{ route('menu') }}"
       class="px-4 py-2 bg-[#d6c1a1] text-white rounded">
        All
    </a>

    @foreach($categories as $cat)
        <a href="{{ route('menu', ['category' => $cat->id]) }}"
           class="px-4 py-2 bg-white border rounded">
            {{ $cat->name }}
        </a>
    @endforeach

</div>

<!-- PRODUCTS GRID -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    @foreach($products as $product)

        <div class="bg-white p-4 rounded shadow">

            <h2 class="text-xl font-semibold text-[#5a4636]">
                {{ $product->name }}
            </h2>

            <p class="text-gray-500 text-sm">
                {{ $product->description }}
            </p>

            <p class="mt-2 font-bold">
                {{ $product->price }} DT
            </p>

            <p class="text-sm text-gray-400">
                Category: {{ $product->category->name ?? 'None' }}
            </p>

        </div>

    @endforeach

</div>

@endsection