<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SonicTIX - Register</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    @include('navbar')
    <div class="container">
        <div class="box form-box">
            <header>Register</header>
            <form id="register-form">
                <div class="field input">
                    <label for="username" class="input-label">Username</label>
                    <input type="text" name="username" id="username" required>
                </div>

                <div class="field input">
                    <label for="password" class="input-label">Password</label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" required>
                        <i class="fas fa-eye" id="toggle-password"></i>
                    </div>
                </div>

                <div class="field input">
                    <label for="email" class="input-label">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="field input">
                    <label for="full-name" class="input-label">Full Name</label>
                    <input type="text" name="full-name" id="full-name" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already have an account? <a href="{{ url('/login') }}">Login here!</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
