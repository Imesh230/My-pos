@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4 col">
            <div class="card-header py-3">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-dark">Product Details Page</h6>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-3 h-100">
                        <img class="img-thumbnail h-100" src="{{ asset('productImages/' . $data->image) }}" alt=""
                            id="output">
                     </div>
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                                    <h4>{{ $data->name }}</h4>

                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                                    <h4>{{ $data->category_name }}</h4>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Barcode</label>
                                    <h4><span class="badge badge-info">{{ $data->barcode ?? 'N/A' }}</span></h4>

                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Product ID</label>
                                    <h4>{{ $data->id }}</h4>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Instock</label>
                                    <h4>{{ $data->count }}</h4>

                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Sell Price</label>
                                    <h4>Rs {{ number_format($data->price, 2) }}</h4>

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Purchase Price</label>
                                    <h4>Rs {{ number_format($data->purchase_price ?? 0, 2) }}</h4>

                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Stock Value</label>
                                    <h4 class="text-info">Rs {{ number_format(($data->purchase_price ?? 0) * $data->count, 2) }}</h4>

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Profit per Unit</label>
                                    @php
                                        $profitPerUnit = $data->price - ($data->purchase_price ?? 0);
                                    @endphp
                                    <h4 class="{{ $profitPerUnit >= 0 ? 'text-success' : 'text-danger' }}">
                                        Rs {{ number_format($profitPerUnit, 2) }}
                                    </h4>

                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Total Potential Profit</label>
                                    <h4 class="text-success">Rs {{ number_format($profitPerUnit * $data->count, 2) }}</h4>

                                </div>
                            </div>

                        </div>
                        <div class="row ">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Description</label>
                                    <h5 class="">{{ $data->description }}</h5>

                                </div>
                            </div>


                        </div>

                        <div class="row w-100">
                            <div class="col-4">
                                <a href="{{ route('productList') }}"
                                    class="btn btn-primary mt-2 text-center w-100">Back</a>
                            </div>
                            <div class="col-4">
                                <a href="{{ route('product.print-barcode', $data->id) }}" target="_blank"
                                    class="btn btn-info mt-2 text-center w-100">
                                    <i class="fa-solid fa-print"></i> Print Barcode
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="{{ route('productEdit', $data->id) }}"
                                    class="btn btn-warning mt-2 text-center w-100">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
