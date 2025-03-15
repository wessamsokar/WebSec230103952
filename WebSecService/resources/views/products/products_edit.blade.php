<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body class="container py-4">
    @section('title', 'Prime Numbers')
    @section('content')
        <form action="{{route('products_save', $product->id)}}" method="post">
            {{ csrf_field() }}
            <div class="row mb-2">
                <div class="col-6">
                    <label for="code" class="form-label">Code:</label>
                    <input type="text" class="form-control" placeholder="Code" name="code" required
                        value="{{$product->code}}">
                </div>
                <div class="col-6">
                    <label for="model" class="form-label">Model:</label>
                    <input type="text" class="form-control" placeholder="Model" name="model" required
                        value="{{$product->model}}">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" placeholder="Name" name="name" required
                        value="{{$product->name}}">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-6">
                    <label for="model" class="form-label">Price:</label>
                    <input type="numeric" class="form-control" placeholder="Price" name="price" required
                        value="{{$product->price}}">
                </div>
                <div class="col-6">
                    <label for="model" class="form-label">Photo:</label>
                    <input type="text" class="form-control" placeholder="Photo" name="photo" required
                        value="{{$product->photo}}">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <label for="name" class="form-label">Description:</label>
                    <textarea type="text" class="form-control" placeholder="Description" name="description"
                        required>{{$product->description}}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    @endsection
    <div class="row mb-2">
        <div class="col">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" placeholder="Name" name="name" required value="{{$product->name}}">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-6">
            <label for="model" class="form-label">Price:</label>
            <input type="numeric" class="form-control" placeholder="Price" name="price" required
                value="{{$product->price}}">
        </div>
        <div class="col-6">
            <label for="model" class="form-label">Photo:</label>
            <input type="text" class="form-control" placeholder="Photo" name="photo" required
                value="{{$product->photo}}">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col">
            <label for="name" class="form-label">Description:</label>
            <textarea type="text" class="form-control" placeholder="Description" name="description"
                required>{{$product->description}}</textarea>
        </div>
    </div>
</body>

</html>