@extends('admin.layouts.master')

@section('content')
    <!-- Mobile Responsive Styles for Shop Settings -->
    <style>
        @media (max-width: 768px) {
            .settings-container {
                padding: 0.5rem;
            }
            
            .form-control {
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }
            
            .receipt-preview {
                font-size: 12px;
                padding: 0.5rem;
            }
            
            .form-group {
                margin-bottom: 1rem;
            }
        }
        
        @media (max-width: 576px) {
            .card-body {
                padding: 0.75rem;
            }
            
            .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.8rem;
            }
            
            .form-control {
                padding: 0.5rem;
            }
            
            .receipt-preview {
                font-size: 11px;
                padding: 0.25rem;
            }
        }
        
        /* Touch-friendly elements */
        @media (hover: none) and (pointer: coarse) {
            .btn {
                min-height: 44px;
                min-width: 44px;
            }
            
            .form-control {
                min-height: 44px;
            }
        }
    </style>
    
    <!-- Begin Page Content -->
    <div class="container-fluid settings-container">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Shop Settings</h6>
                    <button type="button" class="btn btn-warning" onclick="resetSettings()">
                        <i class="fa-solid fa-undo"></i> Reset to Default
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('shop.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="shop_name" class="form-label">Shop Name</label>
                                <input type="text" name="shop_name" value="{{ old('shop_name', $settings->shop_name) }}"
                                    class="form-control @error('shop_name') is-invalid @enderror" id="shop_name" required>
                                @error('shop_name')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" name="contact_number" value="{{ old('contact_number', $settings->contact_number) }}"
                                    class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" required>
                                @error('contact_number')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email', $settings->email) }}"
                                    class="form-control @error('email') is-invalid @enderror" id="email" required>
                                @error('email')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                    id="address" rows="4" required>{{ old('address', $settings->address) }}</textarea>
                                @error('address')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="footer_notice" class="form-label">Footer Notice</label>
                                <textarea name="footer_notice" class="form-control @error('footer_notice') is-invalid @enderror" 
                                    id="footer_notice" rows="3">{{ old('footer_notice', $settings->footer_notice) }}</textarea>
                                @error('footer_notice')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                                <small class="form-text text-muted">This will appear at the bottom of receipts</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="logo" class="form-label">Shop Logo</label>
                                @if($settings->logo)
                                    <div class="mb-2">
                                        <img src="{{ asset('shopAssets/' . $settings->logo) }}" 
                                             class="img-thumbnail" style="max-height: 100px;" alt="Current Logo">
                                        <p class="small text-muted">Current logo</p>
                                    </div>
                                @endif
                                <input type="file" name="logo" 
                                    class="form-control @error('logo') is-invalid @enderror" id="logo" accept="image/*">
                                @error('logo')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-save"></i> Update Settings
                            </button>
                            <a href="{{ route('adminDashboard') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Preview Section -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Receipt Preview</h6>
            </div>
            <div class="card-body">
                <div class="receipt-preview border p-2" style="width: 80mm; font-family: 'Courier New', monospace; background: white; color: black; line-height: 1.2;">
                    <!-- Company Header -->
                    <div style="text-align: center; margin-bottom: 8px;">
                        @if($settings->logo)
                            <img src="{{ asset('shopAssets/' . $settings->logo) }}" 
                                 style="max-height: 25px; margin-bottom: 4px;" alt="Logo">
                        @endif
                        <div style="font-weight: bold; font-size: 14px; margin-bottom: 2px;">{{ $settings->shop_name }}</div>
                        <div style="font-size: 9px; margin-bottom: 1px;">{{ $settings->address }}</div>
                        <div style="font-size: 9px; margin-bottom: 1px;">Phone: {{ $settings->contact_number }}</div>
                        <div style="font-size: 9px; margin-bottom: 4px;">Email: {{ $settings->email }}</div>
                    </div>
                    
                    <!-- Receipt Details -->
                    <div style="border-top: 1px dotted #000; border-bottom: 1px dotted #000; padding: 4px 0; margin-bottom: 4px;">
                        <div style="display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 2px;">
                            <span>Receipt No.:</span>
                            <span style="font-weight: bold;">CASH20250930072240183</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 2px;">
                            <span>Date and Time:</span>
                            <span>{{ date('M d, Y H:i') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 10px;">
                            <span>User:</span>
                            <span>Imesh</span>
                        </div>
                    </div>
                    
                    <!-- Items Section -->
                    <div style="border-bottom: 1px dotted #000; padding-bottom: 4px; margin-bottom: 4px;">
                        <div style="margin-bottom: 3px;">
                            <div style="font-size: 10px; font-weight: bold; margin-bottom: 1px;">oppo</div>
                            <div style="display: flex; justify-content: space-between; font-size: 9px; margin-bottom: 1px;">
                                <span>3x Rs 300</span>
                                <span>Rs 900</span>
                            </div>
                        </div>
                        <div style="font-size: 9px; margin-top: 2px; text-align: right;">
                            Items count: 1
                        </div>
                    </div>
                    
                    <!-- Summary Section -->
                    <div style="border-bottom: 1px dotted #000; padding-bottom: 4px; margin-bottom: 4px;">
                        <div style="display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 2px;">
                            <span>Subtotal:</span>
                            <span>Rs 900</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 2px;">
                            <span>Tax 0.00%:</span>
                            <span>Rs 0.00</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: bold; margin-top: 2px;">
                            <span>TOTAL:</span>
                            <span>Rs 900</span>
                        </div>
                    </div>
                    
                    <!-- Payment Section -->
                    <div style="border-bottom: 1px dotted #000; padding-bottom: 4px; margin-bottom: 4px;">
                        <div style="display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 2px;">
                            <span>Cash:</span>
                            <span>Rs 900</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 2px;">
                            <span>Amount Received (Rs):</span>
                            <span>Rs 1000</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 10px; margin-bottom: 2px;">
                            <span>Paid amount:</span>
                            <span>Rs 900</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 10px;">
                            <span>Change:</span>
                            <span>Rs 100</span>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div style="text-align: center; font-size: 9px; margin-top: 4px;">
                        <div>{{ $settings->footer_notice }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection

@section('js-section')
<script>
function resetSettings() {
    if (confirm('Are you sure you want to reset all settings to default? This action cannot be undone.')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("shop.settings.reset") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
