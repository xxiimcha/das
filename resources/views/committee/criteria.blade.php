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
                <tr id="criteriaHeaders">
                    <th contenteditable="true">Criteria</th>
                    @foreach ($columns as $column)
                        <th contenteditable="true">{{ $column->name }}</th>
                    @endforeach
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="criteriaBody">
                @foreach ($criteria as $item)
                    <tr data-id="{{ $item->id }}">
                        <td contenteditable="true">{{ $item->criteria_name }}</td>
                        @foreach ($item->values as $value)
                            <td contenteditable="true">{{ $value }}</td>
                        @endforeach
                        <td>
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
                        <button class="btn btn-danger btn-sm deleteRow"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;
            $('#criteriaTable tbody').append(newRow);

            // Send an AJAX request to save the new row in the database
            $.ajax({
                url: '{{ route("criteria.row.add") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    criteria_name: 'New Criteria',
                    values: Array.from({ length: {{ count($columns) }} }, () => 'New Description'),
                },
                success: function (response) {
                    console.log('Row added successfully:', response);
                },
                error: function (error) {
                    console.error('Error adding row:', error);
                },
            });
        });

        // Add a new column
        $('#addColumn').on('click', function () {
            const newHeader = `<th contenteditable="true">New Column</th>`;
            $('#criteriaTable thead tr th:last').before(newHeader);

            $('#criteriaTable tbody tr').each(function () {
                const newCell = `<td contenteditable="true">New Cell</td>`;
                $(this).find('td:last').before(newCell);
            });

            // Send an AJAX request to save the new column in the database
            $.ajax({
                url: '{{ route("criteria.column.add") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    column_name: 'New Column',
                },
                success: function (response) {
                    console.log('Column added successfully:', response);
                },
                error: function (error) {
                    console.error('Error adding column:', error);
                },
            });
        });

        // Remove a row
        $(document).on('click', '.deleteRow', function () {
            const row = $(this).closest('tr');
            const criteriaId = row.data('id'); // Get the id from the data-id attribute

            // Send an AJAX request to delete the row from the database
            $.ajax({
                url: '{{ route("criteria.row.delete", ":id") }}'.replace(':id', criteriaId),
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    console.log('Row deleted successfully:', response);
                    row.remove(); // Remove the row from the table on success
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
            const criteriaId = row.data('id'); // Assuming rows have a data-id attribute

            // Send an AJAX request to update the cell value in the database
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
                    console.log('Cell updated successfully:', response);
                },
                error: function (error) {
                    console.error('Error updating cell:', error);
                },
            });
        });
    });
</script>
@endsection
