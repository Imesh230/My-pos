@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4 col-6 offset-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Edit Cashier</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('cashier.update', $cashier->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name', $cashier->name) }}"
                            class="form-control @error('name') is-invalid @enderror" id="name" required>
                        @error('name')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $cashier->email) }}"
                            class="form-control @error('email') is-invalid @enderror" id="email" required>
                        @error('email')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $cashier->phone) }}"
                            class="form-control @error('phone') is-invalid @enderror" id="phone">
                        @error('phone')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" rows="3">{{ old('address', $cashier->address) }}</textarea>
                        @error('address')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="profile" class="form-label">Profile Image</label>
                        @if($cashier->profile)
                            <div class="mb-2">
                                <img src="{{ asset('cashierProfile/' . $cashier->profile) }}" 
                                     class="img-thumbnail" style="max-height: 100px;" alt="Current Profile">
                                <p class="small text-muted">Current profile image</p>
                            </div>
                        @endif
                        <input type="file" name="profile" 
                            class="form-control @error('profile') is-invalid @enderror" id="profile" accept="image/*">
                        @error('profile')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" value="1" 
                                   class="form-check-input" id="is_active" 
                                   {{ $cashier->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active Status
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Update Cashier" class="btn btn-primary w-100">
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
