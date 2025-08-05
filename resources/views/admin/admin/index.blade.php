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
                            <h4 class="mb-sm-0">Admin List</h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <button type="button" class="btn btn-success" data-bs-toggle="offcanvas" data-bs-target="#sidebarAddAdmin" aria-controls="offcanvasRight"><i class="ri-add-large-line"></i> Add Admin</button>
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
                        <h4 class="card-title mb-0 flex-grow-1">Admin List</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-block table-responsive">
                            <table id="adminAdminListingTable" class="table table-hover table-bordered w-100" data-route="{{ route('admin.data') }}">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile Number</th>
                                        <th>User Type</th>
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


<!-- Add Admin form offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarAddAdmin" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Add New Admin Details</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmnewadmindata" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Personal Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="filepond">Upload Profile Image*</label>
                            <div class="avatar-xl">
                                <input type="file" class="" name="filepond" accept="image/png, image/jpeg, image/gif" />
                                <!-- <input type="file" class="filepond filepond-input-circle" name="filepond" id="filepond" accept="image/png, image/jpeg, image/gif" /> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="newadminfullname">Name*</label>
                            <input type="text" class="form-control" name="newadminfullname" id="newadminfullname" required placeholder="Enter your name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="newadminemail">Email*</label>
                            <input type="email" class="form-control" name="newadminemail" id="newadminemail" required placeholder="Enter your email" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="newadminpassword">Password*</label>
                            <input type="password" class="form-control" name="newadminpassword" id="newadminpassword" required placeholder="Enter password"/>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="newadminconfirmpassword">Confirm Password*</label>
                            <input type="password" class="form-control" name="newadminconfirmpassword" id="newadminconfirmpassword" required placeholder="Enter confirm password"/>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="newadminphone">Mobile No*</label>
                            <input class="form-control" id="newadminphone" name="newadminphone" type="tel" required  placeholder="Enter your mobile number" />
                            <div id="error-msg-admin" class="hide"></div>
                            <div id="valid-msg-admin" class="hide"></div>
                            <button id="btn-admin" style="display:none;">Validate</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="newadminjoindate">Join Date</label>
                            <input type="text" class="form-control dateformat" name="newadminjoindate" data-provider="flatpickr" id="newadminjoindate" data-date-format="d.m.y" placeholder="Select date" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="newadminleftdate">Left Date</label>
                            <input type="text" class="form-control dateformat" name="newadminleftdate" id="newadminleftdate" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Select date" />
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
                            <label class="form-label" for="newadmineditcountry">Country*</label>
                            <select class="form-select mb-3 drpcountry" aria-label="Default select example" name="newadmineditcountry" id="newadmineditcountry" required>
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
                            <label class="form-label" for="newadmineditstate">State*</label>
                            <select class="form-select mb-3 drpstate" aria-label="Default select example" name="newadmineditstate" id="newadmineditstate" required>
                                <option value="" selected>Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="newadmineditcity">Town/City*</label>
                            <select class="form-select mb-3 drpcity" aria-label="Default select example" name="newadmineditcity" id="newadmineditcity" required>
                                <option value="" selected>Select City</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="newadminaddress">Address*</label>
                            <textarea class="form-control resize-none" id="newadminaddress" name="newadminaddress" placeholder="Enter your address" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnstorenewadmininfo">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Cancel</button>
                        <input type="hidden" name="newadminphonecode" id="newadminphonecode" value="1"/>
                        <input type="hidden" name="newadminphoneicocode" id="newadminphoneicocode" value="us"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Admin Details -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarUpdateAdmin" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Update Admin Details</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmupdateadmindata" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Personal Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="filepond">Upload Profile Image*</label>
                            <div class="avatar-xl">
                                <img src="" style="height: 90px; width: 75px; border: solid 1px thin;" id="profileimage" />
                                <input type="file" class="" name="editfilepond" accept="image/png, image/jpeg, image/gif" />
                                <!-- <input type="file" class="filepond filepond-input-circle" name="filepond" id="filepond" accept="image/png, image/jpeg, image/gif" /> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="updateadminfullname">Name*</label>
                            <input type="text" class="form-control" name="updateadminfullname" id="updateadminfullname" required placeholder="Enter your name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="updateadminemail">Email*</label>
                            <input type="email" class="form-control" name="updateadminemail" id="updateadminemail" required placeholder="Enter your email" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="updateadminpassword">Password*</label>
                            <input type="password" class="form-control" name="updateadminpassword" id="updateadminpassword" placeholder="Enter password"/>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="updateadminconfirmpassword">Confirm Password*</label>
                            <input type="password" class="form-control" name="updateadminconfirmpassword" id="updateadminconfirmpassword" placeholder="Enter confirm password"/>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="updateadminphone">Mobile No*</label>
                            <input class="form-control" id="updateadminphone" name="updateadminphone" type="tel" required  placeholder="Enter your mobile number" />
                            <div id="error-msg-admin-update" class="hide"></div>
                            <div id="valid-msg-admin-update" class="hide"></div>
                            <button id="btn-admin-update" style="display:none;">Validate</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="updateadminjoindate">Join Date</label>
                            <input type="text" class="form-control dateformat" name="updateadminjoindate" data-provider="flatpickr" id="updateadminjoindate" data-date-format="Y-m-d" placeholder="Select date" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="updateadminleftdate">Left Date</label>
                            <input type="text" class="form-control dateformat" name="updateadminleftdate" id="updateadminleftdate" data-provider="flatpickr" data-date-format="Y-m-d" placeholder="Select date" />
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
                            <label class="form-label" for="updateadmineditcountry">Country*</label>
                            <select class="form-select mb-3 drpcountry" aria-label="Default select example" name="updateadmineditcountry" id="updateadmineditcountry" required>
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
                            <label class="form-label" for="updateadmineditstate">State*</label>
                            <select class="form-select mb-3 drpstate" aria-label="Default select example" name="updateadmineditstate" id="updateadmineditstate" required>
                                <option value="" selected>Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="updateadmineditcity">Town/City*</label>
                            <select class="form-select mb-3 drpcity" aria-label="Default select example" name="updateadmineditcity" id="updateadmineditcity" required>
                                <option value="" selected>Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="updateadminaddress">Address*</label>
                            <textarea class="form-control resize-none" id="updateadminaddress" name="updateadminaddress" placeholder="Enter your address" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnupdateadmininfo">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Cancel</button>
                        <input type="hidden" name="updateadminid" id="updateadminid" value=""/>
                        <input type="hidden" name="updateadminphonecode" id="updateadminphonecode" value="1"/>
                        <input type="hidden" name="updateadminphoneicocode" id="updateadminphoneicocode" value="us"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Record and history offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarViewInformation" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">View Admin Details</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="viewInformationBlock">
            <div class="garage-owner-img mb-3 d-flex justify-content-center">
                <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="" class="avatar-lg radius-100" id="ownerprofileimage">
            </div>
            <div class="table-responsive table-card bg-primary-subtle border-primary">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td class="fw-medium">Name</td>
                            <td id="adminname">G Myatt</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Email</td>
                            <td id="adminemail">AvaniForest@mailinator.com</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Mobile No</td>
                            <td id="adminmobile">7990538895</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Join Date</td>
                            <td id="adminjoindate">01-01-1970</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Address</td>
                            <td id="adminaddress">403, Gujarat Ahmedabad, Canada.</td>
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="removeAdminNotificationModal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Remove Admin User Details</h5>
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
                    <input type="hidden" value="" id="txtdeleteadminid"/>
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="offcanvas">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-admin-notification">Yes, Delete It!</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection