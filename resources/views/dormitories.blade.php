@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="container py-5">
        <h1 class="mb-4"><span class="text-danger">Accredited</span> Dormitories</h1>
        <div class="row mb-4">
            <div class="col-md-12 text-right">
                <input type="text" class="form-control w-25 d-inline-block" placeholder="Search...">
                <button class="btn btn-light"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between position-relative">
                        <div class="ribbon ribbon-top-left"><span>FULL</span></div>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/dorm-image.jpg') }}" alt="Dormitory 1" class="mr-4" style="width: 100px; height: 100px; object-fit: cover;">
                            <div>
                                <h5 class="mb-1">Dormitory Name</h5>
                                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Brgy Example</small>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-danger mb-1">₱0.00 - ₱0.00</p>
                            <button class="btn btn-dark btn-sm">View More</button>
                        </div>
                    </a>

                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/dorm-image.jpg') }}" alt="Dormitory 2" class="mr-4" style="width: 100px; height: 100px; object-fit: cover;">
                            <div>
                                <h5 class="mb-1">Dormitory Name</h5>
                                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Brgy Example</small>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-danger mb-1">₱0.00 - ₱0.00</p>
                            <button class="btn btn-dark btn-sm">View More</button>
                        </div>
                    </a>

                    <a href="#" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/dorm-image.jpg') }}" alt="Dormitory 3" class="mr-4" style="width: 100px; height: 100px; object-fit: cover;">
                            <div>
                                <h5 class="mb-1">Dormitory Name</h5>
                                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> Brgy Example</small>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-danger mb-1">₱0.00 - ₱0.00</p>
                            <button class="btn btn-dark btn-sm">View More</button>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.ribbon {
    position: absolute;
    top: 10px;
    left: -5px;
    z-index: 1;
    overflow: hidden;
    width: 75px;
    height: 75px;
    text-align: right;
}

.ribbon span {
    font-size: 12px;
    font-weight: bold;
    color: #fff;
    text-transform: uppercase;
    text-align: center;
    line-height: 20px;
    transform: rotate(-45deg);
    -webkit-transform: rotate(-45deg);
    width: 100px;
    display: block;
    background: #dc3545;
    background: linear-gradient(#dc3545 0%, #b71c1c 100%);
    position: absolute;
    top: 19px;
    left: -21px;
}

.list-group-item img {
    border-radius: 5px;
    object-fit: cover;
}

.list-group-item div {
    gap: 1rem;
}
</style>
@endsection
