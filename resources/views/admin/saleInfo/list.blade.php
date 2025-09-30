@extends('admin.layouts.master')
@section('content')
    <!-- Mobile Responsive Styles for Sales Info -->
    <style>
        @media (max-width: 768px) {
            .sales-summary-cards .col-xl-3 {
                margin-bottom: 1rem;
            }
            
            .sales-summary-cards .card-body {
                padding: 1rem;
            }
            
            .sales-summary-cards .h5 {
                font-size: 1.25rem;
            }
            
            .sales-summary-cards .text-xs {
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
            .sales-summary-cards .col-xl-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
            
            .sales-summary-cards .card-body {
                padding: 0.75rem;
            }
            
            .sales-summary-cards .h5 {
                font-size: 1rem;
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
        
        /* Touch-friendly elements */
        @media (hover: none) and (pointer: coarse) {
            .btn {
                min-height: 44px;
                min-width: 44px;
            }
            
            .btn-sm {
                min-height: 36px;
                min-width: 36px;
            }
        }
    </style>
    
    <!-- Begin Page Content -->
    <div class="container-fluid">
            <!-- Daily Sales Summary Cards -->
            <div class="row mb-4 sales-summary-cards">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Today's Date</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $todayDate }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                        Daily Sales Total</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rs {{ number_format($dailySalesTotal, 2) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                        Total Orders</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dailySalesCount }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
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
                                        Average Order Value</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        Rs {{ $dailySalesCount > 0 ? number_format($dailySalesTotal / $dailySalesCount, 2) : '0.00' }}
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

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <h6 class="m-0 font-weight-bold text-dark">Today's Sale Information</h6>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center text-white">
                                    <th>Product Image</th>
                                    <th>Name</th>
                                    <th>User Name</th>
                                    <th>Date</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                    <th>Order Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order as $item)
                                    <tr class="text-center text-white">
                                        <td><img class="rounded-circle" style="width: 64px; height: 64px;" src="{{ asset('productImages/'. $item->productimage)}}" alt=""></td>
                                        <td>{{ $item->productname }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                        <td>{{ $item->ordercount }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td><a href="{{route ('userOrderDetails', $item->order_code)}}">{{ $item->order_code }} </a></td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        {{-- <span class="d-flex justify-content-end">{{ $order->links()}}</span> --}}
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
@endsection
@section('js-section')
    <script>
        $(document).ready(function(){
            $('.statusChange').change(function(){
                $currentStatus = $(this).val();
                $orderCode = $(this).parents("tr").find('.orderCode').val();

                $data ={
                    'status' : $currentStatus,
                    'orderCode' : $orderCode
                }
                // console.log($data);
                $.ajax({
                    type : 'get',
                    url : 'change/status',
                    data  : $data,
                    dataType   : 'json'
                })

            })
        })
    </script>
@endsection
