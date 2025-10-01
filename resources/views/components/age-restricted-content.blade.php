@props([
    'restricted' => true,
    'userAge' => null,
    'allowedMinAge' => 18,
    'allowedMaxAge' => 30
])

@if($restricted)
    <div class="age-restricted-overlay">
        <div class="text-center">
            <i class="bi bi-shield-exclamation text-warning mb-3" style="font-size: 3rem;"></i>
            <h4 class="mb-3">Age Restricted Content</h4>
            <p class="text-muted mb-4">
                This content is only available to users between {{ $allowedMinAge }}-{{ $allowedMaxAge }} years of age.
            </p>

            @if(!session('age_verified'))
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ageVerificationModal">
                    <i class="bi bi-check-circle me-1"></i>Verify Your Age
                </button>
            @elseif($userAge && ($userAge < $allowedMinAge || $userAge > $allowedMaxAge))
                <div class="alert alert-info d-inline-block">
                    <i class="bi bi-info-circle me-2"></i>
                    You must be between {{ $allowedMinAge }}-{{ $allowedMaxAge }} years old to access this content.
                </div>
            @endif
        </div>
    </div>
@else
    {{ $slot }}
@endif

@once
    @push('styles')
    <style>
        .age-restricted-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 0.375rem;
        }

        .age-restricted-card {
            position: relative;
        }

        .age-restricted-card .card-body {
            filter: blur(3px);
        }
    </style>
    @endpush
@endonce
