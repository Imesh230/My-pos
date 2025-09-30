@extends('admin.layouts.master')
@section('content')
    <!-- Mobile Responsive Styles for Sales Report -->
    <style>
        @media (max-width: 768px) {
            .sales-report-cards .col-xl-4 {
                margin-bottom: 1rem;
            }
            
            .sales-report-cards .card-body {
                padding: 1rem;
            }
            
            .sales-report-cards .h5 {
                font-size: 1.25rem;
            }
            
            .sales-report-cards .text-xs {
                font-size: 0.75rem;
            }
            
            .table-responsive {
                font-size: 12px;
            }
            
            .table th, .table td {
                padding: 0.5rem 0.25rem;
            }
            
            .form-control {
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }
        
        @media (max-width: 576px) {
            .sales-report-cards .col-xl-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            
            .sales-report-cards .card-body {
                padding: 0.75rem;
            }
            
            .sales-report-cards .h5 {
                font-size: 1rem;
            }
            
            .table th, .table td {
                padding: 0.25rem;
                font-size: 11px;
            }
        }
        
        /* Touch-friendly elements */
        @media (hover: none) and (pointer: coarse) {
            .btn {
                min-height: 44px;
                min-width: 44px;
            }
        }
    </style>
    
    <section class="container-fluid">
        <div class="card">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-4">
                        <h3 class="intro-y text-lg text-white fw-bold font-medium mt-1 mb-1" >
                            Sales Report Details</h3>
                    </div>
                    <div class="col-8 mt-1">
                        <form action="{{ route('salesReport') }}" method="GET" class="mb-4  d-flex justify-content-end align-items-center">
                            <input type="date" name="start_date" class="form-control mx-2" value="{{ request('start_date') }}" style="max-width: 200px;">
                            <input type="date" name="end_date" class="form-control mx-2" value="{{ request('end_date') }}" style="max-width: 200px;">
                            <button type="submit" class="btn btn-dark text-dark fw-bold mx-2" style="background-color: #ffffff;">Filter</button>
                            <button type="button" class="btn btn-success" onclick="exportTableToExcel('salesTable')">Export To Excel</button>
                        </form>
                    </div>
                </div>

                <!-- Sales Summary Cards -->
                @if(!empty($sales) && count($sales) > 0)
                <div class="row mb-4">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Sales Amount</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rs {{ number_format($totalSalesAmount, 2) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Total Orders</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrdersCount }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Average Order Value</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            Rs {{ $totalOrdersCount > 0 ? number_format($totalSalesAmount / $totalOrdersCount, 2) : '0.00' }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Table of Daily Sales -->
                @if(!empty($sales) && count($sales) > 0)
                <table class="table table-bordered" id="salesTable" >
                    <thead class="table-dark">
                        <tr class="text-white text-center">
                        <th>Order ID</th>
                            <th>Order Code</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Instock</th>
                            <th>Sold</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales  as $item)
                        <tr class="text-white text-center">
                        <td>{{ $item->order_id }}</td>
                            <td>{{ $item->order_code }}</td>
                            <td>{{ $item->productname }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->instock }}</td>
                            <td>{{ $item->sold }}</td>
                            <td>{{ $item->created_at->format('j-F-y') }}</td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
                @else
                <div class="alert alert-warning" role="alert">
                    <p class="text-center text-dark">There are no data to show within this date.</p>
                </div>
            @endif
            </div>
        </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <!-- export excel -->
     <script>
        function exportTableToExcel(tableId, filename = 'Sales_Report_Details.xlsx') {
            const table = document.getElementById(tableId);
            const workbook = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(workbook, filename);
        }
     </script>


@endsection
