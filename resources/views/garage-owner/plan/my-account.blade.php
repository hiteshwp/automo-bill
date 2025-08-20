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
                            <h4 class="mb-sm-0">Plans</h4>
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
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Current Plan</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- start current plan -->
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card pricing-box text-center overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body h-100 align-content-center bg-plan-gold">
                                <div class="current-plan-title">
                                    <h1 class="mb-2 plan-text-gold-color">Gold</h1>
                                    <div class="fs-1 fw-bold">
                                        <sup class="fs-16 text-muted align-middle me-1 d-inline-block">$</sup>249.49<span class="text-muted fw-normal fs-12 ms-1 align-end">/ Per Year</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-6">
                            <div class="card-body border-start mt-4 mt-lg-0">
                                <ul class="list-group mt-3 mb-3 px-3">
                                    <li class="list-group-item bg-light">
                                        <div class="d-flex align-items-center"> 
                                            <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                            <span><strong class="me-1 d-inline-block">Unlimited</strong> Invoices / Per Month </span>
                                        </div>
                                    </li>
                                    <li class="list-group-item bg-light">
                                        <div class="d-flex align-items-center"> 
                                            <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                            <span>Unlimited Estimates</span> 
                                        </div>
                                    </li>
                                    <li class="list-group-item bg-light">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span>
                                            <span>Unlimited Repair Orders</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item bg-light">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                            <span><strong class="me-1 d-inline-block">25 CarMD</strong> Credits *</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item bg-light">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                            <span>Labor Guides</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item bg-light">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                            <span>Priority Support</span>
                                        </div>
                                    </li>
                                    <li class="list-group-item bg-light">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                            <span>SMS Customer Contact Included</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>
        <!-- end current plan -->

        <!-- start plan tab -->
        <div class="row justify-content-center mt-4">
            <div class="col-lg-5">
                <div class="text-center mb-4">
                    <h4 class="fs-22">Plans & Pricing</h4>
                    <p class="text-muted mb-4 fs-15">Monthly, Annual and Topup Plans Subscription</p>

                    <div class="d-inline-flex">
                        <ul class="nav nav-pills arrow-navtabs plan-nav rounded mb-3 p-1" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold active" id="month-tab" data-bs-toggle="pill" data-bs-target="#month" type="button" role="tab" aria-selected="true">Monthly</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link fw-semibold" id="annual-tab" data-bs-toggle="pill" data-bs-target="#annual" type="button" role="tab" aria-selected="false">Annually</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!-- end plan tab -->

        <!-- start plan info -->
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="month" role="tabpanel">
                        <div class="row">
                            <div class="col-xxl-4 col-lg-6">
                                <div class="card custom-card text-center">
                                    <div class="card-body p-4">
                                        <div class="plan-icon bronze-plan-icon">
                                            <i class="ri-medal-2-line"></i>
                                        </div>
                                        <h3 class="mb-1 plan-text-Bronze-color">Bronze</h3>
                                        <p class="fs-12 text-muted mb-0">Affordable and effective solution for small businesses.</p>
                                        <div class="fs-1 fw-bold">
                                            <sup class="fs-16 text-muted align-middle me-1 d-inline-block">$</sup>7.99<span class="text-muted fw-normal fs-12 ms-1 align-end">/ Per Month</span>
                                        </div>
                                        <ul class="list-group mt-3 mb-3">
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">25</strong> Invoices</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>Unlimited Estimates</span> 
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span>
                                                    <span>Unlimited Repair Orders</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">10 CarMD</strong> Credits *</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span> Standard Support (1-2 Days) </span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-close-large-line fw-medium fs-18 text-danger"></i> </span> 
                                                    <span> SMS Customer Contact Included </span>
                                                </div>
                                            </li>
                                        </ul>
                                        <button type="button" class="btn btn-primary w-100 mb-2"><span><i class="ri-paypal-line"></i></span> Subscribe </button>
                                        <button type="button" class="btn btn-soft-primary w-100"><span><i class="ri-bank-card-line"></i></span> Debit/Credit Card </button>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
    
                            <div class="col-xxl-4 col-lg-6">
                                <div class="card custom-card text-center">
                                    <div class="card-body ribbon-box p-4">
                                        <div class="ribbon-two ribbon-two-danger"><span>Popular</span></div>
                                        <div class="plan-icon silver-plan-icon">
                                            <i class="ri-medal-2-line"></i>
                                        </div>
                                        <h3 class="mb-1 plan-text-silver-color">Silver</h3>
                                        <p class="fs-12 text-muted mb-0">Great for growing businesses looking for more.</p>
                                        <div class="fs-1 fw-bold">
                                            <sup class="fs-16 text-muted align-middle me-1 d-inline-block">$</sup>14.99<span class="text-muted fw-normal fs-12 ms-1 align-end">/ Per Month</span>
                                        </div>
                                        <ul class="list-group mt-3 mb-3">
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">50</strong> Invoices </span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>Unlimited Estimates</span> 
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span>
                                                    <span>Unlimited Repair Orders</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">15 CarMD</strong> Credits *</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>Standard Support (12-24 Hours)</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>SMS Customer Contact Included</span>
                                                </div>
                                            </li>
                                        </ul>
                                        <button type="button" class="btn btn-primary w-100 mb-2"><span><i class="ri-paypal-line"></i></span> Subscribe </button>
                                        <button type="button" class="btn btn-soft-primary w-100"><span><i class="ri-bank-card-line"></i></span> Debit/Credit Card </button>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
    
                            <div class="col-xxl-4 col-lg-6">
                                <div class="card custom-card text-center">
                                    <div class="card-body p-4">
                                        <div class="plan-icon gold-plan-icon">
                                            <i class="ri-medal-2-line"></i>
                                        </div>
                                        <h3 class="mb-1 plan-text-gold-color">Gold</h3>
                                        <p class="fs-12 text-muted mb-0">Perfect for businesses that require the best features.</p>
                                        <div class="fs-1 fw-bold">
                                            <sup class="fs-16 text-muted align-middle me-1 d-inline-block">$</sup>22.50<span class="text-muted fw-normal fs-12 ms-1 align-end">/ Per Month</span>
                                        </div>
                                        <ul class="list-group mt-3 mb-3">
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">Unlimited</strong> Invoices </span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>Unlimited Estimates</span> 
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span>
                                                    <span>Unlimited Repair Orders</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">25 CarMD</strong> Credits *</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>Priority Support</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>SMS Customer Contact Included</span>
                                                </div>
                                            </li>
                                        </ul>
                                        <button type="button" class="btn btn-primary w-100 mb-2"><span><i class="ri-paypal-line"></i></span> Subscribe </button>
                                        <button type="button" class="btn btn-soft-primary w-100"><span><i class="ri-bank-card-line"></i></span> Debit/Credit Card </button>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                        <!-- end plan info -->
                    </div>
                    <div class="tab-pane" id="annual" role="tabpanel">
                        <div class="row">
                            <div class="col-xxl-4 col-lg-6">
                                <div class="card custom-card text-center">
                                    <div class="card-body p-4">
                                        <div class="plan-icon bronze-plan-icon">
                                            <i class="ri-medal-2-line"></i>
                                        </div>
                                        <h3 class="mb-1 plan-text-Bronze-color">Bronze</h3>
                                        <p class="fs-12 text-muted mb-0">Affordable and effective solution for small businesses.</p>
                                        <div class="fs-1 fw-bold">
                                            <sup class="fs-16 text-muted align-middle me-1 d-inline-block">$</sup>89.99<span class="text-muted fw-normal fs-12 ms-1 align-end">/ Per Year</span>
                                        </div>
                                        <ul class="list-group mt-3 mb-3">
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">25</strong> Invoices / Per Month</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>Unlimited Estimates</span> 
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span>
                                                    <span>Unlimited Repair Orders</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">10 CarMD</strong> Credits *</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span> Standard Support (1-2 Days) </span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-close-large-line fw-medium fs-18 text-danger"></i> </span> 
                                                    <span> SMS Customer Contact Included </span>
                                                </div>
                                            </li>
                                        </ul>
                                        <button type="button" class="btn btn-primary w-100 mb-2"><span><i class="ri-paypal-line"></i></span> Subscribe </button>
                                        <button type="button" class="btn btn-soft-primary w-100"><span><i class="ri-bank-card-line"></i></span> Debit/Credit Card </button>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
    
                            <div class="col-xxl-4 col-lg-6">
                                <div class="card custom-card text-center">
                                    <div class="card-body ribbon-box p-4">
                                        <div class="ribbon-two ribbon-two-danger"><span>Popular</span></div>
                                        <div class="plan-icon silver-plan-icon">
                                            <i class="ri-medal-2-line"></i>
                                        </div>
                                        <h3 class="mb-1 plan-text-silver-color">Silver</h3>
                                        <p class="fs-12 text-muted mb-0">Great for growing businesses looking for more.</p>
                                        <div class="fs-1 fw-bold">
                                            <sup class="fs-16 text-muted align-middle me-1 d-inline-block">$</sup>149.99<span class="text-muted fw-normal fs-12 ms-1 align-end">/ Per Year</span>
                                        </div>
                                        <ul class="list-group mt-3 mb-3">
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">50</strong> Invoices / Per Month</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>Unlimited Estimates</span> 
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span>
                                                    <span>Unlimited Repair Orders</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">15 CarMD</strong> Credits *</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>Standard Support (12-24 Hours)</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>SMS Customer Contact Included</span>
                                                </div>
                                            </li>
                                        </ul>
                                        <button type="button" class="btn btn-primary w-100 mb-2"><span><i class="ri-paypal-line"></i></span> Subscribe </button>
                                        <button type="button" class="btn btn-soft-primary w-100"><span><i class="ri-bank-card-line"></i></span> Debit/Credit Card </button>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
    
                            <div class="col-xxl-4 col-lg-6">
                                <div class="card custom-card text-center">
                                    <div class="card-body p-4">
                                        <div class="plan-icon gold-plan-icon">
                                            <i class="ri-medal-2-line"></i>
                                        </div>
                                        <h3 class="mb-1 plan-text-gold-color">Gold</h3>
                                        <p class="fs-12 text-muted mb-0">Perfect for businesses that require the best features.</p>
                                        <div class="fs-1 fw-bold">
                                            <sup class="fs-16 text-muted align-middle me-1 d-inline-block">$</sup>249.49<span class="text-muted fw-normal fs-12 ms-1 align-end">/ Per Year</span>
                                        </div>
                                        <ul class="list-group mt-3 mb-3">
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">Unlimited</strong> Invoices / Per Month </span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center"> 
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>Unlimited Estimates</span> 
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span>
                                                    <span>Unlimited Repair Orders</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span><strong class="me-1 d-inline-block">25 CarMD</strong> Credits *</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>Labor Guides</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>Priority Support</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item bg-light">
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                                    <span>SMS Customer Contact Included</span>
                                                </div>
                                            </li>
                                        </ul>
                                        <button type="button" class="btn btn-primary w-100 mb-2"><span><i class="ri-paypal-line"></i></span> Subscribe </button>
                                        <button type="button" class="btn btn-soft-primary w-100"><span><i class="ri-bank-card-line"></i></span> Debit/Credit Card </button>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end plan info -->

        <!-- start page title -->
        <div class="row justify-content-center mt-4">
            <div class="col-lg-5">
                <div class="text-center mb-4">
                    <h4 class="fs-22">TopUp Plans</h4>
                    <p class="text-muted mb-4 fs-15">TopUp Plans Subscription</p>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- start Topup plan -->
        <div class="row">
            <div class="col-xxl-4 col-lg-6">
                <div class="card custom-card text-center">
                    <div class="card-body p-4">
                        <div class="plan-icon bronze-plan-icon">
                            <i class="ri-medal-2-line"></i>
                        </div>
                        <h3 class="mb-1 plan-text-Bronze-color">Bronze TopUp</h3>
                        <p class="fs-12 text-muted mb-0">Affordable and effective solution for small businesses.</p>
                        <div class="fs-1 fw-bold">
                            <sup class="fs-16 text-muted align-middle me-1 d-inline-block">$</sup>9.99
                        </div>
                        <ul class="list-group mt-3 mb-3">
                            <li class="list-group-item bg-light">
                                <div class="d-flex align-items-center"> 
                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                    <span><strong class="me-1 d-inline-block">10</strong> Invoices</span>
                                </div>
                            </li>
                            <li class="list-group-item bg-light">
                                <div class="d-flex align-items-center">
                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                    <span> Standard Support (1-2 Days) </span>
                                </div>
                            </li>
                        </ul>
                        <button type="button" class="btn btn-primary w-100 mb-2"><span><i class="ri-paypal-line"></i></span> Subscribe </button>
                        <button type="button" class="btn btn-soft-primary w-100"><span><i class="ri-bank-card-line"></i></span> Debit/Credit Card </button>
                    </div>
                </div>
            </div>
            <!--end col-->

            <div class="col-xxl-4 col-lg-6">
                <div class="card custom-card text-center">
                    <div class="card-body ribbon-box p-4">
                        <div class="ribbon-two ribbon-two-danger"><span>Popular</span></div>
                        <div class="plan-icon silver-plan-icon">
                            <i class="ri-medal-2-line"></i>
                        </div>
                        <h3 class="mb-1 plan-text-silver-color">Silver TopUp</h3>
                        <p class="fs-12 text-muted mb-0">Great for growing businesses looking for more.</p>
                        <div class="fs-1 fw-bold">
                            <sup class="fs-16 text-muted align-middle me-1 d-inline-block">$</sup>19.99
                        </div>
                        <ul class="list-group mt-3 mb-3">
                            <li class="list-group-item bg-light">
                                <div class="d-flex align-items-center"> 
                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                    <span><strong class="me-1 d-inline-block">25</strong> Invoices </span>
                                </div>
                            </li>
                            <li class="list-group-item bg-light">
                                <div class="d-flex align-items-center">
                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                    <span>Standard Support (1-2 Days)</span>
                                </div>
                            </li>
                        </ul>
                        <button type="button" class="btn btn-primary w-100 mb-2"><span><i class="ri-paypal-line"></i></span> Subscribe </button>
                        <button type="button" class="btn btn-soft-primary w-100"><span><i class="ri-bank-card-line"></i></span> Debit/Credit Card </button>
                    </div>
                </div>
            </div>
            <!--end col-->

            <div class="col-xxl-4 col-lg-6">
                <div class="card custom-card text-center">
                    <div class="card-body p-4">
                        <div class="plan-icon gold-plan-icon">
                            <i class="ri-medal-2-line"></i>
                        </div>
                        <h3 class="mb-1 plan-text-gold-color">Gold TopUp</h3>
                        <p class="fs-12 text-muted mb-0">Perfect for businesses that require the best features.</p>
                        <div class="fs-1 fw-bold">
                            <sup class="fs-16 text-muted align-middle me-1 d-inline-block">$</sup>39.99
                        </div>
                        <ul class="list-group mt-3 mb-3">
                            <li class="list-group-item bg-light">
                                <div class="d-flex align-items-center"> 
                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                    <span><strong class="me-1 d-inline-block">50</strong> Invoices </span>
                                </div>
                            </li>
                            <li class="list-group-item bg-light">
                                <div class="d-flex align-items-center">
                                    <span class="me-2 fs-14 lh-1"> <i class="ri-check-double-line fw-medium fs-18 text-success"></i> </span> 
                                    <span>Standard Support (1-2 Days)</span>
                                </div>
                            </li>
                        </ul>
                        <button type="button" class="btn btn-primary w-100 mb-2"><span><i class="ri-paypal-line"></i></span> Subscribe </button>
                        <button type="button" class="btn btn-soft-primary w-100"><span><i class="ri-bank-card-line"></i></span> Debit/Credit Card </button>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!-- end plan info -->
        <!-- end Topup plan -->
    </div>
    <!-- container-fluid -->
</div>

@include('layouts.explore')

@endsection