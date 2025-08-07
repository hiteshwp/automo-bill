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
                            <h4 class="mb-sm-0 d-flex align-items-center gap-2"><a href="{{ route('garage-owner.repair-order.list') }}" class="btn btn-soft-primary btn-icon shadow-none"><i class="ri-arrow-left-line"></i></a> New Invoice - <span class="fs-14 fw-normal">({{ $repair_order_data->client_name }})</span></h4>
                            <div class="page-title-action-list d-flex gap-2">
                                <div class="page-title-action-item">
                                    <a href="{{ route('garage-owner.repair-order.list') }}" class="btn btn-primary btn-select2"><i class="ri-add-large-line"></i> New Invoice</a>
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
                                <form method="post" id="frmnewinvoiceinformation">
                                    <div class="card-header border-bottom-dashed py-4 px-0">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <img src="{{ asset('assets/images/logo-dark.png') }}" class="card-logo card-logo-dark" alt="logo dark" height="40">
                                                <img src="{{ asset('assets/images/logo-light.png') }}" class="card-logo card-logo-light" alt="logo light" height="40">
                                                <div class="mt-4">
                                                    <h6 class="text-muted text-uppercase fw-semibold">Quote/Estimate</h6>
                                                    <div class="formgroup mb-3 custom-width1">
                                                        <input type="text" class="form-control" data-provider="flatpickr" name="txtestimatedate" data-date-format="Y-m-d" placeholder="Select date" value="{{ $repair_order_data->repairorder_order_date }}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                                <h6><span>John Doe Corporation</span></h6>
                                                <h6><span>Man Machine Works</span></h6>
                                                <h6><span class="text-muted fw-normal">Address:</span> <span id="address"> General Palace, Comman Street, VA</span></h6>
                                                <h6><span class="text-muted fw-normal">Phone:</span> <span id="contact-no"> (859)-678-9645</span></h6>
                                                <h6><span class="text-muted fw-normal">Email:</span> <span id="email">support.jdc@mailinator.com</span></h6>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="invoice-user-info-list py-4">
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Client ID</p>
                                            <h5 class="fs-14 mb-0"><span id="address">{{ $repair_order_data->repairorder_customer_id }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Name</p>
                                            <h5 class="fs-14 mb-0"><span id="name">{{ $repair_order_data->client_name }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Address</p>
                                            <h5 class="fs-14 mb-0"><span id="address">{{ $repair_order_data->client_address }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">VIN</p>
                                            <h5 class="fs-14 mb-0"><span id="vin">{{ $repair_order_data->vin }}</span></h5>
                                        </div>
                                        <div class="invoice-user-info-item">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold">Vehicle</p>
                                            <h5 class="fs-14 mb-0"><span id="vehicle">{{ $repair_order_data->vehicle }}</span></h5>
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
                                                        @foreach($labour_data as $labour_data_list)
                                                            <tr class="product labour-row">
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>
                                                                    <div class="formgroup">
                                                                        <input type="text" class="form-control" id="validationCustom05" name="txtlabourname[]" required placeholder="Enter labour name" value="{{ $labour_data_list->estimate_labor_item }}" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="formgroup">
                                                                        <input type="text" class="form-control hours" name="txtlabourhours[]" id="validationCustom05" required placeholder="Enter hours" value="{{ $labour_data_list->estimate_labor_hours }}" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="formgroup">
                                                                        <select class="form-select rate" name="txtlabourcost[]">
                                                                            <option>Cost</option>
                                                                            <option value="60" {{ $labour_data_list->estimate_labor_rate == "60" ? 'selected' : '' }}>60</option>
                                                                            <option value="40" {{ $labour_data_list->estimate_labor_rate == "40" ? 'selected' : '' }}>40</option>
                                                                            <option value="80" {{ $labour_data_list->estimate_labor_rate == "80" ? 'selected' : '' }}>80</option>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="formgroup">
                                                                        <input type="text" class="form-control cost" id="validationCustom05" name="txttotallabourcust[]" required placeholder="Enter cost" value="{{ $labour_data_list->estimate_labor_cost }}" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="formgroup">
                                                                        <select class="form-select tax" name="txtlabourtax[]">
                                                                            <option>None</option>
                                                                            <option value="10" {{ $labour_data_list->estimate_labor_tax == "10" ? 'selected' : '' }}>10</option>
                                                                            <option value="13" {{ $labour_data_list->estimate_labor_tax == "13" ? 'selected' : '' }}>13</option>
                                                                            <option value="15" {{ $labour_data_list->estimate_labor_tax == "15" ? 'selected' : '' }}>15</option>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        <input type="text" class="form-control bg-light border-0 product-line-price total" name="txtlabourtotal[]" placeholder="$0.00" readonly value="{{ $labour_data_list->estimate_labor_total }}" />
                                                                    </div>
                                                                </td>
                                                                <td class="product-removal">
                                                                    <a href="javascript:void(0)" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Delete"><i class="ri-delete-bin-6-line"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
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
                                                        @foreach($product_data as $product_data_list)
                                                            <tr class="product product-row">
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>
                                                                    <div class="formgroup">
                                                                        <select class="form-select product-select" name="txtproductname[]">
                                                                            <option>Select Any Item</option>
                                                                            @foreach($product_list as $productlist)
                                                                            <option value="{{ $productlist->product_id }}" {{ $product_data_list->estimate_parts_product_id == $productlist->product_id ? 'selected' : '' }}>
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
                                                                            <input type="number" class="product-quantity" name="txtproductqty[]" value="{{ $product_data_list->estimate_parts_quantity }}" min="1" max="10000">
                                                                            <button type="button" class="plus">+</button>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="formgroup">
                                                                        <input type="text" class="form-control product-price" id="validationCustom05" name="txtproductprice[]" required placeholder="Enter price" value="{{ $product_data_list->estimate_parts_cost }}" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="formgroup">
                                                                        <input type="text" class="form-control product-cost" id="validationCustom05" name="txtproductcost[]" required placeholder="Enter cost" value="{{ $product_data_list->estimate_parts_markup }}" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="formgroup">
                                                                        <select class="form-select product-tax" name="txtproducttax[]">
                                                                            <option value="">None</option>
                                                                            <option value="10" {{ $product_data_list->estimate_parts_tax == "10" ? 'selected' : '' }}>10</option>
                                                                            <option value="13" {{ $product_data_list->estimate_parts_tax == "13" ? 'selected' : '' }}>13</option>
                                                                            <option value="15" {{ $product_data_list->estimate_parts_tax == "15" ? 'selected' : '' }}>15</option>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        <input type="text" class="form-control bg-light border-0 product-line-price" name="txtproducttotalprice[]" placeholder="$0.00" readonly value="{{ $product_data_list->estimate_parts_total }}" />
                                                                        <input type="hidden" class="txtproducttitle" name="txtproducttitle[]" value="{{ $product_data_list->product_name }}"/>
                                                                    </div>
                                                                </td>
                                                                <td class="product-removal">
                                                                    <a href="javascript:void(0)" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Delete"><i class="ri-delete-bin-6-line"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <!--end table-->
                                            </div>
                                        </div>

                                        <div class="invoice-note-block mt-4">
                                            <div class="formgroup">
                                                <label class="form-label">Notes</label>
                                                <textarea class="form-control resize-none" rows="5" placeholder="Enter your note" name="txtextranotes">{{ $repair_order_data->repairorder_notes }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="invoice-total-info py-4 px-0">
                                        <div class="border-top border-top-dashed mt-2">
                                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                                <tbody>
                                                    <tr>
                                                        <td>Total Labour</td>
                                                        <td class="text-end" id="txttotallabour">${{ $repair_order_data->estimate_labor_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Parts/Materials</td>
                                                        <td class="text-end" id="txttotalpartsmaterials">${{ $repair_order_data->estimate_parts_total }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tax</td>
                                                        <td class="text-end" id="txttotaltax"> {{ $repair_order_data->estimate_tax }}</td>
                                                    </tr>
                                                    <tr class="border-top border-top-dashed fs-15">
                                                        <th scope="row">Total Due Amount</th>
                                                        <th class="text-end" id="txttotalduewamount">${{ $repair_order_data->estimate_total_inctax }}</th>
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
                                                <input class="form-check-input" type="checkbox" id="mail" checked />
                                                <label class="form-check-label" for="mail">Select to send Invoice to client on mail.</label>
                                            </div>
                                            <div class="formgroup form-check">
                                                <input class="form-check-input" type="checkbox" id="sms" checked />
                                                <label class="form-check-label" for="sms">Select to send Invoice to client on sms.</label>
                                            </div>
                                            <button type="submit" class="btn btn-success" id="btnnewestimate">Create</button>
                                            <input type="hidden" name="txtsumtotallabour" id="txtsumtotallabour" value="{{ $repair_order_data->estimate_labor_total }}"/>
                                            <input type="hidden" name="txtsumtotalparts" id="txtsumtotalparts" value="{{ $repair_order_data->estimate_parts_total }}"/>
                                            <input type="hidden" name="txtsumtotaltax" id="txtsumtotaltax" value="{{ $repair_order_data->estimate_tax }}"/>
                                            <input type="hidden" name="txtsumtotaldueamountexcepttax" id="txtsumtotaldueamountexcepttax" value="{{ $repair_order_data->estimate_total }}"/>
                                            <input type="hidden" name="txtsumtotaldueamount" id="txtsumtotaldueamount" value="{{ $repair_order_data->estimate_total_inctax }}"/>
                                            <input type="hidden" name="txtrepairorderid" id="txtrepairorderid" value="{{ $repair_order_data->repairorder_id }}"/>
                                            <input type="hidden" name="txtbookingid" id="txtbookingid" value="{{ $repair_order_data->repairorder_booking_id }}"/>
                                            <input type="hidden" name="txtcustomerid" id="txtcustomerid" value="{{ $repair_order_data->repairorder_customer_id }}"/>
                                            <input type="hidden" name="txtvehicleid" id="txtvehicleid" value="{{ $repair_order_data->repairorder_vehicle_id }}"/>
                                            <input type="hidden" name="txtestimateid" id="txtestimateid" value="{{ $repair_order_data->repairorder_estimate_id }}"/>
                                            <input type="hidden" name="txtgarageid" id="txtgarageid" value="{{ $repair_order_data->repairorder_garage_id }}"/>
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