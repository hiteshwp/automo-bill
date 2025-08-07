@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <!-- <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-title-box p-0 d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Dashboard</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- end page title -->
        <div class="dashboardBannerBlock">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="dashboardBannerInfoBlock">
                        <div class="dashboardBannerLogo">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" class="bannerBrandLogo" />
                            <img src="{{ asset('assets/images/aws-logo.png') }}" alt="" class="bannerAwsLogo" />
                        </div>
                        <h4 class="mb-0">Auto Repair Shop Software</h4>
                        <span class="text-white">(made by mechanics for mechanics)</span>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="dashboardBannerItems">
                        <div class="dashboardBannerList">
                            <h5>Easy Use</h5>
                            <div class="dashboardBannerAction">
                                <img src="{{ asset('assets/images/carfax-logo.png') }}" alt="" />
                            </div>
                        </div>
                        <div class="dashboardBannerList">
                            <h5>Your Plan</h5>
                            <div class="dashboardBannerAction">
                                <img src="{{ asset('assets/images/carmd-logo.png') }}" alt="" />
                            </div>
                        </div>
                        <div class="dashboardBannerList">
                            <h5>Getting Started <a href="#" class="btn-arrow btn-arrow-light"><i class="ri-arrow-right-up-long-line"></i></a></h5>
                            <div class="dashboardBannerAction">
                                <img src="{{ asset('assets/images/youtube-logo.png') }}" alt="" />
                            </div>
                        </div>
                        <div class="dashboardBannerList">
                            <h5>Subscription <a href="#" class="btn-arrow btn-arrow-light"><i class="ri-arrow-right-up-long-line"></i></a></h5>
                            <div class="dashboardBannerAction">
                                <a href="#" class="btn btn-primary waves-effect">View Packages</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Dashboard Top banner -->

        <!-- Start Gauge chart -->
        <div class="dashboardGaugeChartBlock">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">All Booking</h4>
                            <a href="{{ route('garage-owner.booking.list') }}" class="btn btn-light btn-sm waves-effect">View Report <i class="ri-arrow-right-long-line"></i></a>
                        </div>
                        <div class="card-body position-relative">
                            <div id="chart-allbooking" data-colors='["#03C03C"]' class="gauge-charts" data-total="{{ $total_booking }}"></div>
                            <div class="chartLogo">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
                
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">Repair Orders</h4>
                            <a href="{{ route('garage-owner.repair-order.list') }}" class="btn btn-light btn-sm waves-effect">View Report <i class="ri-arrow-right-long-line"></i></a>
                        </div>
                        <div class="card-body position-relative">
                            <div id="chart-repairorder" data-colors='["#FFBF00"]' class="gauge-charts" data-total="{{ $total_repair_order }}"></div>
                            <div class="chartLogo">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">Outstanding Invoice</h4>
                            <a href="#" class="btn btn-light btn-sm waves-effect">View Report <i class="ri-arrow-right-long-line"></i></a>
                        </div>
                        <div class="card-body position-relative">
                            <div id="chart-outstandinginvoice" data-colors='["#C51E3A"]' class="gauge-charts"></div>
                            <div class="chartLogo">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">Paid Invoice</h4>
                            <a href="#" class="btn btn-light btn-sm waves-effect">View Report <i class="ri-arrow-right-long-line"></i></a>
                        </div>
                        <div class="card-body position-relative">
                            <div id="chart-paidinvoice" data-colors='["#007FFF"]' class="gauge-charts"></div>
                            <div class="chartLogo">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

            </div>
        </div>
        <!-- Start Gauge chart -->

        <!-- Start Booking info -->
        <div class="dashboardBookingBlock">
            <div class="row">
                <div class="col-12 col-md-3 col-lg-3">
                    <div class="card custom-height-100-24">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Links</h4>
                        </div>
                        <div class="card-body">
                            <div class="dashboardLinkList" style="display: flex;">
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Covid Safe Booking List</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Import</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Suppliers</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Product</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Purchase</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Stock</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Labour Guide</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Import</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Sales Reports</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>OBDII Code Lookup</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>VIN Plate Decoder</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Carfax Service History</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Manage Tickets</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardLinkBtn">
                                        <span>Marketing</span>
                                        <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                    </a>
                                </div>
                            </div>
                            <div class="dashboardLinkList dashboardIconLinks" style="display: none;">
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardIconLinkBtn">
                                        <span class="dashboardLinkImg">
                                            <img src="assets/images/paypal-icon.png" alt="" width="70" height="70" />
                                        </span>
                                        <div class="dashboardIconLinkTitle">
                                            <span class="mb-2 d-block">Paypal</span>
                                            <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardIconLinkBtn">
                                        <span class="dashboardLinkImg">
                                            <img src="assets/images/aws-icon.png" alt="" width="70" height="70" />
                                        </span>
                                        <div class="dashboardIconLinkTitle">
                                            <span class="mb-2 d-block">AWS</span>
                                            <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardIconLinkBtn">
                                        <span class="dashboardLinkImg">
                                            <img src="assets/images/crisp-icon.png" alt="" width="70" height="70" />
                                        </span>
                                        <div class="dashboardIconLinkTitle">
                                            <span class="mb-2 d-block">Crisp</span>
                                            <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardIconLinkBtn">
                                        <span class="dashboardLinkImg">
                                            <img src="assets/images/clicksend-icon.png" alt="" width="70" height="70" />
                                        </span>
                                        <div class="dashboardIconLinkTitle">
                                            <span class="mb-2 d-block">Clickend</span>
                                            <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardIconLinkBtn">
                                        <span class="dashboardLinkImg">
                                            <img src="assets/images/carmd-icon.png" alt="" width="70" height="70" />
                                        </span>
                                        <div class="dashboardIconLinkTitle">
                                            <span class="mb-2 d-block">CarMD</span>
                                            <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardIconLinkBtn">
                                        <span class="dashboardLinkImg">
                                            <img src="assets/images/youtube-icon.png" alt="" width="70" height="70" />
                                        </span>
                                        <div class="dashboardIconLinkTitle">
                                            <span class="mb-2 d-block">Youtube</span>
                                            <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardIconLinkBtn">
                                        <span class="dashboardLinkImg">
                                            <img src="assets/images/facebook-icon.png" alt="" width="70" height="70" />
                                        </span>
                                        <div class="dashboardIconLinkTitle">
                                            <span class="mb-2 d-block">Facebook</span>
                                            <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                        </div>
                                    </a>
                                </div>
                                <div class="dashboardLinkItem">
                                    <a href="#" class="dashboardIconLinkBtn">
                                        <span class="dashboardLinkImg">
                                            <img src="assets/images/tickets-icon.png" alt="" width="70" height="70" />
                                        </span>
                                        <div class="dashboardIconLinkTitle">
                                            <span class="mb-2 d-block">Tickets</span>
                                            <span class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9 col-lg-9">
                    <div class="card custom-height-100-24">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Calendar Bookings</h4>
                        </div>
                        <div class="card-body">
                            <div class="dashboardCalendarBlock">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Booking info -->

        <!-- Start Booking info list -->
        <div class="dashboardBookingGraphInfoBlock">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="card custom-height-100-24">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Recent Booking</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-doughnut" data-colors='["--am-primary", "--am-success", "--am-warning"]' class="e-charts"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8 col-lg-8">
                    <div class="card custom-height-100-24">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Booking List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-block table-responsive">
                                <table class="table table-hover table-bordered table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Vehicle Number</th>
                                            <th>Date/Time</th>
                                            <th>Service Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($booking_data as $booking_data_list)
                                            <tr>
                                                <td>
                                                    <span class="tName">{{ $booking_data_list->client_name }}</span>
                                                    <span class="tEmail">{{ $booking_data_list->client_email }}</span>
                                                </td>
                                                <td>{{ $booking_data_list->number_plate }}</td>
                                                <td>{{ date("Y-m-d", strtotime($booking_data_list->booking_date)) }} | {{ date("h:i A", strtotime($booking_data_list->booking_time)) }}</td>
                                                <td>
                                                    @if ($booking_data_list->booking_status === '2')
                                                        <span class="badge bg-success-subtle text-success">Done</span>
                                                    @elseif ($booking_data_list->booking_status === '1')
                                                        <span class="badge bg-warning-subtle text-warning">Pending</span>
                                                    @else ($booking_data_list->booking_status === '3')
                                                        <span class="badge bg-danger-subtle text-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Booking info list -->

    </div>
    <!-- container-fluid -->
</div>
@endsection
