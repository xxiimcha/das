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
                    <td>{{ $schedule->dormitory->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->evaluation_date)->format('M d, Y') }}</td>
                    <td>
                        <span class="badge 
                            {{ $schedule->status === 'completed' ? 'bg-success' : 
                            ($schedule->status === 'pending' ? 'bg-warning text-dark' : 
                            ($schedule->status === 'under review' ? 'bg-primary' : 'bg-secondary')) }}">
                            {{ ucfirst($schedule->status) }}
                        </span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($schedule->created_at)->format('M d, Y') }}</td>
                    <td>
                        @if ($schedule->status === 'pending')
                            <a href="{{ route('evaluation.form', ['schedule_id' => $schedule->id]) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-check-circle"></i> Evaluate
                            </a>
                        @else
                            <a href="{{ route('evaluation.review', ['schedule_id' => $schedule->id]) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Review
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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

        // Handle evaluate button click
        const evaluateBtns = document.querySelectorAll('.evaluate-btn');

        evaluateBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const scheduleId = btn.getAttribute('data-id');
                const dormitoryName = btn.getAttribute('data-dorm');

                document.getElementById('schedule_id').value = scheduleId;
                document.getElementById('dormitory_name').textContent = dormitoryName;
            });
        });
    });
</script>
@endsection
