@extends('layouts.admin-layout')

@section('title', 'Your Account')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Your Account Details</h3>
    </div>
    <div class="card-body">
        <form method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
            </div>
            <button type="submit" class="btn btn-danger mt-3">Update Account</button>
        </form>
    </div>
</div>
@endsection
