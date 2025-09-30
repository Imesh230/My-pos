@extends('admin.layouts.master')

@section('title', 'Add New Repair Service')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Repair Service</h1>
        <a href="{{ route('repair.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <!-- Repair Service Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Repair Service Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('repair.store') }}" method="POST">
                @csrf
                
                <div class="row">
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
                            <label for="customer_phone">Phone Number *</label>
                            <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                                   id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="customer_email">Email (Optional)</label>
                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                   id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Device Information -->
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">Device Information</h5>
                        
                        <div class="form-group">
                            <label for="device_brand">Device Brand *</label>
                            <select class="form-control @error('device_brand') is-invalid @enderror" 
                                    id="device_brand" name="device_brand" required>
                                <option value="">Select Brand</option>
                                <option value="Samsung" {{ old('device_brand') == 'Samsung' ? 'selected' : '' }}>Samsung</option>
                                <option value="Apple" {{ old('device_brand') == 'Apple' ? 'selected' : '' }}>Apple</option>
                                <option value="Huawei" {{ old('device_brand') == 'Huawei' ? 'selected' : '' }}>Huawei</option>
                                <option value="Oppo" {{ old('device_brand') == 'Oppo' ? 'selected' : '' }}>Oppo</option>
                                <option value="Vivo" {{ old('device_brand') == 'Vivo' ? 'selected' : '' }}>Vivo</option>
                                <option value="Xiaomi" {{ old('device_brand') == 'Xiaomi' ? 'selected' : '' }}>Xiaomi</option>
                                <option value="OnePlus" {{ old('device_brand') == 'OnePlus' ? 'selected' : '' }}>OnePlus</option>
                                <option value="Other" {{ old('device_brand') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('device_brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="device_model">Device Model *</label>
                            <input type="text" class="form-control @error('device_model') is-invalid @enderror" 
                                   id="device_model" name="device_model" value="{{ old('device_model') }}" required>
                            @error('device_model')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="device_imei">IMEI Number (Optional)</label>
                            <input type="text" class="form-control @error('device_imei') is-invalid @enderror" 
                                   id="device_imei" name="device_imei" value="{{ old('device_imei') }}">
                            @error('device_imei')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <!-- Problem Description -->
                    <div class="col-md-8">
                        <h5 class="text-primary mb-3">Problem Description</h5>
                        
                        <div class="form-group">
                            <label for="problem_description">Problem Description *</label>
                            <textarea class="form-control @error('problem_description') is-invalid @enderror" 
                                      id="problem_description" name="problem_description" rows="4" required>{{ old('problem_description') }}</textarea>
                            @error('problem_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Repair Details -->
                    <div class="col-md-4">
                        <h5 class="text-primary mb-3">Repair Details</h5>
                        
                        <div class="form-group">
                            <label for="estimated_cost">Estimated Cost (Rs) *</label>
                            <input type="number" class="form-control @error('estimated_cost') is-invalid @enderror" 
                                   id="estimated_cost" name="estimated_cost" value="{{ old('estimated_cost') }}" 
                                   min="0" step="0.01" required>
                            @error('estimated_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="estimated_completion">Estimated Completion Date</label>
                            <input type="date" class="form-control @error('estimated_completion') is-invalid @enderror" 
                                   id="estimated_completion" name="estimated_completion" value="{{ old('estimated_completion') }}">
                            @error('estimated_completion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="technician">Assigned Technician</label>
                            <input type="text" class="form-control @error('technician') is-invalid @enderror" 
                                   id="technician" name="technician" value="{{ old('technician') }}">
                            @error('technician')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Create Repair Service
                    </button>
                    <a href="{{ route('repair.index') }}" class="btn btn-secondary btn-lg ml-2">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
