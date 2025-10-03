@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1>
                @if(request('category'))
                    {{ ucfirst(request('category')) }} Products
                @elseif(request('search'))
                    Search Results for "{{ request('search') }}"
                @else
                    All Products
                @endif
            </h1>
            <p class="text-muted">
                @if(isset($products))
                    Showing {{ $products->count() }} of {{ $products->total() }} products
                @else
                    Discover our amazing collection of products
                @endif
            </p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Age Restriction Notice -->
    @if(!session('age_verified'))
        <div class="alert alert-warning">
            <strong>Age Verification Required</strong> - Some products are restricted to users between 18-30 years of age.
            <button class="btn btn-warning btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#ageVerificationModal">
                Verify Age Now
            </button>
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
                    Show Filters
                </button>
                <div class="collapse mt-3" id="mobileFilters">
                    <x-filter-sidebar
                        :sortOptions="[
                            'name_asc' => 'Name A-Z',
                            'name_desc' => 'Name Z-A',
                            'price_asc' => 'Price Low-High',
                            'price_desc' => 'Price High-Low'
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
                    <h3 class="text-muted mb-3">No Products Found</h3>
                    @if(request('search'))
                        <p class="text-muted mb-4">We couldn't find any products matching "{{ request('search') }}"</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
                    @elseif(request()->hasAny(['category', 'price_min', 'price_max', 'in_stock', 'featured', 'age_restricted']))
                        <p class="text-muted mb-4">Try adjusting your filters or search criteria</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Clear All Filters</a>
                    @else
                        <p class="text-muted mb-4">It looks like there are no products available at the moment.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary">Go to Homepage</a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Featured Products Section (if on main page) -->
    @if(!request()->hasAny(['search', 'category', 'sort', 'price_min', 'price_max', 'in_stock', 'featured', 'age_restricted']) && isset($featuredProducts) && $featuredProducts->count() > 0)
        <hr class="my-5">
        <div class="mb-4">
            <h2 class="mb-3">Featured Products</h2>
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

@endsection
