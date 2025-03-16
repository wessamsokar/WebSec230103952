<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multable</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body class="container py-4">
    @extends('layouts.master')
    @section('title', 'Prime Numbers')
    @section('content')
    @php($j = 5)
    <div class="card m-4 col-sm-2">
        <div class="card-header">{{$j}} Multiplication Table</div>
        <div class="card-body">
            <table>
                @foreach (range(1, 10) as $i)
                    <tr>
                        <td>{{$i}} * {{$j}}</td>
                        <td>
                            = {{ $i * $j }}</td>
                        </li>
                @endforeach
            </table>
        </div>
    </div>
    @endsection
</body>

</html>