@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Age Verification Required</h4>
                </div>
                <div class="card-body text-center">
                    <h2 class="mb-3">Verify Your Age</h2>
                    <p class="text-muted mb-4">
                        Some products in our store are restricted to users between <strong>18-30 years of age</strong>.
                        Please verify your age to access all products and features.
                    </p>

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('age.verify') }}">
                        @csrf
                        <div class="row g-3 justify-content-center">
                            <div class="col-auto">
                                <label for="age" class="form-label">Enter your age:</label>
                                <input type="number"
                                       class="form-control text-center @error('age') is-invalid @enderror"
                                       name="age"
                                       id="age"
                                       placeholder="Age"
                                       min="1"
                                       max="120"
                                       value="{{ old('age') }}"
                                       required>
                                @error('age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                Verify Age
                            </button>
                        </div>
                    </form>

                    <div class="mt-4">
                        <small class="text-muted">
                            Your age information is used solely for content filtering and is not stored permanently.
                        </small>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('products.index') }}" class="btn btn-link">
                        Continue browsing without verification
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
