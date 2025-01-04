<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        .login-left h3 {
            font-size: 1.8rem;
            font-weight: bold;
        }
        .login-left p {
            font-size: 1rem;
            margin-top: 10px;
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
        .form-group input, .form-group select {
            border: none;
            border-bottom: 2px solid #ddd;
            border-radius: 0;
            width: 100%;
            padding: 10px 35px 10px 10px;
            font-size: 1rem;
        }
        .form-group input:focus, .form-group select:focus {
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
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <img src="{{ asset('images/unc-logo.png') }}" alt="University Logo">
        </div>
        <div class="login-right">
            <div class="text-center mb-4">
                <p class="welcome-text">Sign in to your account</p>
            </div>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="role">Login As:</label>
                    <select class="form-control" id="role" name="role">
                        <option value="admin">Admin</option>
                        <option value="student">Student</option>
                        <option value="staff">Staff</option>
                    </select>
                    <i class="fas fa-user"></i>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-login btn-block">Sign In</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
