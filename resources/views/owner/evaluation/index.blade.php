@extends('layouts.admin-layout')

@section('title', 'Dormitory Evaluation')

@section('content')
<div class="card shadow">
    <div class="card-header text-center bg-danger text-white py-4">
        <h3 class="fw-bold">Dormitory Evaluation</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th>Dormitory Name</th>
                    <th>Location</th>
                    <th>Capacity</th>
                    <th>Price Range</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dormitories as $dormitory)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dormitory->name }}</td>
                        <td>{{ $dormitory->location }}</td>
                        <td>{{ $dormitory->capacity }}</td>
                        <td>
                            @php
                                $priceRange = explode('-', $dormitory->price_range);
                                echo '₱' . number_format($priceRange[0]) . ' - ₱' . number_format($priceRange[1]);
                            @endphp
                        </td>
                        <td>
                            <span class="badge bg-{{ $dormitory->status === 'approved' ? 'success' : ($dormitory->status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($dormitory->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('evaluation.show', $dormitory->id) }}" class="btn btn-danger btn-sm">
                                View Evaluation
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No dormitories available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
