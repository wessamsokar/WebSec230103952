<nav class="navbar navbar-expand-sm bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
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
                <a class="nav-link" href="{{route('cryptography')}}">Cryptography</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('webcrypto')}}">Web Crypto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/file-security') }}">File Security</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('products_list')}}">Products</a>
            </li>
            @can('show_users')
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.list')}}">Users</a>
                </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/student') }}">Student</a>

            </li>
            @can('admin_users')
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/permissions') }}">Permissions</a>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/roles') }}">Roles</a>

                </li>
            @endcan
        </ul>
        <ul class="navbar-nav">
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{route('profile')}}">{{auth()->user()->name}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('do_logout')}}">Logout</a>
                </li>
            @else
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