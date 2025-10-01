@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            @if($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index', ['category' => $product->category->slug ?? strtolower($product->category->name)]) }}">
                        {{ $product->category->name }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Age Restriction Check -->
    @if($product->age_restricted && !session('age_verified'))
        <div class="alert alert-warning" role="alert">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="alert-heading">
                        <i class="bi bi-shield-exclamation me-2"></i>Age Verification Required
                    </h5>
                    <p class="mb-0">This product is restricted to users between 18-30 years of age. Please verify your age to view product details.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ageVerificationModal">
                        <i class="bi bi-check-circle me-1"></i>Verify Age
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(!$product->age_restricted || session('age_verified') || (session('user_age') >= 18 && session('user_age') <= 30))
        <!-- Product Details -->
        <div class="row g-4">
            <!-- Product Images -->
            <div class="col-lg-6">
                <div class="product-images">
                    @if($product->image)
                        <div class="main-image mb-3">
                            <img src="{{ $product->image }}" class="img-fluid rounded shadow" alt="{{ $product->name }}" id="mainImage" style="width: 100%; height: 400px; object-fit: cover;">
                        </div>
                    @else
                        <div class="main-image mb-3">
                            <div class="bg-light rounded shadow d-flex align-items-center justify-content-center" style="width: 100%; height: 400px;">
                                <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                            </div>
                        </div>
                    @endif

                    <!-- Thumbnail Gallery (placeholder for multiple images) -->
                    <div class="row g-2">
                        @if($product->image)
                            <div class="col-3">
                                <img src="{{ $product->image }}" class="img-fluid rounded thumbnail-img active" alt="{{ $product->name }}" style="height: 80px; object-fit: cover; cursor: pointer;" onclick="changeMainImage(this.src)">
                            </div>
                        @endif
                        <!-- Placeholder thumbnails -->
                        @for($i = 0; $i < 3; $i++)
                            <div class="col-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center thumbnail-placeholder" style="height: 80px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="col-lg-6">
                <div class="product-info">
                    <!-- Product Title and Badges -->
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <h1 class="h2 mb-0">{{ $product->name }}</h1>
                        <div class="d-flex flex-column gap-1">
                            @if($product->featured)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill me-1"></i>Featured
                                </span>
                            @endif
                            @if($product->age_restricted)
                                <span class="badge age-restriction-badge">18+ Only</span>
                            @endif
                        </div>
                    </div>

                    <!-- Category -->
                    @if($product->category)
                        <p class="text-muted mb-3">
                            <i class="bi bi-tag me-1"></i>
                            <a href="{{ route('products.index', ['category' => $product->category->slug ?? strtolower($product->category->name)]) }}" class="text-decoration-none">
                                {{ $product->category->name }}
                            </a>
                        </p>
                    @endif

                    <!-- Price and Stock -->
                    <div class="price-stock-info mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="h3 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                            <div class="stock-info">
                                @if($product->stock > 0)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>{{ $product->stock }} in stock
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle me-1"></i>Out of stock
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Product Description -->
                    @if($product->description)
                        <div class="product-description mb-4">
                            <h5>Product Description</h5>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>
                    @endif

                    <!-- Product Features (placeholder) -->
                    <div class="product-features mb-4">
                        <h6>Features</h6>
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success me-2"></i>High Quality Materials</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Fast Shipping Available</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>30-Day Return Policy</li>
                            @if($product->age_restricted)
                                <li><i class="bi bi-shield-check text-warning me-2"></i>Age Verification Required</li>
                            @endif
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="product-actions">
                        @if($product->stock > 0)
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                                        <input type="number" class="form-control text-center" value="1" min="1" max="{{ $product->stock }}" id="quantity">
                                        <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-primary w-100" onclick="addToCart({{ $product->id }})">
                                        <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                    </button>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-6">
                                    <button class="btn btn-outline-primary w-100" onclick="addToWishlist({{ $product->id }})">
                                        <i class="bi bi-heart me-1"></i>Wishlist
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-success w-100" onclick="buyNow({{ $product->id }})">
                                        <i class="bi bi-lightning me-1"></i>Buy Now
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-secondary w-100" disabled>
                                    <i class="bi bi-x-circle me-2"></i>Out of Stock
                                </button>
                                <button class="btn btn-outline-primary w-100" onclick="notifyWhenAvailable({{ $product->id }})">
                                    <i class="bi bi-bell me-1"></i>Notify When Available
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Tabs -->
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details-pane" type="button" role="tab">
                            <i class="bi bi-info-circle me-1"></i>Details
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications-pane" type="button" role="tab">
                            <i class="bi bi-list-check me-1"></i>Specifications
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-pane" type="button" role="tab">
                            <i class="bi bi-star me-1"></i>Reviews
                        </button>
                    </li>
                </ul>

                <div class="tab-content border border-top-0 p-4" id="productTabsContent">
                    <div class="tab-pane fade show active" id="details-pane" role="tabpanel">
                        <h5>Product Details</h5>
                        <p>{{ $product->description ?? 'Detailed product information will be displayed here.' }}</p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><strong>Category:</strong> {{ $product->category->name ?? 'General' }}</li>
                                    <li><strong>Stock:</strong> {{ $product->stock }} units available</li>
                                    <li><strong>SKU:</strong> {{ $product->sku ?? 'PRD-' . $product->id }}</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li><strong>Weight:</strong> {{ $product->weight ?? 'N/A' }}</li>
                                    <li><strong>Dimensions:</strong> {{ $product->dimensions ?? 'N/A' }}</li>
                                    <li><strong>Material:</strong> {{ $product->material ?? 'N/A' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="specifications-pane" role="tabpanel">
                        <h5>Specifications</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    <tr><td><strong>Brand</strong></td><td>{{ $product->brand ?? 'Generic' }}</td></tr>
                                    <tr><td><strong>Model</strong></td><td>{{ $product->model ?? 'Standard' }}</td></tr>
                                    <tr><td><strong>Color</strong></td><td>{{ $product->color ?? 'Various' }}</td></tr>
                                    <tr><td><strong>Size</strong></td><td>{{ $product->size ?? 'One Size' }}</td></tr>
                                    <tr><td><strong>Warranty</strong></td><td>{{ $product->warranty ?? '1 Year Limited' }}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="reviews-pane" role="tabpanel">
                        <h5>Customer Reviews</h5>
                        <div class="text-center py-4">
                            <i class="bi bi-star text-muted mb-3" style="font-size: 3rem;"></i>
                            <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                            <button class="btn btn-outline-primary">Write a Review</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Related Products</h3>
                    <div class="row g-4">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="col-sm-6 col-lg-3">
                                <x-product-card :product="$relatedProduct" :showDescription="false" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @else
        <!-- Age Restriction Blocked Content -->
        <div class="text-center py-5">
            <i class="bi bi-shield-exclamation text-warning mb-4" style="font-size: 5rem;"></i>
            <h2 class="text-muted mb-3">Age Verification Required</h2>
            <p class="text-muted mb-4">This product is restricted to users between 18-30 years of age.</p>
            <button class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#ageVerificationModal">
                <i class="bi bi-check-circle me-2"></i>Verify Your Age
            </button>
        </div>
    @endif
</div>

@push('scripts')
<script>
    function changeMainImage(src) {
        document.getElementById('mainImage').src = src;

        // Update active thumbnail
        document.querySelectorAll('.thumbnail-img').forEach(img => img.classList.remove('active'));
        event.target.classList.add('active');
    }

    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        const maxValue = parseInt(quantityInput.max);

        if (currentValue < maxValue) {
            quantityInput.value = currentValue + 1;
        }
    }

    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        const minValue = parseInt(quantityInput.min);

        if (currentValue > minValue) {
            quantityInput.value = currentValue - 1;
        }
    }

    function addToCart(productId) {
        const quantity = document.getElementById('quantity').value;
        // Placeholder for cart functionality
        alert(`Added ${quantity} item(s) to cart! (This would be implemented with proper cart functionality)`);
    }

    function addToWishlist(productId) {
        // Placeholder for wishlist functionality
        alert('Added to wishlist! (This would be implemented with proper wishlist functionality)');
    }

    function buyNow(productId) {
        const quantity = document.getElementById('quantity').value;
        // Placeholder for buy now functionality
        alert(`Proceeding to checkout with ${quantity} item(s)! (This would redirect to checkout)`);
    }

    function notifyWhenAvailable(productId) {
        // Placeholder for notification functionality
        alert('You will be notified when this product is back in stock! (This would be implemented with proper notification system)');
    }
</script>
@endpush

@push('styles')
<style>
    .thumbnail-img.active {
        border: 2px solid var(--bs-primary);
    }

    .thumbnail-img:hover {
        opacity: 0.8;
    }

    .product-images .main-image {
        position: relative;
    }

    .nav-tabs .nav-link {
        color: #6c757d;
    }

    .nav-tabs .nav-link.active {
        color: var(--bs-primary);
        border-color: var(--bs-primary) var(--bs-primary) #fff;
    }

    .tab-content {
        background-color: #fff;
        border-radius: 0 0 0.375rem 0.375rem;
    }
</style>
@endpush
@endsection
