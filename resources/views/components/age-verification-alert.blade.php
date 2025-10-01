@props([
    'show' => false,
    'title' => 'Age Verification Required',
    'message' => 'This content is restricted to users between 18-30 years of age.',
    'showForm' => true
])

@if($show)
<div class="alert alert-warning border-warning" role="alert">
    <div class="d-flex align-items-start">
        <i class="bi bi-shield-exclamation me-3 fs-4 text-warning"></i>
        <div class="flex-grow-1">
            <h6 class="alert-heading mb-2">{{ $title }}</h6>
            <p class="mb-3">{{ $message }}</p>

            @if($showForm)
                <form method="POST" action="{{ route('age.verify') }}" class="d-flex flex-wrap gap-2 align-items-center">
                    @csrf
                    <input type="number"
                           class="form-control form-control-sm"
                           style="width: 100px;"
                           name="age"
                           placeholder="Age"
                           min="1"
                           max="120"
                           required>
                    <button type="submit" class="btn btn-warning btn-sm">
                        <i class="bi bi-check-circle me-1"></i>Verify
                    </button>
                </form>
            @else
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ageVerificationModal">
                    <i class="bi bi-check-circle me-1"></i>Verify Age
                </button>
            @endif
        </div>
    </div>
</div>
@endif
