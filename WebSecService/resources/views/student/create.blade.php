@extends('layouts.master')
@section('content')
    <div class="container">
        <h1 class="mb-4">Create Student</h1>
        <form action="{{ route('student.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">age</label>
                <input type="text" name="age" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Major</label>
                <input type="text" name="major" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('student.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
