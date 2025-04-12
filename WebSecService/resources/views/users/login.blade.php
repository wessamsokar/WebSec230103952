@extends('layouts.master')
@section('title', 'Login')
@section('content')
    <div class="d-flex justify-content-center">
        <div class="card m-4 col-sm-6">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            <strong>Error!</strong> {{ $error }}
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('do_login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group mb-2">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" placeholder="email" name="email" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" placeholder="password" name="password" required>
                    </div>
                    <div class="form-group mb-2">
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        <a href="{{ route('forgot_password') }}" class="btn btn-link w-100">Forgot Password?</a>
                    </div>
                    <div class="form-group mb-2">
                        <a href="{{ route('register') }}" class="btn btn-link w-100">Register</a>
                        <a href="{{ route('login_with_google') }}" class="btn btn-success w-100">Login with Google</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
