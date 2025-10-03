<div class="filter-sidebar">
    <form id="filterForm">
        <h5 class="mb-3">Filters</h5>

        <!-- Sort Options -->
        <div class="mb-3">
            <h6>Sort By</h6>
            <select name="sort" class="form-select">
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
                    <input name="price_from" type="number" class="form-control" placeholder="from">
                </div>
                <div class="col-6">
                    <input name="price_to" type="number" class="form-control" placeholder="to">
                </div>
            </div>
        </div>

        <!-- Category Filter -->
        <div class="mb-3">
            <h6>Categories</h6>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="category" value="" checked>
                <label class="form-check-label">All Categories</label>
            </div>
            @foreach ($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" {{ request('category') == $category->id ? 'checked' : '' }} type="radio" name="category" value="{{ $category->id }}">
                    <label class="form-check-label">{{ $category->name }}</label>
                </div>
            @endforeach
        </div>
        <div class="mb-3">
            <button class="btn btn-primary btn-sm mt-2  w-100">Apply</button>
            <!-- Clear Filters -->
        </div>
        <div class="mb-3">
            <button class="btn btn-secondary btn-sm w-100">Clear Filters</button>
        </div>
    </form>
</div>
