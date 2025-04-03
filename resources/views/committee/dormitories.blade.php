@extends('layouts.admin-layout')

@section('title', 'Dormitories')
@section('page-title', 'Dormitories')
@section('breadcrumb-title', 'Dormitories')

@section('content')
<div class="card shadow card-danger card-outline">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Dormitories</h3>

        @if(Auth::user()->role === 'admin')
            <div class="ms-auto">
                <div class="dropdown">
                    <button class="btn btn-danger btn-sm dropdown-toggle" type="button" id="addDormDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-plus-circle"></i> Add Dormitory
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="addDormDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('dormitories.create') }}">
                                <i class="bi bi-pencil-square"></i> Add Manually
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="bi bi-upload"></i> Import from File
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        @endif
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
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="dormitoriesTable">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Status</th>
                        <th>Evaluation Date</th>
                        <th>Accreditation Date</th>
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
                            <span class="badge 
                                {{ $dormitory->status === 'accredited' ? 'bg-success' : 
                                    ($dormitory->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ ucfirst($dormitory->status) }}
                            </span>
                        </td>
                        <td>
                            {{ optional($dormitory->accreditationSchedules->last())->evaluation_date 
                                ? \Carbon\Carbon::parse($dormitory->accreditationSchedules->last()->evaluation_date)->format('M d, Y') 
                                : 'N/A' }}
                        </td>
                        <td>
                            {{ optional($dormitory->accreditationSchedules->last())->updated_at 
                                ? \Carbon\Carbon::parse($dormitory->accreditationSchedules->last()->updated_at)->format('M d, Y') 
                                : 'N/A' }}
                        </td>
                        <td>{{ $dormitory->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('committee.dormitories.show', $dormitory->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <button type="button" class="btn btn-danger btn-sm delete-dormitory-btn"
                                    data-id="{{ $dormitory->id }}" data-name="{{ $dormitory->name }}"
                                    data-bs-toggle="modal" data-bs-target="#deleteDormitoryModal">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Dormitory Modal -->
<div class="modal fade" id="deleteDormitoryModal" tabindex="-1" aria-labelledby="deleteDormitoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteDormitoryModalLabel">Delete Dormitory</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('dormitories.import') }}" enctype="multipart/form-data" class="modal-content border-danger">
            @csrf
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="importModalLabel">Import Dormitories</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p>Please upload an Excel file (.xlsx or .csv) with the following columns:</p>
                <ul>
                    <li><strong>Dorm Name</strong></li>
                    <li><strong>Owner</strong></li>
                    <li><strong>Contact Number</strong></li>
                    <li><strong>Email</strong></li>
                    <li><strong>Dorm Location</strong></li>
                    <li><strong>Owner's Address</strong></li>
                </ul>

                <div class="mb-3">
                    <label for="excel_file" class="form-label">Select File</label>
                    <input type="file" name="excel_file" class="form-control" accept=".xlsx,.csv" required>
                </div>

                <a href="{{ asset('templates/sample_dorm_import.xlsx') }}" class="btn btn-link text-danger" download>
                    <i class="bi bi-file-earmark-arrow-down"></i> Download Sample Template
                </a>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Upload File</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
@push('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#dormitoriesTable').DataTable({
            order: [[4, "desc"]],
            columnDefs: [{ orderable: false, targets: [7] }]
        });

        document.querySelectorAll('.delete-dormitory-btn').forEach(button => {
            button.addEventListener('click', function () {
                const dormitoryId = button.getAttribute('data-id');
                document.getElementById('deleteDormitoryForm').action = `/committee/dormitories/${dormitoryId}`;
            });
        });
    });
</script>
@endpush
@endsection
