@extends('layouts.app', ['title' => 'Products Store - Your one-stop shop'])

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="hero-section bg-primary text-white rounded p-5 text-center position-relative overflow-hidden">
                <div class="position-relative z-3">
                    <h1 class="display-4 fw-bold mb-3">Welcome to Products Store</h1>
                    <p class="lead mb-4">Discover amazing products with smart age-appropriate filtering</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-shop me-2"></i>Shop Now
                        </a>
                        @if(!session('age_verified'))
                            <button class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#ageVerificationModal">
                                <i class="bi bi-shield-check me-2"></i>Verify Age
                            </button>
                        @endif
                    </div>
                </div>
                <!-- Background decoration -->
                <div class="position-absolute top-0 end-0 opacity-25">
                    <i class="bi bi-bag-heart" style="font-size: 15rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">Why Choose Us?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <i class="bi bi-shield-check text-primary mb-3" style="font-size: 3rem;"></i>
                        <h4>Age-Appropriate Content</h4>
                        <p class="text-muted">Smart filtering ensures appropriate content for all age groups with special categories for 18-30 years.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <i class="bi bi-funnel text-primary mb-3" style="font-size: 3rem;"></i>
                        <h4>Advanced Filtering</h4>
                        <p class="text-muted">Sort and filter products by price, category, availability, and more to find exactly what you need.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <i class="bi bi-phone text-primary mb-3" style="font-size: 3rem;"></i>
                        <h4>Mobile Responsive</h4>
                        <p class="text-muted">Shop seamlessly on any device with our fully responsive design and intuitive interface.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products Preview -->
    @if(isset($featuredProducts) && $featuredProducts->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Featured Products</h2>
                    <a href="{{ route('products.index', ['featured' => 1]) }}" class="btn btn-outline-primary">
                        View All Featured <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="row g-4">
                    @foreach($featuredProducts->take(4) as $product)
                        <div class="col-sm-6 col-lg-3">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Categories Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">Shop by Category</h2>
            <div class="row g-4">
                @php
                    $categories = [
                        ['name' => 'Electronics', 'slug' => 'electronics', 'icon' => 'laptop', 'color' => 'primary'],
                        ['name' => 'Clothing', 'slug' => 'clothing', 'icon' => 'bag', 'color' => 'success'],
                        ['name' => 'Books', 'slug' => 'books', 'icon' => 'book', 'color' => 'info'],
                        ['name' => 'Home & Garden', 'slug' => 'home', 'icon' => 'house', 'color' => 'warning'],
                        ['name' => 'Sports', 'slug' => 'sports', 'icon' => 'trophy', 'color' => 'danger']
                    ];
                @endphp

                @foreach($categories as $category)
                    <div class="col-sm-6 col-lg-4 col-xl mb-3">
                        <a href="{{ route('products.index', ['category' => $category['slug']]) }}" class="text-decoration-none">
                            <div class="category-card text-center p-4 h-100 border rounded position-relative overflow-hidden">
                                <i class="bi bi-{{ $category['icon'] }} text-{{ $category['color'] }} mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-dark">{{ $category['name'] }}</h5>
                                <p class="text-muted small mb-0">Explore {{ strtolower($category['name']) }}</p>

                                <!-- Hover effect background -->
                                <div class="category-hover-bg position-absolute top-0 start-0 w-100 h-100 bg-{{ $category['color'] }} opacity-0"></div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="row">
        <div class="col-12">
            <div class="cta-section bg-light rounded p-5 text-center">
                <h3 class="mb-3">Ready to Start Shopping?</h3>
                <p class="text-muted mb-4">Browse our complete collection of products with smart filtering and age-appropriate content.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-grid me-2"></i>View All Products
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, var(--bs-primary), var(--bs-primary-hover));
        min-height: 300px;
        display: flex;
        align-items: center;
    }

    .feature-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .category-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .category-card:hover .category-hover-bg {
        opacity: 0.1 !important;
    }

    .category-card:hover h5,
    .category-card:hover p {
        color: var(--bs-dark) !important;
    }

    .cta-section {
        background: linear-gradient(145deg, #f8f9fa, #e9ecef);
    }

    @media (max-width: 768px) {
        .hero-section {
            min-height: 250px;
        }

        .display-4 {
            font-size: 2rem;
        }
    }
</style>
@endpush
@endsection
