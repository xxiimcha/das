@extends('layouts.app')

@section('title', 'Dorm Owner Registration')

@section('content')

<link rel="stylesheet" href="{{ asset('css/dorm_owner.css') }}">

<div class="container py-5">
    <h1 class="text-center mb-4 text-danger">Dorm Owner Registration</h1>
    <div class="card shadow border-0">
        <div class="card-body">
            <!-- Form -->
            <form method="POST" enctype="multipart/form-data" action="{{ route('owner.register') }}" id="registrationForm">
                @csrf
                <!-- Owner Details Section -->
                <h3 class="text-primary">Owner Details</h3>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="ownerName" class="form-label">Full Name</label>
                        <input type="text" id="ownerName" name="owner_name" class="form-control" placeholder="John Doe" required>
                    </div>
                    <div class="col-md-6">
                        <label for="ownerEmail" class="form-label">Email Address</label>
                        <input type="email" id="ownerEmail" name="owner_email" class="form-control" placeholder="email@example.com" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="ownerPhone" class="form-label">Phone Number</label>
                        <input type="text" id="ownerPhone" name="owner_phone" class="form-control" placeholder="09xxxxxxxxx" required>
                    </div>
                    <div class="col-md-6">
                        <label for="ownerAddress" class="form-label">Address</label>
                        <input type="text" id="ownerAddress" name="owner_address" class="form-control" placeholder="123 Street, City" required>
                    </div>
                </div>

                <!-- Dormitory Details Section -->
                <h3 class="text-primary">Dormitory Details</h3>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="dormName" class="form-label">Dormitory Name</label>
                        <input type="text" id="dormName" name="dorm_name" class="form-control" placeholder="Dormitory Name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="dormLocation" class="form-label">Location</label>
                        <input type="text" id="dormLocation" name="dorm_location" class="form-control" placeholder="City/Barangay" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="priceRange" class="form-label">Price Range</label>
                        <input type="text" id="priceRange" name="price_range" class="form-control" placeholder="₱xxxx - ₱xxxx" required>
                    </div>
                    <div class="col-md-6">
                        <label for="dormCapacity" class="form-label">Capacity</label>
                        <input type="number" id="dormCapacity" name="dorm_capacity" class="form-control" placeholder="Number of occupants" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="dormDescription" class="form-label">Description</label>
                        <textarea id="dormDescription" name="dorm_description" class="form-control" rows="4" placeholder="Describe your dormitory..." required></textarea>
                    </div>
                </div>

                <!-- Dynamic Fields for Inclusions/Amenities -->
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="text-primary mb-0">Inclusions/Amenities</h3>
                    <button type="button" class="btn btn-outline-success add-amenity shadow-sm">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </div>
                <hr>
                <div id="amenities-container" class="mb-3">
                    <!-- First Amenity Input -->
                    <div class="row mb-2 align-items-center amenity-row">
                        <div class="col-md-1 text-center">
                            <!-- Placeholder for Selected Icon -->
                            <button type="button" class="btn btn-light select-icon shadow-sm">
                                <i class="fa fa-wifi text-primary"></i>
                            </button>
                            <input type="hidden" name="amenity_icons[]" class="selected-icon">
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="amenities[]" class="form-control shadow-sm" placeholder="Enter an inclusion or amenity (e.g., Free Wi-Fi)" required>
                        </div>
                        <div class="col-md-2 text-center">
                            <button type="button" class="btn btn-outline-danger remove-amenity shadow-sm">
                                <i class="fa fa-minus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <template id="amenity-template">
                    <div class="row mb-2 align-items-center amenity-row">
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-light select-icon shadow-sm">
                                <i class="fa fa-plus-circle text-primary"></i>
                            </button>
                            <input type="hidden" name="amenity_icons[]" class="selected-icon">
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="amenities[]" class="form-control shadow-sm" placeholder="Enter an inclusion or amenity (e.g., Free Wi-Fi)" required>
                        </div>
                        <div class="col-md-2 text-center">
                            <button type="button" class="btn btn-outline-danger remove-amenity shadow-sm">
                                <i class="fa fa-minus-circle"></i>
                            </button>
                        </div>
                    </div>
                </template>

                <!-- Upload Images Section -->
                <h3 class="text-primary">Dormitory Images</h3>
                <hr>
                <div class="mb-3">
                    <div id="image-dropzone" class="border border-dashed rounded p-3 text-center">
                        <p>Drag and drop images here or click to upload.</p>
                        <input type="file" id="dormImages" name="images[]" class="form-control d-none" accept="image/*" multiple>
                    </div>
                    <div id="preview-container" class="row mt-3"></div>
                </div>

                <!-- Upload Permits/Documents -->
                <h3 class="text-primary">Required Permits or Documents</h3>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="permits" class="form-label">Upload Permits or Documents</label>
                        <input type="file" id="permits" name="permits[]" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png" multiple>
                        <small class="text-muted">Accepted formats: PDF, Word, JPG, PNG (max size: 5MB each)</small>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-danger btn-lg px-5" id="submitBtn">Register</button>
                </div>
            </form>
            <!-- Thank You Message -->
            <div id="thankYouMessage" class="text-center d-none">
                <h2 class="text-success">Thank you for your submission!</h2>
                <p>Your dormitory registration has been submitted successfully. It is now pending for approval.</p>
                <a href="/" class="btn btn-primary mt-3">Go to Home</a>
            </div>
        </div>
    </div>
</div>

<!-- Full-Page Loader -->
<div id="fullPageLoader" class="d-none">
    <div class="loader-container">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h3 class="mt-3 text-light">Submitting your application. Please wait...</h3>
    </div>
</div>

<!-- Icon Picker Modal -->
<div class="modal fade" id="iconPickerModal" tabindex="-1" aria-labelledby="iconPickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iconPickerModalLabel">Select an Icon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="iconSearch" class="form-control mb-3" placeholder="Search icons...">
                <div id="iconGrid" class="row g-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/owner_registration.js') }}"></script>
@endsection
