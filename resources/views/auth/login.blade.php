@extends('layouts.app')

@section('content')
<div class="content-wrapper d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #f8f9fa;">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center">
                <img src="{{ asset('images/dormitory-building.jpg') }}" alt="Dormitory" class="img-fluid" style="max-height: 300px;">
                <h3 class="mt-3 text-danger">Dormitory</h3>
                <h4>Management System</h4>
            </div>

            <div class="col-md-6 border-left d-flex flex-column justify-content-center">
                <div class="text-center mb-4">
                    <i class="fas fa-user-circle fa-5x text-danger"></i>
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
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-light" onclick="togglePasswordVisibility()">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-danger btn-block">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection
