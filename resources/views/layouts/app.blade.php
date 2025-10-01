<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="dummy-csrf-token">

    <title>Products Store - Laravel</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <!-- Custom Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #f53003;
            --bs-primary-rgb: 245, 48, 3;
        }

        .btn-primary {
            --bs-btn-bg: var(--bs-primary);
            --bs-btn-border-color: var(--bs-primary);
            --bs-btn-hover-bg: #d42a02;
            --bs-btn-hover-border-color: #d42a02;
            --bs-btn-active-bg: #c1240.2;
            --bs-btn-active-border-color: #c12402;
        }

        .text-primary {
            color: var(--bs-primary) !important;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
        }

        .product-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .age-restriction-badge {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            font-weight: 600;
            border-radius: 20px;
        }

        .filter-sidebar {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
        }

        .sort-dropdown {
            min-width: 200px;
        }

        .price-badge {
            background: linear-gradient(45deg, #2ecc71, #27ae60);
            color: white;
            font-weight: 600;
        }

        .category-tag {
            background-color: #e9ecef;
            color: #495057;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .out-of-stock {
            opacity: 0.6;
            position: relative;
        }

        .out-of-stock::after {
            content: 'Out of Stock';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(220, 53, 69, 0.9);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 600;
            z-index: 10;
        }
    </style>

</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand text-primary" href="/products">
                <i class="bi bi-shop me-2"></i>Products Store
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/products">
                            <i class="bi bi-grid me-1"></i>All Products
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-tags me-1"></i>Categories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/products?category=electronics">Electronics</a></li>
                            <li><a class="dropdown-item" href="/products?category=clothing">Clothing</a></li>
                            <li><a class="dropdown-item" href="/products?category=books">Books</a></li>
                            <li><a class="dropdown-item" href="/products?category=home">Home & Garden</a></li>
                            <li><a class="dropdown-item" href="/products?category=sports">Sports</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/products">View All</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- Search Form -->
                <form class="d-flex me-3" method="GET" action="/products">
                    <div class="input-group">
                        <input class="form-control" type="search" name="search" placeholder="Search products..." aria-label="Search" value="">
                        <button class="btn btn-outline-light" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Age Verification Status -->
                <div class="navbar-nav">
                    <div class="nav-item">
                        <span class="nav-link">
                            <!-- Show verify age button (not verified state) -->
                            <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ageVerificationModal">
                                <i class="bi bi-shield-exclamation me-1"></i>Verify Age
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <!-- Content will be inserted here -->
    </main>

    <!-- Age Verification Modal -->
    <div class="modal fade" id="ageVerificationModal" tabindex="-1" aria-labelledby="ageVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h1 class="modal-title fs-5" id="ageVerificationModalLabel">
                        <i class="bi bi-shield-exclamation me-2"></i>Age Verification Required
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="bi bi-calendar-check text-primary fs-1 mb-3"></i>
                        <h4>Are you 18 years or older?</h4>
                        <p class="text-muted">Some products are restricted to users between 18-30 years of age. Please verify your age to access all products.</p>

                        <form method="POST" action="/age-verify" class="mt-4">
                            <div class="row g-2 justify-content-center">
                                <div class="col-auto">
                                    <input type="number" class="form-control" name="age" placeholder="Enter your age" min="1" max="120" required>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-lg me-1"></i>Verify Age
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-primary">Products Store</h5>
                    <p class="mb-0">Your one-stop shop for quality products with age-appropriate content filtering.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; 2025 Products Store. All rights reserved.</p>
                    <small class="text-muted">Built with Laravel & Bootstrap</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
