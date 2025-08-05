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
                            <h4 class="mb-sm-0">Product</h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <button type="button" class="btn btn-success btn-select2" data-bs-toggle="offcanvas" data-bs-target="#sidebarAddProduct" aria-controls="offcanvasRight"><i class="ri-add-large-line"></i> Add Product</button>
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
                        <h4 class="card-title mb-0 flex-grow-1">Product List</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-block table-responsive">
                            <table id="garageOwnersProductTable" class="table table-hover table-bordered w-100" data-route="{{ route('garage-owner.product.data') }}">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Product Number</th>                                        
                                        <th>Pruduct Name</th>
                                        <th>Price ($)</th>
                                        <th>Supplier Name</th>
                                        <th>Company Name</th>
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

<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarAddProduct" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Add Product</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmaddnewproductinformation" method="post">
                <div class="row">
                    <!-- <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtproductnumber">Product Number*</label>
                            <input type="text" class="form-control" id="txtproductnumber" name="txtproductnumber" required placeholder="Enter product number" />
                        </div>
                    </div> -->
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtproductname">Product Name*</label>
                            <input type="text" class="form-control" id="txtproductname" name="txtproductname" required placeholder="Enter product name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtprice">Price ($)*</label>
                            <input type="text" class="form-control" id="txtprice" name="txtprice" required placeholder="Enter price($)" />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtproductdate">Product Date*</label>
                            <input type="text" class="form-control dateformat" id="txtproductdate" name="txtproductdate" required data-provider="flatpickr" data-date-format="d.m.y" placeholder="Select date" />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtsupplier">Supplier</label>
                            <select class="form-select" required name="txtsupplier" id="txtsupplier" aria-label="Default select example">
                                <option value="">Select Supplier</option>
                                @foreach($supplier as $supplierlist)
                                <option value="{{ $supplierlist->id }}">
                                    {{ $supplierlist->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnaddnewproduct">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarEditProduct" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Update Product</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmupdateproductinformation" method="post">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdateproductnumber">Product Number*</label>
                            <input type="text" class="form-control" id="txtupdateproductnumber" name="txtupdateproductnumber" required disabled placeholder="Enter product number" />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdateproductname">Product Name*</label>
                            <input type="text" class="form-control" id="txtupdateproductname" name="txtupdateproductname" required placeholder="Enter product name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdateprice">Price ($)*</label>
                            <input type="text" class="form-control" id="txtupdateprice" name="txtupdateprice" required placeholder="Enter price($)" />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdateproductdate">Product Date*</label>
                            <input type="text" class="form-control dateformat" id="txtupdateproductdate" name="txtupdateproductdate" required data-provider="flatpickr" data-date-format="d.m.y" placeholder="Select date" />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatesupplier">Supplier</label>
                            <select class="form-select" required name="txtupdatesupplier" id="txtupdatesupplier" aria-label="Default select example">
                                <option value="">Select Supplier</option>
                                @foreach($supplier as $supplierlist)
                                <option value="{{ $supplierlist->id }}">
                                    {{ $supplierlist->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnupdateproduct">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <input type="hidden" name="txtupdateproductid" id="txtupdateproductid" value=""/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="removeProductNotificationModal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Archive Product Details</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="viewInformationBlock">
            <div class="mt-2 text-center">
                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                    <h4>Are you sure ?</h4>
                    <p class="text-muted mx-4 mb-0">Are you sure you want to Archive this Details ?</p>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                <form method="post">
                    <input type="hidden" value="" id="txtarchiveproducttid"/>
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="offcanvas">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="archive-productt-notification">Yes, Archive It!</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- right offcanvas -->
@include('layouts.explore')

@endsection