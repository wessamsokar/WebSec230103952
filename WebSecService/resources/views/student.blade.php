<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bill</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body class="container py-4">
    @extends('layouts.master')
    @section('title', 'Supermarket Bill')
    @section('content')
            <div class="card">
                <div class="card-header">Student</div>
                <div class="card-body">
                    @php
                        $items = [
                            [
                                'name' => 'jam',
                                'ID' => 1,
                                'major' => 'Cybre',
                                'gpa' => 3.1,
                                'courses' => [
                                    [
                                        'code' => 'A',
                                        'name' => 'Math',
                                        'grade' => 'A'
                                    ],
                                    [
                                        'code' => 'B',
                                        'name' => 'Science',
                                        'grade' => 'B'
                                    ],
                                    [
                                        'code' => 'C',
                                        'name' => 'English',
                                        'grade' => 'C'
                                    ]
                                ],
                            ],

                        ];

                    @endphp

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>ID</th>
                                <th>Major</th>
                                <th>GPA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['ID'] }}</td>
                                    <td>{{ $item['major'] }}</td>
                                    <td>{{ $item['gpa'] }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Course Code</th>
                                                    <th>Course Name</th>
                                                    <th>Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item['courses'] as $course)
                                                    <tr>
                                                        <td>{{ $course['code'] }}</td>
                                                        <td>{{ $course['name'] }}</td>
                                                        <td>{{ $course['grade'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
    @endsection
</body>

</html>
