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

    <!-- Pending Accreditation Card -->
    <div class="col-lg-3 col-6">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3>{{ $pendingAccreditations }}</h3>
                <p>Pending Accreditations</p>
            </div>
            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
            </svg>
            <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                More info <i class="bi bi-link-45deg"></i>
            </a>
        </div>
    </div>
</div>

<!-- Tabs for Pending Dormitories -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title"><i class="fas fa-clock"></i> Pending Dormitories</h5>
            </div>
            <div class="card-body">
                <!-- Bootstrap Tabs -->
                <ul class="nav nav-tabs" id="pendingTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#pending-approvals">Pending Approvals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#pending-accreditations">Pending Accreditations</a>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <!-- Pending Approvals Tab -->
                    <div class="tab-pane fade show active" id="pending-approvals">
                        <table id="pendingApprovalsTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Owner</th>
                                    <th>Requested Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingDormitoriesList as $dormitory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dormitory->name }}</td>
                                    <td>{{ $dormitory->owner->name }}</td>
                                    <td>{{ $dormitory->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('committee.dormitories.show', $dormitory->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pending Accreditations Tab -->
                    <div class="tab-pane fade" id="pending-accreditations">
                        <table id="pendingAccreditationsTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Owner</th>
                                    <th>Accreditation Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingAccreditationList as $dormitory)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dormitory->name }}</td>
                                    <td>{{ $dormitory->owner->name }}</td>
                                    <td>{{ $dormitory->accreditationSchedules->last()->evaluation_date->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('committee.dormitories.show', $dormitory->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> <!-- End Tab Content -->
            </div>
        </div>
    </div>
</div>

<!-- Include DataTables and jQuery -->
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#pendingApprovalsTable').DataTable();
        $('#pendingAccreditationsTable').DataTable();
    });
</script>
@endsection

@endsection
