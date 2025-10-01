<!-- Sample Product Card -->
<div class="card product-card h-100">
    <!-- Product Image -->
    <img src="https://via.placeholder.com/300x200/f8f9fa/6c757d?text=Product+Image" class="card-img-top" alt="Sample Product" style="height: 200px; object-fit: cover;">

    <div class="card-body d-flex flex-column">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h5 class="card-title mb-0">Wireless Headphones</h5>
            <!-- Age restriction badge for demo -->
            <span class="badge age-restriction-badge ms-2">18+</span>
        </div>

        <!-- Category tag -->
        <span class="category-tag align-self-start mb-2">Electronics</span>

        <!-- Product description -->
        <p class="card-text text-muted mb-3">High-quality wireless headphones with noise cancellation and premium sound quality.</p>

        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="h5 mb-0 text-primary">$129.99</span>
                <small class="text-muted">
                    <i class="bi bi-check-circle text-success me-1"></i>15 in stock
                </small>
            </div>

            <div class="d-grid gap-2">
                <a href="/products/1" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-eye me-1"></i>View Details
                </a>
                <button class="btn btn-primary btn-sm" onclick="addToCart(1)">
                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                </button>
            </div>
        </div>
    </div>

    <!-- Featured badge -->
    <div class="position-absolute top-0 start-0 m-2">
        <span class="badge bg-warning text-dark">
            <i class="bi bi-star-fill me-1"></i>Featured
        </span>
    </div>
</div>

<script>
    function addToCart(productId) {
        // Placeholder for cart functionality
        alert('Product added to cart! (This would be implemented with proper cart functionality)');
    }
</script>
