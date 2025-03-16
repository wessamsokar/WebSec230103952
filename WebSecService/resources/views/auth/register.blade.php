<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h2 class="card-title text-center">Register</h2>
                <form action="{{route('do_register')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                <strong>Error!</strong> {{$error}}
                            </div>
                        @endforeach
                        {{ csrf_field() }}
                        <div class="form-group">
                            @if(request()->error)
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> {{request()->error}}
                                </div>
                            @endif
                            {{ csrf_field() }}
                            <div class="form-group mb-2">
                                <label for="code" class="form-label">Name:</label>
                                <input type="text" class="form-control" placeholder="name" name="name" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="model" class="form-label">Email:</label>
                                <input type="email" class="form-control" placeholder="email" name="email" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="model" class="form-label">Password:</label>
                                <input type="password" class="form-control" placeholder="password" name="password"
                                    required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="model" class="form-label">Password Confirmation:</label>
                                <input type="password" class="form-control" placeholder="Confirmation"
                                    name="password_confirmation" required>
                            </div>
                            <div class="form-group mb-2">
                                <button type="submit" class="btn btn-primary">Register</button>
                                <div>
                                    <a class="nav-link" href="{{route('login')}}">Login</a>
                                </div>
                            </div>
                </form>
            </div>
        </div>
    </div>
</body>

</h tml>
