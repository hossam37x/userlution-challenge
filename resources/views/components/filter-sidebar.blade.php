<div class="filter-sidebar">
    <h5 class="mb-3">Filters</h5>

    <!-- Sort Options -->
    <div class="mb-3">
        <h6>Sort By</h6>
        <select class="form-select" onchange="updateSort(this.value)">
            <option value="">Default</option>
            <option value="name_asc">Name A-Z</option>
            <option value="name_desc">Name Z-A</option>
            <option value="price_asc">Price Low-High</option>
            <option value="price_desc">Price High-Low</option>
        </select>
    </div>

    <!-- Price Range -->
    <div class="mb-3">
        <h6>Price Range</h6>
        <div class="row g-2">
            <div class="col-6">
                <input type="number" class="form-control" placeholder="Min">
            </div>
            <div class="col-6">
                <input type="number" class="form-control" placeholder="Max">
            </div>
        </div>
        <button class="btn btn-primary btn-sm mt-2 w-100">Apply</button>
    </div>

    <!-- Category Filter -->
    <div class="mb-3">
        <h6>Categories</h6>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="" checked>
            <label class="form-check-label">All Categories</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="electronics">
            <label class="form-check-label">Electronics</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="clothing">
            <label class="form-check-label">Clothing</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="books">
            <label class="form-check-label">Books</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="home">
            <label class="form-check-label">Home</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="sports">
            <label class="form-check-label">Sports</label>
        </div>
    </div>

    <!-- Clear Filters -->
    <button class="btn btn-secondary btn-sm w-100">Clear Filters</button>
</div>
