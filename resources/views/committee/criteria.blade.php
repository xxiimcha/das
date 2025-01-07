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
                    <th contenteditable="true">Criteria</th>
                    <th contenteditable="true">Completely Acceptable (4)</th>
                    <th contenteditable="true">Acceptable (3)</th>
                    <th contenteditable="true">Slightly Acceptable (2)</th>
                    <th contenteditable="true">Unacceptable (1)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td contenteditable="true">1.1 Receiving Room</td>
                    <td contenteditable="true">Limited space / No receiving room available</td>
                    <td contenteditable="true">Small receiving room is available</td>
                    <td contenteditable="true">Adequate space for receiving room</td>
                    <td contenteditable="true">Receiving room with sala set and reading materials</td>
                    <td>
                        <button class="btn btn-danger btn-sm deleteRow">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
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
                    <td contenteditable="true">Description 1</td>
                    <td contenteditable="true">Description 2</td>
                    <td contenteditable="true">Description 3</td>
                    <td contenteditable="true">Description 4</td>
                    <td>
                        <button class="btn btn-danger btn-sm deleteRow"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;
            $('#criteriaTable tbody').append(newRow);
        });

        // Add a new column
        $('#addColumn').on('click', function () {
            // Add new header before the "Action" column
            const newHeader = `<th contenteditable="true">New Column</th>`;
            $('#criteriaTable thead tr th:last').before(newHeader);

            // Add cells to each row before the "Action" column
            $('#criteriaTable tbody tr').each(function () {
                const newCell = `<td contenteditable="true">New Cell</td>`;
                $(this).find('td:last').before(newCell);
            });
        });

        // Remove a row
        $(document).on('click', '.deleteRow', function () {
            $(this).closest('tr').remove();
        });

        // Validate editable content
        $(document).on('input', '[contenteditable="true"]', function () {
            if (!$(this).text().trim()) {
                $(this).text('Empty Field');
            }
        });
    });
</script>
@endsection
