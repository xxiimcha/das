@extends('layouts.admin-layout')

@section('title', 'Add Dormitory')
@section('page-title', 'Add Dormitory')
@section('breadcrumb-title', 'Add Dormitory')

@section('content')
<div class="card shadow card-danger card-outline">
    <div class="card-header">
        <h3 class="card-title">New Dormitory Details</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dormitory Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Owner</label>
                    <select name="owner_id" class="form-control" required>
                        <option value="">Select Owner</option>
                        <option value="1">Juan Dela Cruz</option>
                        <option value="2">Maria Santos</option>
                        <option value="3">Sample Owner</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price Range (₱)</label>
                    <input type="text" name="price_range" class="form-control" placeholder="e.g. 2500-3500" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="accredited">Accredited</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Location Coordinates (lat,lng)</label>
                    <input type="text" name="location" class="form-control" placeholder="e.g. 13.6231,123.1949" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Formatted Address</label>
                    <input type="text" name="formatted_address" class="form-control" placeholder="Full address of the dormitory" required>
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <label class="form-label">Upload Images</label>
                <input type="file" name="images[]" class="form-control" multiple>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Documents</label>
                <input type="file" name="documents[]" class="form-control" multiple>
            </div>

            <div class="mb-3">
                <label class="form-label">Amenities (comma separated)</label>
                <input type="text" name="amenities" class="form-control" placeholder="e.g. Wifi, Kitchen, Aircon">
            </div>

            <button type="submit" class="btn btn-danger">Submit Dormitory</button>
        </form>
    </div>
</div>
@endsection
