@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-page py-5">
                <i class="bi bi-exclamation-triangle-fill text-danger mb-4" style="font-size: 6rem;"></i>
                <h1 class="display-4 mb-3">500</h1>
                <h2 class="mb-4">Server Error</h2>
                <p class="text-muted mb-4 lead">
                    Something went wrong on our end. Please try again later.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="bi bi-shop me-1"></i>Browse Products
                    </a>
                    <a href="javascript:location.reload()" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i>Try Again
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .error-page {
        min-height: 60vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
</style>
@endpush
@endsection
