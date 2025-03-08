@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="loader" id="loader">
    <i class="fas fa-spinner fa-spin"></i>
</div>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="login-container">
        <!-- Left Section with Logo -->
        <div class="login-left">
            <img src="{{ asset('images/unc-logo.png') }}" alt="University Logo" class="img-fluid">
        </div>

        <!-- Right Section with Form -->
        <div class="login-right">
            <div class="text-center mb-4">
                <p class="welcome-text text-danger">Sign in to your account</p>
            </div>
            <form id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf

                <!-- Email Field -->
                <div class="form-group position-relative">
                    <input type="email" id="email" name="email" class="form-control" required>
                    <label for="email" class="floating-label">Email</label>
                    <i class="fas fa-envelope input-icon"></i>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group position-relative">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <label for="password" class="floating-label">Password</label>
                    <i class="fas fa-lock input-icon"></i>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group form-check">
                    <input type="checkbox" id="remember" name="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Remember Me</label>
                </div>

                <!-- Sign In Button -->
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-login btn-block">Sign In</button>
                </div>

                <!-- Create Account Link -->
                <!-- <div class="text-center mt-3">
                    <p class="small">
                        Don't have an account? <a href="{{ route('auth.register.form') }}" class="text-danger no-underline">Create Account</a>
                    </p>
                </div>-->

                <!-- Error Message -->
                @if (session('error'))
                    <div class="text-danger text-center">{{ session('error') }}</div>
                @endif
            </form>
        </div>
    </div>
</div>

<style>
    .loader {
        display: none;
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
        justify-content: center;
        align-items: center;
        padding: 40px;
        background-color: #f8f9fa;
    }

    .login-left img {
        max-width: 70%;
        margin-bottom: 0;
    }

    .login-right {
        flex: 1;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-control {
        border: none;
        border-bottom: 2px solid #ddd;
        border-radius: 0;
        font-size: 1rem;
        width: 100%;
        padding: 10px 10px 10px 0;
        background-color: transparent;
    }

    .form-control:focus {
        border-bottom: 2px solid #dc3545;
        outline: none;
    }

    .floating-label {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        font-size: 1rem;
        color: #6c757d;
        transition: all 0.2s ease-in-out;
        pointer-events: none;
    }

    .form-control:focus + .floating-label,
    .form-control:not(:placeholder-shown) + .floating-label {
        top: -10px;
        font-size: 0.85rem;
        color: #dc3545;
    }

    .input-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
    }

    .btn-login {
        background-color: #dc3545;
        color: white;
        font-size: 1rem;
        font-weight: bold;
        border: none;
        padding: 12px;
        border-radius: 8px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        width: 100%;
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
    }

    .no-underline {
        text-decoration: none !important;
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('loginForm');
        const loader = document.getElementById('loader');

        form.addEventListener('submit', function () {
            loader.style.display = 'flex';
        });
    });
</script>
@endsection
