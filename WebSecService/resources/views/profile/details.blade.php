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
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <td>{{$user->name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$user->email}}</td>
                    </tr>
                    <tr>
                        <th>Roles</th>
                        <td>
                            @if($user->roles)
                                @foreach($user->roles as $role)
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                @endforeach
                            @else
                                <span>No roles assigned</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Direct Permissions</th>
                        <td>
                            @if($user->permissions)
                                @foreach($user->permissions as $permission)
                                    <span class="badge bg-success">{{ $permission->display_name }}</span>
                                @endforeach
                            @else
                                <span>No permissions assigned</span>
                            @endif
                        </td>
                    </tr>
                    
                </table>

            </div>
        </div>
    @endsection
</body>

</html>
