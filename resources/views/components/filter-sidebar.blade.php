<div class="filter-sidebar">
    <h5 class="mb-4">
        <i class="bi bi-funnel me-2"></i>Filters & Sorting
    </h5>

    <!-- Sort Options -->
    <div class="mb-4">
        <h6 class="fw-bold">Sort By</h6>
        <select class="form-select sort-dropdown" onchange="updateSort(this.value)">
            <option value="">Default</option>
            <option value="name_asc">Name A-Z</option>
            <option value="name_desc">Name Z-A</option>
            <option value="price_asc">Price Low-High</option>
            <option value="price_desc">Price High-Low</option>
            <option value="newest">Newest First</option>
        </select>
    </div>

    <!-- Price Range -->
    <div class="mb-4">
        <h6 class="fw-bold">Price Range</h6>
        <div class="row g-2">
            <div class="col-6">
                <input type="number" class="form-control form-control-sm" placeholder="Min" name="price_min" value="">
            </div>
            <div class="col-6">
                <input type="number" class="form-control form-control-sm" placeholder="Max" name="price_max" value="">
            </div>
        </div>
        <button class="btn btn-sm btn-outline-primary mt-2 w-100" onclick="applyPriceFilter()">
            Apply Price Filter
        </button>
    </div>

    <!-- Category Filter -->
    <div class="mb-4">
        <h6 class="fw-bold">Categories</h6>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="" id="category_all" checked onchange="updateCategory(this.value)">
            <label class="form-check-label" for="category_all">All Categories</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="electronics" id="category_electronics" onchange="updateCategory(this.value)">
            <label class="form-check-label" for="category_electronics">Electronics</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="clothing" id="category_clothing" onchange="updateCategory(this.value)">
            <label class="form-check-label" for="category_clothing">Clothing</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="books" id="category_books" onchange="updateCategory(this.value)">
            <label class="form-check-label" for="category_books">Books</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="home" id="category_home" onchange="updateCategory(this.value)">
            <label class="form-check-label" for="category_home">Home</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="category" value="sports" id="category_sports" onchange="updateCategory(this.value)">
            <label class="form-check-label" for="category_sports">Sports</label>
        </div>
    </div>

    <!-- Availability Filter -->
    <div class="mb-4">
        <h6 class="fw-bold">Availability</h6>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="in_stock" value="1" id="in_stock" onchange="updateAvailability(this.checked)">
            <label class="form-check-label" for="in_stock">
                In Stock Only
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured" onchange="updateFeatured(this.checked)">
            <label class="form-check-label" for="featured">
                Featured Products
            </label>
        </div>
    </div>

    <!-- Age Restriction Filter (shown for demo) -->
    <div class="mb-4">
        <h6 class="fw-bold">Age Restriction</h6>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="age_restricted" value="1" id="age_restricted" onchange="updateAgeRestriction(this.checked)">
            <label class="form-check-label" for="age_restricted">
                <span class="badge age-restriction-badge me-1">18+</span> Show Adult Content
            </label>
        </div>
    </div>

    <!-- Clear Filters -->
    <div class="d-grid">
        <button class="btn btn-outline-secondary btn-sm" onclick="clearAllFilters()">
            <i class="bi bi-arrow-clockwise me-1"></i>Clear All Filters
        </button>
    </div>
</div>

<script>
    function updateSort(sortValue) {
        updateUrl({ sort: sortValue });
    }

    function updateCategory(category) {
        updateUrl({ category: category });
    }

    function updateAvailability(inStock) {
        updateUrl({ in_stock: inStock ? '1' : '' });
    }

    function updateFeatured(featured) {
        updateUrl({ featured: featured ? '1' : '' });
    }

    function updateAgeRestriction(ageRestricted) {
        updateUrl({ age_restricted: ageRestricted ? '1' : '' });
    }

    function applyPriceFilter() {
        const minPrice = document.querySelector('input[name="price_min"]').value;
        const maxPrice = document.querySelector('input[name="price_max"]').value;
        updateUrl({
            price_min: minPrice,
            price_max: maxPrice
        });
    }

    function clearAllFilters() {
        const baseUrl = window.location.pathname;
        window.location.href = baseUrl;
    }

    function updateUrl(params) {
        const url = new URL(window.location);

        // Update or remove parameters
        Object.keys(params).forEach(key => {
            if (params[key] === '' || params[key] === null || params[key] === undefined) {
                url.searchParams.delete(key);
            } else {
                url.searchParams.set(key, params[key]);
            }
        });

        // Preserve existing search parameter
        if (url.searchParams.get('search')) {
            // Keep search parameter
        }

        window.location.href = url.toString();
    }
</script>
