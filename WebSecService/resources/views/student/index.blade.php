@extends('layouts.master')
@section('title', 'Student')
@section('content')
<div class="card">
    @section('content')
        <div class="container">
            <h1 class="mb-4">Students</h1>
            @if(auth()->check() && auth()->user()->role === 'Admin')
                <a href="{{ route('student.create') }}" class="btn btn-success mb-4">Create New Student</a>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Major</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->age }}</td>
                            <td>{{ $student->major }}</td>
                            @if(auth()->check() && auth()->user()->role === 'Admin')
                                <td>
                                    <a href="" class="btn btn-warning btn-sm">Edit</a>
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
