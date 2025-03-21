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