@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Welcome Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Dashboard</h4>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                    </form>
                </div>
                <div class="card-body">
                    <h5>Welcome back!</h5>
                    <p class="text-muted">You are successfully logged in. Here's what you can do:</p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Browse Products</h6>
                                    <p class="card-text">Explore our wide range of products available for purchase.</p>
                                    <a href="{{ route('products.index') }}" class="btn btn-primary">View Products</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Age Verification</h6>
                                    <p class="card-text">Verify your age to access age-restricted products.</p>
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ageVerificationModal">
                                        Verify Age
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h6>Account Information</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>user@example.com (Demo)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Member Since:</strong></td>
                                        <td>{{ date('F j, Y') }} (Demo)</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Account Status:</strong></td>
                                        <td><span class="badge bg-success">Active</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection