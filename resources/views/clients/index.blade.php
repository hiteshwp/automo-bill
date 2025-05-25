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
                        <table id="garageOwnersClientsTable" class="table table-hover table-bordered w-100" data-route="{{ route('clients.data') }}">
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

<!-- Edit Garage Owner form offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarEditGarageOwner" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Edit <span class="fs-14 fw-normal" id="editnametitle">(G Myatt)</span></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" method="post" id="frmeditgarageownerdata">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Personal Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txteditname">Name*</label>
                            <input type="text" class="form-control" id="txteditname" required placeholder="Enter your name" value="G Myatt" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtcompanyname">Company Name*</label>
                            <input type="text" class="form-control" id="txtcompanyname" required placeholder="Enter company name" value="Forest" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txteditemail">Email*</label>
                            <input type="text" class="form-control" id="txteditemail" required placeholder="Enter your email" value="gmyatt@gmail.com" disabled />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txteditmobilenumber">Mobile No*</label>
                            <input class="form-control" id="txteditmobilenumber" name="phone" type="tel" required placeholder="Enter your mobile number" value="1234567890" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txteditpassword">Password</label>
                            <input type="password" class="form-control" id="txteditpassword" placeholder="Enter password"/>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txteditconfirmpassword">Confirm Password</label>
                            <input type="password" class="form-control" id="txteditconfirmpassword" placeholder="Enter confirm password"/>
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
                            <label class="form-label" for="txteditcountry">Country*</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="txteditcountry" required>
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
                            <label class="form-label" for="txteditstate">State*</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="txteditstate" required>
                                <option value="" selected>Select State</option>
                                @foreach($states as $statelist)
                                <option value="{{ $statelist->id }}">
                                    {{ $statelist->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txteditcity">Town/City*</label>
                            <select class="form-select mb-3" aria-label="Default select example" id="txteditcity" required>
                                <option value="" selected>Select State</option>
                                @foreach($cities as $citieslist)
                                <option value="{{ $citieslist->id }}">
                                    {{ $citieslist->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txteditaddress">Address*</label>
                            <textarea class="form-control resize-none" id="txteditaddress" placeholder="Enter your address" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <input type="hidden" name="txtupdategarageownerid" id="txtupdategarageownerid"/>
                        <button type="submit" class="btn btn-primary" id="btnupdategarageownerdata">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Record and history offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarViewInformation" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">View Garage Owner</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="viewInformationBlock">
            <div class="garage-owner-img mb-3 d-flex justify-content-center">
                <img id="ownerprofileimage" src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="" class="avatar-lg radius-100">
            </div>
            <div class="table-responsive table-card bg-primary-subtle border-primary">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td class="fw-medium">Name</td>
                            <td id="ownername">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Email</td>
                            <td id="owneremail">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Mobile No</td>
                            <td id="ownermobile">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Date Of Birth</td>
                            <td id="ownerdob">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Gender</td>
                            <td id="ownergender">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Address</td>
                            <td id="owneraddress">&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
                <!--end table-->
            </div>
            <div class="raise-ticket-comment mt-4">
                <div class="card-header pb-2 mb-3">
                    <h4 class="card-title mb-0 flex-grow-1">More Info</h4>
                </div>
                <div class="more-info-details">
                    <div class="alert alert-warning text-center">
                        Not Available
                    </div>
                </div>
            </div>
            <div class="raise-ticket-comment mt-4">
                <div class="card-header pb-2 mb-3">
                    <h4 class="card-title mb-0 flex-grow-1">Current Plan</h4>
                </div>
                <div class="current-plan-list">
                    <ul>
                        <li>
                            <h6 class="mb-1 text-muted">Current Plan</h6>
                            <p class="card-text" id="ownercurrentplan">&nbsp;</p>
                        </li>
                        <li>
                            <h6 class="mb-1 text-muted">Connected PayPal</h6>
                            <p class="card-text" id="ownerconnectedpaypal">&nbsp;</p>
                        </li>
                        <li>
                            <h6 class="mb-1 text-muted">Expiry</h6>
                            <p class="card-text" id="ownerexpirydate">&nbsp;</p>
                        </li>
                    </ul>
                </div>
            </div>
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
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-file-chart-line"></i> <span>Sales Reports</span>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="removeNotificationModal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Remove Garage Owner Details</h5>
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
                    <input type="hidden" value="" id="txtdeleteownerid"/>
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="offcanvas">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection