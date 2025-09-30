@extends('admin.layouts.master')

@section('content')
    <!-- Mobile Responsive Styles -->
    <style>
        @media (max-width: 768px) {
            .summary-cards .col-xl-3 {
                margin-bottom: 1rem;
            }
            
            .summary-cards .card-body {
                padding: 1rem;
            }
            
            .summary-cards .h5 {
                font-size: 1.25rem;
            }
            
            .summary-cards .text-xs {
                font-size: 0.75rem;
            }
            
            .table-responsive {
                font-size: 12px;
            }
            
            .table th, .table td {
                padding: 0.5rem 0.25rem;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
        
        @media (max-width: 576px) {
            .summary-cards .col-xl-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
            
            .summary-cards .card-body {
                padding: 0.75rem;
            }
            
            .summary-cards .h5 {
                font-size: 1rem;
            }
            
            .summary-cards .fa-2x {
                font-size: 1.5rem !important;
            }
            
            .table th, .table td {
                padding: 0.25rem;
                font-size: 11px;
            }
            
            .btn-sm {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }
        }
    </style>
    
    <script>
        // Toggle select all checkboxes
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.product-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            
            updatePrintButton();
        }
        
        // Update print button state
        function updatePrintButton() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            const printBtn = document.getElementById('printBulkBtn');
            const selectAll = document.getElementById('selectAll');
            
            printBtn.disabled = checkboxes.length === 0;
            
            // Update select all checkbox state
            const allCheckboxes = document.querySelectorAll('.product-checkbox');
            selectAll.checked = checkboxes.length === allCheckboxes.length;
            selectAll.indeterminate = checkboxes.length > 0 && checkboxes.length < allCheckboxes.length;
        }
        
        // Print selected barcodes
        function printSelectedBarcodes() {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            const productIds = Array.from(checkboxes).map(cb => cb.value);
            
            if (productIds.length === 0) {
                alert('Please select at least one product to print barcodes.');
                return;
            }
            
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("products.print-bulk-barcodes") }}';
            form.target = '_blank';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add product IDs
            productIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'product_ids[]';
                input.value = id;
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    </script>
    
    <div class="container-fluid">
        <!-- Stock Summary Cards -->
        <div class="row mb-4 summary-cards">
            @php
                $totalStockValue = 0;
                $totalProfit = 0;
                $totalProducts = 0;
                foreach($products as $item) {
                    $costPrice = $item->purchase_price ?? 0;
                    $salePrice = $item->price;
                    $stock = $item->count;
                    $stockValue = $costPrice * $stock;
                    $profitPerUnit = $salePrice - $costPrice;
                    $totalProfit += $profitPerUnit * $stock;
                    $totalStockValue += $stockValue;
                    $totalProducts++;
                }
            @endphp
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Products</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-boxes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Stock Value</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rs {{ number_format($totalStockValue, 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Potential Profit</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rs {{ number_format($totalProfit, 2) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Average Profit Margin</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $totalStockValue > 0 ? number_format(($totalProfit / $totalStockValue) * 100, 1) : '0.0' }}%
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-percentage fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-dark">
                            <form action="{{route('productList')}}" method="get">
                                <div class="input-group mb-3">
                                    <input type="text" name="searchKey" class="form-control "
                                        placeholder="Products name..." value="{{request('searchKey')}}">
                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </h6>
                    </div>
                    <div class="font-weight-bold">
                        <button type="button" class="btn btn-info btn-sm" onclick="printSelectedBarcodes()" id="printBulkBtn" disabled>
                            <i class="fa-solid fa-print"></i> Print Selected
                        </button>
                        <a href="{{ route('productCreate') }}"><i class="fa-solid fa-plus"></i> Add Product</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center text-white">
                                <th><input type="checkbox" id="selectAll" onchange="toggleSelectAll()"></th>
                                <th>Product Name</th>
                                <th>Barcode</th>
                                <th>Image</th>
                                <th>Sale Price</th>
                                <th>Cost Price</th>
                                <th>Stock</th>
                                <th>Stock Value</th>
                                <th>Profit/Unit</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                                @php
                                    $costPrice = $item->purchase_price ?? 0;
                                    $salePrice = $item->price;
                                    $stock = $item->count;
                                    $stockValue = $costPrice * $stock;
                                    $profitPerUnit = $salePrice - $costPrice;
                                    $totalProfit = $profitPerUnit * $stock;
                                @endphp
                                <tr class="text-center text-white">
                                    <td><input type="checkbox" class="product-checkbox" value="{{ $item->id }}" onchange="updatePrintButton()"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <small class="badge badge-info">{{ $item->barcode ?? 'N/A' }}</small>
                                    </td>
                                    <td >
                                        <img class="rounded-circle" style="width: 64px; height: 64px;" src="{{ asset('productImages/' . $item->image) }}" alt="">
                                    </td>
                                    <td>Rs {{ number_format($salePrice, 2) }}</td>
                                    <td>Rs {{ number_format($costPrice, 2) }}</td>
                                    <td>{{ $stock }}</td>
                                    <td>Rs {{ number_format($stockValue, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $profitPerUnit >= 0 ? 'badge-success' : 'badge-danger' }}">
                                            Rs {{ number_format($profitPerUnit, 2) }}
                                        </span>
                                    </td>
                                    <td style="width: 250px;">
                                        <a href="{{ route('productDetails', $item->id) }}" title="View Details"><i class="fa-solid fa-eye btn btn-primary btn-sm"></i></a>
                                        <a href="{{ route('productEdit', $item->id) }}" title="Edit Product"><i class="fa-solid fa-pen-to-square btn btn-secondary btn-sm"></i></a>
                                        <a href="{{ route('product.print-barcode', $item->id) }}" target="_blank" title="Print Barcode"><i class="fa-solid fa-print btn btn-info btn-sm"></i></a>
                                        <a href="{{ route('productDelete', $item->id) }}" title="Delete Product"><i class="fa-solid fa-trash-can btn btn-danger btn-sm"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <span class="d-flex justify-content-end">{{ $products->links() }}</span>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
