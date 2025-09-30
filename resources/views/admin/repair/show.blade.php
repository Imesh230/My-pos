@extends('admin.layouts.master')

@section('title', 'Repair Service Details')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Repair Service Details</h1>
        <div>
            <a href="{{ route('repair.edit', $repair) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('repair.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Repair Information -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Repair Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Repair Code:</strong></td>
                                    <td>{{ $repair->repair_code }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $repair->status_badge }}">
                                            {{ $repair->status_text }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Received Date:</strong></td>
                                    <td>{{ $repair->received_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Estimated Completion:</strong></td>
                                    <td>{{ $repair->estimated_completion ? $repair->estimated_completion->format('M d, Y') : 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Completed Date:</strong></td>
                                    <td>{{ $repair->completed_date ? $repair->completed_date->format('M d, Y') : 'Not completed' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Delivered Date:</strong></td>
                                    <td>{{ $repair->delivered_date ? $repair->delivered_date->format('M d, Y') : 'Not delivered' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Estimated Cost:</strong></td>
                                    <td><strong>Rs {{ number_format($repair->estimated_cost, 2) }}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Final Cost:</strong></td>
                                    <td>
                                        @if($repair->final_cost)
                                            <strong>Rs {{ number_format($repair->final_cost, 2) }}</strong>
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Technician:</strong></td>
                                    <td>{{ $repair->technician ?: 'Not assigned' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $repair->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $repair->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $repair->customer_name }}</p>
                            <p><strong>Phone:</strong> {{ $repair->customer_phone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Email:</strong> {{ $repair->customer_email ?: 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Device Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Device Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Brand:</strong> {{ $repair->device_brand }}</p>
                            <p><strong>Model:</strong> {{ $repair->device_model }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>IMEI:</strong> {{ $repair->device_imei ?: 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Problem Description -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Problem Description</h6>
                </div>
                <div class="card-body">
                    <p>{{ $repair->problem_description }}</p>
                </div>
            </div>

            <!-- Repair Notes -->
            @if($repair->repair_notes)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Repair Notes</h6>
                </div>
                <div class="card-body">
                    <p>{{ $repair->repair_notes }}</p>
                </div>
            </div>
            @endif

            <!-- Warranty Information -->
            @if($repair->warranty_info)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Warranty Information</h6>
                </div>
                <div class="card-body">
                    <p>{{ $repair->warranty_info }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Status Update -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('repair.update-status', $repair) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending" {{ $repair->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diagnosed" {{ $repair->status == 'diagnosed' ? 'selected' : '' }}>Diagnosed</option>
                                <option value="in_progress" {{ $repair->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $repair->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="delivered" {{ $repair->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $repair->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="repair_notes">Repair Notes</label>
                            <textarea class="form-control" id="repair_notes" name="repair_notes" rows="3" 
                                      placeholder="Add repair notes...">{{ $repair->repair_notes }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="final_cost">Final Cost (Rs)</label>
                            <input type="number" class="form-control" id="final_cost" name="final_cost" 
                                   value="{{ $repair->final_cost }}" min="0" step="0.01" 
                                   placeholder="Enter final cost...">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('repair.edit', $repair) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Details
                        </a>
                        <a href="{{ route('repair.bill', $repair) }}" class="btn btn-success" target="_blank">
                            <i class="fas fa-receipt"></i> Generate Bill
                        </a>
                        <a href="{{ route('repair.print-bill', $repair) }}" class="btn btn-info" target="_blank">
                            <i class="fas fa-print"></i> Print Bill
                        </a>
                        <a href="{{ route('repair.thermal-receipt', $repair) }}" class="btn btn-warning" target="_blank">
                            <i class="fas fa-print"></i> Thermal Receipt
                        </a>
                        <form action="{{ route('repair.destroy', $repair) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Are you sure you want to delete this repair service?')">
                                <i class="fas fa-trash"></i> Delete Repair
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
