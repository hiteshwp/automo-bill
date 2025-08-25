@extends('layouts.app')

@section('title', 'My Booking Estimate List | '.config('app.name', 'Laravel'))

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-title-box p-0 d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Booking Estimate List</h4>
                            <!-- <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <a href="{{ route('garage-owner.booking.list') }}" class="btn btn-success btn-select2"><i class="ri-add-large-line"></i> Add Estimate</a>
                                </div>
                                <div class="page-title-action-item">
                                    <button type="button" class="btn btn-light" data-bs-toggle="offcanvas" data-bs-target="#sidebarExplore" aria-controls="offcanvasRight"><i class="ri-indent-decrease"></i> Explore</button>
                                </div>
                            </div> -->
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
                        <h4 class="card-title mb-0 flex-grow-1">Booking Estimate List</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-block table-responsive">
                            <table id="userEstimateTable" class="table table-hover table-bordered w-100" data-route="{{ route('user.estimate.data') }}">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Booking ID</th>
                                        <th>Estimate ID</th>
                                        <th>Garage Owner</th>
                                        <th>Model</th>
                                        <th>Licence Plate</th>
                                        <th>Amount</th>
                                        <th>Ex Tax</th>
                                        <th>Date</th>
                                        <th>Client Approval</th>
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

<div class="offcanvas offcanvas-end" tabindex="-1" id="updateEstimateStatusModal" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Update Estimate Status</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="viewInformationBlock">
            <div class="mt-2 text-center">
                <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                    <h4>Are you sure ?</h4>
                    <p class="text-muted mx-4 mb-0" id="updateEstimateMessage">Are you sure you want to Archive this Details ?</p>
                </div>
            </div>
            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                <form method="post">
                    <input type="hidden" value="" id="txtestimateid"/>
                    <input type="hidden" value="" id="txtestimatetype"/>
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="offcanvas">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="update-estimate-btn">Yes, Approve It!</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- right offcanvas -->
@include('layouts.explore')

@endsection