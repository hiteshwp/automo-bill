@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-title-box p-0 d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Stock</h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <button type="button" class="btn btn-success btn-select2" data-bs-toggle="offcanvas" data-bs-target="#sidebarAddPurchase" aria-controls="offcanvasRight"><i class="ri-add-large-line"></i> Add Purchase</button>
                                </div>
                                <div class="page-title-action-item">
                                    <button type="button" class="btn btn-light" data-bs-toggle="offcanvas" data-bs-target="#sidebarExplore" aria-controls="offcanvasRight"><i class="ri-indent-decrease"></i> Explore</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <!-- start row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Stock List</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-block table-responsive">
                            <table id="garageOwnersStockTable" class="table table-hover table-bordered w-100" data-route="{{ route('garage-owner.stock.data') }}">
                            <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Product Number</th>
                                        <th>Manufacturer Name</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Of Measurement</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>     
                                                                   
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div>
    <!-- container-fluid -->
</div>

<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarViewInformation" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">View Stock</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="viewInformationBlock viewPurchaseInformationBlock">
            <div class="card p-3" id="demo">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-header border-bottom-dashed p-3 ps-0 pe-0">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <img src="{{ asset('assets/images/logo-dark.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="30">
                                    <img src="{{ asset('assets/images/logo-light.png') }}" class="card-logo card-logo-light" alt="logo light" height="30">
                                </div>
                            </div>
                        </div>
                        <!--end card-header-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-0 shadow-none">
                            <div class="table-block table-responsive">
                                <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr class="table-active">
                                            <th scope="col">Category</th>
                                            <th scope="col">Product Code</th>
                                            <th scope="col">Manufacturer Name</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Purchase Date</th>
                                            <th scope="col">Supplier Name</th>
                                            <th scope="col" class="text-end">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-list">
                                        <tr>
                                            <td>Part</td>
                                            <td>PR100007</td>
                                            <td>N/A</td>
                                            <td>Steering Wheel</td>
                                            <td>02-12-2025</td>
                                            <td>Chirag Kanjariya</td>
                                            <td class="text-end">15</td>
                                        </tr>
                                    </tbody>
                                </table><!--end table-->
                            </div>
                            <div class="border-top border-top-dashed mt-2">
                                <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                    <tbody>
                                        <tr>
                                            <td>Total Stock</td>
                                            <td class="text-end">03</td>
                                        </tr>
                                        <tr>
                                            <td>Sales Stock</td>
                                            <td class="text-end">0</td>
                                        </tr>
                                        <tr class="border-top border-top-dashed fs-15">
                                            <th scope="row">Current Stock</th>
                                            <th class="text-end">03</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                        </div>
                        <!--end card-body-->
                    </div><!--end col-->
                </div><!--end row-->
            </div>
        </div>
    </div>
</div>

<!-- right offcanvas -->
@include('layouts.explore')

@endsection