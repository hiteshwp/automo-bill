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
                            <h4 class="mb-sm-0 d-flex align-items-center gap-2"><a href="{{ url()->previous() }}" class="btn btn-soft-primary btn-icon shadow-none"><i class="ri-arrow-left-line"></i></a> Vehicle List - <span class="fs-14 fw-normal">({{ $client_details->name }})</span></h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <button type="button" class="btn btn-success btn-select2" data-bs-toggle="offcanvas" data-bs-target="#sidebarNewVehicle" aria-controls="offcanvasRight"><i class="ri-add-large-line"></i> New Vehicle</button>
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
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-block table-responsive">
                        <table id="garageOwnersVehicleTable" class="table table-hover table-bordered w-100" data-route="{{ route('garage-owner.clients.vehicles.data') }}" data-customerid="{{ $client_details->id }}">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Vin</th>
                                    <th>Number Plate</th>
                                    <th>Model Year</th>
                                    <th>Model Name</th>
                                    <th>Model Brand</th>
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

<!-- New Vehicle offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarNewVehicle" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Add New Vehicle Information</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">  
            <form class="form-fields-block needs-validation" id="frmaddnewvehicleinformation" method="post">          
                <div class="row mt-3">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="vindetails">VIN*</label>
                            <input type="text" class="form-control" id="vehiclevindetails" name="vindetails" required placeholder="Enter VIN number" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="vehiclelicenceplate">Licence Plate*</label>
                            <input type="text" class="form-control" id="vehiclelicenceplate" name="vehiclelicenceplate" required placeholder="Enter registration number" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="vehiclemake">Make*</label>
                            <input type="text" class="form-control" id="vehiclemake" name="vehiclemake" required placeholder="Enter model brand" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="vehiclemodel">Model*</label>
                            <input type="text" class="form-control" id="vehiclemodel" name="vehiclemodel" required placeholder="Enter model name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="vehiclemakeyear">Year*</label>
                            <select name="vehiclemakeyear" id="vehiclemakeyear" required class="form-control">
                                <option value="">Select Year</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="vehiclelastservicedate">Last Service</label>
                            <input type="text" class="form-control dateformat" id="vehiclelastservicedate" name="vehiclelastservicedate"  required placeholder="Select last service" />
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnnewvehicledetail">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <input type="hidden" name="vehiclecustomerid" id="vehiclecustomerid" value="{{ $client_details->id }}"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Vehicle Offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarEditVehicle" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Update Vehicle Information</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">  
            <form class="form-fields-block needs-validation" id="frmeditvehicleinformation" method="post">          
                <div class="row mt-3">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatevehiclevindetails">VIN*</label>
                            <input type="text" class="form-control" id="txtupdatevehiclevindetails" name="txtupdatevehiclevindetails" required placeholder="Enter VIN number" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatevehiclelicenceplate">Licence Plate*</label>
                            <input type="text" class="form-control" id="txtupdatevehiclelicenceplate" name="txtupdatevehiclelicenceplate" required placeholder="Enter registration number" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatevehiclemake">Make*</label>
                            <input type="text" class="form-control" id="txtupdatevehiclemake" name="txtupdatevehiclemake" required placeholder="Enter model brand" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatevehiclemodel">Model*</label>
                            <input type="text" class="form-control" id="txtupdatevehiclemodel" name="txtupdatevehiclemodel" required placeholder="Enter model name" />
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatevehiclemakeyear">Year*</label>
                            <select name="txtupdatevehiclemakeyear" id="txtupdatevehiclemakeyear" required class="form-control">
                                <option value="">Select Year</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="txtupdatevehiclelastservicedate">Last Service</label>
                            <input type="text" class="form-control dateformat" id="txtupdatevehiclelastservicedate" name="txtupdatevehiclelastservicedate"  required placeholder="Select last service" />
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnupdatevehicledetail">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <input type="hidden" name="txtupdatevehicleid" id="txtupdatevehicleid" value=""/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- removeNotificationModal -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="removeVechicleNotificationModal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Remove Vehicle Details</h5>
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
                    <input type="hidden" value="" id="txtdeletevehicleid"/>
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="offcanvas">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-vehicle-notification">Yes, Delete It!</button>
                </form>
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
@endsection