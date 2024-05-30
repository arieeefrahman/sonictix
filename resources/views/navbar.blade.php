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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var authToken = sessionStorage.getItem('authToken');
            var guestLinks = document.querySelectorAll('#guest-links');
            var authLinks = document.getElementById('auth-links');

            if (authToken) {
                guestLinks.forEach(function(link) {
                    link.classList.add('d-none');
                });
                authLinks.classList.remove('d-none');
            } else {
                guestLinks.forEach(function(link) {
                    link.classList.remove('d-none');
                });
                authLinks.classList.add('d-none');
            }
        });

        function logout() {
            sessionStorage.removeItem('authToken');
            // Redirect to login page or home after logging out
            window.location.href = "{{ url('/home') }}";
        }
    </script>
</body>
</html>
