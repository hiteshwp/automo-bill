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
                            <h4 class="mb-sm-0 d-flex align-items-center gap-2"><a href="{{ route('garage-owner.estimate.list') }}" class="btn btn-soft-primary btn-icon shadow-none"><i class="ri-arrow-left-line"></i></a> Add Repair Order - <span class="fs-14 fw-normal">({{ $estimate_data->client_name }})</span></h4>
                            <div class="page-title-action-list d-flex gap-2">
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
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card" id="demo">
                    <div class="card-body">
                        <form method="post" id="frmnewrepairorderinformation">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-8 col-lg-9">
                                    <div class="card-header border-bottom-dashed py-4 px-0">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <img src="{{ asset('assets/images/logo-dark.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="40">
                                                <img src="{{ asset('assets/images/logo-light.png') }}" class="card-logo card-logo-light" alt="logo light" height="40">
                                            </div>
                                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                                <h6><span>John Doe Corporation</span></h6>
                                                <h6><span>Man Machine Works</span></h6>
                                                <h6><span class="text-muted fw-normal">Address:</span> <span id="address"> General Palace, Comman Street, VA</span></h6>
                                                <h6><span class="text-muted fw-normal">Phone:</span> <span id="contact-no"> (859)-678-9645</span></h6>
                                                <h6><span class="text-muted fw-normal">Email:</span> <span id="email">support.jdc@mailinator.com</span></h6>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="invoice-user-info-list py-4">
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Client ID</p>
                                            <h5 class="fs-14 mb-0"><span id="address">{{ $estimate_data->estimate_customer_id }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Name</p>
                                            <h5 class="fs-14 mb-0"><span id="name">{{ $estimate_data->client_name }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Address</p>
                                            <h5 class="fs-14 mb-0"><span id="address">{{ $estimate_data->client_address }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">VIN</p>
                                            <h5 class="fs-14 mb-0"><span id="vin">{{ $estimate_data->vin }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Vehicle</p>
                                            <h5 class="fs-14 mb-0"><span id="vehicle">{{ $estimate_data->vehicle }}</span></h5>
                                        </div>
                                    </div>

                                    <div class="invoice-employee-info-list mt-3">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="card-header p-0 pb-2 mb-3">
                                                    <h4 class="card-title mb-0 flex-grow-1">Employee Information</h4>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                <div class="formgroup mb-3">
                                                    <label class="form-label" for="validationCustom05">Employee Name*</label>
                                                    <input type="text" class="form-control" id="validationCustom05" required="" placeholder="Enter employee name" name="txtemployeename">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                <div class="formgroup mb-3">
                                                    <label class="form-label" for="validationCustom05">Employee Email*</label>
                                                    <input type="text" class="form-control" id="validationCustom05" required="" placeholder="Enter employee email" name="txtemployeeemail">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                <div class="formgroup mb-3">
                                                    <label class="form-label" for="validationCustom05">Employee Phone*</label>
                                                    <input type="text" class="form-control" id="validationCustom05" required="" placeholder="Enter employee phone" name="txtemployeephone">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                                                <div class="formgroup mb-3">
                                                    <label class="form-label" for="validationCustom05">Date*</label>
                                                    <input type="text" class="form-control" data-provider="flatpickr" required="" data-date-format="Y-m-d" placeholder="Enter date" name="txtrepairorderdate"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="invoice-form-block">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="invoice-form">
                                                    <div class="card-header align-items-center d-flex border-top border-top-dashed border-bottom-0 px-0">
                                                        <h4 class="card-title mb-0 flex-grow-1">Repair Order Parts</h4>
                                                    </div>
                                                    <div class="table-block table-responsive">
                                                        <table class="invoice-table table table-borderless table-nowrap mb-0">
                                                            <thead class="align-middle">
                                                                <tr class="table-active">
                                                                    <th scope="col">Item</th>
                                                                    <th scope="col" style="width: 150px;">Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($product_data as $product_data_list)
                                                                <tr class="product">
                                                                    <td>
                                                                        <div class="formgroup">
                                                                            <input type="text" class="form-control" value="{{ $product_data_list->product_name }}" readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="formgroup">
                                                                            <input type="text" class="form-control" value="{{ $product_data_list->estimate_parts_quantity }}" readonly>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endforeach                                                            
                                                            </tbody>
                                                        </table>
                                                        <!--end table-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="invoice-form">
                                                    <div class="card-header align-items-center d-flex border-top border-top-dashed border-bottom-0 px-0">
                                                        <h4 class="card-title mb-0 flex-grow-1">Labour</h4>
                                                    </div>
                                                    <div class="table-block table-responsive">
                                                        <table class="invoice-table table table-borderless table-nowrap mb-0">
                                                            <thead class="align-middle">
                                                                <tr class="table-active">
                                                                    <th scope="col">Labour/Other</th>
                                                                    <th scope="col" style="width: 150px;">Time</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($labour_data as $labour_data_list)
                                                                <tr class="product">
                                                                    <td>
                                                                        <div class="formgroup">
                                                                            <input type="text" class="form-control" value="{{ $labour_data_list->estimate_labor_item }}" readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="formgroup">
                                                                            <input type="text" class="form-control" value="{{ $labour_data_list->estimate_labor_hours }}" readonly>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                                <!-- <tr class="product">
                                                                    <td>
                                                                        <div class="formgroup">
                                                                            <input type="text" class="form-control" value="Test" readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="formgroup">
                                                                            <input type="text" class="form-control" value="10" readonly>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="formgroup">
                                                                            <input type="text" class="form-control" value="15" readonly>
                                                                        </div>
                                                                    </td>
                                                                </tr> -->
                                                            </tbody>
                                                        </table>
                                                        <!--end table-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="invoice-note-block mt-3 row">
                                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="formgroup mb-3">
                                                            <label class="form-label" for="validationCustom05">Total Time*</label>
                                                            <input type="text" class="form-control" id="validationCustom05" value="{{ $total_hours }}" required="" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                        <div class="formgroup mb-3">
                                                            <label class="form-label" for="validationCustom05">Actual Time*</label>
                                                            <input type="text" class="form-control" id="validationCustom05" required="" value="{{ $total_hours }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12">
                                                        <div class="formgroup">
                                                            <div class="card-header align-items-center d-flex border-top border-top-dashed border-bottom-0 px-0">
                                                                <h4 class="card-title mb-0 flex-grow-1">Extra Notes</h4>
                                                            </div>
                                                            <textarea class="form-control resize-none" rows="5" placeholder="Enter your note" name="txtextranotes"></textarea>
                                                            <p></p>
                                                            <div class="alert alert-warning">
                                                                <p class="mb-0">
                                                                    <span id="note">Additional notes are added for extra work, Then please leave the repair order in job status pending for client to give approval on new estimate for extra work.</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="invoice-total-info py-4 px-0">
                                        <div class="hstack gap-2 justify-content-end d-print-none">
                                            <div class="formgroup form-check">
                                                <input class="form-check-input" name="txtsendemailtoemployeeforrepairorder" type="checkbox" id="mail" checked />
                                                <label class="form-check-label" for="mail">Select to send Repair Order to employee.</label>
                                            </div>
                                            <div class="formgroup form-check ps-0">
                                                <div class="formgroup">
                                                    <select class="form-select" aria-label="Default select example" required="" name="txtrepairorderstatus">
                                                        <option value="">Select Client Approval status</option>
                                                        <option value="1">Panding</option>
                                                        <option value="2">Done</option>
                                                        <option value="3">Not Done</option>
                                                        <option value="4">Update Estimation Again Request!</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="submit" class="btn btn-success" value="Create" id="btncreaterepairorder">
                                            <input type="hidden" name="txtbookingid" value="{{ $estimate_data->estimate_booking_id }}" />
                                            <input type="hidden" name="txtestimateid" value="{{ $estimate_data->estimate_id }}" />
                                            <input type="hidden" name="txtgarageid" value="{{ $estimate_data->estimate_garage_id }}" />
                                            <input type="hidden" name="txtcustomerid" value="{{ $estimate_data->estimate_customer_id }}" />
                                            <input type="hidden" name="txtvehicleid" value="{{ $estimate_data->estimate_vehicle_id }}" />
                                            <input type="hidden" name="txttotalparts" value="{{ $estimate_data->estimate_parts_total }}" />
                                            <input type="hidden" name="txttotalamount" value="{{ $estimate_data->estimate_total_inctax }}" />
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </form>
                    </div>
                </div>
                <!--end card-->
            </div>
        </div><!-- end row -->
    </div>
    <!-- container-fluid -->
</div>

@include('layouts.explore')

@endsection