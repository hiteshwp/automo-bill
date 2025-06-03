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
                            <h4 class="mb-sm-0">Clients</h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <a href="javascript:void(0);" class="btn btn-warning">Compose Promotional Email</a>
                                </div>
                                <div class="page-title-action-item">
                                    <button type="button" id="btnnewaddclient" class="btn btn-success btn-select2" data-bs-toggle="offcanvas" data-bs-target="#sidebarNewClient" aria-controls="offcanvasRight"><i class="ri-add-large-line"></i> New Client</button>
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
                    <div class="card-body">
                        <div class="table-block table-responsive">
                        <table id="garageOwnersClientsTable" class="table table-hover table-bordered w-100" data-route="{{ route('garage-owner.clients.data') }}">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Owner Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>User Type</th>
                                    <th>Country</th>
                                    <th>Zip Code</th>
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

<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarNewClient" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Add New Client Informartion</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmaddnewinformation" method="post">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Personal Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtclientname">Name*</label>
                            <input type="text" class="form-control" id="txtclientname" name="txtclientname" required placeholder="Enter your name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtclientemail">Email*</label>
                            <input type="email" class="form-control" id="txtclientemail" name="txtclientemail" required placeholder="Enter your email" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtclientmobilenumber">Mobile No*</label>
                            <input class="form-control" id="txtclientmobilenumber" name="txtclientmobilenumber" required type="tel" value="" placeholder="Enter your mobile number" />
                            <div id="error-msg-client" class="hide"></div>
                            <div id="valid-msg-client" class="hide"></div>
                            <button id="btn-client" style="display:none;">Validate</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtclientlandlinenumber">Landline No</label>
                            <input type="text" class="form-control" id="txtclientlandlinenumber" name="txtclientlandlinenumber" placeholder="Enter your landline number" />
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
                            <label class="form-label" for="txtclientcountry">Country*</label>
                            <select class="form-select mb-3 drpcountry" aria-label="Default select example" name="txtclientcountry" id="txtclientcountry" required>
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
                            <label class="form-label" for="txtclientstate">State*</label>
                            <select class="form-select mb-3 drpstate" aria-label="Default select example" name="txtclientstate" id="txtclientstate" required>
                                <option value="" selected>Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtclientcity">Town/City*</label>
                            <select class="form-select mb-3 drpcity" aria-label="Default select example" name="txtclientcity" id="txtclientcity" required>
                                <option value="" selected>Select City</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtclientaddress">Address*</label>
                            <textarea class="form-control resize-none" id="txtclientaddress" name="txtclientaddress" placeholder="Enter your address" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnaddnewclient">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <input type="hidden" name="newclientphonecode" id="newclientphonecode" value=""/>
                        <input type="hidden" name="newclientphoneicocode" id="newclientphoneicocode" value=""/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarUpdateClient" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Update Client Informartion</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmclientupdateinformation" method="post">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Personal Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdateclientname">Name*</label>
                            <input type="text" class="form-control" id="txtupdateclientname" name="txtupdateclientname" required placeholder="Enter your name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdateclientemail">Email*</label>
                            <input type="email" class="form-control" id="txtupdateclientemail" name="txtupdateclientemail" required placeholder="Enter your email" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdateclientmobilenumber">Mobile No*</label>
                            <input class="form-control" id="txtupdateclientmobilenumber" name="txtupdateclientmobilenumber" required type="tel" value="" placeholder="Enter your mobile number" />
                            <div id="error-msg-update" class="hide"></div>
                            <div id="valid-msg-update" class="hide"></div>
                            <button id="btn-update" style="display:none;">Validate</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdateclientlandlinenumber">Landline No</label>
                            <input type="text" class="form-control" id="txtupdateclientlandlinenumber" name="txtupdateclientlandlinenumber" placeholder="Enter your landline number" />
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
                            <label class="form-label" for="txtupdateclientcountry">Country*</label>
                            <select class="form-select mb-3 drpcountry" aria-label="Default select example" name="txtupdateclientcountry" id="txtupdateclientcountry" required>
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
                            <label class="form-label" for="txtupdateclientstate">State*</label>
                            <select class="form-select mb-3 drpstate" aria-label="Default select example" name="txtupdateclientstate" id="txtupdateclientstate" required>
                                <option value="" selected>Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdateclientcity">Town/City*</label>
                            <select class="form-select mb-3 drpcity" aria-label="Default select example" name="txtupdateclientcity" id="txtupdateclientcity" required>
                                <option value="" selected>Select City</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdateclientaddress">Address*</label>
                            <textarea class="form-control resize-none" id="txtupdateclientaddress" name="txtupdateclientaddress" placeholder="Enter your address" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnupdatelient">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <input type="hidden" name="updateclientid" id="updateclientid" value=""/>
                        <input type="hidden" name="updateclientphonecode" id="updateclientphonecode" value=""/>
                        <input type="hidden" name="updateclientphoneicocode" id="updateclientphoneicocode" value=""/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- right offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarExplore" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Explore</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="inner-pages-top-menu-block">
            <ul class="inner-navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-box-3-line"></i> <span>Suppliers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-user-search-line"></i> <span>Search Client</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-steering-line"></i> <span>Search Vehicle</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-file-info-line"></i> <span>Invoice Due</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-file-check-line"></i> <span>Paid Invoices</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link dropdownToggleMenuLink" data-bs-toggle="collapse" href="#dropdownToggleMenu" role="button" aria-expanded="true" aria-controls="collapseExample">
                        <i class="ri-file-text-line"></i> <span>Part Inventory</span>
                    </a>
                    <div class="collapse" id="dropdownToggleMenu">
                        <div class="dropdown-toggle-menu">
                            <ul class="nav nav-sm">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Suppliers | Email | Order Part</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Product</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Purchase</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Stock</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-file-chart-line"></i> <span>Sales Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-file-upload-line"></i> <span>Import</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-coupon-3-line"></i> <span>Manage Tickets</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-megaphone-line"></i> <span>Marketing</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- removeNotificationModal -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="removeClientNotificationModal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Remove Client User Details</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="viewInformationBlock">
            <div class="mt-2 text-center">
                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                    <h4>Are you sure ?</h4>
                    <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Details ?</p>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                <form method="post">
                    <input type="hidden" value="" id="txtdeleteclientid"/>
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="offcanvas">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-client-notification">Yes, Delete It!</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection