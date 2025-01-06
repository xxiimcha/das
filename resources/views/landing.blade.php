<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DAS - Landing Page</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .card {
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .card img {
            height: 200px;
            object-fit: cover;
        }

        .see-more-btn {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #dc3545;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 25px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .see-more-btn:hover {
            background-color: #b71c1c;
            transform: scale(1.1);
        }

        .see-more-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <!-- Header Section -->
        <div class="header-top bg-dark text-white py-2">
            <div class="container d-flex justify-content-between align-items-center">
                <div>Email: <span>example.edu.ph</span></div>
                <div>
                    Call: <span>09071568989</span> | <span>09651301775</span>
                </div>
            </div>
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="/" class="navbar-brand">
                    <span class="brand-text font-weight-light">DAS</span>
                </a>
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="/" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#contact" class="nav-link">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a href="#dormitories" class="nav-link">Dormitories</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="hero-section position-relative">
            <img src="{{ asset('images/dormitory-building.jpg') }}" alt="Dormitory Building" class="img-fluid">
            <div class="hero-overlay position-absolute d-flex flex-column justify-content-center align-items-center text-white">
                <h1>Find the Best <span class="text-danger">Dormitory</span> for You</h1>
                <button class="btn btn-danger mt-3" onclick="location.href='/registration';">List Your Dormitory</button>
            </div>
        </div>

        <!-- Contact Section -->
        <div id="contact" class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-4">Contact Us</h2>
                <p class="text-center">Feel free to reach out to us for any inquiries or assistance.</p>
                <form action="/contact" method="post">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control border border-danger" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control border border-danger" placeholder="Your Email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <textarea name="message" class="form-control border border-danger" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger">Send Message</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Dormitories Section -->
        <div id="dormitories" class="py-5">
            <div class="container">
                <h2 class="text-center mb-4">Dormitories</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card border border-danger shadow" onclick="location.href='#';">
                            <img src="{{ asset('images/dorm-image.jpg') }}" class="card-img-top" alt="Dormitory 1">
                            <div class="card-body">
                                <h5 class="card-title text-danger">Dormitory 1</h5>
                                <p class="card-text">A modern dormitory with spacious rooms and excellent facilities.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card border border-danger shadow" onclick="location.href='#';">
                            <img src="{{ asset('images/dorm-image.jpg') }}" class="card-img-top" alt="Dormitory 2">
                            <div class="card-body">
                                <h5 class="card-title text-danger">Dormitory 2</h5>
                                <p class="card-text">Enjoy a cozy and secure stay at our centrally located dormitory.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card border border-danger shadow" onclick="location.href='#';">
                            <img src="{{ asset('images/dorm-image.jpg') }}" class="card-img-top" alt="Dormitory 3">
                            <div class="card-body">
                                <h5 class="card-title text-danger">Dormitory 3</h5>
                                <p class="card-text">Affordable living with all essential amenities and great comfort.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="see-more-container">
                    <a href="#" class="see-more-btn">See More</a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer text-center">
            <strong>Dormitory Accreditation System &copy; {{ date('Y') }}.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
</body>
</html>
