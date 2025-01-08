@extends('layouts.admin-layout')

@section('title', 'Owner Dashboard')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Welcome, {{ Auth::user()->name }}</h3>
    </div>
    <div class="card-body">
        <p>This is your owner dashboard. Manage your dormitories, view evaluations, and monitor the status of your dormitory accreditation here.</p>
    </div>
</div>
@endsection
