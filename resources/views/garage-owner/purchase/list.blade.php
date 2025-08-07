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
                            <h4 class="mb-sm-0">Purchase</h4>
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
                        <h4 class="card-title mb-0 flex-grow-1">Purchase List</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-block table-responsive">
                            <table id="garageOwnersPurchaseTable" class="table table-hover table-bordered w-100" data-route="{{ route('garage-owner.purchase.data') }}">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Purchase Code</th>                                        
                                        <th>Supplier Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Date</th>
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

<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarAddPurchase" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Add Purchase</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmnewpurchaseinformation" method="post">
                <div class="row">
                    <!-- <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Purchase No*</label>
                            <input type="text" class="form-control" id="validationCustom05" required disabled value="P743890" placeholder="Enter your purchase number" />
                        </div>
                    </div> -->
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtnewsuppliername">Supplier Name*</label>
                            <select class="common-select2" name="txtnewsuppliername" id="txtnewsuppliername" required>
                                <option value="">Select supplier name</option>
                                @foreach($supplier as $supplierlist)
                                <option value="{{ $supplierlist->id }}">
                                    {{ $supplierlist->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtnewpurchasedate">Purchase Date*</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="Y-m-d" placeholder="Select date" name="txtnewpurchasedate" id="txtnewpurchasedate" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtnewpurchaseemail">Email*</label>
                            <input type="text" class="form-control" id="txtnewpurchaseemail" name="txtnewpurchaseemail" required placeholder="Enter your email" readonly />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtnewpurchasemobileno">Mobile No*</label>
                            <input class="form-control" id="txtnewpurchasemobileno" name="txtnewpurchasemobileno" type="tel" placeholder="Enter your mobile number" readonly required />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtnewpurchasebillingaddress">Billing Address*</label>
                            <textarea class="form-control resize-none" id="txtnewpurchasebillingaddress" name="txtnewpurchasebillingaddress" readonly required placeholder="Enter your billing address"></textarea>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3 d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 flex-grow-1">Purchase Details</h4>
                            <button type="button" class="btn btn-sm btn-success" id="btnaddnewproductloop"><i class="ri-add-large-line"></i> Add New</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="add-new-purchase-block" id="newproductlistingcontainer">
                            <div class="add-new-purchase-list newproductlistingloop" id="newproductlistingloop">
                                <div class="purchase-close-btn">
                                    <a class="alink btn btn-sm btn-soft-danger shadow-none radius-100"><i class="ri-close-large-line"></i></a>
                                </div>
                                <div class="add-new-purchase-item">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtnewpurchaseloopproductname">Product Name</label>
                                        <select class="common-select2 txtnewpurchaseloopproductname" name="txtnewpurchaseloopproductname[]" required>
                                            <option value="">Select product name</option>
                                            @foreach($product as $productlist)
                                            <option value="{{ $productlist->product_id }}">
                                                {{ $productlist->product_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="add-new-purchase-item">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtnewpurchaseloopqty">Quantity</label>
                                        <div class="input-step light full-width">
                                            <button type="button" class="minus">–</button>
                                            <input type="number" class="product-quantity txtnewpurchaseloopqty" value="1" min="1" max="10000" name="txtnewpurchaseloopqty[]" required>
                                            <button type="button" class="plus">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-new-purchase-item">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtnewpurchaseloopproductno">Product No</label>
                                        <input type="text" class="form-control txtnewpurchaseloopproductno" name="txtnewpurchaseloopproductno[]" required readonly value="" placeholder="Enter Product No" required/>
                                    </div>
                                </div>
                                <div class="add-new-purchase-item">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtnewpurchaseloopprice">Price ($)</label>
                                        <input type="text" class="form-control txtnewpurchaseloopprice" name="txtnewpurchaseloopprice[]" required readonly value="" placeholder="000.00" required/>
                                    </div>
                                </div>
                                <div class="add-new-purchase-item">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtnewpurchaselooptotalamount">Total Amount ($)</label>
                                        <input type="text" class="form-control txtnewpurchaselooptotalamount" name="txtnewpurchaselooptotalamount[]" required readonly value="" placeholder="000.00" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnnewpurchaseinformation">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <input type="hidden" name="txtnewpurchasesuppliername" id="txtnewpurchasesuppliername"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarViewInformation" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">View Purchase</h5>
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
                                <div class="flex-shrink-0 mt-sm-0 mt-3">
                                    <h6><span class="text-muted fw-normal">Purchase Number: </span><span id="purchaseviewpurchasenumber">&nbsp;</span></h6>
                                    <h6><span class="text-muted fw-normal">Date: </span><span id="purchaseviewpurchasedate">&nbsp;</span></h6>
                                </div>
                            </div>
                        </div>
                        <!--end card-header-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-3 ps-0 pe-0 border-top border-top-dashed">
                            <div class="row g-3">
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Billing Address</h6>
                                    <p class="text-muted mb-1" id="purchaseviewsupplieraddress">&nbsp;</p>
                                </div>
                                <!--end col-->
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Supplier Detail</h6>
                                    <p class="text-muted mb-1"><span>Name: </span><span id="purchaseviewsuppliername">&nbsp;</span></p>
                                    <p class="text-muted mb-0"><span>Email: </span><span id="purchaseviewsupplieremail">&nbsp;</span> </p>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-0 shadow-none">
                            <div class="table-block table-responsive">
                                <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr class="table-active">
                                            <th scope="col">Category</th>
                                            <th scope="col">Product Number</th>
                                            <th scope="col">Manufacturer Name</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Price ($)</th>
                                            <th scope="col" class="text-end">Total Amount ($)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-list">
                                        
                                    </tbody>
                                </table><!--end table-->
                            </div>
                            <div class="border-top border-top-dashed mt-2">
                                <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                    <tbody>
                                        <tr class="border-top border-top-dashed fs-15">
                                            <th scope="row">Grand Total</th>
                                            <th class="text-end" id="viewpurchasegrandtotal">$6000.00</th>
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

<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarEditPurchase" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Update Purchase</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmupdatepurchaseinformation" method="post">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatepurchaseno">Purchase No*</label>
                            <input type="text" class="form-control" id="txtupdatepurchaseno" required name="txtupdatepurchaseno" readonly placeholder="Enter your purchase number" />
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatesuppliername">Supplier Name*</label>
                            <select class="common-select2" name="txtupdatesuppliername" id="txtupdatesuppliername" required>
                                <option value="">Select supplier name</option>
                                @foreach($supplier as $supplierlist)
                                <option value="{{ $supplierlist->id }}">
                                    {{ $supplierlist->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatepurchasedate">Purchase Date*</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="Y-m-d" placeholder="Select date" name="txtupdatepurchasedate" id="txtupdatepurchasedate" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatepurchaseemail">Email*</label>
                            <input type="text" class="form-control" id="txtupdatepurchaseemail" name="txtupdatepurchaseemail" required placeholder="Enter your email" readonly />
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatepurchasemobileno">Mobile No*</label>
                            <input class="form-control" id="txtupdatepurchasemobileno" name="txtupdatepurchasemobileno" type="tel" placeholder="Enter your mobile number" readonly required />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatepurchasebillingaddress">Billing Address*</label>
                            <textarea class="form-control resize-none" id="txtupdatepurchasebillingaddress" name="txtupdatepurchasebillingaddress" readonly required placeholder="Enter your billing address"></textarea>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3 d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0 flex-grow-1">Purchase Details</h4>
                            <button type="button" class="btn btn-sm btn-success" id="btnaddupdateproductloop"><i class="ri-add-large-line"></i> Add New</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="add-new-purchase-block" id="updateproductlistingcontainer">
                            <div class="add-new-purchase-list updateproductlistingloop" id="updateproductlistingloop">
                                <div class="purchase-close-btn updatepurchaseremovebtn">
                                    <a class="alink btn btn-sm btn-soft-danger shadow-none radius-100"><i class="ri-close-large-line"></i></a>
                                </div>
                                <div class="add-new-purchase-item">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtupdatepurchaseloopproductname">Product Name</label>
                                        <select class="common-select2 txtupdatepurchaseloopproductname" name="txtupdatepurchaseloopproductname[]" required>
                                            <option value="">Select product name</option>
                                            @foreach($product as $productlist)
                                            <option value="{{ $productlist->product_id }}">
                                                {{ $productlist->product_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="add-new-purchase-item">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtupdatepurchaseloopqty">Quantity</label>
                                        <div class="input-step light full-width">
                                            <button type="button" class="minus">–</button>
                                            <input type="number" class="product-quantity txtupdatepurchaseloopqty" value="1" min="1" max="10000" name="txtupdatepurchaseloopqty[]" required>
                                            <button type="button" class="plus">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-new-purchase-item">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtupdatepurchaseloopproductno">Product No</label>
                                        <input type="text" class="form-control txtupdatepurchaseloopproductno" name="txtupdatepurchaseloopproductno[]" required readonly value="" placeholder="Enter Product No" required/>
                                    </div>
                                </div>
                                <div class="add-new-purchase-item">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtupdatepurchaseloopprice">Price ($)</label>
                                        <input type="text" class="form-control txtupdatepurchaseloopprice" name="txtupdatepurchaseloopprice[]" required readonly value="" placeholder="000.00" required/>
                                    </div>
                                </div>
                                <div class="add-new-purchase-item">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtupdatepurchaselooptotalamount">Total Amount ($)</label>
                                        <input type="text" class="form-control txtupdatepurchaselooptotalamount" name="txtupdatepurchaselooptotalamount[]" required readonly value="" placeholder="000.00" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnupdatepurchaseinformation">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <input type="hidden" name="txtupdatepurchasesppliername" id="txtupdatepurchasesppliername"/>
                        <input type="hidden" name="txtupdatepurchaseid" id="txtupdatepurchaseid"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="removePurchaseNotificationModal" aria-labelledby="offcanvasRightLabel">
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
                    <input type="hidden" value="" id="txtarchivepurchasetid"/>
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="offcanvas">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="archive-purchase-notification">Yes, Archive It!</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- right offcanvas -->
@include('layouts.explore')

@endsection