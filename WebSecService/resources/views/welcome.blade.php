<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="container py-4">
    @extends('layouts.master')
    @section('title', 'Prime Numbers')
    @section('content')
        <div class="card m-4">
            <div class="card-body">
                Welcome to Home Page
            </div>
        </div>

        <div class="card m-4">
            <div class="card-header">Basic Web Page with Bootstrap</div>
            <div class="card-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque consequat consequat
                enim,
                at tincidunt lacus malesuada eget. Fusce nec magna lectus. Donec sit amet consequat est. Aliquam
                quis augue pharetra, ornare ligula sed, dignissim turpis. Interdum et malesuada fames ac ante ipsum
                ortor.</div>
        </div>
        <script>
            function doSomething() {
                alert("Hello from Java Script");
            }
        </script>
        <div class="card m-4">
            <div class="card-body">
                <button type="button" class="btn btn-primary" onclick="doSomething()">Press Me</button>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $("#btn1").click(function () {
                    $("#btn2").show();
                });
                $("#btn2").click(function () {
                    $("#ul1").append("<li>Hello</li>");
                });
            });
        </script>
        <div class="card m-4">
            <div class="card-body">
                <button type="button" id="btn1" class="btn btn-primary">Press Me</button>
                <button type="button" id="btn2" class="btn btn-success" style="display: none;">Press Me Again</button>
                <ul id="ul1">
                </ul>
            </div>
        </div>

    @endsection
</body>

</html>