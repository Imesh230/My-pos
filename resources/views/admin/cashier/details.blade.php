@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Cashier Details</h6>
                    <a href="{{ route('cashier.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($cashier->profile)
                            <img src="{{ asset('cashierProfile/' . $cashier->profile) }}" 
                                 class="img-fluid rounded" alt="Profile Image" style="max-height: 300px;">
                        @else
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                 style="height: 300px;">
                                <i class="fa-solid fa-user fa-5x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Name:</th>
                                <td>{{ $cashier->name }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $cashier->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $cashier->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>{{ $cashier->address ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @if($cashier->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $cashier->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated:</th>
                                <td>{{ $cashier->updated_at->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                        
                        <div class="mt-3">
                            <a href="{{ route('cashier.edit', $cashier->id) }}" class="btn btn-warning">
                                <i class="fa-solid fa-edit"></i> Edit Cashier
                            </a>
                            <a href="{{ route('cashier.screen') }}" class="btn btn-primary">
                                <i class="fa-solid fa-cash-register"></i> Open Cashier Screen
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
