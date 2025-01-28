@extends('layouts.admin-layout')

@section('title', 'Evaluation Schedules')

@section('page-title', 'Evaluation Schedules')
@section('breadcrumb-title', 'Evaluation Schedules')

@section('content')
<div class="card shadow card-danger card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Evaluation Schedules</h3>
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
        <table class="table table-striped table-hover" id="evaluationSchedulesTable">
            <thead class="bg-danger text-white">
                <tr>
                    <th>#</th>
                    <th>Dormitory Name</th>
                    <th>Evaluation Date</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $schedule->dormitory->name ?? 'N/A' }}</td> <!-- Assuming relationship exists -->
                    <td>{{ $schedule->evaluation_date->format('M d, Y') }}</td>
                    <td>
                        <span class="badge {{ $schedule->status === 'completed' ? 'bg-success' : ($schedule->status === 'pending' ? 'bg-warning' : 'bg-secondary') }}">
                            {{ ucfirst($schedule->status) }}
                        </span>
                    </td>
                    <td>{{ $schedule->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a class="btn btn-danger btn-sm delete-schedule-btn" href="#" data-id="{{ $schedule->id }}" data-name="{{ $schedule->dormitory->name }}" data-bs-toggle="modal" data-bs-target="#deleteScheduleModal">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Schedule Modal -->
<div class="modal fade" id="deleteScheduleModal" tabindex="-1" aria-labelledby="deleteScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteScheduleModalLabel">Delete Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this schedule?
            </div>
            <div class="modal-footer">
                <form id="deleteScheduleForm" method="POST">
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
        // Initialize DataTable
        $('#evaluationSchedulesTable').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    next: "Next",
                    previous: "Previous"
                }
            }
        });

        // Set up delete button
        const deleteScheduleBtns = document.querySelectorAll('.delete-schedule-btn');

        deleteScheduleBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const scheduleId = btn.getAttribute('data-id');
                const form = document.getElementById('deleteScheduleForm');
                form.action = `/committee/evaluation/${scheduleId}`;
            });
        });
    });
</script>
@endsection