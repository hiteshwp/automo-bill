@php
    use Illuminate\Support\Facades\Auth;
@endphp

<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">
    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Layout config Js -->
        <script src="{{ asset('assets/js/layout.js') }}"></script>
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> -->

        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Icons Css -->
        <link href="{{ asset('assets/css/intlTelInput.css') }}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{ asset('assets/libs/dropzone/dropzone.css') }}" type="text/css" />

        <!-- Filepond css -->
        <link rel="stylesheet" href="{{ asset('assets/libs/filepond/filepond.min.css') }}" type="text/css" />
        <link rel="stylesheet" href="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">

        <!-- Toastr CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    </head>
<body class="siteurl" data-url="{{ url('/') }}">

<!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box horizontal-logo">
                        @auth
                            @if(auth()->user()->user_type === 'Super Admin')
                                <a href="{{ route('dashboard.super-admin') }}" class="logo logo-dark">
                            @endif
                            @if(auth()->user()->user_type === 'Garage Owner')
                                <a href="{{ route('dashboard.garage-owner') }}" class="logo logo-dark">
                            @endif
                            @if(auth()->user()->user_type === 'User')
                                <a href="{{ route('dashboard.user') }}" class="logo logo-dark">
                            @endif
                        @endauth
                                <span class="logo-sm">
                                    <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="35">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="30">
                                </span>
                            </a>

                            @auth
                                @if(auth()->user()->user_type === 'Super Admin')
                                    <a href="{{ route('dashboard.super-admin') }}" class="logo logo-light">
                                @endif
                                @if(auth()->user()->user_type === 'Garage Owner')
                                    <a href="{{ route('dashboard.garage-owner') }}" class="logo logo-light">
                                @endif
                                @if(auth()->user()->user_type === 'User')
                                    <a href="{{ route('dashboard.user') }}" class="logo logo-light">
                                @endif
                            @endauth
                                <span class="logo-sm">
                                    <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="35">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="30">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                    </div>

                    <div class="d-flex align-items-center gap-1">
                        <div class="header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                                <i class="ri-fullscreen-line fs-22"></i>
                            </button>
                        </div>

                        <div class="header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                                <i class='ri-moon-clear-line fs-22'></i>
                            </button>
                        </div>

                        <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                                <i class='ri-notification-2-line fs-22'></i>
                                <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span class="visually-hidden">unread messages</span></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                            </div>
                                            <div class="col-auto dropdown-tabs">
                                                <span class="badge bg-light-subtle text-body fs-13"> 4 New</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="notification-list-block">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3 flex-shrink-0">
                                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                                        <i class="ri-verified-badge-line"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 lh-base">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> Just 30 sec ago</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <img src="{{ asset('assets/images/users/avatar-2.jpg') }}" class="me-3 rounded-circle avatar-xs flex-shrink-0" alt="user-pic">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Angela Bernier</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">Answered to your comment on the cash flow forecast's
                                                            graph 🔔.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 48 min ago</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3 flex-shrink-0">
                                                    <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-16">
                                                        <i class='ri-message-3-line'></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 fs-13 lh-base">You have received <b class="text-success">20</b> new messages in the conversation
                                                        </h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 2 hrs ago</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <img src="{{ asset('assets/images/users/avatar-8.jpg') }}" class="me-3 rounded-circle avatar-xs flex-shrink-0" alt="user-pic">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Maureen Gibson</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">We talked about a project on linkedin.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="mdi mdi-clock-outline"></i> 4 hrs ago</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="my-3 text-center view-all">
                                            <button type="button" class="btn btn-soft-success waves-effect waves-light">View
                                                All Notifications <i class="ri-arrow-right-line align-middle"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn p-1 radius-100" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="{{  asset('assets/images/users/avatar-1.jpg') }}" alt="Header Avatar">
                                    <span class="text-start ms-xl-2">
                                    @if(Auth::check())
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                        <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ Auth::user()->user_type }}</span>
                                    @endif
                                </span>
                                <span class="topbar-user-icon">
                                    <i class="ri-arrow-down-s-line"></i>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
                                <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                                <a class="dropdown-item" href="#"><i class="ri-account-box-line align-middle me-1"></i> <span class="align-middle">My Account</span></a>
                                @if(auth()->user()->user_type === 'Super Admin')
                                    <a class="dropdown-item" href="{{ route('admin.index') }}"><i class="ri-user-line align-middle me-1"></i> <span class="align-middle">Admin List</span></a>
                                @endif
                                <a class="dropdown-item" href="#"><i class="ri-settings-3-line align-middle me-1"></i> <span class="align-middle">Setting</span></a>
                                <a class="dropdown-item" href="#"><i class="ri-lock-line align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>
                                <a class="dropdown-item" href="{{ route('logout') }}"><i class="ri-logout-box-r-line align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                            </div>
                        </div>

                        <div class="header-item d-none d-sm-flex">
                            <div class="customizer-setting">
                                <div class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
                                    <i class='ri-settings-3-line fs-22'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                @auth
                    @if(auth()->user()->user_type === 'Super Admin')
                        <a href="{{ route('dashboard.super-admin') }}" class="logo logo-dark">
                    @endif
                    @if(auth()->user()->user_type === 'Garage Owner')
                        <a href="{{ route('dashboard.garage-owner') }}" class="logo logo-dark">
                    @endif
                    @if(auth()->user()->user_type === 'User')
                        <a href="{{ route('dashboard.user') }}" class="logo logo-dark">
                    @endif
                @endauth
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="35">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="30">
                    </span>
                </a>
                <!-- Light Logo-->
                @auth
                    @if(auth()->user()->user_type === 'Super Admin')
                        <a href="{{ route('dashboard.super-admin') }}" class="logo logo-light">
                    @endif
                    @if(auth()->user()->user_type === 'Garage Owner')
                        <a href="{{ route('dashboard.garage-owner') }}" class="logo logo-light">
                    @endif
                    @if(auth()->user()->user_type === 'User')
                        <a href="{{ route('dashboard.user') }}" class="logo logo-light">
                    @endif
                @endauth
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="35">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="30">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>                        
                        @auth
                            @if(auth()->user()->user_type === 'Super Admin')
                                <li class="nav-item">
                                    <a class="nav-link menu-link active" href="{{ route('dashboard.super-admin') }}">
                                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboard">Dashboard</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#sidebarCustomers" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                        <i class="ri-group-line"></i> <span data-key="t-customers">Customers</span>
                                    </a>
                                    <div class="collapse menu-dropdown" id="sidebarCustomers">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="{{ route('admin.garage-owners.index') }}" class="nav-link" data-key="t-garage-owners">Garage Owners</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('admin.searchclient.list') }}" class="nav-link" data-key="t-search-client">Search Client</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('admin.searchVehicle.list') }}" class="nav-link" data-key="t-search-vehicle">Search Vehicle</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-invoice-due">Invoice Due</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-paid-invoices">Paid Invoices</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-sales-reports">Sales Reports</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-manage-tickets">Manage Tickets</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-marketing">Marketing</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-calendar-check-line"></i> <span data-key="t-booking">Booking</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-calculator-line"></i> <span data-key="t-estimates">Estimates</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-list-settings-line"></i> <span data-key="t-repair-orders">Repair Orders</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-box-3-line"></i> <span data-key="t-suppliers">Suppliers</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-book-2-line"></i> <span data-key="t-diarize">Diarize</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-customer-service-2-line"></i> <span data-key="t-contact-us">Contact Us</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-file-paper-line"></i> <span data-key="t-content">Content</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->user_type === 'Garage Owner')
                                <li class="nav-item">
                                    <a class="nav-link menu-link active" href="{{ route('dashboard.garage-owner') }}">
                                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboard">Dashboard</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="{{ route('garage-owner.clients.index') }}">
                                        <i class="ri-group-line"></i> <span data-key="t-customers">Clients</span>
                                    </a>                                    
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-calendar-check-line"></i> <span data-key="t-booking">Booking</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-calculator-line"></i> <span data-key="t-estimates">Estimates</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-list-settings-line"></i> <span data-key="t-repair-orders">Repair Orders</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="{{ route('garage-owner.suppliers.list') }}">
                                        <i class="ri-box-3-line"></i> <span data-key="t-suppliers">Suppliers</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-book-2-line"></i> <span data-key="t-diarize">Diarize</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-customer-service-2-line"></i> <span data-key="t-contact-us">Contact Us</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link menu-link" href="#">
                                        <i class="ri-file-paper-line"></i> <span data-key="t-content">Content</span>
                                    </a>
                                </li>
                            @endif

                            @if(auth()->user()->user_type === 'User')
                                <li class="nav-item">
                                    <a class="nav-link menu-link active" href="{{ route('dashboard.user') }}">
                                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboard">Dashboard</span>
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
    
        <div class="main-content">
            @yield('content')  <!-- ✅ Correct way to include dynamic content -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <p class="mb-0 text-center">&copy; <script>document.write(new Date().getFullYear())</script> Auto Mobill. Designed with by <a href="#" class="link">Webintoto</a> All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>
    <!-- END layout-wrapper -->
    
    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-primary btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Theme Settings -->
    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="theme-settings-offcanvas">
        <div class="d-flex align-items-center bg-primary bg-gradient p-3 offcanvas-header">
            <h5 class="m-0 me-2 text-white">Theme Customizer</h5>
            <button type="button" class="btn-close btn-close-white ms-auto" id="customizerclose-btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div data-simplebar class="h-100">
                <div class="p-4">
                    <h6 class="mb-0 fw-bold text-uppercase">Layout</h6>
                    <p class="text-muted">Choose your layout</p>

                    <div class="row gy-3">
                        <div class="col-4">
                            <div class="form-check card-radio">
                                <input id="customizer-layout01" name="data-layout" type="radio" value="vertical" class="form-check-input">
                                <label class="form-check-label p-0 avatar-md w-100" for="customizer-layout01">
                                    <span class="d-flex gap-1 h-100">
                                        <span class="flex-shrink-0">
                                            <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                                <span class="bg-light d-block p-1 mt-auto"></span>
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Vertical</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio">
                                <input id="customizer-layout02" name="data-layout" type="radio" value="horizontal" class="form-check-input">
                                <label class="form-check-label p-0 avatar-md w-100" for="customizer-layout02">
                                    <span class="d-flex h-100 flex-column gap-1">
                                        <span class="bg-light d-flex p-1 gap-1 align-items-center">
                                            <span class="d-block p-1 bg-primary-subtle rounded me-1"></span>
                                            <span class="d-block p-1 pb-0 px-2 bg-primary-subtle ms-auto"></span>
                                            <span class="d-block p-1 pb-0 px-2 bg-primary-subtle"></span>
                                        </span>
                                        <span class="bg-light d-block p-1"></span>
                                        <span class="bg-light d-block p-1 mt-auto"></span>
                                    </span>
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Horizontal</h5>
                        </div>
                        <!-- end col -->
                    </div>

                    <h6 class="mt-4 mb-0 fw-bold text-uppercase">Color Scheme</h6>
                    <p class="text-muted">Choose Light or Dark Scheme.</p>

                    <div class="colorscheme-cardradio">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check card-radio">
                                    <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-mode-light" value="light">
                                    <label class="form-check-label p-0 avatar-md w-100" for="layout-mode-light">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Light</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check card-radio dark">
                                    <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-mode-dark" value="dark">
                                    <label class="form-check-label p-0 avatar-md w-100 bg-dark" for="layout-mode-dark">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-white bg-opacity-10 d-flex h-100 flex-column gap-1 p-1">
                                                    <span class="d-block p-1 px-2 bg-white bg-opacity-10 rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-white bg-opacity-10 d-block p-1"></span>
                                                    <span class="bg-white bg-opacity-10 d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Dark</h5>
                            </div>
                        </div>
                    </div>
                    
                    <div id="sidebar-size">
                        <h6 class="mt-4 mb-0 fw-bold text-uppercase">Sidebar Size</h6>
                        <p class="text-muted">Choose a size of Sidebar.</p>

                        <div class="row">
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-default" value="lg">
                                    <label class="form-check-label p-0 avatar-md w-100" for="sidebar-size-default">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Default</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-small" value="sm">
                                    <label class="form-check-label p-0 avatar-md w-100" for="sidebar-size-small">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1">
                                                    <span class="d-block p-1 bg-primary-subtle mb-2"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Small (Icon View)</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-small-hover" value="sm-hover">
                                    <label class="form-check-label p-0 avatar-md w-100" for="sidebar-size-small-hover">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1">
                                                    <span class="d-block p-1 bg-primary-subtle mb-2"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Small Hover View</h5>
                            </div>
                        </div>
                    </div>

                    <div id="preloader-menu">
                        <h6 class="mt-4 mb-0 fw-bold text-uppercase">Preloader</h6>
                        <p class="text-muted">Choose a preloader.</p>
                    
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-preloader" id="preloader-view-custom" value="enable">
                                    <label class="form-check-label p-0 avatar-md w-100" for="preloader-view-custom">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                        <!-- <div id="preloader"> -->
                                        <div id="status" class="d-flex align-items-center justify-content-center">
                                            <div class="spinner-border text-primary avatar-xxs m-auto" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Enable</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio">
                                    <input class="form-check-input" type="radio" name="data-preloader" id="preloader-view-none" value="disable">
                                    <label class="form-check-label p-0 avatar-md w-100" for="preloader-view-none">
                                        <span class="d-flex gap-1 h-100">
                                            <span class="flex-shrink-0">
                                                <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                    <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                </span>
                                            </span>
                                            <span class="flex-grow-1">
                                                <span class="d-flex h-100 flex-column">
                                                    <span class="bg-light d-block p-1"></span>
                                                    <span class="bg-light d-block p-1 mt-auto"></span>
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Disable</h5>
                            </div>
                        </div>
                    
                    </div>
                    <!-- end preloader-menu -->

                </div>
            </div>

        </div>
        <div class="offcanvas-footer border-top p-3 text-center">
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-light w-100" id="reset-layout">Reset</button>
                </div>
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

    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/libs/choices/choices.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <!-- echarts js -->
    <script src="{{ asset('assets/libs/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/echarts.init.js') }}"></script>
    <!-- calendar min js -->
    <!-- <script src="{{ asset('assets/libs/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/calendar.init.js') }}"></script> -->

    <script src="{{ asset('assets/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ asset('assets/libs/pickr/pickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-pickers.init.js') }}"></script>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/select2.init.js') }}"></script>

    <!-- dropzone min -->
    <script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>
    <!-- filepond js -->
    <script src="{{ asset('assets/libs/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ asset('assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
    <script src="{{ asset('assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/form-file-upload.init.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/intlTelInput.min.js"></script>
    <script src="{{ asset('assets/js/intlTelInputWithUtils.js') }}"></script>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/parsley.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <!-- Custom Data table js -->

    <script>
        //let iti;
        get_phone_code("#txtclientmobilenumber", "#btn-client", "#error-msg-client", "#valid-msg-client", "#newclientphonecode", "#newclientphoneicocode");
        get_phone_code("#txtupdateclientmobilenumber", "#btn-update", "#error-msg-update", "#valid-msg-update", "#updateclientphonecode", "#updateclientphoneicocode");

        get_phone_code("#txtsuppliermobilenumber", "#btn-supplier", "#error-msg-supplier", "#valid-msg-supplier", "#newsupplierphonecode", "#newsupplierphoneicocode");
        get_phone_code("#txtupdatesuppliermobilenumber", "#btn-supplier-update", "#error-msg-supplier-update", "#valid-msg-supplier-update", "#updatesupplierphonecode", "#updatesupplierphoneicocode");

        function get_phone_code(selector, btnId, errorId, validId, phonecode, isocode) {
            const input = document.querySelector(selector);
            const button = document.querySelector(btnId);
            const errorMsg = document.querySelector(errorId);
            const validMsg = document.querySelector(validId);
            if (!input) return;

            const iti = window.intlTelInput(input, {
                initialCountry: "us",
                separateDialCode: true,
            });

            // Optionally store the instance on the element itself if needed later
            input._iti = iti;

            const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

            // Get the hidden input field
            const hiddenPhoneCodeInput = document.querySelector(phonecode);
            const hiddenPhoneIsoCodeInput = document.querySelector(isocode);

            // Function to update hidden input with the selected dial code
            const updateHiddenPhoneCode = () => {
                const selectedCountryData = iti.getSelectedCountryData();
                hiddenPhoneCodeInput.value = selectedCountryData.dialCode; // Get the dial code
                hiddenPhoneIsoCodeInput.value = selectedCountryData.iso2; // Get the dial code
                console.log('Selected dial code:', selectedCountryData.dialCode);
                console.log('Selected ISO code:', selectedCountryData.iso2);
            };

            // Update the hidden input when the country flag is clicked
            input.addEventListener('countrychange', updateHiddenPhoneCode);

            const reset = () => {
                input.classList.remove("error");
                errorMsg.innerHTML = "";
                validMsg.innerHTML = "";
                errorMsg.classList.add("hide");
                validMsg.classList.add("hide");
            };

            const showError = (msg) => {
                input.classList.add("error");
                errorMsg.innerHTML = msg;
                errorMsg.classList.remove("hide");
            };

            // Button click validate for this input only
            button.addEventListener('click', () => {
                reset();
                if (!input.value.trim()) {
                    showError("Required");
                } else if (iti.isValidNumber()) {
                    validMsg.innerHTML = "Valid number: " + iti.getNumber();
                    document.querySelector(phonecode).value = iti.getNumber();
                    $(phonecode).val(iti.getNumber());
                    validMsg.classList.remove("hide");
                    console.log(iti.getNumber())
                } else {
                    const errorCode = iti.getValidationError();
                    const msg = errorMap[errorCode] || "Invalid number";
                    showError(msg);
                }
            });

            // On change/keyup reset
            input.addEventListener('change', reset);
            input.addEventListener('keyup', reset);
        }


        flatpickr(".dateformat", {
            dateFormat: "Y-m-d", // 2025-05-25 14:30
            allowInput: true
        });
    </script>

    <script src="{{ asset('assets/js/datatable.js') }}"></script>
    
</body>

</html>
