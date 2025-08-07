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
                            <h4 class="mb-sm-0">Repair Order</h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <a href="{{ route('garage-owner.estimate.list') }}" class="btn btn-success btn-select2"><i class="ri-add-large-line"></i> Add Repair Order</a>
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
                        <h4 class="card-title mb-0 flex-grow-1">Repair Order List</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-block table-responsive">
                            <table id="garageOwnersRepairOrderTable" class="table table-hover table-bordered w-100" data-route="{{ route('garage-owner.repair-order.data') }}">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>RO ID</th>
                                        <th>Employee ID</th>
                                        <th>Client</th>
                                        <th>Make</th>
                                        <th>Model</th>
                                        <th>Licence Plate</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Clock IN</th>
                                        <th>Clock Out</th>
                                        <th>Repair Status</th>
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

<!-- Edit Repair Order offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarEditRepairOrder" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Edit Repair Order</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="am-info-list-block mb-4">
            <div class="am-info-list">
                <div class="am-info-item">
                    <span class="info-list-title">Name</span>
                    <span class="info-list-value">Chirag Kanjariya</span>
                </div>
                <div class="am-info-item">
                    <span class="info-list-title">Client ID</span>
                    <span class="info-list-value">218</span>
                </div>
                <div class="am-info-item">
                    <span class="info-list-title">VIN</span>
                    <span class="info-list-value">AEPLK123456789123</span>
                </div>
                <div class="am-info-item">
                    <span class="info-list-title">Vehicle</span>
                    <span class="info-list-value">Ferrari Ferrari</span>
                </div>
                <div class="am-info-item">
                    <span class="info-list-title">Address</span>
                    <span class="info-list-value">located at 201, Amilaxmi, Lad society road, Vastrapur, Carman, Manitoba, Canada.</span>
                </div>
            </div>
        </div>
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation">
                <div class="row mb-4">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Employee Information</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Employee Name*</label>
                            <input type="text" class="form-control" id="validationCustom05" required="" placeholder="Enter employee name" value="John">
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Employee Email*</label>
                            <input type="text" class="form-control" id="validationCustom05" required="" placeholder="Enter employee email" value="chiragkanjariya24@gmail.com">
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Employee Phone*</label>
                            <input type="text" class="form-control" id="validationCustom05" required="" placeholder="Enter employee phone" value="+1254545655">
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Date*</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Enter date" value="12-28-2024" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card-header pb-2 mb-3">
                            <h4 class="card-title mb-0 flex-grow-1">Repair Order Details</h4>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-5">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Part</label>
                            <select class="common-select3" name="vehicle">
                                <option>Select part</option>
                                <option value="" selected>Oil Filter</option>
                                <option value="">Oil Filter</option>
                                <option value="">Oil Filter</option>
                                <option value="">Oil Filter</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Labor/Other*</label>
                            <input type="text" class="form-control" id="validationCustom05" required="" placeholder="Enter labor" value="John">
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-3">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Qty</label>
                            <div class="input-step light full-width">
                                <button type="button" class="minus">–</button>
                                <input type="number" class="product-quantity" value="0" min="0" max="10000">
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Time</label>
                            <input type="text" class="form-control" id="validationCustom05" required="" placeholder="Enter time" value="25">
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Total Time</label>
                            <input type="text" class="form-control" id="validationCustom05" required="" placeholder="Enter total time" value="25">
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Actual Time</label>
                            <input type="text" class="form-control" id="validationCustom05" required="" placeholder="Enter actual time" value="0">
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Extra Notes</label>
                            <textarea class="form-control resize-none" rows="4" placeholder="Enter extra notes"></textarea>
                            <p class="fs-12 mt-1 text-warning">If Additional notes are added for extra work, Then please leave the repair order in job status pending for client to give approval on new estimate for extra work</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="formgroup">
                            <label class="form-label" for="validationCustom05">Job Status</label>
                            <select class="form-select mb-3" aria-label="Default select example">
                                <option selected="">Select status</option>
                                <option value="1">Panding</option>
                                <option value="2" selected>Done</option>
                                <option value="3">Not Done</option>
                                <option value="4">Update Estimation Again Request!</option>
                            </select>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="alert alert-danger">
                            This form edit is restricted as it already has a invoice associated with it. Kindly archive that invoice and try again!
                        </div>
                    </div>
                </div>
                <div class="form-action-block d-flex align-items-center gap-4">
                    <div class="formgroup form-check">
                        <input class="form-check-input" type="checkbox" id="repair-order" checked="">
                        <label class="form-check-label" for="repair-order">Select to send Repair Order to Employee.</label>
                    </div>
                    <div class="form-action-btn">
                        <button type="button" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Time Logs offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="sidebarViewTimeLog" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Time Log For RO <span>#0060</span></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="viewInformationBlock">
            <div class="table-responsive table-card bg-primary-subtle border-primary">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td class="fw-medium">Date</td>
                            <td>12/19/2024</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Employee</td>
                            <td>chirag</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">VIN</td>
                            <td>AEPLK123456789123</td>
                        </tr>
                        <tr>
                            <td class="fw-medium">Client</td>
                            <td>Chirag Kanjariya</td>
                        </tr>
                    </tbody>
                </table>
                <!--end table-->
            </div>

            <div class="table-block table-responsive view-time-log-table mt-3">
                <table class="table table-borderless table-nowrap align-middle mb-0">
                    <thead>
                        <tr class="table-active">
                            <th scope="col">Log ID</th>
                            <th scope="col">In/Out</th>
                            <th scope="col">Clock Time</th>
                        </tr>
                    </thead>
                    <tbody id="products-list">
                        <tr>
                            <td>0170</td>
                            <td>
                                <span class="badge bg-success-subtle text-success"><i class="ri-time-line"></i> Time In</span>
                            </td>
                            <td>12/29/2024, 12:14:45 PM</td>
                        </tr>
                        <tr>
                            <td>0170</td>
                            <td>
                                <span class="badge bg-danger-subtle text-danger"><i class="ri-time-line"></i> Time Out</span>
                            </td>
                            <td>12/29/2024, 12:14:45 PM</td>
                        </tr>
                        <tr>
                            <td>0170</td>
                            <td>
                                <span class="badge bg-success-subtle text-success"><i class="ri-time-line"></i> Time In</span>
                            </td>
                            <td>12/29/2024, 12:14:45 PM</td>
                        </tr>
                        <tr>
                            <td>0170</td>
                            <td>
                                <span class="badge bg-danger-subtle text-danger"><i class="ri-time-line"></i> Time Out</span>
                            </td>
                            <td>12/29/2024, 12:14:45 PM</td>
                        </tr>
                    </tbody>
                </table><!--end table-->
            </div>

            <div class="alert alert-warning mt-3 text-center">
                Total time: 02:10:30(hours)
            </div>
        </div>
    </div>
</div>

<!-- right offcanvas -->
@include('layouts.explore')

@endsection