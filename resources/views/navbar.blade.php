<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
</head>
<body>
    
    <nav class="mborder-solid border-2 border-black relative mx-auto px-8 py-4 bg-white">
        <!-- flex container -->
        <div class="border-solid border-2 border-black flex items-center justify-between">
            <!-- logo -->
            <div class="border-solid border-2 border-black">
                <img href="{{ url('/') }}" src="{{ asset('img/sonictix-logo.jpeg') }}" alt="SonicTIX Logo" class="h-10">
            </div>
            <!-- menu items -->
            <div class="hidden md:flex space-x-6 font-semibold">
                <a href="{{ url('/') }}" class="p-3 px-6 pt-2">Home</a>
                <a href="{{ url('/login') }}" id="login-link" class="p-3 px-6 pt-2">Login</a>
                <a href="{{ url('/logout') }}" id="logout-link" class="p-3 px-6 pt-2 text-white bg-brightBlue rounded-full baseline" onclick="confirmLogout(event)">Logout</a>
                <!-- register button -->
                <a href="{{ url('/register') }}" id="register-link" class="block p-3 px-6 pt-2 text-white bg-brightBlue rounded-full baseline">Register</a>
            </div>
        </div>
    </nav>

    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
