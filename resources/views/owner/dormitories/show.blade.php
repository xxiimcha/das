@extends('layouts.admin-layout')

@section('title', 'Dormitory Details')

@section('content')
<div class="card shadow">
    <div class="card-header text-center bg-danger text-white py-4">
        <h2 class="fw-bold mb-0">{{ $dormitory->name }}</h2>
    </div>
    <div class="card-body">
        <!-- Dormitory Details Section -->
        <div class="row mb-5">
            <div class="col-md-6">
                <h5 class="text-danger border-bottom pb-2">General Information</h5>
                <div class="mt-3">
                    <p><strong>Location:</strong> <span class="text-muted">{{ $dormitory->location }}</span></p>
                    <p>
                        <strong>Price Range:</strong>
                        @php
                            $priceRange = explode('-', $dormitory->price_range);
                            $formattedPriceRange = '₱' . number_format($priceRange[0]) . ' - ₱' . number_format($priceRange[1]);
                        @endphp
                        <span class="text-muted">{{ $formattedPriceRange }}</span>
                    </p>
                    <p><strong>Capacity:</strong> <span class="text-muted">{{ $dormitory->capacity }} persons</span></p>
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="text-danger border-bottom pb-2">Additional Information</h5>
                <div class="mt-3">
                    <p><strong>Description:</strong></p>
                    <p class="text-muted">{{ $dormitory->description }}</p>
                    <p>
                        <strong>Status:</strong>
                        <span class="badge rounded-pill bg-{{ $dormitory->status === 'approved' ? 'success' : ($dormitory->status === 'pending' ? 'warning' : 'danger') }} px-3 py-2">
                            {{ ucfirst($dormitory->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Images Section (Gallery) -->
        <h4 class="text-danger border-bottom pb-2 mb-4">Images</h4>
        <div class="row g-3 mb-4">
            @forelse($dormitory->images as $image)
                <div class="col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm">
                        <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top img-fluid rounded" alt="Dormitory Image">
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-muted">No images available.</p>
            @endforelse
        </div>

        <!-- Documents Section -->
        <h4 class="text-danger border-bottom pb-2 mb-4">Documents</h4>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-group">
                    @forelse($dormitory->documents as $document)
                        <li class="list-group-item d-flex align-items-center">
                            @php
                                $extension = pathinfo($document->file_path, PATHINFO_EXTENSION);
                                $icon = match($extension) {
                                    'pdf' => 'fas fa-file-pdf text-danger',
                                    'doc', 'docx' => 'fas fa-file-word text-primary',
                                    'xls', 'xlsx' => 'fas fa-file-excel text-success',
                                    default => 'fas fa-file text-muted'
                                };
                            @endphp
                            <i class="{{ $icon }} me-3 fa-lg"></i>
                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-decoration-none text-danger">
                                {{ basename($document->file_path) }}
                            </a>
                        </li>
                    @empty
                        <p class="text-muted">No documents available.</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Add some styling for the gallery -->
<style>
    .card-img-top {
        transition: transform 0.3s ease;
    }
    .card-img-top:hover {
        transform: scale(1.05);
    }
</style>
@endsection
