<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Even Numbers</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body class="container py-4">
    @extends('layouts.master')
    @section('title', 'Prime Numbers')
    @section('content')
        <div class="card">
            <div class="card-header">Even Numbers</div>
            <div class="card-body">
                @foreach (range(1, 100) as $i)
                    @if($i % 2 == 0)
                        <span class="badge bg-primary">{{$i}}</span>
                    @else
                        <span class="badge bg-secondary">{{$i}}</span>
                    @endif
                @endforeach
            </div>
        </div>
    @endsection
</body>

</html>