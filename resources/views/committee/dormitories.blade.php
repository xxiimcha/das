@extends('layouts.admin-layout')

@section('title', 'Dormitories')

@section('page-title', 'Dormitories')
@section('breadcrumb-title', 'Dormitories')

@section('content')
<div class="card shadow card-danger card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-house-user"></i> Dormitories</h3>
        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#addDormitoryModal">
            <i class="fas fa-plus-circle"></i> Add Dormitory
        </button>
    </div>
    <div class="card-body">
        <!-- Toastr Alerts -->
        @if (session('success'))
            <script>
                toastr.success("{{ session('success') }}", "Success", { timeOut: 5000 });
            </script>
        @endif

        @if (session('error'))
            <script>
                toastr.error("{{ session('error') }}", "Error", { timeOut: 5000 });
            </script>
        @endif

        <!-- Table -->
        <table class="table table-striped table-hover" id="dormitoriesTable">
            <thead class="bg-danger text-white">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Owner</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dormitories as $dormitory)
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
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="actionDropdown{{ $dormitory->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $dormitory->id }}">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-eye"></i> View</a></li>
                                <li><a class="dropdown-item text-danger delete-dormitory-btn" href="#" data-id="{{ $dormitory->id }}" data-name="{{ $dormitory->name }}" data-bs-toggle="modal" data-bs-target="#deleteDormitoryModal">
                                    <i class="fas fa-trash"></i> Delete
                                </a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
