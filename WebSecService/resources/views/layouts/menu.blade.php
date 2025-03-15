<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/welcome') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/even') }}">Even Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/prime') }}">Prime Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/multiplication') }}">Multiplication Table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/multable') }}">Multable</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/bill') }}">Bill</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/student') }}">Student</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('products.list') }}">Products</a>
            </li>
        </ul>
        @if(Auth::check())
            <a href="{{ route('profile.details') }}" class="text-primary text-decoration-none">
                {{ Auth::user()->name }}
            </a>
        @endif



        <nav class="navbar navbar-expand-sm bg-light">
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 mt-2">Logout</button>
                </form>
            @else
                <div class="container-fluid">

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('login')}}">Login</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{route('register')}}">Register</a>
                        </li>
            @endauth
                </ul>
            </div>
        </nav>

    </div>
</nav>