@extends('layouts.admin-layout')

@section('title', 'Committee Dashboard')

@section('page-title', 'Dashboard')
@section('breadcrumb-title', 'Dashboard')

@section('content')

<div class="row">
    <!-- Total Dormitories Card -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-danger">
            <div class="inner">
                <h3>{{ $totalDormitories }}</h3>
                <p>Total Dormitories</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M3 9V7h18v2H3zm0 4v-2h18v2H3zm0 4v-2h18v2H3z"></path>
            </svg>
            <a href="{{ route('committee.dormitories') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>

    <!-- Pending Approvals Card -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3>{{ $pendingDormitories }}</h3>
                <p>Pending Approvals</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
            </svg>
            <a href="{{ route('committee.dormitories') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>

    <!-- Accredited Dormitories Card -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>{{ $accreditedDormitories }}</h3>
                <p>Accredited Dormitories</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M9 16.2L4.8 12l-1.4 1.4 6 6 10-10-1.4-1.4z"></path>
            </svg>
            <a href="{{ route('committee.dormitories') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Dormitories Table -->
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title"><i class="fas fa-clock"></i> Recent Dormitories</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Owner</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentDormitories as $dormitory)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dormitory->name }}</td>
                            <td>{{ $dormitory->owner->name }}</td>
                            <td>
                                <span class="badge {{ $dormitory->status === 'accredited' ? 'bg-success' : ($dormitory->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ ucfirst($dormitory->status) }}
                                </span>
                            </td>
                            <td>{{ $dormitory->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
