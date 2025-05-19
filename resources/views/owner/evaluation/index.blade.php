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
                    <th>Evaluator</th>
                    <th>Average Rating</th>
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
                                $priceRange = explode('-', $dormitory->price_range ?? '');
                                $priceMin = isset($priceRange[0]) && is_numeric($priceRange[0]) ? number_format((float)$priceRange[0]) : 'N/A';
                                $priceMax = isset($priceRange[1]) && is_numeric($priceRange[1]) ? number_format((float)$priceRange[1]) : 'N/A';
                                echo "₱{$priceMin} - ₱{$priceMax}";
                            @endphp
                        </td>
                        <td>{{ $dormitory->evaluator }}</td>
                        <td>
                            @if($dormitory->average_rating !== null)
                                {{ number_format($dormitory->average_rating, 2) }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $dormitory->status === 'accredited' ? 'success' : ($dormitory->status === 'pending' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($dormitory->status) }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#evaluationModal{{ $dormitory->id }}">
                                View Evaluation
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No dormitories available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Evaluation Modals --}}
        @foreach($dormitories as $dormitory)
            <div class="modal fade" id="evaluationModal{{ $dormitory->id }}" tabindex="-1" aria-labelledby="evaluationModalLabel{{ $dormitory->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="evaluationModalLabel{{ $dormitory->id }}">Evaluation: {{ $dormitory->name }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Location:</strong> {{ $dormitory->location }}</p>
                            <p><strong>Capacity:</strong> {{ $dormitory->capacity }}</p>
                            <p><strong>Price Range:</strong>
                                @php
                                    $priceRange = explode('-', $dormitory->price_range ?? '');
                                    $priceMin = isset($priceRange[0]) && is_numeric($priceRange[0]) ? number_format((float)$priceRange[0]) : 'N/A';
                                    $priceMax = isset($priceRange[1]) && is_numeric($priceRange[1]) ? number_format((float)$priceRange[1]) : 'N/A';
                                    echo "₱{$priceMin} - ₱{$priceMax}";
                                @endphp
                            </p>
                            <p><strong>Evaluator:</strong> {{ $dormitory->evaluator }}</p>
                            <p><strong>Average Rating:</strong> 
                                {{ $dormitory->average_rating !== null ? number_format($dormitory->average_rating, 2) : 'N/A' }}
                            </p>

                            @if ($dormitory->accreditationSchedules->isNotEmpty())
                                <hr>
                                <h6 class="text-danger">Latest Evaluation Breakdown</h6>
                                @php $schedule = $dormitory->accreditationSchedules->first(); @endphp
                                @if ($schedule && $schedule->ratings->count())
                                    <ul>
                                        @foreach($schedule->ratings as $rating)
                                            <li>
                                                <strong>{{ $rating->criteria->criteria_name ?? 'Unnamed Criteria (ID: ' . $rating->criteria_id . ')' }}:</strong>
                                                {{ $rating->rating ?? 'N/A' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">No detailed ratings available.</p>
                                @endif
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
