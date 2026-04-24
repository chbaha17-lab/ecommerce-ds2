<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-4xl mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6">🛒 Your Cart</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @php $total = 0; @endphp

    @if(count($cart) > 0)

        @foreach($cart as $id => $item)

            @php $total += $item['price'] * $item['quantity']; @endphp

            <div class="bg-white p-4 rounded shadow mb-3 flex justify-between items-center">

                <div>
                    <h2 class="font-bold">{{ $item['name'] }}</h2>
                    <p>{{ $item['price'] }} DT x {{ $item['quantity'] }}</p>
                </div>

                <form action="{{ route('cart.remove', $id) }}" method="POST">
                    @csrf
                    <button class="bg-red-500 text-white px-3 py-1 rounded">
                        Remove
                    </button>
                </form>

            </div>

        @endforeach

        <!-- TOTAL -->
        <div class="bg-white p-4 rounded shadow mt-6 text-right">
            <h2 class="text-xl font-bold">
                Total: {{ $total }} DT
            </h2>
        </div>

    @else

        <p class="text-gray-500">Your cart is empty 🛒</p>

    @endif

</div>

</body>
</html>