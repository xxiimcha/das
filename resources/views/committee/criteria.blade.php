@extends('layouts.admin-layout')

@section('title', 'Set Criteria')

@section('page-title', 'Criteria')
@section('breadcrumb-title', 'Set Criteria')

@section('content')
<!-- Buttons Outside the Card -->
<div class="d-flex justify-content-center mb-3">
    <button id="addRow" class="btn btn-light btn-sm mx-2">
        <i class="fas fa-plus fa-lg text-danger"></i>
    </button>
    <button id="addColumn" class="btn btn-light btn-sm mx-2">
        <i class="fas fa-columns fa-lg text-danger"></i>
    </button>
    <button id="deleteSelected" class="btn btn-light btn-sm mx-2">
        <i class="fas fa-trash fa-lg text-danger"></i>
    </button>
</div>

<div class="card">
    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
        <h5 class="card-title">Dormitory Criteria</h5>
    </div>
    <div class="card-body table-responsive">
        <table id="criteriaTable" class="table table-bordered text-center align-middle">
        <thead class="bg-danger text-white">
    <tr>
        <th>Criteria</th>
        @foreach ($columns as $column)
            <th>{{ $column->name }}</th>
        @endforeach
        <th>Status</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
    @foreach ($criteria as $item)
    <tr data-id="{{ $item->id }}">
        <td contenteditable="true">{{ $item->criteria_name }}</td>
        @foreach ($item->values as $value)
            <td contenteditable="true">{{ $value }}</td>
        @endforeach
        <td>
            <span class="badge {{ $item->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                {{ ucfirst($item->status) }}
            </span>
        </td>
        <td>
            <button class="btn btn-warning btn-sm toggleStatus" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                <i class="fas {{ $item->status === 'active' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
            </button>
            <button class="btn btn-danger btn-sm deleteRow">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
    @endforeach
</tbody>

        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Add a new row
        $('#addRow').on('click', function () {
            const newRow = `
                <tr>
                    <td contenteditable="true">New Criteria</td>
                    @foreach ($columns as $column)
                        <td contenteditable="true">New Description</td>
                    @endforeach
                    <td>
                        <span class="badge bg-danger">Inactive</span>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm toggleStatus" data-status="inactive">
                            <i class="fas fa-toggle-off"></i>
                        </button>
                        <button class="btn btn-danger btn-sm deleteRow"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;
            $('#criteriaTable tbody').append(newRow);
        });

        // Toggle Activate/Deactivate
        $(document).on('click', '.toggleStatus', function () {
            const button = $(this);
            const row = button.closest('tr');
            const criteriaId = row.data('id');
            let currentStatus = button.data('status');

            // Toggle status
            let newStatus = currentStatus === 'active' ? 'inactive' : 'active';

            // Send AJAX request to update the status
            $.ajax({
                url: '{{ route("criteria.toggle.status") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: criteriaId,
                    status: newStatus
                },
                success: function (response) {
                    console.log('Status updated:', response);
                    button.data('status', newStatus);

                    // Update button icon and badge
                    button.find('i').toggleClass('fa-toggle-on fa-toggle-off');
                    const statusBadge = row.find('.badge');
                    statusBadge.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1))
                               .toggleClass('bg-success bg-danger');
                },
                error: function (error) {
                    console.error('Error updating status:', error);
                }
            });
        });

        // Remove a row
        $(document).on('click', '.deleteRow', function () {
            const row = $(this).closest('tr');
            const criteriaId = row.data('id'); 

            // Send AJAX request to delete the row
            $.ajax({
                url: '{{ route("criteria.row.delete", ":id") }}'.replace(':id', criteriaId),
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    console.log('Row deleted:', response);
                    row.remove();
                },
                error: function (error) {
                    console.error('Error deleting row:', error);
                },
            });
        });

        // Update content when edited
        $(document).on('focusout', '[contenteditable="true"]', function () {
            const cell = $(this);
            const row = cell.closest('tr');
            const columnIndex = cell.index();
            const criteriaId = row.data('id');

            $.ajax({
                url: '{{ route("criteria.row.update") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: criteriaId,
                    column_index: columnIndex,
                    value: cell.text(),
                },
                success: function (response) {
                    console.log('Cell updated:', response);
                },
                error: function (error) {
                    console.error('Error updating cell:', error);
                },
            });
        });
    });
</script>
@endsection
