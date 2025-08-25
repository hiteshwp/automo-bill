@extends('layouts.app')

@section('title', 'My Profile | '.config('app.name', 'Laravel'))

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="page-title-box p-0 d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">My Profile</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="position-relative imageloader">
            <div class="profile-wid-bg profile-setting-img">
                <img src="@if ($user->user_profile_background_pic )
                                                {{ asset('uploads/profiles/user/'.$user->user_profile_background_pic) }}
                                            @else
                                                {{ asset('assets/images/profile-bg.jpg') }}
                                            @endif
                                            " class="profile-wid-img" alt="" />
                <div class="overlay-content">
                    <div class="text-end p-3">
                        <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                            <input id="client-profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input">
                            <label for="client-profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                <i class="ri-image-edit-line"></i> Change Cover
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-3">
                <div class="card mt-n5">
                    <div class="card-body p-4 imageloader">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                <img src="@if ($user->user_profile_pic )
                                                {{ asset('uploads/profiles/user/'.$user->user_profile_pic) }}
                                            @else
                                                {{ asset('assets/images/users/avatar-1.jpg') }}
                                            @endif 
                                            " class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="client-profile-img-file-input" type="file" class="profile-img-file-input">
                                    <label for="client-profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <h5 class="fs-16 mb-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-0">{{ $user->user_type }}</p>
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-xxl-9">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link text-body active" data-bs-toggle="tab" href="#personalDetails" role="tab">Personal Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-body" data-bs-toggle="tab" href="#changePassword" role="tab">
                                    <i class="far fa-user"></i>
                                    Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                <form id="frmupdateclientprofile" method="post">
                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="formgroup mb-3">
                                                <label for="firstnameInput" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="firstnameInput" placeholder="Enter your firstname" value="{{ $user->name }}" name="txtfullname">
                                            </div>
                                        </div>
                                        @php
                                            $phone = "";
                                            if($user->mobilenumber)
                                            {
                                                $phone = "+".$user->countrycode.$user->mobilenumber;
                                            }
                                        @endphp
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="formgroup mb-3">
                                                <label for="txtgopphonenumber" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" id="txtgopphonenumber" placeholder="Enter your phone number" value="{{ $phone }}" name="txtmobile">
                                                <div id="error-msg-gop" class="hide"></div>
                                                <div id="valid-msg-gop" class="hide"></div>
                                                <button id="btn-gop" style="display:none;">Validate</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="formgroup mb-3">
                                                <label for="emailInput" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="emailInput" disabled placeholder="Enter your email" value="{{ $user->email }}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <div class="formgroup mb-3">
                                                <label class="form-label" for="validationCustom05">Country*</label>
                                                <select class="common-single-select" name="txteditcountry" id="country" required>
                                                    <option value="" selected>Select Country</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id }}" {{ $country->id == $user->country_id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <div class="formgroup mb-3">
                                                <label class="form-label" for="validationCustom05">State*</label>
                                                <select class="common-single-select" name="txteditstate" id="state" required>
                                                    <option value="" selected>Select State</option>
                                                    @foreach($states as $statelist)
                                                    <option value="{{ $statelist->id }}" {{ $statelist->id == $user->state_id ? 'selected' : '' }}>
                                                        {{ $statelist->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <div class="formgroup mb-3">
                                                <label class="form-label" for="validationCustom05">Town/City*</label>
                                                <select class="common-single-select" name="txteditcity" id="city" required>
                                                    <option value="" selected>Select State</option>
                                                    @foreach($cities as $citieslist)
                                                    <option value="{{ $citieslist->id }}" {{ $citieslist->id == $user->city_id ? 'selected' : '' }}>
                                                        {{ $citieslist->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <div class="formgroup mb-3">
                                                <label for="emailInput" class="form-label">zip</label>
                                                <input type="text" class="form-control" id="zipInput" name="zipInput" placeholder="Enter your zip" value="{{ $user->zip }}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12 mt-3">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary" id="btnclientpupdate">Update</button>
                                                <input type="hidden" name="txtclientpphonecode" id="txtclientpphonecode" value="{{ $user->countrycode }}"/>
                                                <input type="hidden" name="txtclientpphoneicocode" id="txtclientpphoneicocode" value="{{ $user->countryisocode }}"/>
                                                <input type="hidden" name="txtclientid" id="txtclientid" value="{{ $user->id }}"/>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane" id="changePassword" role="tabpanel">
                                <form id="frmupdateclientppassword" method="post">
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <div class="formgroup mb-3">
                                                <label for="txtoldpassword" class="form-label">Old Password*</label>
                                                <input type="password" class="form-control" id="txtoldpassword" placeholder="Enter current password" name="txtoldpassword" required>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div class="formgroup mb-3">
                                                <label for="txtnewpassword" class="form-label">New Password*</label>
                                                <input type="password" class="form-control" id="txtnewpassword" placeholder="Enter new password" name="txtnewpassword" required>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div class="formgroup mb-3">
                                                <label for="txtconfirmpassword" class="form-label">Confirm Password*</label>
                                                <input type="password" class="form-control" id="txtconfirmpassword" placeholder="Confirm password" name="txtconfirmpassword" data-parsley-equalto="#txtnewpassword" required>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <!--end col-->
                                        <div class="col-lg-12 mt-3">
                                            <div class="text-end">
                                                <button type="submit" id="txtclientpchangepassword" class="btn btn-primary">Change Password</button>
                                                <input type="hidden" name="txtclientppid" id="txtclientppid" value="{{ $user->id }}"/>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <!--end tab-pane-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!-- container-fluid -->
</div>
<!-- right offcanvas -->
@include('layouts.explore')

@endsection