<!-- File: resources/views/navbar.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
</head>
<body>
    <nav class="navbar">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('sonictix-logo.jpeg') }}" alt="SonicTIX Logo" style="height: 40px;">
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item" id="guest-links">
                <a class="nav-link" href="{{ url('/login') }}">Login</a>
            </li>
            <li class="nav-item" id="guest-links">
                <a class="nav-link btn" href="{{ url('/register') }}">Register</a>
            </li>
            <li class="nav-item d-none" id="auth-links">
                <a class="nav-link" href="{{ url('/logout') }}" onclick="event.preventDefault(); logout();">
                    Logout
                </a>
            </li>
        </ul>
    </nav>

    <script src="{{ asset('js/navbar.js') }}"></script>
</body>
</html>
