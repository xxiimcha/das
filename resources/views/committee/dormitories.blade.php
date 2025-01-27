@extends('layouts.admin-layout')

@section('title', 'Dormitories')

@section('page-title', 'Dormitories')
@section('breadcrumb-title', 'Dormitories')

@section('content')
<div class="card shadow card-danger card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Dormitories</h3>
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
                        <a href="{{ route('committee.dormitories.show', $dormitory->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a class="btn btn-danger btn-sm delete-dormitory-btn" href="#" data-id="{{ $dormitory->id }}" data-name="{{ $dormitory->name }}" data-bs-toggle="modal" data-bs-target="#deleteDormitoryModal">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Dormitory Modal -->
<div class="modal fade" id="deleteDormitoryModal" tabindex="-1" aria-labelledby="deleteDormitoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDormitoryModalLabel">Delete Dormitory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this dormitory?
            </div>
            <div class="modal-footer">
                <form id="deleteDormitoryForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteDormitoryBtns = document.querySelectorAll('.delete-dormitory-btn');

        deleteDormitoryBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const dormitoryId = btn.getAttribute('data-id');
                const form = document.getElementById('deleteDormitoryForm');
                form.action = `/committee/dormitories/${dormitoryId}`;
            });
        });
    });
</script>
@endsection
