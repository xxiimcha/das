@extends('layouts.admin-layout')

@section('title', 'Dashboard')

@section('dashboard-active', 'active')

@section('page-title', 'Dashboard Overview')
@section('breadcrumb-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Registered Users -->
    <div class="col-lg-3 col-6">
    <!--begin::Small Box Widget 1-->
    <div class="small-box text-bg-primary">
        <div class="inner">
        <h3>150</h3>
        <p>New Orders</p>
        </div>
        <svg
        class="small-box-icon"
        fill="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
        >
        <path
            d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
        ></path>
        </svg>
        <a
        href="#"
        class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
        >
        More info <i class="bi bi-link-45deg"></i>
        </a>
    </div>
    <!--end::Small Box Widget 1-->
    </div>
</div>

<div class="row">
    <!-- Monthly Statistics -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h3 class="card-title">
                    <i class="fas fa-chart-line me-2"></i> Monthly Statistics
                </h3>
            </div>
            <div class="card-body">
                <canvas id="monthlyStatsChart" style="width: 100%; height: 300px;"></canvas>
            </div>
        </div>
    </div>
    <!-- Recent Activities -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h3 class="card-title">
                    <i class="fas fa-clock me-2"></i> Recent Activities
                </h3>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-building text-info me-2"></i> Admin added a new dormitory.
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-user-plus text-success me-2"></i> John Doe registered as a new user.
                    </li>
                    <li>
                        <i class="fas fa-tools text-warning me-2"></i> A maintenance request was resolved.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Example Chart.js placeholder script
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('monthlyStatsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Monthly Data',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endsection
