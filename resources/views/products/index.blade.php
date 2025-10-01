@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="display-6 mb-2">
                        @if(request('category'))
                            {{ ucfirst(request('category')) }} Products
                        @elseif(request('search'))
                            Search Results for "{{ request('search') }}"
                        @else
                            All Products
                        @endif
                    </h1>
                    <p class="text-muted mb-0">
                        @if(isset($products))
                            Showing {{ $products->count() }} of {{ $products->total() }} products
                        @else
                            Discover our amazing collection of products
                        @endif
                    </p>
                </div>

                <!-- Quick Sort Dropdown (Mobile Friendly) -->
                <div class="d-lg-none">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-sort-down me-1"></i>Sort
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}">Name A-Z</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}">Name Z-A</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Price Low-High</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Price High-Low</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest First</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Age Restriction Notice -->
    @if(!session('age_verified'))
        <div class="alert alert-warning" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-shield-exclamation me-3 fs-4"></i>
                <div class="flex-grow-1">
                    <h6 class="alert-heading mb-1">Age Verification Required</h6>
                    <p class="mb-2">Some products are restricted to users between 18-30 years of age. Verify your age to access all products.</p>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ageVerificationModal">
                        <i class="bi bi-check-circle me-1"></i>Verify Age Now
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <!-- Sidebar Filters (Desktop) -->
        <div class="col-lg-3 mb-4">
            <div class="d-lg-block d-none">
                <x-filter-sidebar
                    :sortOptions="[
                        'name_asc' => 'Name A-Z',
                        'name_desc' => 'Name Z-A',
                        'price_asc' => 'Price Low-High',
                        'price_desc' => 'Price High-Low',
                        'newest' => 'Newest First'
                    ]"
                    :activeSort="request('sort', '')"
                />
            </div>

            <!-- Mobile Filter Toggle -->
            <div class="d-lg-none mb-3">
                <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#mobileFilters">
                    <i class="bi bi-funnel me-2"></i>Show Filters
                </button>
                <div class="collapse mt-3" id="mobileFilters">
                    <x-filter-sidebar
                        :sortOptions="[
                            'name_asc' => 'Name A-Z',
                            'name_desc' => 'Name Z-A',
                            'price_asc' => 'Price Low-High',
                            'price_desc' => 'Price High-Low',
                            'newest' => 'Newest First'
                        ]"
                        :activeSort="request('sort', '')"
                    />
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            @if(isset($products) && $products->count() > 0)
                <!-- Products Grid -->
                <div class="row g-4 mb-4">
                    @foreach($products as $product)
                        <div class="col-sm-6 col-lg-4">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            @else
                <!-- No Products Found -->
                <div class="text-center py-5">
                    <i class="bi bi-search text-muted mb-3" style="font-size: 4rem;"></i>
                    <h3 class="text-muted mb-3">No Products Found</h3>
                    @if(request('search'))
                        <p class="text-muted mb-4">We couldn't find any products matching "{{ request('search') }}"</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-1"></i>View All Products
                        </a>
                    @elseif(request()->hasAny(['category', 'price_min', 'price_max', 'in_stock', 'featured', 'age_restricted']))
                        <p class="text-muted mb-4">Try adjusting your filters or search criteria</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-clockwise me-1"></i>Clear All Filters
                        </a>
                    @else
                        <p class="text-muted mb-4">It looks like there are no products available at the moment.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary">
                            <i class="bi bi-house me-1"></i>Go to Homepage
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Featured Products Section (if on main page) -->
    @if(!request()->hasAny(['search', 'category', 'sort', 'price_min', 'price_max', 'in_stock', 'featured', 'age_restricted']) && isset($featuredProducts) && $featuredProducts->count() > 0)
        <hr class="my-5">
        <div class="mb-4">
            <h2 class="mb-3">
                <i class="bi bi-star text-warning me-2"></i>Featured Products
            </h2>
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                    <div class="col-sm-6 col-lg-3">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
    .pagination {
        --bs-pagination-color: var(--bs-primary);
        --bs-pagination-hover-color: var(--bs-primary);
        --bs-pagination-focus-color: var(--bs-primary);
        --bs-pagination-active-bg: var(--bs-primary);
        --bs-pagination-active-border-color: var(--bs-primary);
    }

    @media (max-width: 768px) {
        .display-6 {
            font-size: 1.75rem;
        }
    }
</style>
@endpush
@endsection
