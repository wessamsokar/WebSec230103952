@extends('layouts.master')
@section('title', 'Student')
@section('content')
<div class="card">
    @section('content')
        <div class="container">
            <h1 class="mb-4">Students</h1>
            @if($isAdmin)
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
                            @if($isAdmin)
                                <td>
                                    <a href="" class="btn btn-warning btn-sm">Edit</a>
                                    <a class="btn btn-danger" href='{{route('student_delete', [$student->id])}}'>Delete</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection