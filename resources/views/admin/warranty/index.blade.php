@extends('admin.layouts.master')

@section('title', 'Warranty Management')

@section('content')
    <!-- Mobile Responsive Styles for Warranty Management -->
    <style>
        /* Today Summary Cards */
        .summary-cards {
            margin-bottom: 2rem;
        }
        
        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .summary-card:hover {
            transform: translateY(-5px);
        }
        
        .summary-card h3 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .summary-card p {
            margin: 0;
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .summary-card.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        
        .summary-card.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .summary-card.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .summary-card.danger {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        
        @media (max-width: 768px) {
            .summary-cards .col-md-3 {
                margin-bottom: 1rem;
            }
            
            .summary-card {
                padding: 1rem;
            }
            
            .summary-card h3 {
                font-size: 1.5rem;
            }
            
            .summary-card p {
                font-size: 0.8rem;
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
            
            .card-header {
                padding: 0.75rem;
            }
            
            .card-body {
                padding: 0.75rem;
            }
        }
        
        @media (max-width: 576px) {
            .table th, .table td {
                padding: 0.25rem;
                font-size: 11px;
            }
            
            .btn-sm {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }
            
            .card-header h6 {
                font-size: 0.875rem;
            }
            
            .badge {
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

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Warranty Management</h1>
        <a href="{{ route('warranty.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Warranty
        </a>
    </div>

    <!-- Today's Summary Cards -->
    <div class="row summary-cards">
        <div class="col-md-3 mb-3">
            <div class="summary-card info">
                <h3>{{ $todaySummary['total_warranties'] }}</h3>
                <p>Warranties Today</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="summary-card success">
                <h3>{{ $todaySummary['active_warranties'] }}</h3>
                <p>Active Warranties</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="summary-card warning">
                <h3>{{ $todaySummary['total_claims'] }}</h3>
                <p>Claims Today</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="summary-card danger">
                <h3>{{ $todaySummary['pending_claims'] }}</h3>
                <p>Pending Claims</p>
            </div>
        </div>
    </div>

    <!-- Warranties Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Warranties</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center text-white">
                            <th>Warranty Code</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Expiry Date</th>
                            <th>Claims</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($warranties as $warranty)
                        <tr class="text-center text-white">
                            <td>
                                <small class="badge badge-info">{{ $warranty->warranty_code }}</small>
                            </td>
                            <td>
                                <strong>{{ $warranty->product_name }}</strong><br>
                                <small>{{ $warranty->brand }} {{ $warranty->model }}</small>
                            </td>
                            <td>
                                {{ $warranty->customer_name }}<br>
                                <small>{{ $warranty->customer_phone }}</small>
                            </td>
                            <td>
                                <span class="badge badge-secondary">
                                    {{ ucfirst(str_replace('_', ' ', $warranty->product_type)) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $warranty->status_badge }}">
                                    {{ $warranty->status_text }}
                                </span>
                            </td>
                            <td>
                                {{ $warranty->warranty_end_date->format('Y-m-d') }}
                            </td>
                            <td>
                                <span class="badge badge-primary">{{ $warranty->claims->count() }}</span>
                            </td>
                            <td style="width: 200px;">
                                <a href="{{ route('warranty.show', $warranty) }}" title="View Details" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('warranty.edit', $warranty) }}" title="Edit" class="btn btn-warning btn-sm">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="{{ route('warranty.create-claim', $warranty) }}" title="Create Claim" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                <form action="{{ route('warranty.destroy', $warranty) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $warranties->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
