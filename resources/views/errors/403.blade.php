@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-page py-5">
                <i class="bi bi-shield-exclamation text-danger mb-4" style="font-size: 6rem;"></i>
                <h1 class="display-4 mb-3">403</h1>
                <h2 class="mb-4">Access Forbidden</h2>
                <p class="text-muted mb-4 lead">
                    You don't have permission to access this content. This may be due to age restrictions or other access controls.
                </p>

                @if(!session('age_verified'))
                    <div class="alert alert-warning d-inline-block mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        This content may require age verification to access.
                    </div>
                    <div class="d-flex justify-content-center gap-3 mb-4">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ageVerificationModal">
                            <i class="bi bi-check-circle me-1"></i>Verify Age
                        </button>
                    </div>
                @endif

                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="bi bi-shop me-1"></i>Browse Products
                    </a>
                    <a href="javascript:history.back()" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Go Back
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
