@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center text-center py-5" style="min-height: 80vh;">
    <div class="card shadow border-0 p-5" style="max-width: 600px; width: 100%;">
        <div class="mb-4">
            <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
        </div>
        <h2 class="text-success fw-bold mb-3">Thank you for registering!</h2>
        <p class="lead text-secondary">Your dormitory registration has been successfully submitted and is now under review.</p>

        <a href="{{ url('/') }}" class="btn btn-primary btn-lg mt-4 px-4">Go to Homepage</a>
    </div>
</div>
@endsection
