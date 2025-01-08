@extends('layouts.admin-layout')

@section('title', 'Profile')

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-danger text-white text-center py-5">
        <div class="d-flex justify-content-center mb-4">
            <div class="profile-picture rounded-circle bg-white overflow-hidden" style="width: 120px; height: 120px;">
                <img src="{{ asset('storage/default-avatar.png') }}" class="img-fluid" alt="User Avatar" style="object-fit: cover;">
            </div>
        </div>
        <h2 class="fw-bold mb-0">{{ auth()->user()->name }}</h2>
        <p class="mb-0">{{ ucfirst(auth()->user()->role) }}</p>
        <span class="badge rounded-pill bg-{{ auth()->user()->status === 'active' ? 'success' : 'danger' }} px-3 py-2">
            {{ ucfirst(auth()->user()->status) }}
        </span>
    </div>
    <div class="card-body">
        <!-- Profile Details -->
        <div class="row g-4">
            <div class="col-md-6">
                <h5 class="text-danger border-bottom pb-2">General Information</h5>
                <ul class="list-unstyled mt-3">
                    <li><strong>Email:</strong> <span class="text-muted">{{ auth()->user()->email }}</span></li>
                    <li><strong>Role:</strong>
                        <span class="badge rounded-pill bg-primary px-3 py-2">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="text-danger border-bottom pb-2">Account Details</h5>
                <ul class="list-unstyled mt-3">
                    <li><strong>Last Updated:</strong> <span class="text-muted">{{ auth()->user()->updated_at->format('F d, Y') }}</span></li>
                    <li><strong>Status:</strong>
                        <span class="badge rounded-pill bg-{{ auth()->user()->status === 'active' ? 'success' : 'danger' }} px-3 py-2">
                            {{ ucfirst(auth()->user()->status) }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Activity Logs Section Placeholder -->
        <div class="mt-5">
            <h5 class="text-danger border-bottom pb-2">Activity Logs</h5>
            <p class="text-muted mt-3">Activity logs will be displayed here in the future.</p>
        </div>

        <!-- Edit Profile Section -->
        <div class="mt-5 text-center">
            <a href="{{ route('profile.edit') }}" class="btn btn-danger px-5 py-2">
                <i class="fas fa-edit me-2"></i>Edit Profile
            </a>
        </div>
    </div>
</div>

<style>
    .profile-picture img {
        border-radius: 50%;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
