@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Cashier Management</h6>
                    </div>
                    <div class="">
                        <a href="{{ route('cashier.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Add New Cashier
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center text-white">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cashiers as $cashier)
                                <tr class="text-center text-white">
                                    <td>{{ $cashier->id }}</td>
                                    <td class="text-info font-weight-bold">
                                        <a href="{{ route('cashier.show', $cashier->id) }}">{{ $cashier->name }}</a>
                                    </td>
                                    <td>{{ $cashier->email }}</td>
                                    <td>{{ $cashier->phone ?? 'N/A' }}</td>
                                    <td>
                                        @if($cashier->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('cashier.show', $cashier->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('cashier.edit', $cashier->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cashier.destroy', $cashier->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span class="d-flex justify-content-end">{{ $cashiers->links() }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
