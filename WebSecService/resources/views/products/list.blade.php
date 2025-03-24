@extends('layouts.master')
@section('title', 'Products')
@section('content')
    <!-- ... existing header and search form ... -->

    @foreach($products as $product)
        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col col-sm-12 col-lg-4">
                        <img src="{{asset("images/$product->photo")}}" class="img-thumbnail" alt="{{$product->name}}" width="100%">
                    </div>
                    <div class="col col-sm-12 col-lg-8 mt-3">
                        <!-- ... existing buttons ... -->
                        <table class="table table-striped">
                            <!-- ... existing fields ... -->
                            <tr>
                                <th>Quantity</th>
                                <td>{{$product->quantity}} {{ $product->quantity == 0 ? '(Out of Stock)' : '' }}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>${{$product->price}}</td>
                            </tr>
                            <!-- ... other fields ... -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
