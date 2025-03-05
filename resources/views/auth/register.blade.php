<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') }} - Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Tell Input Css -->
    <link href="{{ asset('assets/css/intlTelInput.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Parsley CSS -->
    <link href="{{ asset('assets/css/parsley.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper vh-100 d-flex">
        <!-- auth-page content -->
        <div class="auth-page-content">
            <div class="row g-0 h-100">
                <div class="col-lg-6">
                    <div class="auth-form-block">
                        <div class="auth-form-container auth-form-sign-container">
                            <div class="auth-form-title-block">
                                <div class="auth-logo-block">
                                    <img src="{{ asset('assets/images/logo-dark.png') }}" height="40" alt="" />
                                </div>
                                <h5>Register Account</h5>
                                <p class="text-muted">Get your Free Auto Mobill account now.</p>
                            </div>

                             <!-- Display General Errors -->
                             @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
    
                            <div class="auth-form">
                                <form method="POST" action="{{ route('register') }}" id="frmregister">
                                @csrf
                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="fullname" placeholder="Enter your name" value="{{ old('fullname')}}" required>
                                                @error('fullname')
                                                    <div class="text-danger" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Register As a</label>
                                                <select class="form-select" aria-label="Default select example" name="usaertype" id="usaertype" required>
                                                    <option selected>Select Type</option>
                                                    <option value="Garage Owner">Garage Owner</option>
                                                    <option value="User">User</option>
                                                </select>
                                                @error('usaertype')
                                                    <div class="text-danger" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Business/Company</label>
                                                <input type="text" class="form-control" id="business/company" name="businessname" placeholder="Enter your business/company" value="{{ old('businessname') }}" required>
                                                @error('businessname')
                                                    <div class="text-danger" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Mobile Number</label>
                                                <input class="form-control" id="phone" name="mobilenumber" type="tel" value="" placeholder="Enter your mobile number"  value="{{ old('mobilenumber') }}" required/>
                                                @error('mobilenumber')
                                                    <div class="text-danger" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>                                        
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label for="taxnumber" class="form-label">Tax Number</label>
                                                <input type="text" class="form-control" id="taxnumber" name="taxnumber" placeholder="xxxx-xxxx-xxxx" value="{{ old('taxnumber') }}" required>
                                                @error('taxnumber')
                                                    <div class="text-danger" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label for="website" class="form-label">Website</label>
                                                <input type="text" class="form-control" id="website" name="website" placeholder="Enter your website" value="{{ old('website') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label for="emailaddress" class="form-label">Email Address</label>
                                                <input type="text" class="form-control" id="emailaddress" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <div class="text-danger" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">Password</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" class="form-control pe-5 password-input" placeholder="Enter your password" id="password-input" name="password" required>
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon shadow-none" type="button" id="password-addon"><i class="ri-eye-line align-middle"></i></button>
                                                    @error('password')
                                                        <div class="text-danger" role="alert">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="password-input">Confirm Password</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" class="form-control pe-5 password-input" placeholder="Enter your Confirm password" id="password-input" name="password_confirmation" required>
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon shadow-none" type="button" id="password-addon"><i class="ri-eye-line align-middle"></i></button>
                                                    @error('confirmpassword')
                                                        <div class="text-danger" role="alert">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="address" placeholder="Enter your address" name="address" value="{{ old('address') }}" required>
                                                @error('address')
                                                    <div class="text-danger" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Country</label>
                                                <select class="form-select" aria-label="Default select example" name="country" id="country" required>
                                                    <option selected>Select Country</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('country')
                                                    <div class="text-danger" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">State</label>
                                                <select class="form-select" aria-label="Default select example" id="state" name="state" required>
                                                    <option selected>Select State</option>
                                                </select>
                                                @error('state')
                                                    <div class="text-danger" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Town/City</label>
                                                <select class="form-select" aria-label="Default select example" name="city" id="city" required>
                                                    <option selected>Select City</option>
                                                </select>
                                                @error('city')
                                                    <div class="text-danger" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Zip Code</label>
                                                <input type="text" class="form-control" id="zip-code" name="zip" value="{{ old('zip') }}" placeholder="Enter your zip code" required>
                                                @error('zip')
                                                    <div class="text-danger" role="alert">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check">I agree with the <a href="#" class="text-primary">T&C</a> / <a href="#" class="text-primary">Privacy Policy</a></label>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Sign Up</button>
                                        <input type="hidden" name="phonecode" class="hdnphonecode" value="" id="hdnphonecode"/>
                                    </div>
    
                                    <div class="mt-4 text-left">
                                        <div class="signin-other-title">
                                            <h5 class="mb-4 title fw-normal">Or Log in with</h5>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-soft-danger waves-effect waves-light"><i class="ri-google-fill fs-16"></i> Google</button>
                                            <button type="button" class="btn btn-soft-primary waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i> Facebook</button>
                                        </div>
                                    </div>
    
                                </form>
                            </div>
    
                            <div class="mt-4 mb-4 text-left">
                                <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary"> Log In</a></p>
                            </div>
                        </div>
                        <div class="auth-footer-block">
                            <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> Auto Mobill. Designed with by <a href="#" class="link">Webintoto</a> All rights reserved.</p>
                        </div>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-lg-6">
                    <div class="auth-one-bg h-100 d-flex align-items-center">
                        <div class="position-relative d-flex flex-column m-auto">
                            <div class="auth-info-block">
                                <div class="auth-info-logo">
                                    <img src="{{ asset('assets/images/logo-light.png') }}" height="50" alt="" />
                                </div>
                                <div class="auth-info-details-block">
                                    <h2>Welcome Motor Repair Bill</h2>
                                    <h5>Login to your Account</h5>
                                    <p>Welcome to the Admin Dashboard. Please log in to securely manage your administrative tools and oversee platform activities.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end auth page content -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/intlTelInputWithUtils.js') }}"></script>
    <script>
        /* phone number country input dropdown js start */
        const input = document.querySelector("#phone");
        const iti = window.intlTelInput(input, {
        initialCountry: "us",
        });
        window.iti = iti; // useful for testing

        // Get the hidden input field
        const hiddenPhoneCodeInput = document.querySelector("#hdnphonecode");

        // Function to update hidden input with the selected dial code
        const updateHiddenPhoneCode = () => {
            const selectedCountryData = iti.getSelectedCountryData();
            hiddenPhoneCodeInput.value = selectedCountryData.dialCode; // Get the dial code
            console.log('Selected dial code:', selectedCountryData.dialCode);
        };

        // Update the hidden input when the country flag is clicked
        input.addEventListener('countrychange', updateHiddenPhoneCode);

        const button = document.querySelector("#btn");
        const errorMsg = document.querySelector("#error-msg");
        const validMsg = document.querySelector("#valid-msg");
        const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

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

        // on click button: validate
        button.addEventListener('click', () => {
            console.log("Hello");
        reset();
        if (!input.value.trim()) {
            showError("Required");
        } else if (iti.isValidNumber()) {
            validMsg.innerHTML = "Valid number: " + iti.getNumber();
            document.querySelector("#hdnphonecode").value = iti.getNumber();
            $("#hdnphonecode").val(iti.getNumber());
            validMsg.classList.remove("hide");
        } else {
            const errorCode = iti.getValidationError();
            const msg = errorMap[errorCode] || "Invalid number";
            showError(msg);
        }
        });

        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
        /* phone number country input dropdown js end */

    </script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <!-- password-addon init -->
    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/js/parsley.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            //$("#frmregister").parsley();
        });

        // Fetch states when a country is selected
        $('#country').on('change', function () {
            let countryId = $(this).val();
            $('#state').empty().append('<option value="">Select State</option>');
            $('#city').empty().append('<option value="">Select City</option>');

            if (countryId) {
                $.ajax({
                    url: '/get-states/' + countryId,
                    type: 'GET',
                    success: function (states) {
                        $.each(states, function (id, name) {
                            $('#state').append('<option value="' + id + '">' + name + '</option>');
                        });
                    }
                });
            }
        });

        // Fetch cities when a state is selected
        $('#state').on('change', function () {
            let stateId = $(this).val();
            $('#city').empty().append('<option value="">Select City</option>');

            if (stateId) {
                $.ajax({
                    url: '/get-cities/' + stateId,
                    type: 'GET',
                    success: function (cities) {
                        $.each(cities, function (id, name) {
                            $('#city').append('<option value="' + id + '">' + name + '</option>');
                        });
                    }
                });
            }
        });

    </script>
</body>
</html>