@extends('layouts.admin-layout')

@section('title', 'Monitoring Details')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Monitoring Details</h3>
    </div>
    <div class="card-body">
        <p>Current Status: <strong>{{ $dormitory->status }}</strong></p>
        <p>Last Updated: {{ $dormitory->updated_at }}</p>
    </div>
</div>
@endsection
