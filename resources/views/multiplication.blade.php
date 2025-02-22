<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Multiplication Tables</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="container py-4">
    @extends('layouts.master')
    @section('title', 'Prime Numbers')
    @section('content')
        <div class="row">
            @foreach (range(1, 10) as $j)
                <div class="col-md-2 m-2 p-2 border">
                    <div class="card">
                        <div class="card-header text-center">Table {{$j}}</div>
                        <div class="card-body">
                            <table class="table table-bordered text-center">
                                @foreach (range(1, 10) as $i)
                                    <tr>
                                        <td>{{$i}} x {{$j}}</td>
                                        <td>= {{ $i * $j }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endsection
</body>

</html>
