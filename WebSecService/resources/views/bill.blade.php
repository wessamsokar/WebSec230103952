<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bill</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body class="container py-4">
    @extends('layouts.master')
    @section('title', 'Supermarket Bill')
    @section('content')
    <div class="card">
        <div class="card-header">Supermarket Bill</div>
        <div class="card-body">
            @php
                $items = [
                    ['name' => 'jam', 'quantity' => 1, 'price' => 50,],
                    ['name' => 'tea', 'quantity' => 2, 'price' => 20],
                    ['name' => 'banana', 'quantity' => 1, 'price' => 15],
                    ['name' => 'Ice Cream', 'quantity' => 3, 'price' => 25],
                ];
            @endphp

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php($totalPrice = 0)
                    @foreach ($items as $item)
                    @php($totalPrice1 = $item['price'] * $item['quantity'])
                    @php($totalPrice += $totalPrice1)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['price'] }}</td>
                        <td>{{ $item['price'] * $item['quantity'] }}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

            <h4 class="mt-3">Total Price: <span class="badge bg-success">{{ $totalPrice }}</span></h4>
        </div>
    </div>
    @endsection
</body>

</html>