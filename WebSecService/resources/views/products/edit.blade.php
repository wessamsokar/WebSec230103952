@extends('layouts.master')
@section('title', 'Edit Product')
@section('content')

    <form action="{{route('products_save', $product->id ?? '')}}" method="post">
        @csrf
        @method($product->id ? 'PUT' : 'POST')

        @foreach($errors->all() as $error)
            <div class="alert alert-danger">
                <strong>Error!</strong> {{$error}}
            </div>
        @endforeach

        <div class="row mb-2">
            <div class="col-6">
                <label for="code" class="form-label">Code:</label>
                <input type="text" class="form-control" name="code" required value="{{$product->code ?? ''}}">
            </div>
            <div class="col-6">
                <label for="model" class="form-label">Model:</label>
                <input type="text" class="form-control" name="model" required value="{{$product->model ?? ''}}">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-6">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" required value="{{$product->name ?? ''}}">
            </div>
            <div class="col-6">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" class="form-control" name="quantity" required value="{{$product->quantity ?? 0}}" min="0">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-6">
                <label for="price" class="form-label">Price:</label>
                <input type="number" step="0.01" class="form-control" name="price" required value="{{$product->price ?? ''}}">
            </div>
            <div class="col-6">
                <label for="photo" class="form-label">Photo:</label>
                <input type="text" class="form-control" name="photo" required value="{{$product->photo ?? ''}}">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" name="description" required>{{$product->description ?? ''}}</textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
