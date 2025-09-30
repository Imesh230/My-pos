@extends('admin.layouts.master')

@section('title', 'Create Warranty')

@section('content')
    <!-- Mobile Responsive Styles -->
    <style>
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }
            
            .form-group {
                margin-bottom: 1rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .row .col-md-6 {
                margin-bottom: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .card-header h6 {
                font-size: 0.875rem;
            }
            
            .form-control {
                font-size: 14px;
            }
            
            .btn {
                font-size: 14px;
                padding: 0.5rem 1rem;
            }
        }
    </style>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Warranty</h1>
        <div>
            <a href="{{ route('warranty.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Warranty Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Warranty Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('warranty.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Product Information -->
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">Product Information</h5>
                        
                        <div class="form-group">
                            <label for="product_name">Product Name *</label>
                            <input type="text" class="form-control @error('product_name') is-invalid @enderror" 
                                   id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="product_type">Product Type *</label>
                            <select class="form-control @error('product_type') is-invalid @enderror" 
                                    id="product_type" name="product_type" required>
                                <option value="">Select Product Type</option>
                                <option value="charger" {{ old('product_type') == 'charger' ? 'selected' : '' }}>Charger</option>
                                <option value="power_bank" {{ old('product_type') == 'power_bank' ? 'selected' : '' }}>Power Bank</option>
                                <option value="mobile_accessory" {{ old('product_type') == 'mobile_accessory' ? 'selected' : '' }}>Mobile Accessory</option>
                            </select>
                            @error('product_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="brand">Brand *</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" name="brand" value="{{ old('brand') }}" required>
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="model">Model *</label>
                            <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                   id="model" name="model" value="{{ old('model') }}" required>
                            @error('model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="serial_number">Serial Number</label>
                            <input type="text" class="form-control @error('serial_number') is-invalid @enderror" 
                                   id="serial_number" name="serial_number" value="{{ old('serial_number') }}">
                            @error('serial_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">Customer Information</h5>
                        
                        <div class="form-group">
                            <label for="customer_name">Customer Name *</label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                   id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="customer_phone">Customer Phone *</label>
                            <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                                   id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="customer_email">Customer Email</label>
                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                   id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="purchase_date">Purchase Date *</label>
                            <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" 
                                   id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}" required>
                            @error('purchase_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="purchase_price">Purchase Price (Rs) *</label>
                            <input type="number" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror" 
                                   id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}" required>
                            @error('purchase_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Warranty Details -->
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">Warranty Details</h5>
                        
                        <div class="form-group">
                            <label for="warranty_period_months">Warranty Period (Months) *</label>
                            <select class="form-control @error('warranty_period_months') is-invalid @enderror" 
                                    id="warranty_period_months" name="warranty_period_months" required>
                                <option value="">Select Period</option>
                                <option value="3" {{ old('warranty_period_months') == '3' ? 'selected' : '' }}>3 Months</option>
                                <option value="6" {{ old('warranty_period_months') == '6' ? 'selected' : '' }}>6 Months</option>
                                <option value="12" {{ old('warranty_period_months') == '12' ? 'selected' : '' }}>12 Months</option>
                                <option value="18" {{ old('warranty_period_months') == '18' ? 'selected' : '' }}>18 Months</option>
                                <option value="24" {{ old('warranty_period_months') == '24' ? 'selected' : '' }}>24 Months</option>
                            </select>
                            @error('warranty_period_months')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="warranty_terms">Warranty Terms</label>
                            <textarea class="form-control @error('warranty_terms') is-invalid @enderror" 
                                      id="warranty_terms" name="warranty_terms" rows="3">{{ old('warranty_terms') }}</textarea>
                            @error('warranty_terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">Additional Information</h5>
                        
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="row">
                    <div class="col-12">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Warranty
                            </button>
                            <a href="{{ route('warranty.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
