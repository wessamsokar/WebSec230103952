@extends('layouts.master')
@section('title', 'Forgot Password')
@section('content')
    <div class="d-flex justify-content-center">
        <div class="card m-4 col-sm-6">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif
                <form action="{{ route('send_reset_password') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group mb-2">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group mb-2">
                        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
