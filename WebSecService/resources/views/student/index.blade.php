<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body class="container py-4">
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
</body>

</html>