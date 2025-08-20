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
                            <h4 class="mb-sm-0 d-flex align-items-center gap-2"><a href="{{ url()->previous() }}" class="btn btn-soft-primary btn-icon shadow-none"><i class="ri-arrow-left-line"></i></a> View Details - <span class="fs-14 fw-normal">({{ $clientDetails->name }})</span></h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <button type="button" class="btn btn-success btn-select2" data-bs-toggle="offcanvas" data-bs-target="#sidebarNewClient" aria-controls="offcanvasRight"><i class="ri-add-large-line"></i> New Client</button>
                                </div>
                                <div class="page-title-action-item">
                                    <button type="button" class="btn btn-primary btn-select2" data-bs-toggle="offcanvas" data-bs-target="#sidebarNewBooking" aria-controls="offcanvasRight"><i class="ri-add-large-line"></i> New Booking</button>
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
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card custom-height-100-24">
                    <div class="card-header align-items-center d-flex">
                        <img src="{{ asset('assets/images/carfax-logo.png') }}" alt="" width="100" />
                    </div>
                    <div class="card-body flex-grow-0">
                        <div class="car-card-info bg-light p-3 radius-10">
                            <div class="car-card-action-info d-flex flex-wrap align-items-center gap-2">
                                <a href="#" class="btn btn-sm btn-soft-dark shadow-none">Vehicle Spec</a>
                                <a href="#" class="btn btn-sm btn-soft-dark shadow-none">Service History</a>
                                <a href="#" class="btn btn-sm btn-soft-dark shadow-none" data-bs-toggle="offcanvas" data-bs-target="#sidebarPayment" aria-controls="offcanvasRight">New Payment</a>
                            </div>
                        </div>
                    </div><!-- end card-body -->

                    <div class="card-header align-items-center d-flex pt-0">
                        <img src="{{ asset('assets/images/carmd-dark-logo.png') }}" alt="" width="90" />
                    </div>
                    <div class="card-body flex-grow-0">
                        <div class="car-card-info bg-light p-3 radius-10">
                            <div class="car-card-action-info d-flex flex-wrap align-items-center gap-2">
                                <a href="#" class="btn btn-sm btn-soft-dark shadow-none">Vehicle Warranty</a>
                                <a href="#" class="btn btn-sm btn-soft-dark shadow-none">Sefty Recalls</a>
                                <a href="#" class="btn btn-sm btn-soft-dark shadow-none">SB</a>
                                <a href="#" class="btn btn-sm btn-soft-dark shadow-none">Upcoming Repairs</a>
                                <a href="#" class="btn btn-sm btn-soft-dark shadow-none">Smart OBD-II</a>
                            </div>
                        </div>
                    </div><!-- end card-body -->  
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-12 col-md-6 col-lg-8">
                <div class="card custom-height-100-24">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Client Details</h4>
                        <div class="card-header-action-block d-flex flex-wrap gap-2">
                            <div class="formgroup select-vehicle-dropdown">
                                <select class="common-single-select" name="vehicle" id="vehiclelisting">
                                    @foreach ($vehicleList as $vehicle_lists )
                                        <option value="{{ $vehicle_lists->id }}###{{ $vehicleClientDetails->id }}">{{ $vehicle_lists->modelbrand. " " .$vehicle_lists->modelyear }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <a href="#" class="btn btn-soft-success shadow-none"><i class="ri-add-large-line"></i> Add Another Vehicle</a>
                        </div>
                    </div>
                    <div class="card-body" id="clientvehicledetailcontainer">
                        <div class="am-info-list-block">
                            <ul class="am-info-list">
                                <li class="am-info-item">
                                    <span class="info-list-title">Selected Vehicle</span>
                                    <span class="info-list-value clientvehicleselecedvehicle">{{ $vehicleClientDetails->modelbrand ?? "N/A" }} {{ $vehicleClientDetails->modelyear }}</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">Licence Plate</span>
                                    <span class="info-list-value clientvehiclelicenceplate">{{ $vehicleClientDetails->number_plate ?? "N/A" }}</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">VIN</span>
                                    <span class="info-list-value clientvehiclevin">{{ $vehicleClientDetails->vin ?? "N/A" }}</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">Client ID</span>
                                    <span class="info-list-value clientvehicleclientid">{{ $vehicleClientDetails->id ?? "N/A" }}</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">Name</span>
                                    <span class="info-list-value clientvehicleclientname">{{ $vehicleClientDetails->name ?? "N/A" }}</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">Make</span>
                                    <span class="info-list-value clientvehiclemake">{{ $vehicleClientDetails->modelbrand ?? "N/A" }}</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">Model</span>
                                    <span class="info-list-value clientvehiclemodel">{{ $vehicleClientDetails->modelname ?? "N/A" }}</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">Year</span>
                                    <span class="info-list-value clientvehicleyear">{{ $vehicleClientDetails->modelyear ?? "N/A" }}</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">Phone</span>
                                    <span class="info-list-value clientvehiclephone">N/A</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">Mobile</span>
                                    <span class="info-list-value clientvehiclemobile">+{{ $vehicleClientDetails->countrycode }} {{ $vehicleClientDetails->mobilenumber ?? "N/A" }}</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">Address</span>
                                    <span class="info-list-value clientvehicleaddress">{{ $vehicleClientDetails->address ?? "N/A" }}</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">Email</span>
                                    <span class="info-list-value clientvehicleemail">{{ $vehicleClientDetails->email ?? "N/A" }}</span>
                                </li>
                                <li class="am-info-item">
                                    <span class="info-list-title">CARMD/CARFAX</span>
                                    <span class="info-list-value"><a href="#" class="link-primary link-offset-2 text-decoration-underline link-underline-opacity-25 link-underline-opacity-100-hover">SERVICE HISTORY REPORT</a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

        <!-- start row -->
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Notes & Reminders</h4>
                            </div>
                            <div class="card-body custom-height-100-53">
                                <div class="card-details-widget h-100 bg-light p-3 radius-10">
                                    <form class="form-fields-block">
                                        <div class="formgroup mb-3">
                                            <textarea class="form-control resize-none" rows="5" placeholder="Enter notes & reminders"></textarea>
                                        </div>
                                        <div class="form-action-block">
                                            <div class="form-action-btn">
                                                <button type="button" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Car Details</h4>
                            </div>
                            <div class="card-body custom-height-100-53">
                                <div class="card-details-widget h-100 bg-light p-3 radius-10">
                                    <form class="form-fields-block">
                                        <div class="d-flex gap-2">
                                            <div class="formgroup mb-3">
                                                <label class="form-label" for="validationCustom05">Mileage</label>
                                                <input type="text" class="form-control" id="validationCustom05" required="" placeholder="Enter mileage">
                                                <div class="invalid-feedback">
                                                    You must agree before submitting.
                                                </div>
                                            </div>
                                            <div class="formgroup mb-3">
                                                <label class="form-label" for="validationCustom05">Last service</label>
                                                <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Select model year" />
                                                <div class="invalid-feedback">
                                                    You must agree before submitting.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-action-block">
                                            <div class="form-action-btn">
                                                <button type="button" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Service Reminders</h4>
                            </div>
                            <div class="card-body custom-height-100-53">
                                <div class="card-details-widget h-100 bg-light p-3 radius-10">
                                    <form class="form-fields-block">
                                        <div class="d-flex gap-2">
                                            <div class="formgroup mb-3">
                                                <label class="form-label" for="validationCustom05">Last reminder date</label>
                                                <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Select last remider date" />
                                                <div class="invalid-feedback">
                                                    You must agree before submitting.
                                                </div>
                                            </div>
                                            <div class="formgroup mb-3">
                                                <label class="form-label" for="validationCustom05">Next reminder date</label>
                                                <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Select next reminder date" />
                                                <div class="invalid-feedback">
                                                    You must agree before submitting.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="formgroup mb-3">
                                            <label class="form-label" for="validationCustom05">Frequency</label>
                                            <select class="form-select mb-3" aria-label="Default select example">
                                                <option selected="">Select Frequency</option>
                                                <option value="1">Every 3 Months</option>
                                                <option value="2">Every 6 Months</option>
                                                <option value="2">Every 9 Months</option>
                                                <option value="2">Every 12 Months</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                You must agree before submitting.
                                            </div>
                                        </div>
                                        <div class="form-action-block align-items-center justify-content-between">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="send-remiders" checked="">
                                                <label class="form-check-label" for="send-remiders">Send reminders</label>
                                            </div>
                                            <div class="form-action-btn">
                                                <button type="button" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end row -->

        <!-- start row -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card custom-height-100-24">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Booking Details</h4>
                        <div class="card-header-action-block d-flex flex-wrap gap-2">
                            <a href="#" class="btn btn-sm btn-soft-success shadow-none"><i class="ri-add-large-line"></i> New Booking</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning text-center">
                            No Booking Available
                        </div>
                        <!-- <div class="booking-details-info table-block table-responsive">
                            <table class="table table-hover table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Booking scheduled</td>
                                        <td>12-28-2024 21:50:00</td>
                                        <td>Full Service.</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none" title="Edit"><i class="ri-edit-line"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Previous bookings</td>
                                        <td>12-19-2024 09:10:00</td>
                                        <td>Full Service.</td>
                                        <td>-</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card custom-height-100-24">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Repair Orders</h4>
                    </div>
                    <div class="card-body">                        
                        @if( count($repairOrderData) > 0 )
                            <div class="booking-details-info table-block table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <th>RO</th>
                                        <th>Date</th>
                                        <th>Employee</th>
                                        <th>Clock In</th>
                                        <th>Clock Out</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ( $repairOrderData as $repairOrderData_list )
                                            <tr>
                                                <td>
                                                    <a href="javascript:void(0)" class="link-primary link-offset-2">{{ $repairOrderData_list->repairorder_order_no }}</a>
                                                </td>
                                                <td>{{ $repairOrderData_list->repairorder_order_date }}</td>
                                                <td>{{ $repairOrderData_list->repairorder_garage_employee }}</td>
                                                <td>
                                                    <span class="text-success">1</span>
                                                </td>
                                                <td>
                                                    <span class="text-danger">2</span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none" title="Edit"><i class="ri-edit-line"></i></button>
                                                    <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Delete"><i class="ri-delete-bin-6-line"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach                                            
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning text-center">
                                No Repair Orders Available
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card custom-height-100-24">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Outstanding Invoices</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning text-center">
                            No Outstanding Invoice History
                        </div>
                        <!-- <div class="booking-details-info table-block table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <th>Invoice</th>
                                    <th>Date</th>
                                    <th>Due Amount</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="#" class="link-primary link-offset-2">112233</a>
                                        </td>
                                        <td>12-19-2024</td>
                                        <td>$400.00</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-primary btn-border btn-icon shadow-none" title="View Invoice" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewInvoice" aria-controls="offcanvasRight"><i class="ri-file-pdf-2-line"></i></button>
                                            <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none" title="Edit"><i class="ri-edit-line"></i></button>
                                            <button type="button" class="btn btn-soft-warning btn-border btn-icon shadow-none btn-select2" title="Pay" data-bs-toggle="offcanvas" data-bs-target="#sidebarPayment" aria-controls="offcanvasRight"><i class="ri-secure-payment-line"></i></button>
                                            <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Delete"><i class="ri-delete-bin-6-line"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Total Due:</td>
                                        <td colspan="2">$400.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card custom-height-100-24">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Transaction & Invoice History</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning text-center">
                            No transaction & Invoice History
                        </div>
                        <!-- <div class="booking-details-info table-block table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <th>Transaction</th>
                                    <th>Invoice</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Invoice</td>
                                        <td><a href="#" class="link-primary link-offset-2">2233</a></td>
                                        <td>12-19-2024</td>
                                        <td>$200.00</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-primary btn-border btn-icon shadow-none" title="View Invoice" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewInvoice" aria-controls="offcanvasRight"><i class="ri-file-pdf-2-line"></i></button>
                                            <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Delete"><i class="ri-delete-bin-6-line"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Invoice</td>
                                        <td><a href="#" class="link-primary link-offset-2">2233</a></td>
                                        <td>12-19-2024</td>
                                        <td>$200.00</td>
                                        <td>
                                            <button type="button" class="btn btn-soft-primary btn-border btn-icon shadow-none" title="View Invoice" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewInvoice" aria-controls="offcanvasRight"><i class="ri-file-pdf-2-line"></i></button>
                                            <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Delete"><i class="ri-delete-bin-6-line"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3">Account Balance:</td>
                                        <td colspan="2">$700.00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div> -->
                    </div>
                </div>
            </div>
        </div><!-- end row -->
    </div>
    <!-- container-fluid -->
</div>

<!-- New Client offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarNewClient" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Add New Client</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Personal Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Name*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter your name" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Email*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter your email" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Mobile No*</label>
                            <input class="form-control" id="phone" name="phone" type="tel" value="" placeholder="Enter your mobile number" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Landline No</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter your landline number" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Address*</label>
                            <textarea class="form-control resize-none" id="validationCustom05" placeholder="Enter your address"></textarea>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Vehicle Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">VIN*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter VIN number" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Licence Plate*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter registration number" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Make*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter model brand" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Model*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter model name" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Year*</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Select model year" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Last Service</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Select last service" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="button" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- New Booking offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarNewBooking" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">New Booking</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label">Vehicle*</label>
                            <select class="common-select2" name="vehicle">
                                <option>Select vehicle</option>
                                <option value="">Cadilac DeVille (John Doe)</option>
                                <option value="">Cadilac DeVille (John Doe)</option>
                                <option value="">Cadilac DeVille (John Doe)</option>
                                <option value="">Cadilac DeVille (John Doe)</option>
                                <option value="">Cadilac DeVille (John Doe)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Client*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter client" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Date & Time*</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" data-enable-time placeholder="Enter date" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label">Details*</label>
                            <input type="text" class="form-control" placeholder="Enter details" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="service" checked />
                            <label class="form-check-label" for="service">Service</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label">Covid Safe Notification Template</label>
                            <textarea class="form-control resize-none" placeholder="Enter covid safe notification template"></textarea>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="button" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Invoice details offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarViewInvoice" aria-labelledby="offcanvasRightLabel">
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
                                    <img src="{{ asset('') }}assets/images/logo-dark.png" class="card-logo card-logo-dark" alt="logo dark" height="30">
                                    <img src="{{ asset('') }}assets/images/logo-light.png" class="card-logo card-logo-light" alt="logo light" height="30">
                                </div>
                                <div class="flex-shrink-0 mt-sm-0 mt-3">
                                    <h6><span>John Doe Corporation</span></h6>
                                    <h6><span class="text-muted fw-normal">Date:</span><span id="contact-no">06-12-2022</span></h6>
                                </div>
                            </div>
                        </div>
                        <!--end card-header-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-3 ps-0 pe-0 border-top border-top-dashed">
                            <div class="row g-3">
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Address Details</h6>
                                    <p class="text-muted mb-1" id="billing-address-line-1">General Palace, Comman Street, VA</p>
                                    <p class="text-muted mb-1" id="billing-address-line-1">support.jdc@mailinator.com</p>
                                    <p class="text-muted mb-1" id="billing-address-line-1">(859)-678-9645</p>
                                </div>
                                <!--end col-->
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Contact Info</h6>
                                    <p class="text-muted mb-1"><span>Name: </span><span id="shipping-phone-no">Chirag Kanjariya</span></p>
                                    <p class="text-muted mb-0"><span>Address: </span><span id="address">General Palace, Comman Street, VA</span> </p>
                                    <p class="text-muted mb-0"><span>Contact: </span><span id="contact">9825409350</span> </p>
                                    <p class="text-muted mb-0"><span>Email: </span><span id="email">chiragkanjariya14@gmail.com</span> </p>
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
                                <table class="table table-borderless table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr class="table-active">
                                            <th scope="col">Vehicle Name</th>
                                            <th scope="col">Reg. No.</th>
                                            <th scope="col">VIN</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-list">
                                        <tr>
                                            <td>Ferrari Ferrari</td>
                                            <td>CHJK247</td>
                                            <td>AEPLK123456789123</td>
                                        </tr>
                                    </tbody>
                                </table><!--end table-->
                            </div>
                            <div class="card-header align-items-center d-flex px-0 my-3">
                                <h4 class="card-title mb-0 flex-grow-1">Parts</h4>
                            </div>
                            <div class="table-block table-responsive">
                                <table class="table table-borderless table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr class="table-active">
                                            <th scope="col">#</th>
                                            <th scope="col">Part</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Cost</th>
                                            <th scope="col">Markup</th>
                                            <th scope="col">Tax</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-list">
                                        <tr>
                                            <td>01</td>
                                            <td>Oil Filter</td>
                                            <td>01</td>
                                            <td>50.00</td>
                                            <td>1.00</td>
                                            <td>10.00</td>
                                            <td>55.55</td>
                                        </tr>
                                        <tr>
                                            <td>02</td>
                                            <td>Oil</td>
                                            <td>01</td>
                                            <td>100.00</td>
                                            <td>2.00</td>
                                            <td>20.00</td>
                                            <td>200.55</td>
                                        </tr>
                                    </tbody>
                                </table><!--end table-->
                            </div>

                            <div class="card-header align-items-center d-flex px-0 my-3">
                                <h4 class="card-title mb-0 flex-grow-1">Labor</h4>
                            </div>
                            <div class="table-block table-responsive">
                                <table class="table table-borderless table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr class="table-active">
                                            <th scope="col">#</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Rate</th>
                                            <th scope="col">Hours</th>
                                            <th scope="col">Cost</th>
                                            <th scope="col">Tax</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-list">
                                        <tr>
                                            <td>01</td>
                                            <td>Jon</td>
                                            <td>40</td>
                                            <td>20</td>
                                            <td>1000</td>
                                            <td>10</td>
                                            <td>1100</td>
                                        </tr>
                                    </tbody>
                                </table><!--end table-->
                            </div>
                            <div class="border-top border-top-dashed mt-2">
                                <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                    <tbody>
                                        <tr>
                                            <td>Total Labor</td>
                                            <td class="text-end">$1000.00</td>
                                        </tr>
                                        <tr>
                                            <td>Total Parts</td>
                                            <td class="text-end">$55.55</td>
                                        </tr>
                                        <tr>
                                            <td>Tax%</td>
                                            <td class="text-end">$105.05</td>
                                        </tr>
                                        <tr class="border-top border-top-dashed fs-15">
                                            <th scope="row">Total</th>
                                            <th class="text-end">$1160.60</th>
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
            <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                <a href="javascript:;" class="btn btn-info"><i class="ri-file-pdf-2-line"></i> Print</a>
                <a href="javascript:;" class="btn btn-primary"><i class="ri-file-download-line"></i> Download</a>
                <a href="javascript:;" class="btn btn-danger">Close</a>
            </div>
        </div>
    </div>
</div>

<!-- Payment offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarPayment" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Payment</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Invoice Number*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter invoice number" value="0033" disabled />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Payment Number*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter payment number" value="P370415" disabled />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Payment Date*</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Enter date" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Amount Due($)*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter amount due" value="460.60" disabled />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Payment Type*</label>
                            <select class="form-select" aria-label="Select payment type">
                                <option selected="">Select payment type </option>
                                <option value="1">PayPal</option>
                                <option value="2">Cash</option>
                                <option value="3">Card</option>
                            </select>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Amount Received($)*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter amount" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Last Service Date</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Enter date" value="2024-11-10" disabled />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Next Service Date</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Enter date" value="2025-11-10" disabled />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Frequency*</label>
                            <select class="form-select" aria-label="Select frequency to next service date">
                                <option selected="">Select frequency to next service date </option>
                                <option value="1">Every 3 Months</option>
                                <option value="2">Every 6 Months</option>
                                <option value="3">Every 9 Months</option>
                                <option value="4">Every 12 Months</option>
                            </select>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="button" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@include('layouts.explore')

@endsection