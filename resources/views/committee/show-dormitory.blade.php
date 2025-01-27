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
                <strong>Location:</strong>
                <p>{{ $dormitory->location }}</p>
            </div>
            <div class="col-md-6">
                <strong>Price Range:</strong>
                <p>{{ $dormitory->price_range }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <strong>Capacity:</strong>
                <p>{{ $dormitory->capacity }}</p>
            </div>
            <div class="col-md-6">
                <strong>Status:</strong>
                <p>{{ ucfirst($dormitory->status) }}</p>
                @if ($dormitory->status === 'pending')
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</button>
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#declineModal">Decline</button>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <strong>Description:</strong>
                <p>{{ $dormitory->description }}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h4>Amenities:</h4>
                <ul>
                    @foreach ($dormitory->amenities as $amenity)
                        <li>{{ $amenity->name }} <i class="{{ $amenity->icon }}"></i></li>
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
@endsection
