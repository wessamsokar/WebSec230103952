
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Details</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>

<body class="container py-4">
    @extends('layouts.master')
    @section('title', 'Profile Details')
    @section('content')
        <div class="card">
            <div class="card-header">Profile Details</div>
            <div class="card-body">
            <h2 class="card-title">Profile Details</h2>
                <h4>{{ $user->name }}</h4>
                <p>Email: {{ $user->email }}</p>
            </div>
        </div>
        
    @endsection
</body>

</html>
