@extends('layouts.app')

@section('title', 'My Invoice List | '.config('app.name', 'Laravel'))

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-title-box p-0 d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Invoice List</h4>
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
                            <table id="userInvoiceTable" class="table table-hover table-bordered w-100" data-route="{{ route('user.invoice.data') }}">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Booking ID</th>
                                        <th>Invoice</th>
                                        <th>Garage Owner</th>
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

<!-- right offcanvas -->
@include('layouts.explore')

@endsection