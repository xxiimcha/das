@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="register-card">
        <img src="{{ asset('images/unc-logo.png') }}" alt="Logo">
        <h4 class="text-danger">Create Your Account</h4>

        <!-- Loading Spinner -->
        <div id="loading" class="text-center" style="display: none;">
            <div class="spinner-border text-danger" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2">Processing your registration, please wait...</p>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="text-center" style="display: none;">
            <h5 class="text-success">Registration Successful!</h5>
            <p>You will be redirected to the login page shortly...</p>
        </div>

        <!-- Registration Form -->
        <form id="registerForm">
            @csrf

            <div class="form-group">
                <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Firstname" required>
            </div>

            <div class="form-group">
                <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Lastname" required>
            </div>

            <div class="form-group">
                <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Mobile Number" required>
            </div>

            <div class="form-group">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>

            <div class="form-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="form-group">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Retype Password" required>
            </div>

            <div class="terms">
                By signing up for an account, you agree to our
                <a href="#" class="text-danger no-underline">Terms of Service</a> and <a href="#" class="text-danger no-underline">Privacy Policy</a>.
            </div>

            <button type="submit" class="btn btn-register">Create Account</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}" class="text-danger no-underline">Log in here</a>
        </div>
    </div>
</div>

<style>
    .register-card {
        width: 100%;
        max-width: 500px;
        background-color: white;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .register-card img {
        width: 80px;
        margin-bottom: 20px;
    }
    .register-card h4 {
        font-weight: bold;
        margin-bottom: 30px;
        color: #dc3545;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group input {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 12px;
        font-size: 0.95rem;
    }
    .form-group input:focus {
        border-color: #dc3545;
        box-shadow: 0 0 5px rgba(220, 53, 69, 0.3);
        outline: none;
    }
    .btn-register {
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
    .btn-register:hover {
        background-color: #b71c1c;
        transform: translateY(-2px);
    }
    .terms {
        font-size: 0.85rem;
        margin: 10px 0;
        color: #6c757d;
    }
    .login-link {
        font-size: 0.85rem;
        margin-top: 20px;
    }
    .no-underline {
        text-decoration: none !important;
    }
</style>

<script>
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Show loading spinner
        document.getElementById('registerForm').style.display = 'none';
        document.getElementById('loading').style.display = 'block';

        // Collect form data
        const formData = new FormData(this);

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            alert('CSRF token not found. Please refresh the page.');
            document.getElementById('registerForm').style.display = 'block';
            document.getElementById('loading').style.display = 'none';
            return;
        }

        // Send form data to the server
        fetch("{{ route('auth.register') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('successMessage').style.display = 'block';

                // Redirect to login after 3 seconds
                setTimeout(() => {
                    window.location.href = "{{ route('login') }}";
                }, 3000);
            } else {
                alert(data.message);
                document.getElementById('registerForm').style.display = 'block';
                document.getElementById('loading').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            document.getElementById('registerForm').style.display = 'block';
            document.getElementById('loading').style.display = 'none';
        });
    });

</script>
@endsection
