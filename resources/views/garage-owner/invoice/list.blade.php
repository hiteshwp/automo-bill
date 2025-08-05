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
                            <h4 class="mb-sm-0">Invoice</h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <a href="{{ route('garage-owner.repair-order.list') }}" class="btn btn-success btn-select2"><i class="ri-add-large-line"></i> Add Invoice</a>
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
                        <h4 class="card-title mb-0 flex-grow-1">Invoice List</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-block table-responsive">
                            <table id="garageOwnersInvoiceTable" class="table table-hover table-bordered w-100" data-route="{{ route('garage-owner.invoice.data') }}">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Booking ID</th>
                                        <th>Invoice</th>
                                        <th>Name</th>
                                        <th>Make</th>
                                        <th>Model</th>
                                        <th>Licence Plate</th>
                                        <th>Amount</th>
                                        <th>Ex Tax</th>
                                        <th>Date</th>
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

<!-- View Invoice offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarViewInvoice" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">View Invoice</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="viewInformationBlock viewPurchaseInformationBlock">
            <div class="card p-3" id="demo">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-header border-bottom-dashed p-3 ps-0 pe-0">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <img src="{{ asset('assets/images/logo-dark.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="30">
                                    <img src="{{ asset('assets/images/logo-light.png') }}" class="card-logo card-logo-light" alt="logo light" height="30">
                                </div>
                                <div class="flex-shrink-0 mt-sm-0 mt-3">
                                    <h6><span class="text-muted fw-normal">Name : </span><span id="customer_name">Chirag Kanjariya</span></h6>
                                    <h6><span class="text-muted fw-normal">Contact : </span><span id="customer_contact">9825409350</span></h6>
                                    <h6><span class="text-muted fw-normal">Email : </span><span id="customer_email">chiragkanjariya14@gmail.com</span></h6>
                                    <h6><span class="text-muted fw-normal">Address : </span><span id="customer_address">305 S San Gabriel Blvd</span></h6>
                                </div>
                            </div>
                        </div>
                        <!--end card-header-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-3 ps-0 pe-0 border-top border-top-dashed">
                            <div class="row g-3">
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">John Doe Corporation</h6>
                                    <p class="text-muted mb-1"><span>Address: </span><span id="address">General Palace, Comman Street, VA</span></p>
                                    <p class="text-muted mb-1"><span>Email: </span><span id="email">support.jdc@mailinator.com</span> </p>
                                    <p class="text-muted mb-1"><span>Phone: </span><span id="phone-no">(859)-678-9645</span></p>
                                </div>
                                <!--end col-->
                                <div class="col-6">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3" id="">Vehicle Info</h6>
                                    <p class="text-muted mb-1"><span>Vehicle Name : </span><span id="vehicle_name">Ferrari Ferrari</span></p>
                                    <p class="text-muted mb-1"><span>Reg. No. : </span><span id="vehicle_reg_no">CHJK247</span> </p>
                                    <p class="text-muted mb-1"><span>VIN : </span><span id="vehicle_vin">AEPLK123456789123</span></p>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                        <!--end card-body-->
                    </div><!--end col-->
                    <div class="col-lg-12">
                        <div class="card-body p-0 shadow-none">
                            <div class="card-header p-0 pb-2 mb-3">
                                <h4 class="card-title mb-0 flex-grow-1">Parts</h4>
                            </div>
                            <div class="table-block table-responsive mb-4">
                                <table class="table table-borderless table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr class="table-active">
                                            <th scope="col">#</th>
                                            <th scope="col">Part</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Cost</th>
                                            <th scope="col">Markup</th>
                                            <th scope="col">Tax</th>
                                            <th scope="col">Total ($)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-list">
                                        <tr>
                                            <td>1</td>
                                            <td>Oil Filter</td>
                                            <td>1.00</td>
                                            <td>50.00</td>
                                            <td>1.00</td>
                                            <td>10.00</td>
                                            <td>62.00</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Oil Filter</td>
                                            <td>1.00</td>
                                            <td>50.00</td>
                                            <td>1.00</td>
                                            <td>10.00</td>
                                            <td>62.00</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Oil Filter</td>
                                            <td>1.00</td>
                                            <td>50.00</td>
                                            <td>1.00</td>
                                            <td>10.00</td>
                                            <td>62.00</td>
                                        </tr>
                                    </tbody>
                                </table><!--end table-->
                            </div>
                            <div class="card-header p-0 pb-2 mb-3">
                                <h4 class="card-title mb-0 flex-grow-1">Labor</h4>
                            </div>
                            <div class="table-block table-responsive">
                                <table class="table table-borderless table-nowrap align-middle mb-0">
                                    <thead>
                                        <tr class="table-active">
                                            <th scope="col">#</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Rate</th>
                                            <th scope="col">Hours</th>
                                            <th scope="col">Cost</th>
                                            <th scope="col">Tax</th>
                                            <th scope="col">Total ($)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="labour-list">
                                        <tr>
                                            <td>1</td>
                                            <td>jon</td>
                                            <td>40</td>
                                            <td>25</td>
                                            <td>1000</td>
                                            <td>10</td>
                                            <td>1100</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>jon</td>
                                            <td>40</td>
                                            <td>25</td>
                                            <td>1000</td>
                                            <td>10</td>
                                            <td>1100</td>
                                        </tr>
                                    </tbody>
                                </table><!--end table-->
                            </div>
                            <div class="border-top border-top-dashed mt-2">
                                <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                    <tbody>
                                        <tr>
                                            <td>Total Labor</td>
                                            <td class="text-end" id="total_labour">$1,000.00</td>
                                        </tr>
                                        <tr>
                                            <td>Total Parts</td>
                                            <td class="text-end" id="total_parts">$55.55</td>
                                        </tr>
                                        <tr>
                                            <td>Tax (5%)</td>
                                            <td class="text-end" id="total_tax">$105.05</td>
                                        </tr>
                                        <tr class="border-top border-top-dashed fs-15">
                                            <th scope="row">Grand Total</th>
                                            <th class="text-end" id="grand_total">$1,160.60</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                        </div>
                        <!--end card-body-->
                    </div><!--end col-->
                </div><!--end row-->
            </div>
            <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line"></i> Print</a>
                <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line"></i> Download</a>
                <a href="javascript:void(0);" class="btn btn-danger">Close</a>
            </div>
        </div>
    </div>
</div>

<!-- Payment offcanvas -->
<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarPayment" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Payment</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Invoice Number*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter invoice number" value="0033" disabled />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Payment Number*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter payment number" value="P370415" disabled />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Payment Date*</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Enter date" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Amount Due($)*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter amount due" value="460.60" disabled />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Payment Type*</label>
                            <select class="form-select" aria-label="Select payment type">
                                <option selected="">Select payment type </option>
                                <option value="1">PayPal</option>
                                <option value="2">Cash</option>
                                <option value="3">Card</option>
                            </select>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Amount Received($)*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter amount" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Last Service Date</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Enter date" value="2024-11-10" disabled />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Next Service Date</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Enter date" value="2025-11-10" disabled />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Frequency*</label>
                            <select class="form-select" aria-label="Select frequency to next service date">
                                <option selected="">Select frequency to next service date </option>
                                <option value="1">Every 3 Months</option>
                                <option value="2">Every 6 Months</option>
                                <option value="3">Every 9 Months</option>
                                <option value="4">Every 12 Months</option>
                            </select>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-action-block">
                    <div class="form-action-btn">
                        <button type="button" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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

<!-- right offcanvas -->
@include('layouts.explore')

@endsection