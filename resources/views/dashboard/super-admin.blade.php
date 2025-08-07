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

        <!-- Start Dashboard Top banner -->
        <div class="dashboardBannerBlock">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="dashboardBannerInfoBlock">
                        <div class="dashboardBannerLogo">
                            <img src="assets/images/logo-light.png" alt="" class="bannerBrandLogo" />
                            <img src="assets/images/aws-logo.png" alt="" class="bannerAwsLogo" />
                        </div>
                        <h4>Auto-repair software that Heals Automobiles</h4>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="dashboardBannerItems">
                        <div class="dashboardBannerList">
                            <h5>Easy Use</h5>
                            <div class="dashboardBannerAction">
                                <img src="assets/images/carfax-logo.png" alt="" />
                            </div>
                        </div>
                        <div class="dashboardBannerList">
                            <h5>Your Plan</h5>
                            <div class="dashboardBannerAction">
                                <img src="assets/images/carmd-logo.png" alt="" />
                            </div>
                        </div>
                        <div class="dashboardBannerList">
                            <h5>Getting Started <a href="#" class="btn-arrow btn-arrow-light"><i class="ri-arrow-right-up-long-line"></i></a></h5>
                            <div class="dashboardBannerAction">
                                <img src="assets/images/youtube-logo.png" alt="" />
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
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="dashboardAdminInfoItem">
                        <div class="dashboardAdminInfoList">
                            <a href="#" class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></a>
                            <div class="dashboardAdminInfoIcon">
                                <img src="assets/images/garage.png" width="100px" alt="" />
                            </div>
                            <div class="dashboardAdminInfo">
                                <h5>Garage Owners</h5>
                                <span class="dashboardAdminInfoCounter">6</span>
                            </div>
                        </div>
                        <div class="dashboardAdminInfoList">
                            <a href="#" class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></a>
                            <div class="dashboardAdminInfoIcon">
                                <img src="assets/images/product.png" width="100px" alt="" />
                            </div>
                            <div class="dashboardAdminInfo">
                                <h5>Products</h5>
                                <span class="dashboardAdminInfoCounter">100+</span>
                            </div>
                        </div>
                        <div class="dashboardAdminInfoList">
                            <a href="#" class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></a>
                            <div class="dashboardAdminInfoIcon">
                                <img src="assets/images/suppliers.png" width="100px" alt="" />
                            </div>
                            <div class="dashboardAdminInfo">
                                <h5>Suppliers</h5>
                                <span class="dashboardAdminInfoCounter">50+</span>
                            </div>
                        </div>
                        <div class="dashboardAdminInfoList">
                            <a href="#" class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></a>
                            <div class="dashboardAdminInfoIcon">
                                <img src="assets/images/marketing.png" width="100px" alt="" />
                            </div>
                            <div class="dashboardAdminInfo">
                                <h5>Marketing</h5>
                                <span class="dashboardAdminInfoCounter">15+</span>
                            </div>
                        </div>
                        <div class="dashboardAdminInfoList">
                            <a href="#" class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></a>
                            <div class="dashboardAdminInfoIcon">
                                <img src="assets/images/booking.png" width="100px" alt="" />
                            </div>
                            <div class="dashboardAdminInfo">
                                <h5>Booking</h5>
                                <span class="dashboardAdminInfoCounter">50+</span>
                            </div>
                        </div>
                        <div class="dashboardAdminInfoList">
                            <a href="#" class="btn-arrow btn-arrow-dark"><i class="ri-arrow-right-up-long-line"></i></a>
                            <div class="dashboardAdminInfoIcon">
                                <img src="assets/images/support.png" width="100px" alt="" />
                            </div>
                            <div class="dashboardAdminInfo">
                                <h5>Support</h5>
                                <span class="dashboardAdminInfoCounter">100+</span>
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
                            <a href="#" class="btn btn-light btn-sm waves-effect">View Report <i class="ri-arrow-right-long-line"></i></a>
                        </div>
                        <div class="card-body position-relative">
                            <div id="chart-allbooking" data-colors='["#03C03C"]' class="gauge-charts"></div>
                            <div class="chartLogo">
                                <img src="assets/images/logo-dark.png" alt="" />
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
                            <a href="#" class="btn btn-light btn-sm waves-effect">View Report <i class="ri-arrow-right-long-line"></i></a>
                        </div>
                        <div class="card-body position-relative">
                            <div id="chart-repairorder" data-colors='["#FFBF00"]' class="gauge-charts"></div>
                            <div class="chartLogo">
                                <img src="assets/images/logo-dark.png" alt="" />
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
                                <img src="assets/images/logo-dark.png" alt="" />
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
                                <img src="assets/images/logo-dark.png" alt="" />
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
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="tName">Elena smith</span>
                                                <span class="tEmail">elenasmith387@gmail.com</span>
                                            </td>
                                            <td>GJ-01-AS-1234</td>
                                            <td>23-01-2023 | 01:05 PM</td>
                                            <td><span class="badge bg-success-subtle text-success">Done</span></td>
                                            <td>
                                                <div class="tAction">
                                                    <button type="button" class="btn btn-soft-success btn-border btn-icon waves-effect shadow-none">
                                                        <i class="ri-edit-line"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-soft-danger btn-border btn-icon waves-effect shadow-none">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="tName">Elena smith</span>
                                                <span class="tEmail">elenasmith387@gmail.com</span>
                                            </td>
                                            <td>GJ-01-AS-1234</td>
                                            <td>23-01-2023 | 01:05 PM</td>
                                            <td><span class="badge bg-success-subtle text-success">Done</span></td>
                                            <td>
                                                <div class="tAction">
                                                    <button type="button" class="btn btn-soft-success btn-border btn-icon waves-effect shadow-none">
                                                        <i class="ri-edit-line"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-soft-danger btn-border btn-icon waves-effect shadow-none">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="tName">Elena smith</span>
                                                <span class="tEmail">elenasmith387@gmail.com</span>
                                            </td>
                                            <td>GJ-01-AS-1234</td>
                                            <td>23-01-2023 | 01:05 PM</td>
                                            <td><span class="badge bg-success-subtle text-success">Done</span></td>
                                            <td>
                                                <div class="tAction">
                                                    <button type="button" class="btn btn-soft-success btn-border btn-icon waves-effect shadow-none">
                                                        <i class="ri-edit-line"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-soft-danger btn-border btn-icon waves-effect shadow-none">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="tName">Elena smith</span>
                                                <span class="tEmail">elenasmith387@gmail.com</span>
                                            </td>
                                            <td>GJ-01-AS-1234</td>
                                            <td>23-01-2023 | 01:05 PM</td>
                                            <td><span class="badge bg-success-subtle text-success">Done</span></td>
                                            <td>
                                                <div class="tAction">
                                                    <button type="button" class="btn btn-soft-success btn-border btn-icon waves-effect shadow-none">
                                                        <i class="ri-edit-line"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-soft-danger btn-border btn-icon waves-effect shadow-none">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="tName">Elena smith</span>
                                                <span class="tEmail">elenasmith387@gmail.com</span>
                                            </td>
                                            <td>GJ-01-AS-1234</td>
                                            <td>23-01-2023 | 01:05 PM</td>
                                            <td><span class="badge bg-success-subtle text-success">Done</span></td>
                                            <td>
                                                <div class="tAction">
                                                    <button type="button" class="btn btn-soft-success btn-border btn-icon waves-effect shadow-none">
                                                        <i class="ri-edit-line"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-soft-danger btn-border btn-icon waves-effect shadow-none">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
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
