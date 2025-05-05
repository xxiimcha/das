@extends('layouts.admin-layout')

@section('title', 'Dormitory Details')

@section('page-title', 'Dormitory Details')
@section('breadcrumb-title', 'Dormitory Details')

@section('content')
<div class="card shadow card-danger card-outline">
    <div class="card-header">
        <h3 class="card-title">{{ $dormitory->name }} Details</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <strong>Name:</strong>
                <p>{{ $dormitory->name }}</p>
            </div>
            <div class="col-md-6">
                <strong>Owner:</strong>
                <p>{{ $dormitory->owner->name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <strong>Price Range:</strong>
                <p>₱{{ $dormitory->price_range }}</p>
            </div>
            <div class="col-md-6">
                <strong>Capacity:</strong>
                <p>{{ $dormitory->capacity }} occupants</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <strong>Status:</strong>
                <p>{{ ucfirst($dormitory->status) }}</p>
                @if ($dormitory->status === 'pending' && auth()->user()->role !== 'admin')
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</button>
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#declineModal">Decline</button>
                @endif
            </div>
        </div>

        <hr>

        <!-- Dormitory Location on Map -->
        <h4 class="text-danger mt-4">Location</h4>
        <div id="map" style="height: 400px; border-radius: 10px; margin-bottom: 20px;"></div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <h4>Amenities:</h4>
                <ul>
                    @foreach ($dormitory->amenities as $amenity)
                        <li><i class="{{ $amenity->icon }} text-danger"></i> {{ $amenity->name }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <h4>Images:</h4>
                <div class="d-flex flex-wrap">
                    @foreach ($dormitory->images as $image)
                        <img src="{{ asset($image->image_path) }}" alt="Dormitory Image" class="img-thumbnail" style="max-width: 200px; margin: 5px;">
                    @endforeach
                </div>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <h4>Documents:</h4>
                <ul>
                    @foreach ($dormitory->documents as $document)
                        <li><a href="{{ asset($document->file_path) }}" target="_blank">View Document</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Schedule and Evaluation Section -->
        @if ($dormitory->status !== 'pending' && $dormitory->status !== 'rejected')
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h4>Schedule and Evaluation:</h4>
                <table class="table table-bordered">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>Evaluation Date</th>
                            <th>Evaluator</th>
                            <th>Result</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dormitory->accreditationSchedules ?? [] as $schedule)
                            @forelse ($schedule->evaluations ?? [] as $evaluation)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($evaluation->evaluation_date)->format('M d, Y') ?? 'N/A' }}</td>
                                <td>{{ $evaluation->evaluator_name ?? 'Unknown' }}</td>
                                <td>{{ $evaluation->schedule->status ?? 'Pending' }}</td>
                                <td>
                                <button class="btn btn-info btn-sm view-evaluation-btn"
                                    data-id="{{ $evaluation->id }}"
                                    data-date="{{ $evaluation->evaluation_date }}"
                                    data-evaluator="{{ $evaluation->evaluator_name }}"
                                    data-result="{{ $evaluation->schedule->status ?? 'Pending' }}"
                                    data-remarks="{{ $evaluation->remarks ?? 'No remarks available' }}"
                                    data-criteria='@json($evaluation->details->map(function($detail) {
                                        return [
                                            "criteria_name" => $detail->criteria->criteria_name ?? "N/A", // FIXED
                                            "rating" => $detail->rating
                                        ];
                                    }))'>
                                    <i class="fas fa-eye"></i> View
                                </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No evaluations yet</td>
                                </tr>
                            @endforelse
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No scheduled evaluations</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Approve Dormitory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="approveForm" method="POST" action="{{ route('committee.dormitories.approve', $dormitory->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="evaluationDate" class="form-label">Evaluation/Accreditation Date</label>
                        <input type="date" class="form-control" id="evaluationDate" name="evaluation_date" required>
                    </div>
                    <button type="submit" class="btn btn-success">Approve</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Decline Modal -->
<div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="declineModalLabel">Decline Dormitory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="declineForm" method="POST" action="{{ route('committee.dormitories.decline', $dormitory->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="declineReason" class="form-label">Reason for Decline</label>
                        <textarea class="form-control" id="declineReason" name="decline_reason" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Decline</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Evaluation Modal -->
<div class="modal fade" id="evaluationModal" tabindex="-1" aria-labelledby="evaluationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="evaluationModalLabel">Evaluation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Evaluation Date:</strong>
                    <p id="modal-evaluation-date"></p>
                </div>
                <div class="mb-3">
                    <strong>Evaluator:</strong>
                    <p id="modal-evaluator-name"></p>
                </div>
                <div class="mb-3">
                    <strong>Result:</strong>
                    <p id="modal-evaluation-result" class="badge"></p>
                </div>
                <div class="mb-3">
                    <strong>Remarks:</strong>
                    <textarea id="modal-remarks" class="form-control" rows="3" placeholder="No remarks available" readonly></textarea>
                </div>
                <hr>
                <h5>Criteria & Ratings</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Criteria</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody id="modal-criteria-body">
                        <!-- Dynamic content will be inserted here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const locationString = "{{ $dormitory->location }}";
    const [latitude, longitude] = locationString.split(',').map(parseFloat);

    // Initialize Leaflet map
    var map = L.map('map').setView([latitude, longitude], 15);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Add marker
    L.marker([latitude, longitude]).addTo(map)
        .bindPopup("<strong>{{ $dormitory->name }}</strong><br>{{ $dormitory->formatted_address }}")
        .openPopup();
});

document.addEventListener("DOMContentLoaded", function() {
    const viewButtons = document.querySelectorAll(".view-evaluation-btn");

    viewButtons.forEach(button => {
        button.addEventListener("click", function() {
            try {
                const evaluationDate = button.getAttribute("data-date") || "N/A";
                const evaluatorName = button.getAttribute("data-evaluator") || "Unknown";
                const evaluationResult = button.getAttribute("data-result") || "Pending";
                const remarks = button.getAttribute("data-remarks") || "No remarks available";
                const criteriaData = button.getAttribute("data-criteria") || "[]"; // Ensure default empty array string

                let parsedCriteria = [];
                try {
                    parsedCriteria = JSON.parse(criteriaData);
                    if (!Array.isArray(parsedCriteria)) {
                        throw new Error("Invalid criteria format: Expected an array");
                    }
                } catch (error) {
                    console.error("Error parsing criteria data:", error);
                    parsedCriteria = [];
                }

                // Populate modal fields
                document.getElementById("modal-evaluation-date").textContent = evaluationDate;
                document.getElementById("modal-evaluator-name").textContent = evaluatorName;
                document.getElementById("modal-remarks").value = remarks;

                // Apply badge color based on evaluation result
                const resultBadge = document.getElementById("modal-evaluation-result");
                resultBadge.textContent = evaluationResult;
                resultBadge.className = "badge " + 
                    (evaluationResult.toLowerCase() === "pass" ? "bg-success" :
                    evaluationResult.toLowerCase() === "fail" ? "bg-danger" :
                    "bg-secondary");

                // Populate Criteria Table
                const criteriaTableBody = document.getElementById("modal-criteria-body");
                criteriaTableBody.innerHTML = ""; // Clear previous content

                if (parsedCriteria.length > 0) {
                    parsedCriteria.forEach(criteria => {
                        let row = `<tr>
                            <td>${criteria.criteria_name || "N/A"}</td>
                            <td>${criteria.rating || "N/A"}</td>
                        </tr>`;
                        criteriaTableBody.innerHTML += row;
                    });
                } else {
                    criteriaTableBody.innerHTML = `<tr><td colspan="2" class="text-center">No criteria available</td></tr>`;
                }

                // Show Modal
                new bootstrap.Modal(document.getElementById("evaluationModal")).show();

            } catch (error) {
                console.error("Error handling evaluation modal:", error);
                alert("An error occurred while loading evaluation details.");
            }
        });
    });
});

</script>
@endsection
