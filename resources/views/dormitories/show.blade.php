@extends('layouts.app')

<style>
    /* Header styling for name and price */
    .dorm-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .dorm-header .name-address {
        max-width: 70%;
    }

    .dorm-header .name-address h1 {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0;
    }

    .dorm-header .name-address p {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 0;
    }

    .dorm-header .price {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .dorm-header .price .amount {
        font-size: 1.25rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .dorm-header .price .actions {
        display: flex;
        gap: 10px;
    }

    .dorm-header .price .actions button {
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        font-size: 1.25rem;
        padding: 5px;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .dorm-header .price .actions button:hover {
        color: #dc3545;
    }

    .dorm-header .price .actions button:focus {
        outline: none;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 10px;
        margin-bottom: 20px;
    }

    .gallery-grid img {
        border-radius: 10px;
        cursor: pointer;
        border: 1px solid #ddd;
        transition: transform 0.2s;
    }

    .gallery-grid img:hover {
        transform: scale(1.05);
    }

    .details-inquiry-container {
        display: flex;
        gap: 20px;
        margin-top: 30px;
    }

    .details-container {
        flex: 3;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .highlight-badge {
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 15px;
        background-color: #f8f9fa;
        color: #dc3545;
        border: 1px solid #dc3545;
        margin-right: 5px;
    }

    .inquiry-section {
        flex: 1;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
    }

    .inquiry-tab {
        display: flex;
        justify-content: space-between;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .inquiry-tab button {
        flex: 1;
        padding: 10px 0;
        border: none;
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: bold;
        text-align: center;
        transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
    }

    .inquiry-tab button.active {
        background-color: #dc3545;
        color: #fff;
    }

    .inquiry-tab button:hover {
        background-color: #dc3545;
        color: #fff;
    }
</style>

@section('content')
<div class="content-wrapper" style="background-color: #f8f9fa;">
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $dormitory->name }}</li>
            </ol>
        </nav>

        <!-- Main Image and Gallery -->
        <div class="row">
            <div class="col-md-12">
                <img src="{{ asset($dormitory->images->first()->image_path ?? 'images/dorm-image.jpg') }}"
                     alt="{{ $dormitory->name }}" class="img-fluid rounded mb-3" style="border: 1px solid #ddd;">
                <div class="gallery-grid">
                    @foreach($dormitory->images as $image)
                        <img src="{{ asset($image->image_path) }}"
                             alt="Gallery Image" class="img-fluid" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ asset($image->image_path) }}">
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Header with Dorm Name, Address, and Price -->
        <div class="dorm-header mt-5">
            <div class="name-address">
                <h1>{{ $dormitory->name }}</h1>
                <p>{{ $dormitory->location }}</p>
            </div>
            <div class="price">
                <p class="amount">₱{{ $dormitory->price_range }} <small>monthly</small></p>
                <div class="actions">
                    <button title="Share">
                        <i class="fas fa-share-alt"></i>
                    </button>
                    <button title="Favorite">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Details and Inquiry Section -->
        <div class="details-inquiry-container">
            <!-- Details Section -->
            <div class="details-container">
                <h4 class="text-danger">Details</h4>

                <!-- Highlights -->
                <h5 class="mt-3">Highlights</h5>
                <div>
                    @foreach($dormitory->amenities as $amenity)
                        <span class="highlight-badge">{{ $amenity->name }}</span>
                    @endforeach
                </div>

                <!-- Description -->
                <h5 class="mt-4">Description</h5>
                <p>{{ $dormitory->description }}</p>
            </div>

            <!-- Inquiry Section -->
            <div class="inquiry-section">
                <div class="inquiry-tab">
                    <button class="active" id="inquireTab" onclick="showInquiry()">Inquire</button>
                    <button id="scheduleTab" onclick="showSchedule()">Schedule a Visit</button>
                </div>
                <div id="inquiryContent">
                    <h5 class="mb-3">Send an Inquiry</h5>
                    <form>
                        <input type="text" class="form-control mb-2" placeholder="Your Name" required>
                        <textarea class="form-control mb-2" placeholder="Your Message to the Landlord" rows="3" required></textarea>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="agree" required>
                            <label class="form-check-label" for="agree">I have read and agreed to the <a href="#" class="text-danger">Terms</a>, <a href="#" class="text-danger">Privacy Policy</a>, and <a href="#" class="text-danger">Safety Guidelines</a>.</label>
                        </div>
                        <button class="btn btn-danger w-100">Send Message</button>
                    </form>
                </div>
                <div id="scheduleContent" style="display: none;">
                    <h5 class="mb-3">Book an On-Site Viewing</h5>
                    <p class="text-center">Login is Required</p>
                    <a href="/login" class="btn btn-danger w-100">Login Here</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" id="modalImage" alt="Gallery Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
    function showInquiry() {
        document.getElementById('inquiryContent').style.display = 'block';
        document.getElementById('scheduleContent').style.display = 'none';
        document.getElementById('inquireTab').classList.add('active');
        document.getElementById('scheduleTab').classList.remove('active');
    }

    function showSchedule() {
        document.getElementById('inquiryContent').style.display = 'none';
        document.getElementById('scheduleContent').style.display = 'block';
        document.getElementById('inquireTab').classList.remove('active');
        document.getElementById('scheduleTab').classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const galleryImages = document.querySelectorAll('.gallery-grid img');
        const modalImage = document.getElementById('modalImage');

        galleryImages.forEach(image => {
            image.addEventListener('click', function () {
                const imgSrc = this.getAttribute('data-image');
                modalImage.setAttribute('src', imgSrc);
            });
        });
    });
</script>
@endsection
