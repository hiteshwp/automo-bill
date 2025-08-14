<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') }} - Log In</title>
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
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

</head>

<body>
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper vh-100 d-flex">
        <!-- auth-page content -->
        <div class="auth-page-content">
            <div class="row g-0 h-100">
                <div class="col-lg-6">
                    <div class="auth-form-block">
                        <div class="auth-form-container">
                            <div class="auth-form-title-block">
                                <div class="auth-logo-block">
                                    <img src="{{ asset('assets/images/logo-dark.png') }}" height="40" alt="" />
                                </div>
                                <p class="text-muted">Enter the information to new password.</p>
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
                                <form method="POST" action="{{ route('password.store') }}">
                                @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Email Address*</label>
                                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                                        @error('email')
                                        <div class="text-danger" role="alert">{{ $message }}</div>
                                        @enderror
                                    </div>
    
                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Enter your password" id="password-input">
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon shadow-none" type="button" id="password-addon"><i class="ri-eye-line align-middle"></i></button>
                                            @error('password')
                                                <div class="text-danger" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Confirm Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" class="form-control pe-5 password-input" name="password_confirmation" placeholder="Enter confirm password" id="password-input">
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon shadow-none" type="button" id="password-addon"><i class="ri-eye-line align-middle"></i></button>
                                            @error('password')
                                                <div class="text-danger" role="alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
    
                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                    </div>    
                                </form>
                            </div>
                             <div class="mt-4 text-left">
                                <p class="mb-0">Go to Sign In <a href="{{ route('login') }}" class="text-primary"> Sign In</a></p>
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
                                    <img src="assets/images/logo-light.png" alt="" height="50" />
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
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <!-- password-addon init -->
    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (session('status'))
            toastr.success("{{ session('status') }}", "Success", { timeOut: 5000 });
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}", "Error", { timeOut: 5000 });
            @endforeach
        @endif
    </script>
</body>
</html>
