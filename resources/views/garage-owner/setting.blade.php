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
                            <h4 class="mb-sm-0">Settings</h4>
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
        
        <!-- start row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Financial Settings</h4>
                    </div>
                    <div class="card-body">
                        <form id="frmfinancialsetting" method="post">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="validationCustom05">Tax Rates*</label>
                                        <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter tax rates" name="txttaxrates1" value="{{ optional($setting_data)->setting_tax_1 ?? '' }}" />                                    
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="validationCustom05">Tax Rates</label>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" id="validationCustom05" placeholder="Enter tax rates" name="txttaxrates2" value="{{ optional($setting_data)->setting_tax_2 ?? '' }}"/>
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="validationCustom05">Tax Rates</label>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" id="validationCustom05" placeholder="Enter tax rates" name="txttaxrates3" value="{{ optional($setting_data)->setting_tax_3 ?? '' }}" />
                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="validationCustom05">Labor Rates*</label>
                                        <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter labor rates" name="txtlabourrate1" value="{{ optional($setting_data)->setting_labor_1 ?? '' }}"  />                                    
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="validationCustom05">Labor Rates</label>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" id="validationCustom05" placeholder="Enter labor rates" name="txtlabourrate2" value="{{ optional($setting_data)->setting_labor_2 ?? '' }}"  />
                                        </div>                                    
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="validationCustom05">Labor Rates</label>
                                        <div class="d-flex gap-2">
                                            <input type="text" class="form-control" id="validationCustom05" placeholder="Enter labor rates" name="txtlabourrate3" value="{{ optional($setting_data)->setting_labor_3 ?? '' }}"  />
                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="validationCustom05">Tax Number*</label>
                                        <input type="text" class="form-control" id="validationCustom05" required placeholder="Enter tax number" name="txttaxnumber" value="{{ optional($setting_data)->setting_tax_number ?? '' }}"  />                                    
                                    </div>
                                </div>
                            </div>

                            <div class="alert border-0 alert-warning text-center mb-2" role="alert">
                                Tax information is used to calculate Tax on sales and for display on invoice.
                            </div>

                            <div class="form-action-block">
                                <div class="form-action-btn">
                                    <button type="submit" class="btn btn-primary" id="btnfinancialsetting">Update</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

        <!-- start row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Company Settings</h4>
                    </div>
                    <div class="card-body">
                        <form id="frmcompanysetting" method="post">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtcompanylogo" id="companysettingimage" data-imagepath="{{ asset('uploads/company/') }}/{{ optional($setting_data)->setting_logo_image ?? '' }}">Logo*</label>
                                        <div class="avatar-xl">
                                            <input type="file" class="filepond filepond-input-circle companysettingimg" name="filepond" accept="image/png, image/jpeg, image/gif" />
                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtbusinessname">Business Name*</label>
                                        <input type="text" class="form-control" id="txtbusinessname" required placeholder="Enter business name" name="txtbusinessname" value="{{ optional($setting_data)->setting_system_name ?? '' }}" />                                    
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtbusinesstagline">Business Tagline*</label>
                                        <input type="text" class="form-control" id="txtbusinesstagline" required placeholder="Enter business tagline" name="txtbusinesstagline" value="{{ optional($setting_data)->setting_tag_line ?? '' }}" />                                    
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtbusinessaddress">Business Address*</label>
                                        <textarea type="text" class="form-control resize-none" rows="1" id="txtbusinessaddress" required placeholder="Enter business address" name="txtbusinessaddress">{{ optional($setting_data)->setting_address ?? '' }}</textarea>                                    
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtcompanyphone">Phone*</label>
                                        <input class="form-control" id="txtcompanyphone" name="txtcompanyphone" type="tel" value="+{{ optional($setting_data)->setting_countrycode ?? '' }}{{ optional($setting_data)->setting_phone_number ?? '' }}" placeholder="Enter your mobile number" required />    
                                        <div id="error-msg-bsp" class="hide"></div>
                                        <div id="valid-msg-bsp" class="hide"></div>
                                        <button id="btn-bsp" style="display:none;">Validate</button>                                
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtbusinessemail">Email*</label>
                                        <input type="text" class="form-control" id="txtbusinessemail" required placeholder="Enter your email" name="txtbusinessemail" value="{{ optional($setting_data)->setting_email ?? '' }}" />                                    
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="formgroup mb-3">
                                        <label class="form-label" for="txtbusinesswebsite">Website</label>
                                        <textarea type="text" class="form-control resize-none" rows="1" id="txtbusinesswebsite" placeholder="Enter your website" name="txtbusinesswebsite">{{ optional($setting_data)->setting_website ?? '' }}</textarea>                                    
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="show-tax-number" name="txtshowtaxnumber" {{ !empty($setting_data->setting_show_tax_number) && $setting_data->setting_show_tax_number == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show-tax-number">Show Tax Number</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="show-invoice-number" name="txtshowinvoicenumber" {{ !empty($setting_data->setting_show_invoice_number) && $setting_data->setting_show_invoice_number == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show-invoice-number">Show Invoice Number</label>
                                    </div>
                                </div>
                            </div>

                            <div class="alert border-0 alert-warning text-center mb-2 mt-3" role="alert">
                                The following information will be used for your invoices and estimates.
                            </div>

                            <div class="form-action-block">
                                <div class="form-action-btn">
                                    <button type="submit" class="btn btn-primary" id="btncomapanysetting">Update</button>
                                    <input type="hidden" name="txtcspphonecode" id="txtcspphonecode" value="{{ optional($setting_data)->setting_countrycode ?? '' }}"/>
                                    <input type="hidden" name="txtcspphoneicocode" id="txtcspphoneicocode" value="{{ optional($setting_data)->setting_countryisocode ?? '' }}"/>
                                </div>
                            </div>
                        </form>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

        <!-- start row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Company Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert border-0 alert-warning text-center mb-2 mt-3" role="alert">
                            Linking your Google Account enables autocomplete for entering new clients, and syncing your Google Calendar.
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12 d-flex justify-content-center mt-2">
                                <div class="formgroup">
                                    <button type="button" class="btn btn-primary">Link Google Account</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div>
    <!-- container-fluid -->
</div>

@include('layouts.explore')

@endsection