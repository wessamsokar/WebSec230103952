@extends('layouts.master')
@section('title', 'Login')
@section('content')
    <div class="d-flex justify-content-center">
        <div class="card m-4 col-sm-6">
            <div class="card-body">
                <form action="{{route('do_login')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                <strong>Error!</strong> {{$error}}
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group mb-2">
                        <label for="model" class="form-label">Email:</label>
                        <input type="email" class="form-control" placeholder="email" name="email" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="model" class="form-label">Password:</label>
                        <input type="password" class="form-control" placeholder="password" name="password" required>
                    </div>
                    
                    <div>
                        <a class="nav-link" href="{{route('register')}}">Register</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" href="./resgister">Login</button>
                </form>
                <a href="{{ route('users.change-password') }}" class="btn btn-secondary w-100 mt-2">Change
                    Password</a>
                </form>
            </div>
        </div>
    </div>
@endsection
