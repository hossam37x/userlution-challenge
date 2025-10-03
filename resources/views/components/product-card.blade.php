<!-- Sample Product Card -->
<div class="card h-100">
    <!-- Product Image -->
    <img src="https://via.placeholder.com/300x200/f8f9fa/6c757d?text=Product+Image" class="card-img-top" alt="Sample Product" style="height: 200px; object-fit: cover;">

    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $product->name }}</h5>
        <!-- Age restriction badge for demo -->
        <span class="badge age-restriction-badge mb-2">18+ Only</span>

        <!-- Category tag -->
        <span class="category-tag mb-2">{{ $product->category->name }}</span>

        <!-- Product description -->
        <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 100) }}</p>

        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="h5 mb-0 text-primary">{{ $product->price }}</span>
                <small class="text-muted">{{ $product->stock_quantity }} in stock</small>
            </div>

            <div class="d-grid gap-2">
                <a href="/products/{{ $product->id }}" class="btn btn-outline-primary btn-sm">View Details</a>
            </div>
        </div>
    </div>
</div>
