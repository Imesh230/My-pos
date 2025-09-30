@extends('admin.layouts.master')

@section('title', 'Repair Services')

@section('content')
    <!-- Mobile Responsive Styles for Repair Services -->
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
        }
        @media (max-width: 768px) {
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
            
            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
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
        <h1 class="h3 mb-0 text-gray-800">Repair Services</h1>
        <a href="{{ route('repair.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Repair
        </a>
    </div>

    <!-- Today's Summary Cards -->
    <div class="row summary-cards">
        <div class="col-md-3 mb-3">
            <div class="summary-card info">
                <h3>{{ $todaySummary['total_repairs'] }}</h3>
                <p>Total Repairs Today</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="summary-card success">
                <h3>{{ $todaySummary['completed_today'] }}</h3>
                <p>Completed Today</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="summary-card warning">
                <h3>{{ $todaySummary['in_progress_today'] }}</h3>
                <p>In Progress</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="summary-card danger">
                <h3>Rs {{ number_format($todaySummary['total_estimated_cost'], 2) }}</h3>
                <p>Total Estimated Cost</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('repair.search') }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by repair code, customer name, phone, or device..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diagnosed" {{ request('status') == 'diagnosed' ? 'selected' : '' }}>Diagnosed</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route('repair.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Repair Services Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Repair Services List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Repair Code</th>
                            <th>Customer</th>
                            <th>Device</th>
                            <th>Problem</th>
                            <th>Status</th>
                            <th>Estimated Cost</th>
                            <th>Received Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($repairs as $repair)
                        <tr>
                            <td>
                                <strong>{{ $repair->repair_code }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $repair->customer_name }}</strong><br>
                                    <small class="text-muted">{{ $repair->customer_phone }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $repair->device_brand }}</strong><br>
                                    <small class="text-muted">{{ $repair->device_model }}</small>
                                </div>
                            </td>
                            <td>
                                <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                    {{ Str::limit($repair->problem_description, 50) }}
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $repair->status_badge }}">
                                    {{ $repair->status_text }}
                                </span>
                            </td>
                            <td>
                                <strong>Rs {{ number_format($repair->estimated_cost, 2) }}</strong>
                            </td>
                            <td>
                                {{ $repair->received_date->format('M d, Y') }}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('repair.show', $repair) }}" class="btn btn-info btn-sm" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('repair.edit', $repair) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('repair.bill', $repair) }}" class="btn btn-success btn-sm" title="Generate Bill" target="_blank">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                    <a href="{{ route('repair.thermal-receipt', $repair) }}" class="btn btn-warning btn-sm" title="Thermal Receipt" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <form action="{{ route('repair.destroy', $repair) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No repair services found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $repairs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
