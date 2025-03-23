@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Edit Permission</h1>
        <form action="{{ route('permissions.update', $permission) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $permission->name }}" readonly>
            </div>
            <div class="form-group">
                <label for="display_name">Display Name</label>
                <input type="text" name="display_name" id="display_name" class="form-control" value="{{ $permission->display_name }}">
            </div>

            

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
