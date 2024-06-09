<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SonicTIX - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('navbar')
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <form id="login-form">
                <div class="field input">
                    <input type="text" name="username" id="username" placeholder="Enter your username" required>
                </div>

                <div class="field input">
                    <div class="password-container">
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                        <i class="fas fa-eye" id="toggle-password"></i>
                    </div>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    New to SonicTIX? <a href="{{ url('/register') }}">Create an account</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
