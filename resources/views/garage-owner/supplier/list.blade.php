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
                            <h4 class="mb-sm-0">Suppliers | Email | Order Parts</h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <button type="button" class="btn btn-success btn-select2" data-bs-toggle="offcanvas" data-bs-target="#sidebarAddSupplier" aria-controls="offcanvasRight"><i class="ri-add-large-line"></i> Add Supplier</button>
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
                        <h4 class="card-title mb-0 flex-grow-1">Supplier List</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-block table-responsive">
                            <table id="garageOwnersSupplierTable" class="table table-hover table-bordered w-100" data-route="{{ route('garage-owner.suppliers.data') }}">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Full Name</th>                                        
                                        <th>Email</th>
                                        <th>Business Name</th>
                                        <th>Product Name</th>
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

<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarViewInformation" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">View Supplier Detail</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="viewInformationBlock">
            <div class="table-responsive table-card bg-primary-subtle border-primary">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td class="fw-medium">Name</td>
                            <td id="supplierfullname">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Email</td>
                            <td id="supplieremail">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Mobile No</td>
                            <td id="suppliermobilenumber">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Address</td>
                            <td id="supplieraddress">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <!--end table-->
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarAddSupplier" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Add New Supplier Informartion</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmaddnewsupplierinformation" method="post">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Personal Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtsuppliername">Name*</label>
                            <input type="text" class="form-control" id="txtsuppliername" name="txtsuppliername" required placeholder="Enter your name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtcompanyname">Company Name*</label>
                            <input type="text" class="form-control" id="txtcompanyname" name="txtcompanyname" required placeholder="Enter company name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtsupplieremail">Email*</label>
                            <input type="email" class="form-control" id="txtsupplieremail" name="txtsupplieremail" required placeholder="Enter your email" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtsuppliermobilenumber">Mobile No*</label>
                            <input class="form-control" id="txtsuppliermobilenumber" name="txtsuppliermobilenumber" required type="tel" value="" placeholder="Enter your mobile number" />
                            <div id="error-msg-supplier" class="hide"></div>
                            <div id="valid-msg-supplier" class="hide"></div>
                            <button id="btn-supplier" style="display:none;">Validate</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtsupplierlandlinenumber">Landline No</label>
                            <input type="text" class="form-control" id="txtsupplierlandlinenumber" name="txtsupplierlandlinenumber" placeholder="Enter your landline number" />
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Address Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtsuppliercountry">Country*</label>
                            <select class="form-select mb-3 drpcountry" aria-label="Default select example" name="txtsuppliercountry" id="txtsuppliercountry" required>
                                <option value="" selected>Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}">
                                    {{ $country->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>                    
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtsupplierstate">State*</label>
                            <select class="form-select mb-3 drpstate" aria-label="Default select example" name="txtsupplierstate" id="txtsupplierstate" required>
                                <option value="" selected>Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtsuppliercity">Town/City*</label>
                            <select class="form-select mb-3 drpcity" aria-label="Default select example" name="txtsuppliercity" id="txtsuppliercity" required>
                                <option value="" selected>Select City</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtsupplieraddress">Address*</label>
                            <textarea class="form-control resize-none" id="txtsupplieraddress" name="txtsupplieraddress" placeholder="Enter your address" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnaddnewsupplier">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <input type="hidden" name="newsupplierphonecode" id="newsupplierphonecode" value="1"/>
                        <input type="hidden" name="newsupplierphoneicocode" id="newsupplierphoneicocode" value="us"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarUpdateSupplier" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Update SUpplier Informartion</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmsupplierupdateinformation" method="post">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Personal Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatesuppliername">Name*</label>
                            <input type="text" class="form-control" id="txtupdatesuppliername" name="txtupdatesuppliername" required placeholder="Enter your name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatecompanyname">Company Name*</label>
                            <input type="text" class="form-control" id="txtupdatecompanyname" name="txtupdatecompanyname" required placeholder="Enter company name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatesupplieremail">Email*</label>
                            <input type="email" class="form-control" id="txtupdatesupplieremail" name="txtupdatesupplieremail" required placeholder="Enter your email" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatesuppliermobilenumber">Mobile No*</label>
                            <input class="form-control" id="txtupdatesuppliermobilenumber" name="txtupdatesuppliermobilenumber" required type="tel" value="" placeholder="Enter your mobile number" />
                            <div id="error-msg-update-supplier" class="hide"></div>
                            <div id="valid-msg-update-supplier" class="hide"></div>
                            <button id="btn-update-supplier" style="display:none;">Validate</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatesupplierlandlinenumber">Landline No</label>
                            <input type="text" class="form-control" id="txtupdatesupplierlandlinenumber" name="txtupdatesupplierlandlinenumber" placeholder="Enter your landline number" />
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Address Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatesuppliercountry">Country*</label>
                            <select class="form-select mb-3 drpcountry" aria-label="Default select example" name="txtupdatesuppliercountry" id="txtupdatesuppliercountry" required>
                                <option value="" selected>Select Country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->id }}">
                                    {{ $country->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>                    
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatesupplierstate">State*</label>
                            <select class="form-select mb-3 drpstate" aria-label="Default select example" name="txtupdatesupplierstate" id="txtupdatesupplierstate" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatesuppliercity">Town/City*</label>
                            <select class="form-select mb-3 drpcity" aria-label="Default select example" name="txtupdatesuppliercity" id="txtupdatesuppliercity" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatesupplieraddress">Address*</label>
                            <textarea class="form-control resize-none" id="txtupdatesupplieraddress" name="txtupdatesupplieraddress" placeholder="Enter your address" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnupdatesupplier">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <input type="hidden" name="updatesupplierid" id="updatesupplierid" value=""/>
                        <input type="hidden" name="updatesupplierphonecode" id="updatesupplierphonecode" value=""/>
                        <input type="hidden" name="updatesupplierphoneicocode" id="updatesupplierphoneicocode" value=""/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="removeSupplierNotificationModal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Archive Supplier Details</h5>
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
                    <input type="hidden" value="" id="txtarchivesuppliertid"/>
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="offcanvas">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="archive-supplier-notification">Yes, Archive It!</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- right offcanvas -->
@include('layouts.explore')

@endsection