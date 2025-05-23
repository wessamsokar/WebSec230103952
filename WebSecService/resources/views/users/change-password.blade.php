@extends('layouts.master')
@section('title', 'Change Password')
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
                <form action="{{ route('update_password') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group mb-2">
                        <label for="password" class="form-label">New Password:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="password_confirmation" class="form-label">Confirm Password:</label>
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                    <div class="form-group mb-2">
                        <button type="submit" class="btn btn-primary w-100">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
