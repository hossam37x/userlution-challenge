@extends('layouts.app')

@section('title', $product['name'])

@section('content')
<div class="container my-4">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item"><span class="badge bg-secondary">{{ ucfirst($product->category->name) }}</span></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Product Details -->
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6">
            <div class="product-images">
                <div class="main-image mb-3">
                    <img src="{{ $product->images->first()?->url }}" class="img-fluid rounded" alt="{{ $product->name }}" id="mainImage">
                </div>
                <div class="row">
                    @foreach($product->images as $index => $image)
                        <div class="col-4">
                            <img src="{{ $image->url }}" class="img-fluid rounded mb-2 thumbnail-img" alt="{{ $product->name }} - Image {{ $index + 1 }}" onclick="changeMainImage('{{ $image->url }}')" style="cursor: pointer;">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Product Information -->
        <div class="col-md-6">
            <h1 class="h3 mb-3">{{ $product->name }}</h1>

            <div class="price mb-3">
                <span class="h4 text-primary">${{ number_format($product->price, 2) }}</span>
            </div>

            <div class="mb-3">
                <span class="badge bg-secondary">{{ ucfirst($product->category->name) }}</span>
                @if($product->in_stock)
                    <span class="badge bg-success">In Stock ({{ $product->stock_quantity }} available)</span>
                @else
                    <span class="badge bg-danger">Out of Stock</span>
                @endif
            </div>

            <div class="description mb-4">
                <h5>Description</h5>
                <p>{{ $product->description }}</p>
            </div>

            <!-- Add to Cart Form -->
            @if($product->in_stock)
                <form class="mb-4">
                    <div class="row align-items-end">
                        <div class="col-auto">
                            <label for="quantity" class="form-label">Quantity</label>
                            <select class="form-select" id="quantity" name="quantity">
                                @for($i = 1; $i <= min(10, $product->stock_quantity); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </div>
                    </div>
                </form>
            @endif

            <!-- Product Features -->
            @if(isset($product->features) && count($product->features) > 0)
                <div class="features mb-4">
                    <h5>Features</h5>
                    <ul class="list-unstyled">
                        @foreach($product->features as $feature)
                            <li class="mb-1">• {{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <!-- Product Specifications -->
    @if(isset($product->specifications) && count($product->specifications) > 0)
        <div class="row mt-4">
            <div class="col-12">
                <h5>Specifications</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        @foreach($product->specifications as $spec => $value)
                            <tr>
                                <td><strong>{{ $spec }}</strong></td>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Navigation -->
    <div class="row mt-4">
        <div class="col">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
        </div>
    </div>
</div>

<script>
    function changeMainImage(src) {
        document.getElementById('mainImage').src = src;
    }
</script>
@endsection
