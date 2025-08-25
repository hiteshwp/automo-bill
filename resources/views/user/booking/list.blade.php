@extends('layouts.app')

@section('title', 'My Booking List | '.config('app.name', 'Laravel'))

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-title-box p-0 d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">My Booking</h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <button type="button" class="btn btn-primary btn-select2" data-bs-toggle="offcanvas" data-bs-target="#sidebarNewBooking" aria-controls="offcanvasRight"><i class="ri-add-large-line"></i> Add Booking</button>
                                </div>
                                <!-- <div class="page-title-action-item">
                                    <button type="button" class="btn btn-light" data-bs-toggle="offcanvas" data-bs-target="#sidebarExplore" aria-controls="offcanvasRight"><i class="ri-indent-decrease"></i> Explore</button>
                                </div> -->
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
                        <h4 class="card-title mb-0 flex-grow-1">My Booking List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-block table-responsive">
                            <table id="userBookingTable" class="table table-hover table-bordered w-100" data-route="{{ route('user.booking.data') }}">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Appointment Date/Time</th>
                                        <th>Garage Owner</th>
                                        <th>Licence Plate</th>
                                        <th>Details</th>
                                        <th>Booking Type</th>
                                        <th>Service</th>
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

<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarNewBooking" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">New Booking</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmclientnewbookinginformation" method="post">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label">Vehicle*</label>
                            <select class="common-select2" name="txtbookingclientvehicle" id="txtbookingclientvehicle" required>
                                <option value="" data-customerid="">Select Vehicle</option>
                                @foreach($vehicle_list as $vehiclelist)
                                <option value="{{ $vehiclelist->id }}" data-customerid={{ $vehiclelist->customer_id }}>
                                    {{ $vehiclelist->modelbrand }} {{ $vehiclelist->modelname }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Garage Owner*</label>
                            <select class="common-select2" name="txtbookinggarageowner" id="txtbookinggarageowner" required>
                                <option value="" data-customerid="">Select Garage Owner</option>
                                @foreach($garageOwnerList as $garageOwnerLists)
                                <option value="{{ $garageOwnerLists->id }}" data-garageownerid={{ $garageOwnerLists->id }}>
                                    {{ $garageOwnerLists->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Date & Time*</label>
                            <input type="text" class="form-control datetimeformat" id="ttxtbookingdatetime" name="ttxtbookingdatetime" data-provider="flatpickr" data-date-format="d.m.y" data-enable-time placeholder="Enter date" readonly required />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label">Details*</label>
                            <input type="text" class="form-control" id="txtbookingdetails" name="txtbookingdetails" placeholder="Enter details" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="txtbookingservice" name="txtbookingservice" />
                            <label class="form-check-label" for="service">Service</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="txtbookingcovidsafe" name="txtbookingcovidsafe" />
                            <label class="form-check-label" for="service">Covid Safe Booking</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label">Covid Safe Notification Template</label>
                            <textarea class="form-control resize-none txtcovidsafenotificationtemplate" required id="txtcovidsafenotificationtemplate" name="txtcovidsafenotificationtemplate" placeholder="Enter covid safe notification template" rows="10" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnclientnewbooking">Submit</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <input type="hidden" name="txtbookingclientname" id="txtbookingclientname" value="{{ $clientData["client_name"] }}"/>
                        <input type="hidden" name="txtbookinguserid" id="txtbookinguserid" value="{{ $clientData["client_id"] }}"/>
                        <input type="hidden" name="txtbookingdate" id="txtbookingdate" value=""/>
                        <input type="hidden" name="txtbookingtime" id="txtbookingtime" value=""/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarEditBooking" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Update Booking</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation" id="frmupdateclientbookinginformation" method="post">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label">Vehicle*</label>
                            <select class="common-select2" name="txtupdateclientbookingvehicle" id="txtupdateclientbookingvehicle" required>
                                <option value="" data-customerid="">Select Vehicle</option>
                                @foreach($vehicle_list as $vehiclelist)
                                <option value="{{ $vehiclelist->id }}" data-customerid={{ $vehiclelist->customer_id }}>
                                    {{ $vehiclelist->modelbrand }} {{ $vehiclelist->modelname }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Garage Owner*</label>
                            <select class="common-select2" name="txtbookingclientgarageowner" id="txtbookingclientgarageowner" required>
                                <option value="" data-customerid="">Select Garage Owner</option>
                                @foreach($garageOwnerList as $garageOwnerLists)
                                <option value="{{ $garageOwnerLists->id }}" data-garageownerid={{ $garageOwnerLists->id }}>
                                    {{ $garageOwnerLists->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Date & Time*</label>
                            <input type="text" class="form-control datetimeformat" id="ttxtupdateclientbookingdatetime" name="ttxtupdatebookingdatetime" data-provider="flatpickr" data-date-format="d.m.y" data-enable-time placeholder="Enter date" readonly required />
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label">Details*</label>
                            <input type="text" class="form-control" id="txtupdatebookingdetails" name="txtupdatebookingdetails" placeholder="Enter details" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="txtupdatebookingservice" name="txtupdatebookingservice" />
                            <label class="form-check-label" for="service">Service</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="txtupdatebookingcovidsafe" name="txtupdatebookingcovidsafe" />
                            <label class="form-check-label" for="service">Covid Safe Booking</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label">Covid Safe Notification Template</label>
                            <textarea class="form-control resize-none txtupdatecovidsafenotificationtemplate" required id="txtupdatecovidsafenotificationtemplate" name="txtupdatecovidsafenotificationtemplate" placeholder="Enter covid safe notification template" rows="10" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="submit" class="btn btn-primary" id="btnupdateclientbooking">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                        <input type="hidden" name="txtupdatebookinguserid" id="txtupdatebookinguserid" value=""/>
                        <input type="hidden" name="txtupdatebookingdate" id="txtupdatebookingdate" value=""/>
                        <input type="hidden" name="txtupdatebookingtime" id="txtupdatebookingtime" value=""/>
                        <input type="hidden" name="txtupdatebookingid" id="txtupdatebookingid" value=""/>
                        <input type="hidden" name="txtupdatebookingclientname" id="txtupdatebookingclientname" value="{{ $clientData["client_name"] }}"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="removeClientbookingNotificationModal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Archive Booking Details</h5>
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
                    <input type="hidden" value="" id="txtarchivebookingid"/>
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="offcanvas">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="archive-booking-notification">Yes, Archive It!</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="covertNormalBookingNotificationModal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Convert to Normal Booking</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="viewInformationBlock">
            <div class="mt-2 text-center">
                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                    <h4>Are you sure ?</h4>
                    <p class="text-muted mx-4 mb-0">Are you sure you want to Convert this Booking to Normal Booking?</p>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                <form method="post">
                    <input type="hidden" value="" id="txtbookingid"/>
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="offcanvas">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="convert-normal-booking-notification">Yes, Convert It!</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- right offcanvas -->
@include('layouts.explore')

@endsection