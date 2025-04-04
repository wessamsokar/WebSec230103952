@extends('layouts.master')

@section('content')
    <div class="container">
        <h1 class="mb-4">Create User</h1>
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div>
                <label class="form-label">Credit</label>
                <input type="number" name="credit" class="form-control" min="0" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Role</label>
                <div class="d-flex flex-column">
                    @foreach($roles as $role)
                        <div class="form-check mb-2">
                            <input type="radio" class="form-check-input" name="role" value="{{$role->name}}"
                                id="role_{{$role->name}}" {{$role->taken ? 'checked' : ''}}>
                            <label class="form-check-label" for="role_{{$role->name}}">{{$role->name}}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('users.list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
