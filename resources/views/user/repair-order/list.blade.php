@extends('layouts.app')

@section('title', 'My Repair Order List | '.config('app.name', 'Laravel'))

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-title-box p-0 d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Repair Order List</h4>
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
                            <table id="userRepairOrderTable" class="table table-hover table-bordered w-100" data-route="{{ route('user.repair-order.data') }}">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>RO ID</th>
                                        <th>Employee ID</th>
                                        <th>Garage Owner</th>
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

<div class="offcanvas offcanvas-end" tabindex="-1" id="updateRepairOrderStatusModal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Update Repair Order Status</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="viewInformationBlock">
            <div class="mt-2 text-center">
                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                    <h4>Are you sure ?</h4>
                    <p class="text-muted mx-4 mb-0" id="updateRepairOrderMessage">Are you sure you want to Archive this Details ?</p>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                <form method="post">
                    <input type="hidden" value="" id="txtrepairorderid"/>
                    <input type="hidden" value="" id="txtrepairordertype"/>
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="offcanvas">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="update-repair-order-btn">Yes, Approve It!</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- right offcanvas -->
@include('layouts.explore')

@endsection