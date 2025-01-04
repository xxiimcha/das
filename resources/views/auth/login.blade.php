<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        body {
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            width: 100%;
            max-width: 900px;
            background-color: white;
            border-radius: 16px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .login-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background-color: white;
        }
        .login-left img {
            max-width: 60%;
            margin-bottom: 20px;
        }
        .login-right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }
        .form-group input {
            border: none;
            border-bottom: 2px solid #ddd;
            border-radius: 0;
            width: 100%;
            padding: 10px 35px 10px 10px;
            font-size: 1rem;
        }
        .form-group input:focus {
            border-bottom: 2px solid #dc3545;
            outline: none;
        }
        .form-group i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .btn-login {
            background-color: #dc3545;
            color: white;
            font-size: 1rem;
            border-radius: 5px;
            padding: 12px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-login:hover {
            background-color: #b71c1c;
            transform: translateY(-2px);
        }
        .welcome-text {
            font-size: 1.2rem;
            font-weight: bold;
            color: #495057;
            margin-bottom: 20px;
            text-align: center;
        }
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            .login-left, .login-right {
                flex: none;
                width: 100%;
            }
            .login-left {
                text-align: center;
                padding: 20px;
            }
            .login-right {
                padding: 30px;
            }
        }
        .text-danger {
            font-size: 0.9rem;
            margin-top: 10px;
        }
        /* Updated Centered Loader */
        .loader {
            display: none; /* Ensures loader is hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .loader i {
            font-size: 4rem;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="loader" id="loader">
        <i class="fas fa-spinner fa-spin"></i>
    </div>
    <div class="login-container">
        <div class="login-left">
            <img src="{{ asset('images/unc-logo.png') }}" alt="University Logo">
        </div>
        <div class="login-right">
            <div class="text-center mb-4">
                <p class="welcome-text">Sign in to your account</p>
            </div>
            <form id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    <i class="fas fa-envelope"></i>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group form-check">
                    <input type="checkbox" id="remember" name="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Remember Me</label>
                </div>

                <!-- Submit Button -->
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-login btn-block">Sign In</button>
                </div>

                <!-- Error Message -->
                @if (session('error'))
                    <div class="text-danger text-center">{{ session('error') }}</div>
                @endif
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function () {
            // Toastr Error Display
            @if (session('error'))
                toastr.error('{{ session('error') }}', 'Error', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-center",
                });
            @endif

            // Toastr Success Display
            @if (session('success'))
                toastr.success('{{ session('success') }}', 'Success', {
                    closeButton: true,
                    progressBar: true,
                    positionClass: "toast-top-center",
                });
                setTimeout(() => {
                    window.location.href = '{{ session('redirect') }}';
                }, 2000);
            @endif

            // Show loader on form submission
            $('#loginForm').submit(function (e) {
                e.preventDefault(); // Prevent immediate form submission
                $('#loader').css('display', 'flex'); // Dynamically apply flex for centering loader

                // Simulate form submission delay (for testing purposes)
                setTimeout(() => {
                    this.submit(); // Submit the form after showing the loader
                }, 500); // Adjust delay as needed
            });
        });
    </script>
</body>
</html>
