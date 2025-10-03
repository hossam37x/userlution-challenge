@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Create Account</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required minlength="8">
                            <small class="form-text text-muted">Password must be at least 8 characters long.</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password_confirmation" name="password_confirmation" required>
                            <small id="passwordMatch" class="form-text"></small>
                        </div>

                        <!-- Age -->
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control @error('age') is-invalid @enderror"
                                   id="age" name="age" value="{{ old('age') }}" min="12" max="120" required>
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input @error('terms') is-invalid @enderror"
                                       type="checkbox" id="terms" name="terms"
                                       {{ old('terms') ? 'checked' : '' }} required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="text-decoration-none">Terms and Conditions</a>
                                </label>
                                @error('terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Create Account</button>
                        </div>
                    </form>

                    <!-- Login Link -->
                    <div class="text-center mt-3">
                        <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Sign in here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Password confirmation validation
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    const passwordMatch = document.getElementById('passwordMatch');

    function checkPasswordMatch() {
        if (passwordConfirmation.value === '') {
            passwordMatch.textContent = '';
            passwordMatch.className = 'form-text';
        } else if (password.value === passwordConfirmation.value) {
            passwordMatch.textContent = 'Passwords match ✓';
            passwordMatch.className = 'form-text text-success';
        } else {
            passwordMatch.textContent = 'Passwords do not match';
            passwordMatch.className = 'form-text text-danger';
        }
    }

    password.addEventListener('input', checkPasswordMatch);
    passwordConfirmation.addEventListener('input', checkPasswordMatch);
</script>
@endsection
