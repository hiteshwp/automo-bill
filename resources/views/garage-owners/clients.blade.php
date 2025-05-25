@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-title-box p-0 d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 d-flex align-items-center gap-2"><a href="{{ route('garage-owners.index') }}" class="btn btn-soft-primary btn-icon shadow-none"><i class="ri-arrow-left-line"></i></a> Client - <span class="fs-14 fw-normal">({{ $garageOwners->name }})</span></h4>

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
        
        <!-- start row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Client List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-block table-responsive">
                        <table id="garageOwnersClientTable" class="table table-hover table-bordered w-100" data-route="{{ route('garage.clients.data', ['id' => $garageOwners->id ]) }}" data-garageownerid = "{{ $garageOwners->user_id }}">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Client</th>
                                    <th>Email</th>
                                    <th>Make</th>
                                    <th>Model</th>
                                    <th>Licence Plate</th>
                                    <th>Client Phone</th>
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