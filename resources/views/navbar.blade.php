<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
</head>
<body>
    <nav class="relative mx-auto px-6 py-4 bg-white">
        <!-- flex container -->
        <div class="flex items-center justify-between">
            <!-- logo -->
            <div>
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
            
            <!-- hamburger menu -->
            <button id="menu-btn" class="block hamburger md:hidden ml-auto focus:outline-none">
                <span class="hamburger-top"></span>
                <span class="hamburger-mid"></span>
                <span class="hamburger-bot"></span>
            </button>

            <!-- mobile menu -->
            <div class="md:hidden">
                <div id="menu" class="absolute flex-col items-center self-end hidden py-6 mt-10 space-y-6 font-bold bg-white sm:w-auto sm:self-center left-6 right-6 drop-shadow-md">
                    <a href="#">Home</a>
                    <a href="#" id="mobile-login-link">Login</a>
                    <a href="#" id="mobile-logout-link">Logout</a>
                    <a href="#" id="mobile-register-link">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
