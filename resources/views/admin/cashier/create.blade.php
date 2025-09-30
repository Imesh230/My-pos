@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4 col-6 offset-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Add New Cashier</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('cashier.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" id="name" required>
                        @error('name')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" id="email" required>
                        @error('email')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" 
                            class="form-control @error('password') is-invalid @enderror" id="password" required>
                        @error('password')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="form-control @error('phone') is-invalid @enderror" id="phone">
                        @error('phone')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" rows="3">{{ old('address') }}</textarea>
                        @error('address')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="profile" class="form-label">Profile Image</label>
                        <input type="file" name="profile" 
                            class="form-control @error('profile') is-invalid @enderror" id="profile" accept="image/*">
                        @error('profile')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Create Cashier" class="btn btn-primary w-100">
                        </div>
                        <div class="col">
                            <a href="{{ route('cashier.index') }}" class="btn btn-secondary w-100">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
