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
                            <h4 class="mb-sm-0 d-flex align-items-center gap-2"><a href="{{ route('garage-owner.booking.list') }}" class="btn btn-soft-primary btn-icon shadow-none"><i class="ri-arrow-left-line"></i></a> New Booking Estimate - <span class="fs-14 fw-normal">({{ $booking_data->client_name }})</span></h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <a href="{{ route('garage-owner.booking.list') }}" class="btn btn-primary btn-select2"><i class="ri-add-large-line"></i> New Booking</a>
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
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card" id="demo">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8 col-lg-9">
                                <form method="post" id="frmnewestimateinformation">
                                    <div class="card-header border-bottom-dashed py-4 px-0">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <img src="{{ asset('assets/images/logo-dark.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="40">
                                                <img src="{{ asset('assets/images/logo-light.png') }}" class="card-logo card-logo-light" alt="logo light" height="40">
                                                <div class="mt-4">
                                                    <h6 class="text-muted text-uppercase fw-semibold">Quote/Estimate</h6>
                                                    <div class="formgroup mb-3 custom-width1">
                                                        <input type="text" class="form-control" data-provider="flatpickr" name="txtestimatedate" data-date-format="Y-m-d" placeholder="Select date" />
                                                    </div>
                                                </div>
                                            </div>
                                            @php
                                                $phone = "N/A";
                                                if($setting_data->setting_phone_number)
                                                {
                                                    $phone = "+".$setting_data->setting_countrycode. " " .$setting_data->setting_phone_number;
                                                }
                                            @endphp
                                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                                <h6><span>{{ $setting_data->setting_system_name ?? "N/A" }}</span></h6>
                                                <h6><span>{{ $setting_data->setting_tag_line ?? "N/A" }}</span></h6>
                                                <h6><span class="text-muted fw-normal">Address:</span> <span id="address"> {{ $setting_data->setting_address ?? "N/A" }}</span></h6>
                                                <h6><span class="text-muted fw-normal">Phone:</span> <span id="contact-no"> {{ $phone }}</span></h6>
                                                <h6><span class="text-muted fw-normal">Email:</span> <span id="email">{{ $setting_data->setting_email ?? "N/A" }}</span></h6>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="invoice-user-info-list py-4">
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Client ID</p>
                                            <h5 class="fs-14 mb-0"><span id="address">{{ $booking_data->booking_customer_id }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Name</p>
                                            <h5 class="fs-14 mb-0"><span id="name">{{ $booking_data->client_name }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Address</p>
                                            <h5 class="fs-14 mb-0"><span id="address">{{ $booking_data->client_address }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Date</p>
                                            <h5 class="fs-14 mb-0"><span id="invoice-date">{{ date("d M, Y", strtotime($booking_data->booking_date_time)) }}</span> <small class="text-muted" id="invoice-time">{{ date("h:iA", strtotime($booking_data->booking_date_time)) }}</small></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">VIN</p>
                                            <h5 class="fs-14 mb-0"><span id="vin">{{ $booking_data->vin }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Vehicle</p>
                                            <h5 class="fs-14 mb-0"><span id="vehicle">{{ $booking_data->vehicle }}</span></h5>
                                        </div>
                                    </div>
                                    <div class="invoice-form-block">
                                        <div class="invoice-form">
                                            <div class="card-header align-items-center d-flex border-top border-top-dashed border-bottom-0 px-0">
                                                <h4 class="card-title mb-0 flex-grow-1">Labour</h4>

                                                <a href="javascript:new_link()" id="addItemNewEstimation" class="btn btn-sm btn-soft-secondary"><i class="ri-add-fill me-1 align-bottom"></i> Add Item</a>
                                            </div>
                                            <div class="table-block table-responsive">
                                                <table class="invoice-table table table-borderless table-nowrap mb-0">
                                                    <thead class="align-middle">
                                                        <tr class="table-active">
                                                            <th scope="col" style="width: 50px;">#</th>
                                                            <th scope="col">Labour</th>
                                                            <th scope="col">Hours</th>
                                                            <th scope="col" style="width: 110px;">Rate</th>
                                                            <th scope="col">Cost</th>
                                                            <th scope="col" style="width: 110px;">Tax</th>
                                                            <th scope="col">Total ($)</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="labouritemlistingwrapper">
                                                        <tr class="product labour-row">
                                                            <td>1</td>
                                                            <td>
                                                                <div class="formgroup">
                                                                    <input type="text" class="form-control" id="validationCustom05" name="txtlabourname[]" required placeholder="Enter labour name" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="formgroup">
                                                                    <input type="text" class="form-control hours" name="txtlabourhours[]" id="validationCustom05" required placeholder="Enter hours" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="formgroup">
                                                                    <select class="form-select rate" name="txtlabourcost[]">
                                                                        <option>Cost</option>
                                                                        <option value="{{ $setting_data->setting_labor_1 }}">{{ $setting_data->setting_labor_1 }}</option>
                                                                        <option value="{{ $setting_data->setting_labor_2 }}">{{ $setting_data->setting_labor_2 }}</option>
                                                                        <option value="{{ $setting_data->setting_labor_3 }}">{{ $setting_data->setting_labor_3 }}</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="formgroup">
                                                                    <input type="text" class="form-control cost" id="validationCustom05" name="txttotallabourcust[]" required placeholder="Enter cost" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="formgroup">
                                                                    <select class="form-select tax" name="txtlabourtax[]">
                                                                        <option>None</option>
                                                                        <option value="{{ $setting_data->setting_tax_1 }}">{{ $setting_data->setting_tax_1 }}</option>
                                                                        <option value="{{ $setting_data->setting_tax_2 }}">{{ $setting_data->setting_tax_2 }}</option>
                                                                        <option value="{{ $setting_data->setting_tax_3 }}">{{ $setting_data->setting_tax_3 }}</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <input type="text" class="form-control bg-light border-0 product-line-price total" name="txtlabourtotal[]" placeholder="$0.00" readonly />
                                                                </div>
                                                            </td>
                                                            <td class="product-removal">
                                                                <a href="javascript:void(0)" class="btn btn-soft-danger btn-border btn-icon shadow-none disabled" title="Delete"><i class="ri-delete-bin-6-line"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--end table-->
                                            </div>
                                        </div>

                                        <div class="invoice-form mt-4">
                                            <div class="card-header align-items-center d-flex border-top border-top-dashed border-bottom-0 px-0">
                                                <h4 class="card-title mb-0 flex-grow-1">Parts</h4>
                                                <div class="card-header-action-block d-flex flex-wrap gap-2">
                                                    <a href="javascript:void(0);" id="addProductNewEstimation" class="btn btn-sm btn-soft-secondary"><i class="ri-add-fill align-bottom"></i> Add Item</a>
                                                    <button type="button" class="btn btn-sm btn-soft-success btn-select3" data-bs-toggle="offcanvas" data-bs-target="#sidebarPartProduct" aria-controls="offcanvasRight"><i class="ri-add-fill align-bottom"></i> Add Part</button>
                                                </div>
                                            </div>
                                            <div class="table-block table-responsive">
                                                <table class="invoice-table table table-borderless table-nowrap mb-0">
                                                    <thead class="align-middle">
                                                        <tr class="table-active">
                                                            <th scope="col" style="width: 50px;">#</th>
                                                            <th scope="col">Item</th>
                                                            <th scope="col">Qty</th>
                                                            <th scope="col">Cost</th>
                                                            <th scope="col">Markup%</th>
                                                            <th scope="col" style="width: 110px;">Tax</th>
                                                            <th scope="col">Total ($)</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="productitemlistingwrapper">
                                                        <tr class="product product-row">
                                                            <td>1</td>
                                                            <td>
                                                                <div class="formgroup">
                                                                    <select class="form-select product-select" name="txtproductname[]">
                                                                        <option value="">Select Any Item</option>
                                                                        @foreach($product_list as $productlist)
                                                                        <option value="{{ $productlist->product_id }}">
                                                                            {{ $productlist->product_name }}
                                                                        </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="formgroup">
                                                                    <div class="input-step light full-width">
                                                                        <button type="button" class="minus">–</button>
                                                                        <input type="number" class="product-quantity" name="txtproductqty[]" value="1" min="1" max="10000">
                                                                        <button type="button" class="plus">+</button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="formgroup">
                                                                    <input type="text" class="form-control product-price" id="validationCustom05" name="txtproductprice[]" required placeholder="Enter price" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="formgroup">
                                                                    <input type="text" class="form-control product-cost" id="validationCustom05" name="txtproductcost[]" required placeholder="Enter cost" />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="formgroup">
                                                                    <select class="form-select product-tax" name="txtproducttax[]">
                                                                        <option value="">None</option>
                                                                        <option value="{{ $setting_data->setting_tax_1 }}">{{ $setting_data->setting_tax_1 }}</option>
                                                                        <option value="{{ $setting_data->setting_tax_2 }}">{{ $setting_data->setting_tax_2 }}</option>
                                                                        <option value="{{ $setting_data->setting_tax_3 }}">{{ $setting_data->setting_tax_3 }}</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <input type="text" class="form-control bg-light border-0 product-line-price" name="txtproducttotalprice[]" placeholder="$0.00" readonly />
                                                                    <input type="hidden" class="txtproducttitle" name="txtproducttitle[]" value=""/>
                                                                </div>
                                                            </td>
                                                            <td class="product-removal">
                                                                <a href="javascript:void(0)" class="btn btn-soft-danger btn-border btn-icon shadow-none disabled" title="Delete"><i class="ri-delete-bin-6-line"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--end table-->
                                            </div>
                                        </div>

                                        <div class="invoice-note-block mt-4">
                                            <div class="formgroup">
                                                <label class="form-label">Notes</label>
                                                <textarea class="form-control resize-none" rows="5" placeholder="Enter your note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="invoice-total-info py-4 px-0">
                                        <div class="border-top border-top-dashed mt-2">
                                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                                <tbody>
                                                    <tr>
                                                        <td>Total Labour</td>
                                                        <td class="text-end" id="txttotallabour">$0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Parts/Materials</td>
                                                        <td class="text-end" id="txttotalpartsmaterials">$0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tax</td>
                                                        <td class="text-end" id="txttotaltax"> 0.00</td>
                                                    </tr>
                                                    <tr class="border-top border-top-dashed fs-15">
                                                        <th scope="row">Total Due Amount</th>
                                                        <th class="text-end" id="txttotalduewamount">$0.00</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!--end table-->
                                        </div>
                                        <div class="mt-4">
                                            <div class="alert alert-warning">
                                                <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                                    <span id="note">All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or credit card or direct payment online. If account is not paid within 7 days the credits details supplied as confirmation of work undertaken will be charged the agreed quoted fee noted above.
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                            <div class="formgroup form-check">
                                                <input class="form-check-input" type="checkbox" id="estimate" checked />
                                                <label class="form-check-label" for="estimate">Select to send Estimate to client.</label>
                                            </div>
                                            <button type="submit" class="btn btn-success" id="btnnewestimate">Create</button>
                                            <input type="hidden" name="txtsumtotallabour" id="txtsumtotallabour"/>
                                            <input type="hidden" name="txtsumtotalparts" id="txtsumtotalparts"/>
                                            <input type="hidden" name="txtsumtotaltax" id="txtsumtotaltax"/>
                                            <input type="hidden" name="txtsumtotaldueamountexcepttax" id="txtsumtotaldueamountexcepttax"/>
                                            <input type="hidden" name="txtsumtotaldueamount" id="txtsumtotaldueamount"/>
                                            <input type="hidden" name="txtbookingid" id="txtbookingid" value="{{ $booking_data->booking_id }}"/>
                                            <input type="hidden" name="txtcustomerid" id="txtcustomerid" value="{{ $booking_data->booking_customer_id }}"/>
                                            <input type="hidden" name="txtvehicleid" id="txtvehicleid" value="{{ $booking_data->booking_vehicle_id }}"/>
                                        </div>
                                    </div>
                                </form>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                </div>
                <!--end card-->
            </div>
        </div><!-- end row -->
    </div>
    <!-- container-fluid -->
</div>

<div class="offcanvas offcanvas-end offcanvas-width-50" tabindex="-1" id="sidebarPartProduct" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Add Part Product</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="offcanvasFormBlock">
            <form class="form-fields-block needs-validation">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Product Number*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter product number" value="PR340607" disabled />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Product Date*</label>
                            <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d.m.y" placeholder="Enter date" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Name*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter name" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label" for="validationCustom05">Price ($)*</label>
                            <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter product price" />
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="formgroup mb-3">
                            <label class="form-label">Supplier*</label>
                            <select class="common-select3" name="vehicle">
                                <option>Select Supplier</option>
                                <option value="">M.G. Motors</option>
                                <option value="">M.G. Motors</option>
                                <option value="">M.G. Motors</option>
                            </select>
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