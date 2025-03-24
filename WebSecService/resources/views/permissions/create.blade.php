@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Create Permission</h1>
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="display_name">Display Name</label>
                <input type="text" name="display_name" id="display_name" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
