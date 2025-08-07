$(document).ready(function() {    

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right", // or 'toast-bottom-left', etc.
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear"
    };

    let baseUrl = $(".siteurl").data("url");
    let dataRoute = $('#garageOwnersTable').data('route');
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    if ($('#garageOwnersTable').length) 
    {
        $('#garageOwnersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:dataRoute,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        alert("Session expired. Redirecting to login...");
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("DataTable load error:", xhr.responseText);
                    }
                }
            },
            stateSave: true,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'mobilenumber', name: 'mobilenumber' },
                { data: 'user_type', name: 'user_type' },
                { data: 'country', name: 'country' },
                { data: 'zip', name: 'zip' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']], // Default sorting by ID
            lengthMenu: [10, 25, 50, 100], // Records per page options
            pageLength: 10, // Default records per page
        });
    }

    // Display garage Owner Data on popup
    $(document).on('click', '.viewgarageownerdata', function () {
        const userId = $(this).data('id');
        console.log(userId);
        $.ajax({
            url: baseUrl + '/garage-owners/view',
            type: 'POST',
            data: {
                _token: csrfToken,
                userId: userId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarViewInformation").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarViewInformation").removeClass("offcanvas-loader");
                // Populate the form fields
                $('#ownerprofileimage').prop("src",data.profilepic);
                $('#ownername').text(data.name);
                $('#owneremail').text(data.email);
                $('#ownermobile').text(data.mobilenumber);
                $('#ownerdob').text(data.dob);
                $('#ownergender').text(data.gender);
                $('#owneraddress').text(data.address);
                $('#ownercurrentplan').text(data.currentplan);
                $('#ownerconnectedpaypal').text(data.connected_paypal);
                $('#ownerexpirydate').text(data.expirydate);
            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    // Get garage Owner Data on popup with edit option
    $(document).on('click', '.editgarageownerdata', function () {
        const userId = $(this).data('id');
        console.log(userId);
        $.ajax({
            url: baseUrl + '/garage-owners/editview',
            type: 'POST',
            data: {
                _token: csrfToken,
                userId: userId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarEditGarageOwner").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarEditGarageOwner").removeClass("offcanvas-loader");
                // Populate the form fields
                $('#editnametitle').text("("+data.name+")");
                $('#txteditname').val(data.name);
                $('#txtcompanyname').val(data.businessname);
                $('#txteditemail').val(data.email);
                $('#txteditmobilenumber').val(data.mobilenumber);    
                $('#txteditaddress').val(data.address);
                $('#txteditcountry').val(data.country_id);
                $('#txteditstate').val(data.state_id);
                $('#txteditcity').val(data.city_id);
                $('#txtupdategarageownerid').val(data.id);
            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    // Update Owner data
    $('#frmeditgarageownerdata').parsley();
    $('#frmeditgarageownerdata').on('submit', function (e) {
        e.preventDefault();

        let password = $('#txteditpassword').val().trim();
        let confirmPassword = $('#txteditconfirmpassword').val().trim();

        // Clear previous error
        $('#txteditpassword, #txteditconfirmpassword').removeClass('is-invalid');
        $('.invalid-feedback.password-error').remove();

        if (password || confirmPassword) {
            if (!password || !confirmPassword) {
                $('#txteditpassword, #txteditconfirmpassword').addClass('is-invalid');
                $('#txteditconfirmpassword').after('<div class="invalid-feedback password-error d-block">Both password fields are required.</div>');
                return false;
            }
            if (password !== confirmPassword) {
                $('#txteditpassword, #txteditconfirmpassword').addClass('is-invalid');
                $('#txteditconfirmpassword').after('<div class="invalid-feedback password-error d-block">Passwords do not match.</div>');
                return false;
            }
        }
        if($('#frmeditgarageownerdata').parsley().isValid())
        {
            let form = $(this);
            let formData = {
                id: $('#txtupdategarageownerid').val(),
                name: $('#txteditname').val(),
                company_name: $('#txtcompanyname').val(),
                mobile: $('#txteditmobilenumber').val(),
                country_id: $('#txteditcountry').val(),
                state_id: $('#txteditstate').val(),
                city_id: $('#txteditcity').val(),
                address: $('#txteditaddress').val(),
                password: $('#txteditpassword').val(),
                confirm_password: $('#txteditconfirmpassword').val()
            };
        
            $.ajax({
                url: baseUrl + '/garage-owners/update',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    form.find('.invalid-feedback').remove();
                    form.find('.is-invalid').removeClass('is-invalid');
                    $("#btnupdategarageownerdata").prop('disabled', true).text('Updating...');
                },
                success: function (res) {
                    if (res.status === 'success') {
                        $("#btnupdategarageownerdata").prop('disabled', false).text('Update');
                        toastr.success(res.message);
                        $('#garageOwnersTable').DataTable().ajax.reload(null, false);
                        $('#sidebarEditGarageOwner').offcanvas('hide');
                        $('#frmeditgarageownerdata').trigger("reset");
                        $('#frmeditgarageownerdata').parsley().reset();
                        $('#garageOwnerTable').DataTable().ajax.reload();
                    }
                },
                error: function (xhr) {
                    $("#btnupdategarageownerdata").prop('disabled', false).text('Update');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            let input = $('#txtedit' + key.replace(/_/g, ''));
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback d-block">' + errors[key][0] + '</div>');
                        }
                    } else {
                        toastr.error('Something went wrong.');
                    }
                }
            });
        }
    });

    // Get Id as per select
    $(document).on('click', '.removeNotificationModal', function () {
        const userId = $(this).data('id');
        $("#txtdeleteownerid").val(userId);
    });

    // Remove garage owner data
    $(document).on('click', '#delete-notification', function () {
        const userId = $("#txtdeleteownerid").val();
        $.ajax({
            url: baseUrl + '/garage-owners/remove-details/'+userId,
            type: 'DELETE',
            data: {
                _token: csrfToken,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $(this).prop('disabled', true).text('Deleting...');
            },
            success: function (res) {
                toastr.success(res.message);
                $(this).prop('disabled', false).text('Yes, Delete It!');
                $('#removeNotificationModal').offcanvas('hide');
                $('#garageOwnersTable').DataTable().ajax.reload(null, false);
            },
            error: function(xhr, error, thrown) {
                $(this).prop('disabled', true).text('Yes, Delete It!');
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    let dataGOCRoute = $('#garageOwnersClientTable').data('route');
    let garage_owner_id = $('#garageOwnersClientTable').data('garageownerid');
    if ($('#garageOwnersClientTable').length) 
    {
        $('#garageOwnersClientTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:dataGOCRoute,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        alert("Session expired. Redirecting to login...");
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("DataTable load error:", xhr.responseText);
                    }
                }
            },
            stateSave: true,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'email', name: 'email' },
                { data: 'email', name: 'email' },
                { data: 'email', name: 'email' },
                { data: 'mobilenumber', name: 'mobilenumber' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']], // Default sorting by ID
            lengthMenu: [10, 25, 50, 100], // Records per page options
            pageLength: 10, // Default records per page
        });
    }

    // Client Data table list
    let dataCRoute = $('#garageOwnersClientsTable').data('route');
    let csrfCToken = $('meta[name="csrf-token"]').attr('content');
    if ($('#garageOwnersClientsTable').length) 
    {
        $('#garageOwnersClientsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:dataCRoute,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        alert("Session expired. Redirecting to login...");
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("DataTable load error:", xhr.responseText);
                    }
                }
            },
            stateSave: true,
            columns: [
                { data: 'id', name: 'users.id' },
                { data: 'name', name: 'users.name' },
                { data: 'email', name: 'users.email' },
                { data: 'mobilenumber', name: 'users.mobilenumber' },
                { data: 'user_type', name: 'users.user_type', orderable: false, searchable: false },
                { data: 'country_name', name: 'tbl_countries.name' },
                { data: 'zip', name: 'users.zip' },
                { data: 'status', name: 'users.user_status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']], // Default sorting by ID
            lengthMenu: [10, 25, 50, 100], // Records per page options
            pageLength: 10, // Default records per page
        });
    }

    $(document).on('click', '.editviewadminclientdetails', function () {
        const userId = $(this).data('id');
        console.log(userId);
        $.ajax({
            url: baseUrl + '/garage-owners/client/editview',
            type: 'POST',
            data: {
                _token: csrfToken,
                userId: userId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarUpdateClient").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarUpdateClient").removeClass("offcanvas-loader");
                // Populate the form fields
                $('#txtupdateclientname').val(data.name);
                $('#txtupdateclientemail').val(data.email);
                $('#txtupdateclientmobilenumber').val(data.mobilenumber);
                $('#txtupdateclientlandlinenumber').val(data.landlinenumber);
                $('#txtupdateclientcountry').val(data.country_id);
                $('#txtupdateclientaddress').val(data.address);
                $('#updateclientid').val(data.id);
                $('#txtupdateclientstate').html("");
                $('#txtupdateclientcity').html("");
                $('#txtupdateclientstate').append('<option value="">Select State</option>');
                $('#txtupdateclientcity').append('<option value="">Select City</option>');
                $.each(data.states, function(key, state) {
                    $('#txtupdateclientstate').append(`<option value="${state.id}">${state.name}</option>`);
                });

                $.each(data.cities, function(key, city) {
                    $('#txtupdateclientcity').append(`<option value="${city.id}">${city.name}</option>`);
                });

                $('#txtupdateclientstate').val(data.state_id);
                $('#txtupdateclientcity').val(data.city_id);

                 // ✅ Set flag and number correctly
                const input = document.querySelector("#txtupdateclientmobilenumber");
                const itiInstance = input._iti;
                const IsoCode = data.countryisocode;     // e.g., 'dz'
                const phone = data.mobilenumber;         // e.g., '5584694128'

                if (itiInstance) {
                    itiInstance.setCountry(IsoCode);     // sets flag
                    input.value = phone;                 // sets number
                }

            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    $('#frmgarageownerclientupdateinformation').parsley();
    $('#frmgarageownerclientupdateinformation').on('submit', function (e) {
        e.preventDefault();
        if($('#frmgarageownerclientupdateinformation').parsley().isValid())
        {
            let form = $(this);
            let formData = new FormData(this);
        
            $.ajax({
                url: baseUrl + '/garage-owners/client/update',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnupdatelient").prop('disabled', true).text('Updating...');
                },
                success: function (res) {
                    if (res.status === 'success') {
                        $("#btnupdatelient").prop('disabled', false).text('Update');
                        toastr.success(res.message);
                        $('#garageOwnersClientTable').DataTable().ajax.reload(null, false);
                        $('#sidebarUpdateClient').offcanvas('hide');
                        $('#frmgarageownerclientupdateinformation').trigger("reset");
                        $('#frmgarageownerclientupdateinformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnupdatelient").prop('disabled', false).text('Update');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            let input = $('#txtedit' + key.replace(/_/g, ''));
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback d-block">' + errors[key][0] + '</div>');
                        }
                    } else {
                        toastr.error('Something went wrong.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.removeAdminClientNotificationModal', function () {
        const userId = $(this).data('id');
        $("#txtdeletegarageownerclientid").val(userId);
    });

    $(document).on('click', '#delete-garage-owner-client-notification', function () {
        const userId = $("#txtdeletegarageownerclientid").val();
        $.ajax({
            url: baseUrl + '/garage-owners/client/remove-details/'+userId,
            type: 'DELETE',
            data: {
                _token: csrfToken,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $(this).prop('disabled', true).text('Deleting...');
            },
            success: function (res) {
                toastr.success(res.message);
                $(this).prop('disabled', false).text('Yes, Delete It!');
                $('#removeClientNotificationModal').offcanvas('hide');
                $('#garageOwnersClientTable').DataTable().ajax.reload(null, false);
            },
            error: function(xhr, error, thrown) {
                $(this).prop('disabled', true).text('Yes, Delete It!');
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });
    
    // Admin Section related details start
    let dataAdminRoute = $('#adminAdminListingTable').data('route');
    let csrfAdminToken = $('meta[name="csrf-token"]').attr('content');
    if ($('#adminAdminListingTable').length) 
    {
        $('#adminAdminListingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:dataAdminRoute,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfAdminToken  // Add CSRF token in headers
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        alert("Session expired. Redirecting to login...");
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("DataTable load error:", xhr.responseText);
                    }
                }
            },
            stateSave: true,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'mobilenumber', name: 'mobilenumber' },
                { data: 'user_type', name: 'user_type' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']], // Default sorting by ID
            lengthMenu: [10, 25, 50, 100], // Records per page options
            pageLength: 10, // Default records per page
        });
    }
    
    $('#frmnewadmindata').parsley();
    $('#frmnewadmindata').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        let password = $('#newadminpassword').val().trim();
        let confirmPassword = $('#newadminconfirmpassword').val().trim();

        // Clear previous error
        $('#newadminpassword, #newadminconfirmpassword').removeClass('is-invalid');
        $('.invalid-feedback.password-error').remove();

        if (password || confirmPassword) {
            if (!password || !confirmPassword) {
                $('#newadminpassword, #newadminconfirmpassword').addClass('is-invalid');
                $('#newadminconfirmpassword').after('<div class="invalid-feedback password-error d-block">Both password fields are required.</div>');
                return false;
            }
            if (password !== confirmPassword) {
                $('#newadminpassword, #newadminconfirmpassword').addClass('is-invalid');
                $('#newadminconfirmpassword').after('<div class="invalid-feedback password-error d-block">Passwords do not match.</div>');
                return false;
            }
        }
        if($('#frmnewadmindata').parsley().isValid())
        {
            let form = $(this);

            $.ajax({
                url: baseUrl + '/admin/store',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    form.find('.invalid-feedback').remove();
                    form.find('.is-invalid').removeClass('is-invalid');
                    $("#btnstorenewadmininfo").prop('disabled', true).text('Saving...');
                },
                success: function (res) {
                    $("#btnstorenewadmininfo").prop('disabled', false).text('Save');
                    if (res.status === 'success') 
                    {
                        toastr.success(res.message);
                        $('#adminAdminListingTable').DataTable().ajax.reload(null, false);
                        $('#sidebarAddAdmin').offcanvas('hide');
                        $('#frmnewadmindata').trigger("reset");
                        $('#frmnewadmindata').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnstorenewadmininfo").prop('disabled', false).text('Save');
                    let res = xhr.responseJSON;

                    if (res.status === 'error' && typeof res.message === 'object') {
                        for (let field in res.message) {
                            if (res.message.hasOwnProperty(field)) {
                                toastr.error(res.message[field][0]); // Show the first error for each field
                            }
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.viewadmindetailonpopup', function () {
        const userId = $(this).data('id');
        console.log(userId);
        $.ajax({
            url: baseUrl + '/admin/view',
            type: 'POST',
            data: {
                _token: csrfToken,
                userId: userId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarViewInformation").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarViewInformation").removeClass("offcanvas-loader");
                // Populate the form fields
                $('#ownerprofileimage').prop("src",data.profilepic);
                $('#adminname').text(data.name);
                $('#adminemail').text(data.email);
                $('#adminmobile').text(data.mobilenumber);
                $('#adminjoindate').text(data.joindate);
                $('#adminaddress').text(data.address);
            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    $(document).on('click', '.removeAdminNotificationModal', function () {
        const userId = $(this).data('id');
        $("#txtdeleteadminid").val(userId);
    });

    $(document).on('click', '#delete-admin-notification', function () {
        const userId = $("#txtdeleteadminid").val();
        $.ajax({
            url: baseUrl + '/admin/remove-details/'+userId,
            type: 'DELETE',
            data: {
                _token: csrfToken,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $(this).prop('disabled', true).text('Deleting...');
            },
            success: function (res) {
                toastr.success(res.message);
                $(this).prop('disabled', false).text('Yes, Delete It!');
                $('#removeAdminNotificationModal').offcanvas('hide');
                $('#adminAdminListingTable').DataTable().ajax.reload(null, false);
            },
            error: function(xhr, error, thrown) {
                $(this).prop('disabled', true).text('Yes, Delete It!');
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    $(document).on('click', '.sidebarUpdateAdmin', function () {
        const userId = $(this).data('id');
        console.log(userId);
        $.ajax({
            url: baseUrl + '/admin/editview',
            type: 'POST',
            data: {
                _token: csrfToken,
                userId: userId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarUpdateAdmin").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarUpdateAdmin").removeClass("offcanvas-loader");
                // Populate the form fields
                $('#updateadminfullname').val(data.name);
                $('#updateadminemail').val(data.email);
                $('#updateadminphone').val(data.mobilenumber);
                $('#updateadminjoindate').val(data.user_join_date);
                $('#updateadminleftdate').val(data.user_left_date);    
                $('#updateadminaddress').val(data.address);
                $('#updateadmineditcountry').val(data.country_id);
                $('#updateadminid').val(data.id);
                $('#updateadminphonecode').val(data.countrycode);
                $('#updateadminphoneicocode').val(data.countryisocode);
                $('#profileimage').prop("src",data.user_profile_pic);

                $('#updateadmineditstate').html("");
                $('#updateadmineditcity').html("");
                $('#updateadmineditstate').append('<option value="">Select State</option>');
                $('#updateadmineditcity').append('<option value="">Select City</option>');
                $.each(data.states, function(key, state) {
                    $('#updateadmineditstate').append(`<option value="${state.id}">${state.name}</option>`);
                });

                $.each(data.cities, function(key, city) {
                    $('#updateadmineditcity').append(`<option value="${city.id}">${city.name}</option>`);
                });

                $('#updateadmineditstate').val(data.state_id);
                $('#updateadmineditcity').val(data.city_id);

                // ✅ Set flag and number correctly
                const input = document.querySelector("#updateadminphone");
                const itiInstance = input._iti;
                const IsoCode = data.countryisocode;     // e.g., 'dz'
                const phone = data.mobilenumber;         // e.g., '5584694128'

                if (itiInstance) {
                    itiInstance.setCountry(IsoCode);     // sets flag
                    input.value = phone;                 // sets number
                }
            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    $('#frmupdateadmindata').parsley();
    $('#frmupdateadmindata').on('submit', function (e) {
        e.preventDefault();

        let password = $('#updateadminpassword').val().trim();
        let confirmPassword = $('#updateadminconfirmpassword').val().trim();

        // Clear previous error
        $('#updateadminpassword, #updateadminconfirmpassword').removeClass('is-invalid');
        $('.invalid-feedback.password-error').remove();

        if (password || confirmPassword) {
            if (!password || !confirmPassword) {
                $('#updateadminpassword, #updateadminconfirmpassword').addClass('is-invalid');
                $('#updateadminconfirmpassword').after('<div class="invalid-feedback password-error d-block">Both password fields are required.</div>');
                return false;
            }
            if (password !== confirmPassword) {
                $('#updateadminpassword, #updateadminconfirmpassword').addClass('is-invalid');
                $('#updateadminconfirmpassword').after('<div class="invalid-feedback password-error d-block">Passwords do not match.</div>');
                return false;
            }
        }
        if($('#frmupdateadmindata').parsley().isValid())
        {
            let form = $(this);
            let formData = new FormData(this);
        
            $.ajax({
                url: baseUrl + '/admin/update',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    form.find('.invalid-feedback').remove();
                    form.find('.is-invalid').removeClass('is-invalid');
                    $("#btnupdateadmininfo").prop('disabled', true).text('Updating...');
                },
                success: function (res) {
                    if (res.status === 'success') {
                        $("#btnupdateadmininfo").prop('disabled', false).text('Update');
                        toastr.success(res.message);
                        $('#adminAdminListingTable').DataTable().ajax.reload(null, false);
                        $('#sidebarUpdateAdmin').offcanvas('hide');
                        $('#frmupdateadmindata').trigger("reset");
                        $('#frmupdateadmindata').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnupdateadmininfo").prop('disabled', false).text('Update');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            let input = $('#txtedit' + key.replace(/_/g, ''));
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback d-block">' + errors[key][0] + '</div>');
                        }
                    } else {
                        toastr.error('Something went wrong.');
                    }
                }
            });
        }
    });
    // Admin Section related details end

    // Client Section related details start
    $('.drpcountry').on('change', function () {
        let countryId = $(this).val();
        $('.drpstate').empty().append('<option value="">Select State</option>');
        $('.drpcity').empty().append('<option value="">Select City</option>');
        if (countryId) {
            loadStates(countryId, null);
        }
    });

    $('.drpstate').on('change', function () {
        let stateId = $(this).val();
        $('.drpcity').empty().append('<option value="">Select City</option>');
        if (stateId) {
            loadCities(stateId, null);
        }
    });

    function loadStates(countryId, preSelectedState) {
        $.ajax({
            url: baseUrl + '/get-states/' + countryId,
            type: 'GET',
            success: function (states) {
                $('.drpstate').empty().append('<option value="">Select State</option>');
                $.each(states, function (id, name) {
                    $('.drpstate').append('<option value="' + id + '">' + name + '</option>');
                });

                if (preSelectedState) {
                    $('.drpstate').val(preSelectedState);
                    loadCities(preSelectedState, selectedCity);
                }
            }
        });
    }

    function loadCities(stateId, preSelectedCity) {
        $.ajax({
            url: baseUrl + '/get-cities/' + stateId,
            type: 'GET',
            success: function (cities) {
                $('.drpcity').empty().append('<option value="">Select City</option>');
                $.each(cities, function (id, name) {
                    $('.drpcity').append('<option value="' + id + '">' + name + '</option>');
                });

                if (preSelectedCity) {
                    $('.drpcity').val(preSelectedCity);
                }
            }
        });
    }

    $('#frmaddnewinformation').parsley();
    $('#frmaddnewinformation').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        if($('#frmaddnewinformation').parsley().isValid())
        {
            let form = $(this);

            $.ajax({
                url: baseUrl + '/clients/store',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnaddnewclient").prop('disabled', true).text('Saving...');
                },
                success: function (res) {
                    $("#btnaddnewclient").prop('disabled', false).text('Save');
                    if (res.status === 'success') 
                    {
                        toastr.success(res.message);
                        $('#garageOwnersClientsTable').DataTable().ajax.reload(null, false);
                        $('#sidebarNewClient').offcanvas('hide');
                        // Reset form and Parsley validation
                        $('#frmaddnewinformation').trigger("reset");
                        $('#frmaddnewinformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnaddnewclient").prop('disabled', false).text('Save');
                    let res = xhr.responseJSON;

                    if (res.status === 'error' && typeof res.message === 'object') {
                        for (let field in res.message) {
                            if (res.message.hasOwnProperty(field)) {
                                toastr.error(res.message[field][0]); // Show the first error for each field
                            }
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        }
    });
    
    $(document).on('click', '.editviewclientdetails', function () {
        const userId = $(this).data('id');
        console.log(userId);
        $.ajax({
            url: baseUrl + '/clients/view',
            type: 'POST',
            data: {
                _token: csrfToken,
                userId: userId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarUpdateClient").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarUpdateClient").removeClass("offcanvas-loader");
                // Populate the form fields
                $('#txtupdateclientname').val(data.name);
                $('#txtupdateclientemail').val(data.email);
                $('#txtupdateclientmobilenumber').val(data.mobilenumber);
                $('#txtupdateclientlandlinenumber').val(data.landlinenumber);
                $('#txtupdateclientcountry').val(data.country_id);
                $('#txtupdateclientaddress').val(data.address);
                $('#updateclientid').val(data.id);
                $('#txtupdateclientstate').html("");
                $('#txtupdateclientcity').html("");
                $('#txtupdateclientstate').append('<option value="">Select State</option>');
                $('#txtupdateclientcity').append('<option value="">Select City</option>');
                $.each(data.states, function(key, state) {
                    $('#txtupdateclientstate').append(`<option value="${state.id}">${state.name}</option>`);
                });

                $.each(data.cities, function(key, city) {
                    $('#txtupdateclientcity').append(`<option value="${city.id}">${city.name}</option>`);
                });

                $('#txtupdateclientstate').val(data.state_id);
                $('#txtupdateclientcity').val(data.city_id);

                 // ✅ Set flag and number correctly
                const input = document.querySelector("#txtupdateclientmobilenumber");
                const itiInstance = input._iti;
                const IsoCode = data.countryisocode;     // e.g., 'dz'
                const phone = data.mobilenumber;         // e.g., '5584694128'

                if (itiInstance) {
                    itiInstance.setCountry(IsoCode);     // sets flag
                    input.value = phone;                 // sets number
                }

            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    $('#frmclientupdateinformation').parsley();
    $('#frmclientupdateinformation').on('submit', function (e) {
        e.preventDefault();
        if($('#frmclientupdateinformation').parsley().isValid())
        {
            let form = $(this);
            let formData = new FormData(this);
        
            $.ajax({
                url: baseUrl + '/clients/update',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnupdatelient").prop('disabled', true).text('Updating...');
                },
                success: function (res) {
                    if (res.status === 'success') {
                        $("#btnupdatelient").prop('disabled', false).text('Update');
                        toastr.success(res.message);
                        $('#garageOwnersClientsTable').DataTable().ajax.reload(null, false);
                        $('#sidebarUpdateClient').offcanvas('hide');
                        $('#frmclientupdateinformation').trigger("reset");
                        $('#frmclientupdateinformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnupdatelient").prop('disabled', false).text('Update');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            let input = $('#txtedit' + key.replace(/_/g, ''));
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback d-block">' + errors[key][0] + '</div>');
                        }
                    } else {
                        toastr.error('Something went wrong.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.removeClientNotificationModal', function () {
        const userId = $(this).data('id');
        $("#txtdeleteclientid").val(userId);
    });

    $(document).on('click', '#delete-client-notification', function () {
        const userId = $("#txtdeleteclientid").val();
        $.ajax({
            url: baseUrl + '/clients/remove-details/'+userId,
            type: 'DELETE',
            data: {
                _token: csrfToken,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $(this).prop('disabled', true).text('Deleting...');
            },
            success: function (res) {
                toastr.success(res.message);
                $(this).prop('disabled', false).text('Yes, Delete It!');
                $('#removeClientNotificationModal').offcanvas('hide');
                $('#garageOwnersClientsTable').DataTable().ajax.reload(null, false);
            },
            error: function(xhr, error, thrown) {
                $(this).prop('disabled', true).text('Yes, Delete It!');
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });
    // Client Section related details end

    // Garage Owner Client's Vehicle Detail start
    let dataVehicleRoute = $('#garageOwnersVehicleTable').data('route');
    let currentcustomerid = $('#garageOwnersVehicleTable').data('customerid');
    if ($('#garageOwnersVehicleTable').length) 
    {
        $('#garageOwnersVehicleTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:dataVehicleRoute,
                type: "POST",
                data: function (d) {
                    d.customer_id = currentcustomerid; // Pass customer ID to server
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        alert("Session expired. Redirecting to login...");
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("DataTable load error:", xhr.responseText);
                    }
                }
            },
            stateSave: true,
            columns: [
                { data: 'id', name: 'tbl_vehicles.id' },
                { data: 'vin', name: 'tbl_vehicles.vin' },
                { data: 'number_plate', name: 'tbl_vehicles.number_plate' },
                { data: 'modelyear', name: 'tbl_vehicles.modelyear' },
                { data: 'modelname', name: 'tbl_vehicles.modelname' },
                { data: 'modelbrand', name: 'tbl_vehicles.modelbrand' },
                { data: 'vehicle_status', name: 'tbl_vehicles.vehicle_status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']], // Default sorting by ID
            lengthMenu: [10, 25, 50, 100], // Records per page options
            pageLength: 10, // Default records per page
        });
    }

    $('#frmaddnewvehicleinformation').parsley();
    $('#frmaddnewvehicleinformation').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        if($('#frmaddnewvehicleinformation').parsley().isValid())
        {
            let form = $(this);

            $.ajax({
                url: baseUrl + '/clients/vehicles/store',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnnewvehicledetail").prop('disabled', true).text('Submitting...');
                },
                success: function (res) {
                    $("#btnnewvehicledetail").prop('disabled', false).text('Submit');
                    if (res.status === 'success') 
                    {
                        toastr.success(res.message);
                        $('#garageOwnersVehicleTable').DataTable().ajax.reload(null, false);
                        $('#sidebarNewVehicle').offcanvas('hide');
                        $('#frmaddnewvehicleinformation').trigger("reset");
                        $('#frmaddnewvehicleinformation').parsley().reset();
                        $("#vehiclecustomerid").val(currentcustomerid);
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnnewvehicledetail").prop('disabled', false).text('Submit');
                    let res = xhr.responseJSON;

                    if (res.status === 'error' && typeof res.message === 'object') {
                        for (let field in res.message) {
                            if (res.message.hasOwnProperty(field)) {
                                toastr.error(res.message[field][0]); // Show the first error for each field
                            }
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.editviewvehicledetails', function () {
        const vehicleId = $(this).data('id');
        $.ajax({
            url: baseUrl + '/clients/vehicles/view',
            type: 'POST',
            data: {
                _token: csrfToken,
                vehicleId: vehicleId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarEditVehicle").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarEditVehicle").removeClass("offcanvas-loader");
                // Populate the form fields
                $('#txtupdatevehiclevindetails').val(data.vin);
                $('#txtupdatevehiclelicenceplate').val(data.number_plate);
                $('#txtupdatevehiclemake').val(data.modelbrand);
                $('#txtupdatevehiclemodel').val(data.modelname);
                $('#txtupdatevehiclemakeyear').val(data.modelyear);
                $('#txtupdatevehiclelastservicedate').val(data.lastservice);
                $('#txtupdatevehicleid').val(data.id);

                $('.dateformat').each(function () {
                    flatpickr(this, {
                        dateFormat: "Y-m-d",
                        defaultDate: this.value.trim() || null,
                        allowInput: true,
                    });
                  });
            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    $('#frmeditvehicleinformation').parsley();
    $('#frmeditvehicleinformation').on('submit', function (e) {
        e.preventDefault();
        if($('#frmeditvehicleinformation').parsley().isValid())
        {
            let form = $(this);
            let formData = new FormData(this);
        
            $.ajax({
                url: baseUrl + '/clients/vehicles/update',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnupdatevehicledetail").prop('disabled', true).text('Updating...');
                },
                success: function (res) {
                    if (res.status === 'success') {
                        $("#btnupdatevehicledetail").prop('disabled', false).text('Update');
                        toastr.success(res.message);
                        $('#garageOwnersVehicleTable').DataTable().ajax.reload(null, false);
                        $('#sidebarEditVehicle').offcanvas('hide');
                        $('#frmeditvehicleinformation').trigger("reset");
                        $('#frmeditvehicleinformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnupdatevehicledetail").prop('disabled', false).text('Update');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            let input = $('#txtedit' + key.replace(/_/g, ''));
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback d-block">' + errors[key][0] + '</div>');
                        }
                    } else {
                        toastr.error('Something went wrong.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.removeVehicleNotificationModal', function () {
        const vehicleId = $(this).data('id');
        $("#txtdeletevehicleid").val(vehicleId);
    });

    $(document).on('click', '#delete-vehicle-notification', function () {
        const vehicleId = $("#txtdeletevehicleid").val();
        $.ajax({
            url: baseUrl + '/clients/vehicles/remove-details/'+vehicleId,
            type: 'DELETE',
            data: {
                _token: csrfToken,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $(this).prop('disabled', true).text('Deleting...');
            },
            success: function (res) {
                toastr.success(res.message);
                $(this).prop('disabled', false).text('Yes, Delete It!');
                $('#removeVechicleNotificationModal').offcanvas('hide');
                $('#garageOwnersVehicleTable').DataTable().ajax.reload(null, false);
            },
            error: function(xhr, error, thrown) {
                $(this).prop('disabled', true).text('Yes, Delete It!');
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });
    // Garage Owner Client's Vehicle Detail end

    // Search Client Data
    let searchCLientDataRoute = $('#adminSearchClientTable').data('route');
    if ($('#adminSearchClientTable').length) 
    {
        $('#adminSearchClientTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:searchCLientDataRoute,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        alert("Session expired. Redirecting to login...");
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("DataTable load error:", xhr.responseText);
                    }
                }
            },
            stateSave: true,
            columns: [
                { data: 'id', name: 'users.id' },
                { data: 'name', name: 'users.name' },
                { data: 'email', name: 'users.email' },
                { data: 'mobilenumber', name: 'users.mobilenumber' },
                { data: 'country_name', name: 'users.country_name' },
                { data: 'zip', name: 'users.zip' },
                { data: 'user_status', name: 'users.user_status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']], // Default sorting by ID
            lengthMenu: [10, 25, 50, 100], // Records per page options
            pageLength: 10, // Default records per page
        });
    }

    // ------------------------------------------- //

    // Manage Supplier Section
    let datasSupplierRoute = $('#garageOwnersSupplierTable').data('route');
    if ($('#garageOwnersSupplierTable').length) 
    {
        $('#garageOwnersSupplierTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:datasSupplierRoute,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        alert("Session expired. Redirecting to login...");
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("DataTable load error:", xhr.responseText);
                    }
                }
            },
            stateSave: true,
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'businessname', name: 'businessname' },
                { data: 'product_names', name: 'product_names' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']], // Default sorting by ID
            lengthMenu: [10, 25, 50, 100], // Records per page options
            pageLength: 10, // Default records per page
        });
    }

    $('#frmaddnewsupplierinformation').parsley();
    $('#frmaddnewsupplierinformation').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        if($('#frmaddnewsupplierinformation').parsley().isValid())
        {
            let form = $(this);

            $.ajax({
                url: baseUrl + '/supplier/store',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnaddnewsupplier").prop('disabled', true).text('Saving...');
                },
                success: function (res) {
                    $("#btnaddnewsupplier").prop('disabled', false).text('Save');
                    if (res.status === 'success') 
                    {
                        toastr.success(res.message);
                        $('#garageOwnersSupplierTable').DataTable().ajax.reload(null, false);
                        $('#sidebarAddSupplier').offcanvas('hide');
                        // Reset form and Parsley validation
                        $('#frmaddnewsupplierinformation').trigger("reset");
                        $('#frmaddnewsupplierinformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnaddnewsupplier").prop('disabled', false).text('Save');
                    let res = xhr.responseJSON;

                    if (res.status === 'error' && typeof res.message === 'object') {
                        for (let field in res.message) {
                            if (res.message.hasOwnProperty(field)) {
                                toastr.error(res.message[field][0]); // Show the first error for each field
                            }
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.viewsupplierinfo', function () {
        const supplierId = $(this).data('supplierid');
        $.ajax({
            url: baseUrl + '/supplier/view',
            type: 'POST',
            data: {
                _token: csrfToken,
                supplierId: supplierId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarViewInformation").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarViewInformation").removeClass("offcanvas-loader");
                // Populate the form fields
                $('#supplierfullname').text(data.name);
                $('#supplieremail').text(data.email);
                $('#suppliermobilenumber').text(data.mobilenumber);
                $('#supplieraddress').text(data.address);
            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });
    
    $(document).on('click', '.editviewsupplierdetails', function () {
        const supplierId = $(this).data('supplierid');
        $.ajax({
            url: baseUrl + '/supplier/editview',
            type: 'POST',
            data: {
                _token: csrfToken,
                supplierId: supplierId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarUpdateSupplier").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarUpdateSupplier").removeClass("offcanvas-loader");
                // Populate the form fields
                $('#txtupdatesuppliername').val(data.name);
                $('#txtupdatecompanyname').val(data.businessname);
                $('#txtupdatesupplieremail').val(data.email);
                $('#txtupdatesuppliermobilenumber').val(data.mobilenumber);
                $('#txtupdatesupplierlandlinenumber').val(data.landlinenumber);
                $('#updatesupplierphonecode').val(data.countrycode);
                $('#updatesupplierid').val(data.id);
                $('#updatesupplierphoneicocode').val(data.countryisocode);
                $('#txtupdatesupplieraddress').val(data.address);
                $('#txtupdatesuppliercountry').val(data.country_id);
                $('#txtupdatesupplierstate').html("");
                $('#txtupdatesuppliercity').html("");
                $('#txtupdatesupplierstate').append('<option value="">Select State</option>');
                $('#txtupdatesuppliercity').append('<option value="">Select City</option>');
                $.each(data.states, function(key, state) {
                    $('#txtupdatesupplierstate').append(`<option value="${state.id}">${state.name}</option>`);
                });

                $.each(data.cities, function(key, city) {
                    $('#txtupdatesuppliercity').append(`<option value="${city.id}">${city.name}</option>`);
                });

                $('#txtupdatesupplierstate').val(data.state_id);
                $('#txtupdatesuppliercity').val(data.city_id);

                // ✅ Set flag and number correctly
                const input = document.querySelector("#txtupdatesuppliermobilenumber");
                const itiInstance = input._iti;
                const IsoCode = data.countryisocode;     // e.g., 'dz'
                const phone = data.mobilenumber;         // e.g., '5584694128'

                if (itiInstance) {
                    itiInstance.setCountry(IsoCode);     // sets flag
                    input.value = phone;                 // sets number
                }

            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    $('#frmsupplierupdateinformation').parsley();
    $('#frmsupplierupdateinformation').on('submit', function (e) {
        e.preventDefault();
        if($('#frmsupplierupdateinformation').parsley().isValid())
        {
            let form = $(this);
            let formData = new FormData(this);
        
            $.ajax({
                url: baseUrl + '/supplier/update',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnupdatesupplier").prop('disabled', true).text('Updating...');
                },
                success: function (res) {
                    if (res.status === 'success') {
                        $("#btnupdatesupplier").prop('disabled', false).text('Update');
                        toastr.success(res.message);
                        $('#garageOwnersSupplierTable').DataTable().ajax.reload(null, false);
                        $('#sidebarUpdateSupplier').offcanvas('hide');
                        $('#frmsupplierupdateinformation').trigger("reset");
                        $('#frmsupplierupdateinformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnupdatesupplier").prop('disabled', false).text('Update');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            let input = $('#txtedit' + key.replace(/_/g, ''));
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback d-block">' + errors[key][0] + '</div>');
                        }
                    } else {
                        toastr.error('Something went wrong.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.removesupplierdetail', function () {
        const supplierId = $(this).data('supplierid');
        $("#txtarchivesuppliertid").val(supplierId);
    });

    $(document).on('click', '#archive-supplier-notification', function () {
        const supplierId = $("#txtarchivesuppliertid").val();
        $.ajax({
            url: baseUrl + '/supplier/remove-details/'+supplierId,
            type: 'DELETE',
            data: {
                _token: csrfToken,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $(this).prop('disabled', true).text('Deleting...');
            },
            success: function (res) {
                toastr.success(res.message);
                $(this).prop('disabled', false).text('Yes, Archive It!');
                $('#removeSupplierNotificationModal').offcanvas('hide');
                $('#garageOwnersSupplierTable').DataTable().ajax.reload(null, false);
            },
            error: function(xhr, error, thrown) {
                $(this).prop('disabled', true).text('Yes, Archive It!');
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });
    // End

    // Manage Product Section
    let dataProductRoute = $('#garageOwnersProductTable').data('route');
    if ($('#garageOwnersProductTable').length) 
    {
        $('#garageOwnersProductTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:dataProductRoute,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        alert("Session expired. Redirecting to login...");
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("DataTable load error:", xhr.responseText);
                    }
                }
            },
            stateSave: true,
            columns: [
                { data: 'product_id', name: 'product_id' },
                { data: 'product_number', name: 'product_number' },
                { data: 'product_name', name: 'product_name' },
                { data: 'product_price', name: 'product_price' },
                { data: 'supplier_name', name: 'supplier_name' },
                { data: 'company_name', name: 'company_name' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']], // Default sorting by ID
            lengthMenu: [10, 25, 50, 100], // Records per page options
            pageLength: 10, // Default records per page
        });
    }

    $('#frmaddnewproductinformation').parsley();
    $('#frmaddnewproductinformation').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        if($('#frmaddnewproductinformation').parsley().isValid())
        {
            let form = $(this);

            $.ajax({
                url: baseUrl + '/product/store',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnaddnewproduct").prop('disabled', true).text('Saving...');
                },
                success: function (res) {
                    $("#btnaddnewproduct").prop('disabled', false).text('Save');
                    if (res.status === 'success') 
                    {
                        toastr.success(res.message);
                        $('#garageOwnersProductTable').DataTable().ajax.reload(null, false);
                        $('#sidebarAddProduct').offcanvas('hide');
                        // Reset form and Parsley validation
                        $('#frmaddnewproductinformation').trigger("reset");
                        $('#frmaddnewproductinformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnaddnewproduct").prop('disabled', false).text('Save');
                    let res = xhr.responseJSON;

                    if (res.status === 'error' && typeof res.message === 'object') {
                        for (let field in res.message) {
                            if (res.message.hasOwnProperty(field)) {
                                toastr.error(res.message[field][0]); // Show the first error for each field
                            }
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.editviewproductdetails', function () {
        const productId = $(this).data('productid');
        $.ajax({
            url: baseUrl + '/product/editview',
            type: 'POST',
            data: {
                _token: csrfToken,
                productId: productId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarEditProduct").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarEditProduct").removeClass("offcanvas-loader");
                // Populate the form fields
                $('#txtupdateproductnumber').val(data.product_number);
                $('#txtupdateproductname').val(data.product_name);
                $('#txtupdateprice').val(data.product_price);
                $('#txtupdateproductdate').val(data.product_date);
                $('#txtupdatesupplier').val(data.product_supplier_id);
                $('#txtupdateproductid').val(data.product_id);
            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    $('#frmupdateproductinformation').parsley();
    $('#frmupdateproductinformation').on('submit', function (e) {
        e.preventDefault();
        if($('#frmupdateproductinformation').parsley().isValid())
        {
            let form = $(this);
            let formData = new FormData(this);
        
            $.ajax({
                url: baseUrl + '/product/update',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnupdateproduct").prop('disabled', true).text('Updating...');
                },
                success: function (res) {
                    if (res.status === 'success') {
                        $("#btnupdateproduct").prop('disabled', false).text('Update');
                        toastr.success(res.message);
                        $('#garageOwnersProductTable').DataTable().ajax.reload(null, false);
                        $('#sidebarEditProduct').offcanvas('hide');
                        $('#frmupdateproductinformation').trigger("reset");
                        $('#frmupdateproductinformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnupdateproduct").prop('disabled', false).text('Update');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let key in errors) {
                            let input = $('#txtedit' + key.replace(/_/g, ''));
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback d-block">' + errors[key][0] + '</div>');
                        }
                    } else {
                        toastr.error('Something went wrong.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.removeprodutdata', function () {
        const productId = $(this).data('productid');
        $("#txtarchiveproducttid").val(productId);
    });

    $(document).on('click', '#archive-productt-notification', function () {
        const productId = $("#txtarchiveproducttid").val();
        $.ajax({
            url: baseUrl + '/product/remove-details/'+productId,
            type: 'DELETE',
            data: {
                _token: csrfToken,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $(this).prop('disabled', true).text('Deleting...');
            },
            success: function (res) {
                toastr.success(res.message);
                $(this).prop('disabled', false).text('Yes, Archive It!');
                $('#removeProductNotificationModal').offcanvas('hide');
                $('#garageOwnersProductTable').DataTable().ajax.reload(null, false);
            },
            error: function(xhr, error, thrown) {
                $(this).prop('disabled', true).text('Yes, Archive It!');
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });
    // End

    // Manage Purchase Section
    let dataPurchaseRoute = $('#garageOwnersPurchaseTable').data('route');
    if ($('#garageOwnersPurchaseTable').length) 
    {
        $('#garageOwnersPurchaseTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:dataPurchaseRoute,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        alert("Session expired. Redirecting to login...");
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("DataTable load error:", xhr.responseText);
                    }
                }
            },
            stateSave: true,
            columns: [
                { data: 'purchase_id', name: 'purchase_id' },
                { data: 'purchase_number', name: 'purchase_number' },
                { data: 'purchase_supplier_name', name: 'purchase_supplier_name' },
                { data: 'purchase_supplier_email', name: 'purchase_supplier_email' },
                { data: 'purchase_supplier_mobile', name: 'purchase_supplier_mobile' },
                { data: 'purchase_date', name: 'purchase_date' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']], // Default sorting by ID
            lengthMenu: [10, 25, 50, 100], // Records per page options
            pageLength: 10, // Default records per page
        });
    }

    $("#txtnewsuppliername").on('change', function () 
    {
        const supplierId = $(this).val();
        if( supplierId != "" )
        {
            $.ajax({
                url: baseUrl + '/purchase/getsupplierdetail',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    supplierId: supplierId
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                beforeSend: function(jqXHR, settings) {
                    $("#sidebarAddPurchase").addClass("offcanvas-loader");
                },
                success: function (data) {
                    $("#sidebarAddPurchase").removeClass("offcanvas-loader");
                    // Populate the form fields
                    $('#txtnewpurchaseemail').val(data.supplier_email);
                    $('#txtnewpurchasesuppliername').val(data.supplier_name);
                    $('#txtnewpurchasemobileno').val("+"+data.supplier_countrycode+""+data.supplier_mobilenumber);
                    $('#txtnewpurchasebillingaddress').val(data.supplier_address);
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                        toastr.error('Session expired due to inactivity. Redirecting to login...');
                        window.location.href = baseUrl + '/login';
                    } else if (xhr.status === 401) {
                        toastr.error('Unauthorized access. Redirecting to login...');
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("AJAX error:", xhr.responseText);
                        toastr.error("AJAX error:", xhr.responseText);
                    }
                }
            });
        }
    });

    $(".txtnewpurchaseloopproductname").select2({
        width: '100%',
        dropdownParent: $('#sidebarAddPurchase')
    });

    $("#btnaddnewproductloop").on('click', function () {
        var $last = $('.newproductlistingloop').last();
    
        // 1. Destroy select2 on the last block before clone
        var $lastSelect = $last.find('select.common-select2');
        $lastSelect.select2('destroy');
    
        // 2. Clone the block
        var $newClone = $last.clone();

        $newClone.find('.parsley-error').removeClass('parsley-error');
        $newClone.find('.parsley-errors-list').remove();
    
        // 3. Remove leftover select2 markup
        $newClone.find('span.select2').remove();
        var $newSelect = $newClone.find('select.common-select2');
        $newSelect.show();
    
        // 4. Reset all input values in clone
        $newClone.removeAttr('id').removeClass('active');
        $newClone.find('input[type="text"], input[type="number"]').val('');
        $newClone.find('input.product-quantity').val('1');
        $newSelect.val('');
    
        // 5. Assign unique ID if needed (optional)
        var uniqueId = 'select2-' + Math.floor(Math.random() * 100000);
        $newSelect.attr('id', uniqueId);
    
        // 6. Append to DOM
        $newClone.appendTo('#newproductlistingcontainer');

        $newClone.find('input, select, textarea').each(function () {
            $(this).parsley(); // attach validation rules
        });
    
        // 7. Re-initialize Select2 for both
        $lastSelect.select2({
            width: '100%',
            dropdownParent: $('#sidebarAddPurchase')
        });
    
        $newSelect.select2({
            width: '100%',
            dropdownParent: $('#sidebarAddPurchase')
        });
    
        // Optional: mark new one as active
        $newClone.addClass('active');
    });
    
    // Quantity +/-
    $(document).on('click', '.plus', function () {
        let $input = $(this).siblings('input');
        let val = parseInt($input.val()) || 0;
        let max = parseInt($input.attr('max')) || 10000;
        if (val < max) $input.val(val + 1).trigger('change');
    });
    
    $(document).on('click', '.minus', function () {
        let $input = $(this).siblings('input');
        let val = parseInt($input.val()) || 1;
        let min = parseInt($input.attr('min')) || 1;
        if (val > min) $input.val(val - 1).trigger('change');
    });
    
    // Remove row
    $(document).on('click', '.purchase-close-btn .alink', function () {
        $(this).closest('.newproductlistingloop').remove();
    });
    
    // Product change: fetch and set data
    $(document).on('change', '.txtnewpurchaseloopproductname', function () {
        var $block = $(this).closest('.newproductlistingloop');
        var productId = $(this).val();
    
        if (!productId) {
            $block.find('.txtnewpurchaseloopproductno').val('');
            $block.find('.txtnewpurchaseloopprice').val('');
            $block.find('.txtnewpurchaselooptotalamount').val('');
            return;
        }
    
        $.ajax({
            url: baseUrl + '/purchase/getproductdetail',
            type: 'POST',
            data: {
                _token: csrfToken,
                productId: productId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function () {
                $("#sidebarAddPurchase").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarAddPurchase").removeClass("offcanvas-loader");
                $block.find('.txtnewpurchaseloopproductno').val(data.product_number);
                $block.find('.txtnewpurchaseloopprice').val(data.product_price);
    
                var qty = parseInt($block.find('.product-quantity').val()) || 1;
                var total = data.product_price * qty;
                $block.find('.txtnewpurchaselooptotalamount').val(total.toFixed(2));
            },
            error: function (xhr) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired. Redirecting...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized. Redirecting...');
                    window.location.href = baseUrl + '/login';
                } else {
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });
    
    // Auto calculate total on quantity change
    $(document).on('change', '.product-quantity', function () {
        var $block = $(this).closest('.newproductlistingloop');
        var price = parseFloat($block.find('.txtnewpurchaseloopprice').val()) || 0;
        var qty = parseInt($(this).val()) || 1;
        var total = price * qty;
        $block.find('.txtnewpurchaselooptotalamount').val(total.toFixed(2));
    })    

    $('#frmnewpurchaseinformation').parsley();
    $('#frmnewpurchaseinformation').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        if($('#frmnewpurchaseinformation').parsley().isValid())
        {
            let form = $(this);
            $.ajax({
                url: baseUrl + '/purchase/store',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnnewpurchaseinformation").prop('disabled', true).text('Saving...');
                },
                success: function (res) {
                    $("#btnnewpurchaseinformation").prop('disabled', false).text('Save');
                    if (res.status === 'success') 
                    {
                        toastr.success(res.message);
                        $('#garageOwnersPurchaseTable').DataTable().ajax.reload(null, false);
                        $('#sidebarAddPurchase').offcanvas('hide');
                        // Reset form and Parsley validation
                        $('#frmnewpurchaseinformation').trigger("reset");
                        $('#frmnewpurchaseinformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnnewpurchaseinformation").prop('disabled', false).text('Save');
                    let res = xhr.responseJSON;

                    if (res.status === 'error' && typeof res.message === 'object') {
                        for (let field in res.message) {
                            if (res.message.hasOwnProperty(field)) {
                                toastr.error(res.message[field][0]); // Show the first error for each field
                            }
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.getPurchaseDetails', function () {
        const purchaseId = $(this).data('purchaseid');
        $.ajax({
            url: baseUrl + '/purchase/getviewpurchasedetails',
            type: 'POST',
            data: {
                _token: csrfToken,
                purchaseId: purchaseId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarViewInformation").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarViewInformation").removeClass("offcanvas-loader");
                // Populate the form fields
                $('#purchaseviewpurchasenumber').text(data.purchase_number);
                $('#purchaseviewpurchasedate').text(data.purchase_date);
                $('#purchaseviewsupplieraddress').text(data.purchase_supplier_address);
                $('#purchaseviewsuppliername').text(data.purchase_supplier_name);
                $('#purchaseviewsupplieremail').text(data.purchase_supplier_email);
                
                // Items
                let rows = '';
                let grandTotal = 0;

                data.purchase_items.forEach(item => {
                    console.log(item)
                    let category = 'N/A';
                    let manufacturer = 'N/A';
                    let productName = item.product_name ?? 'N/A';
                    let productNo = item.product_number ?? 'N/A';
                    let qty = item.purchase_item_qty;
                    let price = item.purchase_item_price;
                    let total = item.purchase_item_total_amount;
                    grandTotal += parseFloat(total);

                    rows += `
                        <tr>
                            <td>${category}</td>
                            <td>${productNo}</td>
                            <td>${manufacturer}</td>
                            <td>${productName}</td>
                            <td>${qty}</td>
                            <td>${price}</td>
                            <td class="text-end">${total}</td>
                        </tr>
                    `;
                });

                $('#products-list').html(rows);
                $('#viewpurchasegrandtotal').text('$'+grandTotal.toFixed(2));

            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    // ---------------------------------------------------- //
    $(document).on('click', '.editviewpurchaedetails', function () {
        $("#txtupdatesuppliername").select2({
            width: '100%',
            dropdownParent: $('#sidebarEditPurchase')
        });

        const purchaseId = $(this).data('purchaseid');

        $.ajax({
            url: baseUrl + '/purchase/getviewpurchasedetails',
            type: 'POST',
            data: {
                _token: csrfToken,
                purchaseId: purchaseId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarEditPurchase").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarEditPurchase").removeClass("offcanvas-loader");
                $("#txtupdatepurchaseno").val(data.purchase_number);
                $("#txtupdatesuppliername").val(data.purchase_supplier_id).trigger('change');
                $("#txtupdatepurchasesppliername").val(data.purchase_supplier_name);
                $("#txtupdatepurchasedate").val(data.purchase_date);
                $("#txtupdatepurchaseemail").val(data.purchase_supplier_email);
                $("#txtupdatepurchasemobileno").val(data.purchase_supplier_mobile); // if available
                $("#txtupdatepurchasebillingaddress").val(data.purchase_supplier_address);
                $("#txtupdatepurchaseid").val(data.purchase_id);

                // Clear old items
                $("#updateproductlistingcontainer").empty();

                // Loop through items
                data.purchase_items.forEach(function (item, index) {
                    const html = generateProductRow(item, data.product_list); // see next step
                    $("#updateproductlistingcontainer").append(html);
                    $(".txtupdatepurchaseloopproductname").select2({
                        width: '100%',
                        dropdownParent: $('#sidebarEditPurchase')
                    });
                });
            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    $("#txtupdatesuppliername").on('change', function () 
    {
        const supplierId = $(this).val();
        if( supplierId != "" )
        {
            $.ajax({
                url: baseUrl + '/purchase/getsupplierdetail',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    supplierId: supplierId
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                beforeSend: function(jqXHR, settings) {
                    $("#sidebarEditPurchase").addClass("offcanvas-loader");
                },
                success: function (data) {
                    $("#sidebarEditPurchase").removeClass("offcanvas-loader");
                    // Populate the form fields
                    $('#txtupdatepurchaseemail').val(data.supplier_email);
                    $('#txtupdatepurchasesppliername').val(data.supplier_name);
                    $('#txtupdatepurchasemobileno').val("+"+data.supplier_countrycode+""+data.supplier_mobilenumber);
                    $('#txtupdatepurchasebillingaddress').val(data.supplier_address);
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                        toastr.error('Session expired due to inactivity. Redirecting to login...');
                        window.location.href = baseUrl + '/login';
                    } else if (xhr.status === 401) {
                        toastr.error('Unauthorized access. Redirecting to login...');
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("AJAX error:", xhr.responseText);
                        toastr.error("AJAX error:", xhr.responseText);
                    }
                }
            });
        }
    });

    $("#btnaddupdateproductloop").on('click', function () {
        var $last = $('.updateproductlistingloop').last();
    
        // 1. Destroy select2 on the last block before clone
        var $lastSelect = $last.find('select.common-select2');
        $lastSelect.select2('destroy');
    
        // 2. Clone the block
        var $newClone = $last.clone();

        $newClone.find('.parsley-error').removeClass('parsley-error');
        $newClone.find('.parsley-errors-list').remove();
    
        // 3. Remove leftover select2 markup
        $newClone.find('span.select2').remove();
        var $newSelect = $newClone.find('select.common-select2');
        $newSelect.show();
    
        // 4. Reset all input values in clone
        $newClone.removeAttr('id').removeClass('active');
        $newClone.find('input[type="text"], input[type="number"]').val('');
        $newClone.find('input.product-quantity').val('1');
        $newSelect.val('');
    
        // 5. Assign unique ID if needed (optional)
        var uniqueId = 'select2-' + Math.floor(Math.random() * 100000);
        $newSelect.attr('id', uniqueId);
    
        // 6. Append to DOM
        $newClone.appendTo('#updateproductlistingcontainer');

        $newClone.find('input, select, textarea').each(function () {
            $(this).parsley(); // attach validation rules
        });
    
        // 7. Re-initialize Select2 for both
        $lastSelect.select2({
            width: '100%',
            dropdownParent: $('#sidebarEditPurchase')
        });
    
        $newSelect.select2({
            width: '100%',
            dropdownParent: $('#sidebarEditPurchase')
        });
    
        // Optional: mark new one as active
        $newClone.addClass('active');
    });

    $(document).on('change', '.txtupdatepurchaseloopproductname', function () {
        var $block = $(this).closest('.updateproductlistingloop');
        var productId = $(this).val();
    
        if (!productId) {
            $block.find('.txtupdatepurchaseloopproductno').val('');
            $block.find('.txtupdatepurchaseloopprice').val('');
            $block.find('.txtupdatepurchaselooptotalamount').val('');
            return;
        }
    
        $.ajax({
            url: baseUrl + '/purchase/getproductdetail',
            type: 'POST',
            data: {
                _token: csrfToken,
                productId: productId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function () {
                $("#sidebarEditPurchase").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarEditPurchase").removeClass("offcanvas-loader");
                $block.find('.txtupdatepurchaseloopproductno').val(data.product_number);
                $block.find('.txtupdatepurchaseloopprice').val(data.product_price);
    
                var qty = parseInt($block.find('.product-quantity').val()) || 1;
                var total = data.product_price * qty;
                $block.find('.txtupdatepurchaselooptotalamount').val(total.toFixed(2));
            },
            error: function (xhr) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired. Redirecting...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized. Redirecting...');
                    window.location.href = baseUrl + '/login';
                } else {
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });
    
    $(document).on('change', '.txtupdatepurchaseloopqty', function () {
        var $block = $(this).closest('.updateproductlistingloop');
        var price = parseFloat($block.find('.txtupdatepurchaseloopprice').val()) || 0;
        var qty = parseInt($(this).val()) || 1;
        var total = price * qty;
        $block.find('.txtupdatepurchaselooptotalamount').val(total.toFixed(2));
    });

    $(document).on('click', '.updatepurchaseremovebtn .alink', function () {
        $(this).closest('.updateproductlistingloop').remove();
    });

    function generateProductRow(item, products) {

        let productOptions = '<option value="">Select product name</option>';

        products.forEach(function(productList) {
            const selected = productList.product_id == item.purchase_item_product_id ? 'selected' : '';
            productOptions += `<option value="${productList.product_id}" ${selected}>${productList.product_name}</option>`;
        });

        return `
        <div class="add-new-purchase-list updateproductlistingloop active">
            <div class="purchase-close-btn updatepurchaseremovebtn">
                <a class="alink btn btn-sm btn-soft-danger shadow-none radius-100"><i class="ri-close-large-line"></i></a>
            </div>
            <div class="add-new-purchase-item">
                <label class="form-label">Product Name</label>
                <select class="common-select2 txtupdatepurchaseloopproductname" name="txtupdatepurchaseloopproductname[]" required>
                    ${productOptions}
                </select>
            </div>
            <div class="add-new-purchase-item">
                <label class="form-label">Quantity</label>
                 <div class="input-step light full-width">
                    <button type="button" class="minus">–</button>
                    <input type="number" class="product-quantity txtupdatepurchaseloopqty" min="1" max="10000" name="txtupdatepurchaseloopqty[]" value="${item.purchase_item_qty}" required>
                    <button type="button" class="plus">+</button>
                </div>
            </div>
            <div class="add-new-purchase-item">
                <label class="form-label">Product No</label>
                <input type="text" class="form-control txtupdatepurchaseloopproductno" name="txtupdatepurchaseloopproductno[]" value="${item.product_number}" readonly required>
            </div>
            <div class="add-new-purchase-item">
                <label class="form-label">Price</label>
                <input type="text" class="form-control txtupdatepurchaseloopprice" name="txtupdatepurchaseloopprice[]" value="${item.purchase_item_price}" readonly required>
            </div>
            <div class="add-new-purchase-item">
                <label class="form-label">Total Amount</label>
                <input type="text" class="form-control txtupdatepurchaselooptotalamount" name="txtupdatepurchaselooptotalamount[]" value="${item.purchase_item_total_amount}" readonly required>
            </div>
        </div>`;
    }    

    $('#frmupdatepurchaseinformation').parsley();
    $('#frmupdatepurchaseinformation').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        if($('#frmupdatepurchaseinformation').parsley().isValid())
        {
            let form = $(this);
            $.ajax({
                url: baseUrl + '/purchase/update',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnnewpurchaseinformation").prop('disabled', true).text('Saving...');
                },
                success: function (res) {
                    $("#btnnewpurchaseinformation").prop('disabled', false).text('Save');
                    if (res.status === 'success') 
                    {
                        toastr.success(res.message);
                        $('#garageOwnersPurchaseTable').DataTable().ajax.reload(null, false);
                        $('#sidebarEditPurchase').offcanvas('hide');
                        // Reset form and Parsley validation
                        $('#frmupdatepurchaseinformation').trigger("reset");
                        $('#frmupdatepurchaseinformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnnewpurchaseinformation").prop('disabled', false).text('Save');
                    let res = xhr.responseJSON;

                    if (res.status === 'error' && typeof res.message === 'object') {
                        for (let field in res.message) {
                            if (res.message.hasOwnProperty(field)) {
                                toastr.error(res.message[field][0]); // Show the first error for each field
                            }
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.removepurchasedata', function () {
        const purchaseId = $(this).data('purchaseid');
        $("#txtarchivepurchasetid").val(purchaseId);
    });

    $(document).on('click', '#archive-purchase-notification', function () {
        const purchaseId = $("#txtarchivepurchasetid").val();
        $.ajax({
            url: baseUrl + '/purchase/remove-details/'+purchaseId,
            type: 'DELETE',
            data: {
                _token: csrfToken,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $(this).prop('disabled', true).text('Deleting...');
            },
            success: function (res) {
                toastr.success(res.message);
                $(this).prop('disabled', false).text('Yes, Archive It!');
                $('#removePurchaseNotificationModal').offcanvas('hide');
                $('#garageOwnersPurchaseTable').DataTable().ajax.reload(null, false);
            },
            error: function(xhr, error, thrown) {
                $(this).prop('disabled', true).text('Yes, Archive It!');
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });
    // End

    // Manage Stock Section
    let dataStockRoute = $('#garageOwnersStockTable').data('route');
    if ($('#garageOwnersStockTable').length) 
    {
        $('#garageOwnersStockTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:dataStockRoute,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        alert("Session expired. Redirecting to login...");
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("DataTable load error:", xhr.responseText);
                    }
                }
            },
            stateSave: true,
            columns: [
                { data: 'product_id', name: 'product_id' },
                { data: 'product_number', name: 'product_number' },
                { data: 'business_name', name: 'business_name' },
                { data: 'product_name', name: 'product_name' },
                { data: 'total_qty', name: 'total_qty' },
                { data: 'unit_of_masurement', name: 'unit_of_masurement' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']], // Default sorting by ID
            lengthMenu: [10, 25, 50, 100], // Records per page options
            pageLength: 10, // Default records per page
        });
    }
    // End


    // Manage Booking Section
    let dataBookingRoute = $('#garageOwnersBookingTable').data('route');
    if ($('#garageOwnersBookingTable').length) 
    {
        $('#garageOwnersBookingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:dataBookingRoute,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 401) {
                        alert("Session expired. Redirecting to login...");
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("DataTable load error:", xhr.responseText);
                    }
                }
            },
            stateSave: true,
            columns: [
                { data: 'booking_id', name: 'booking_id' },
                { data: 'booking_date_time', name: 'booking_date_time' },
                { data: 'client_name', name: 'client_name' },
                { data: 'number_plate', name: 'number_plate' },
                { data: 'booking_details', name: 'booking_details' },
                { data: 'booking_is_covidsafe', name: 'booking_is_covidsafe' },
                { data: 'booking_is_service', name: 'booking_is_service' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'asc']], // Default sorting by ID
            lengthMenu: [10, 25, 50, 100], // Records per page options
            pageLength: 10, // Default records per page
        });
    }

    $("#txtbookingvehicle").on('change', function () 
    {
        const customerId = $("#txtbookingvehicle option:selected").data("customerid");
        if( customerId != "" )
        {
            $.ajax({
                url: baseUrl + '/booking/getuserdetail',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    customerId: customerId
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                beforeSend: function(jqXHR, settings) {
                    $("#sidebarNewBooking").addClass("offcanvas-loader");
                },
                success: function (data) {
                    $("#sidebarNewBooking").removeClass("offcanvas-loader");
                    // Populate the form fields
                    $('#txtbookingclientname').val(data.user_name);
                    $('#txtbookinguserid').val(data.user_id);
                    const curdatetime = $('#ttxtbookingdatetime').val();
                    let date = "";
                    let time = "";
                    if( curdatetime != "" )
                    {
                        let curdatetime = curdatetime.split(" ");
                        date = curdatetime[0];
                        time = curdatetime[1];
                    }
                    let company_name = "";
                    send_covid_sms_template(data.user_name, date, time, company_name, "txtcovidsafenotificationtemplate");
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                        toastr.error('Session expired due to inactivity. Redirecting to login...');
                        window.location.href = baseUrl + '/login';
                    } else if (xhr.status === 401) {
                        toastr.error('Unauthorized access. Redirecting to login...');
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("AJAX error:", xhr.responseText);
                        toastr.error("AJAX error:", xhr.responseText);
                    }
                }
            });
        }
        else
        {
            $('#txtbookingclientname').val("");
            $('#txtbookinguserid').val("");
        }
    });

    function send_covid_sms_template(name, date, time, company_name, templateid)
    {
        let msg_template = `Dear `+name+`,\nYour booking is confirmed on `+date+`.\nArrival Time -  `+time+`.\nYou could park your car at -  __.\nYou could drop the keys at -  __.\nWe will be in touch when the estimate is completed.\nThanks,\n `+company_name+`\nMotor Repair Bill`;
        $('#'+templateid).val(msg_template);
    }

    // flatpickr("#ttxtbookingdatetime", {
    //     dateFormat: "Y-m-d H:i", // 2025-05-25 14:30
    //     allowInput: true,
    //     enableTime: true,
    //     onClose: function(selectedDates, dateStr, instance) {
    //         if (selectedDates.length > 0) {
    //         const selectedDate = selectedDates[0];
    //         const formattedDate = selectedDate.toISOString().split("T")[0]; // "2025-07-09"
    //         const formattedTime = `${String(selectedDate.getHours()).padStart(2, "0")}:${String(selectedDate.getMinutes()).padStart(2, "0")}`; // "18:00"
    //         const clientname = $("#txtbookingclientname").val();       
    //         send_covid_sms_template(clientname, formattedDate, formattedTime, "", "txtcovidsafenotificationtemplate")
    //         $("#txtbookingdate").val(formattedDate);
    //         $("#txtbookingtime").val(formattedTime);
    //         }
    //     }
    // });

    $('#frmaddnewbookinginformation').parsley();
    $('#frmaddnewbookinginformation').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        if($('#frmaddnewbookinginformation').parsley().isValid())
        {
            let form = $(this);
            $.ajax({
                url: baseUrl + '/booking/store',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnaddnewbooking").prop('disabled', true).text('Saving...');
                },
                success: function (res) {
                    $("#btnaddnewbooking").prop('disabled', false).text('Save');
                    if (res.status === 'success') 
                    {
                        toastr.success(res.message);
                        $('#garageOwnersBookingTable').DataTable().ajax.reload(null, false);
                        $('#sidebarNewBooking').offcanvas('hide');
                        // Reset form and Parsley validation
                        $('#frmaddnewbookinginformation').trigger("reset");
                        $('#frmaddnewbookinginformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnaddnewbooking").prop('disabled', false).text('Save');
                    let res = xhr.responseJSON;

                    if (res.status === 'error' && typeof res.message === 'object') {
                        for (let field in res.message) {
                            if (res.message.hasOwnProperty(field)) {
                                toastr.error(res.message[field][0]); // Show the first error for each field
                            }
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.getbookingDetails', function () {
        $("#txtupdatebookingvehicle").select2({
            width: '100%',
            dropdownParent: $('#sidebarEditBooking')
        });

        const bookingId = $(this).data('bookingid');

        $.ajax({
            url: baseUrl + '/booking/getviewbookingdetails',
            type: 'POST',
            data: {
                _token: csrfToken,
                bookingId: bookingId
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $("#sidebarEditBooking").addClass("offcanvas-loader");
            },
            success: function (data) {
                $("#sidebarEditBooking").removeClass("offcanvas-loader");
                $("#txtupdatebookingvehicle").val(data.booking_vehicle_id).trigger('change');
                $("#txtupdatebookingclientname").val(data.client_name);
                //$("#ttxtupdatebookingdatetime").val(data.booking_date_time);
                $("#txtupdatebookingdetails").val(data.booking_details);
                $("#txtupdatecovidsafenotificationtemplate").val(data.booking_sms_template); // if available
                $("#txtupdatebookinguserid").val(data.booking_customer_id);
                $("#txtupdatebookingdate").val(data.booking_date);
                $("#txtupdatebookingtime").val(data.booking_time);
                $("#txtupdatebookingid").val(data.booking_id);

                $('#txtupdatebookingservice').attr("checked", false);
                if( data.booking_is_service == "1" )
                {
                    $('#txtupdatebookingservice').attr("checked", true);
                }

                $('#txtupdatebookingcovidsafe').attr("checked", false);
                if( data.booking_is_covidsafe == "2" )
                {
                    $('#txtupdatebookingcovidsafe').attr("checked", true);
                }

                // Initialize flatpickr with datetime settings
                const fp = flatpickr("#ttxtupdatebookingdatetime", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i"
                });

                fp.setDate(data.booking_date_time);

                //$("#ttxtupdatebookingdatetime").flatpickr().setDate(data.booking_date_time);
            },
            error: function(xhr, error, thrown) {
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    // Add Booking Flatpickr (init once)
    const bookingInput = document.getElementById("ttxtbookingdatetime");

    if (bookingInput) {
        flatpickr(bookingInput, {
            dateFormat: "Y-m-d H:i",
            allowInput: true,
            enableTime: true,
            onClose: function (selectedDates) {
                if (selectedDates.length > 0) {
                    const selectedDate = selectedDates[0];
                    const formattedDate = selectedDate.toISOString().split("T")[0];
                    const formattedTime = `${String(selectedDate.getHours()).padStart(2, "0")}:${String(selectedDate.getMinutes()).padStart(2, "0")}`;
                    const clientname = $("#txtbookingclientname").val();
                    send_covid_sms_template(clientname, formattedDate, formattedTime, "", "txtcovidsafenotificationtemplate");
                    $("#txtbookingdate").val(formattedDate);
                    $("#txtbookingtime").val(formattedTime);
                }
            }
        });
    }

    // Edit Booking Flatpickr — always destroy & reinit
    function initUpdateFlatpickr() {
        const $input = $("#ttxtupdatebookingdatetime");

        // destroy if already initialized
        if ($input.length && $input[0]._flatpickr) {
            $input[0]._flatpickr.destroy();
        }

        // re-initialize
        flatpickr($input[0], {
            dateFormat: "Y-m-d H:i",
            allowInput: true,
            enableTime: true,
            onClose: function (selectedDates) {
                if (selectedDates.length > 0) {
                    const selectedDate = selectedDates[0];
                    const formattedDate = selectedDate.toISOString().split("T")[0];
                    const formattedTime = `${String(selectedDate.getHours()).padStart(2, "0")}:${String(selectedDate.getMinutes()).padStart(2, "0")}`;
                    const clientname = $("#txtupdatebookingclientname").val();
                    send_covid_sms_template(clientname, formattedDate, formattedTime, "", "txtupdatecovidsafenotificationtemplate");
                    $("#txtupdatebookingdate").val(formattedDate);
                    $("#txtupdatebookingtime").val(formattedTime);
                }
            }
        });
    }

    // Hook into Bootstrap's offcanvas open
    $('#sidebarEditBooking').on('shown.bs.offcanvas', function () {
        // Delay needed for DOM to settle properly (fixes close button glitch)
        setTimeout(initUpdateFlatpickr, 10);
    });

    // Also destroy explicitly when closed
    $('#sidebarEditBooking').on('hidden.bs.offcanvas', function () {
        const $input = $("#ttxtupdatebookingdatetime");
        if ($input.length && $input[0]._flatpickr) {
            $input[0]._flatpickr.destroy();
        }
    });

    $("#txtupdatebookingvehicle").on('change', function () 
    {
        const customerId = $("#txtupdatebookingvehicle option:selected").data("customerid");
        if( customerId != "" )
        {
            $.ajax({
                url: baseUrl + '/booking/getuserdetail',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    customerId: customerId
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                beforeSend: function(jqXHR, settings) {
                    $("#sidebarEditBooking").addClass("offcanvas-loader");
                },
                success: function (data) {
                    $("#sidebarEditBooking").removeClass("offcanvas-loader");
                    // Populate the form fields
                    $('#txtupdatebookingclientname').val(data.user_name);
                    $('#txtupdatebookinguserid').val(data.user_id);

                    let curdatetime = $('#ttxtupdatebookingdatetime').val();
                    let date = "";
                    let time = "";
                    if( curdatetime != "" )
                    {
                        curdatetime = curdatetime.split(" ");
                        date = curdatetime[0];
                        time = curdatetime[1];
                    }
                    let company_name = "";
                    send_covid_sms_template(data.user_name, date, time, company_name, "txtupdatecovidsafenotificationtemplate");
                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                        toastr.error('Session expired due to inactivity. Redirecting to login...');
                        window.location.href = baseUrl + '/login';
                    } else if (xhr.status === 401) {
                        toastr.error('Unauthorized access. Redirecting to login...');
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("AJAX error:", xhr.responseText);
                        toastr.error("AJAX error:", xhr.responseText);
                    }
                }
            });
        }
        else
        {
            $('#txtbookingclientname').val("");
            $('#txtbookinguserid').val("");
        }
    });

    $('#frmupdatebookinginformation').parsley();
    $('#frmupdatebookinginformation').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        if($('#frmupdatebookinginformation').parsley().isValid())
        {
            let form = $(this);
            $.ajax({
                url: baseUrl + '/booking/update',
                method: 'POST',
                data: formData,
                contentType: false,    // Required for file upload
                processData: false,    // Required for file upload
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $("#btnaddnewbooking").prop('disabled', true).text('Saving...');
                },
                success: function (res) {
                    $("#btnaddnewbooking").prop('disabled', false).text('Save');
                    if (res.status === 'success') 
                    {
                        toastr.success(res.message);
                        $('#garageOwnersBookingTable').DataTable().ajax.reload(null, false);
                        $('#sidebarEditBooking').offcanvas('hide');
                        // Reset form and Parsley validation
                        $('#frmupdatebookinginformation').trigger("reset");
                        $('#frmupdatebookinginformation').parsley().reset();
                    }
                    else
                    {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "10000"
                        };
                        for (const key in res.message) 
                        {
                            if (res.message.hasOwnProperty(key)) 
                            {
                                toastr.error(res.message[key].toString());
                            }
                        }
                    }
                },
                error: function (xhr) {
                    $("#btnaddnewbooking").prop('disabled', false).text('Save');
                    let res = xhr.responseJSON;

                    if (res.status === 'error' && typeof res.message === 'object') {
                        for (let field in res.message) {
                            if (res.message.hasOwnProperty(field)) {
                                toastr.error(res.message[field][0]); // Show the first error for each field
                            }
                        }
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        }
    });

    $(document).on('click', '.removebookingdata', function () {
        const purchaseId = $(this).data('bookingid');
        $("#txtarchivebookingid").val(purchaseId);
    });

    $(document).on('click', '#archive-booking-notification', function () {
        const bookingId = $("#txtarchivebookingid").val();
        $.ajax({
            url: baseUrl + '/booking/remove-details/'+bookingId,
            type: 'DELETE',
            data: {
                _token: csrfToken,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $(this).prop('disabled', true).text('Deleting...');
            },
            success: function (res) {
                toastr.success(res.message);
                $(this).prop('disabled', false).text('Yes, Archive It!');
                $('#removebookingNotificationModal').offcanvas('hide');
                $('#garageOwnersBookingTable').DataTable().ajax.reload(null, false);
            },
            error: function(xhr, error, thrown) {
                $(this).prop('disabled', true).text('Yes, Archive It!');
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });

    $(document).on('click', '.convertnormalbookingdata', function () {
        const purchaseId = $(this).data('bookingid');
        $("#txtbookingid").val(purchaseId);
    });

    $(document).on('click', '#convert-normal-booking-notification', function () {
        const bookingId = $("#txtbookingid").val();
        $.ajax({
            url: baseUrl + '/booking/convert-normal-booking/'+bookingId,
            type: 'DELETE',
            data: {
                _token: csrfToken,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function(jqXHR, settings) {
                $(this).prop('disabled', true).text('Converting...');
            },
            success: function (res) {
                toastr.success(res.message);
                $(this).prop('disabled', false).text('Yes, Convert It!');
                $('#covertNormalBookingNotificationModal').offcanvas('hide');
                $('#garageOwnersBookingTable').DataTable().ajax.reload(null, false);
            },
            error: function(xhr, error, thrown) {
                $(this).prop('disabled', true).text('Yes, Convert It!');
                if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                    toastr.error('Session expired due to inactivity. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else if (xhr.status === 401) {
                    toastr.error('Unauthorized access. Redirecting to login...');
                    window.location.href = baseUrl + '/login';
                } else {
                    console.error("AJAX error:", xhr.responseText);
                    toastr.error("AJAX error:", xhr.responseText);
                }
            }
        });
    });
    // End


    // Estimate Module code start
        $('#addItemNewEstimation').click(function () {
            var $originalRow = $('tbody#labouritemlistingwrapper tr.product').first(); // get the first product row
            var $clonedRow = $originalRow.clone(); // clone it

            // Optional: Reset input values in the cloned row
            $clonedRow.find('input').val('');
            $clonedRow.find('select').prop('selectedIndex', 0);

            $clonedRow.find('.product-removal a').removeClass('disabled');

            // Update serial number (1st column)
            var rowCount = $('tbody#labouritemlistingwrapper tr.product').length + 1;
            $clonedRow.find('td:first').text(rowCount);

            // Append to tbody
            $('tbody#labouritemlistingwrapper').append($clonedRow);

            calculateGrandTotal();
        });

        $(document).on('click', '#labouritemlistingwrapper .product-removal a', function () {
            $(this).closest('tr').remove();

            // Optional: Recalculate serial numbers
            $('tbody#labouritemlistingwrapper tr.product').each(function (index) {
                $(this).find('td:first').text(index + 1);
            });

            calculateGrandTotal();
        });

        $('#addProductNewEstimation').click(function () {
            var $originalRow = $('tbody#productitemlistingwrapper tr.product').first(); // get the first product row
            var $clonedRow = $originalRow.clone(); // clone it

            // Optional: Reset input values in the cloned row
            $clonedRow.find('input').val('');
            $clonedRow.find('.product-quantity').val(1);
            $clonedRow.find('select').prop('selectedIndex', 0);

            $clonedRow.find('.product-price, .product-tax, .product-quantity').trigger('change');

            $clonedRow.find('.product-removal a').removeClass('disabled');

            // Update serial number (1st column)
            var rowCount = $('tbody#productitemlistingwrapper tr.product').length + 1;
            $clonedRow.find('td:first').text(rowCount);

            // Append to tbody
            $('tbody#productitemlistingwrapper').append($clonedRow);

            calculateGrandTotal();
        });

        $(document).on('click', '#productitemlistingwrapper .product-removal a', function () {
            $(this).closest('tr').remove();

            // Optional: Recalculate serial numbers
            $('tbody#productitemlistingwrapper tr.product').each(function (index) {
                $(this).find('td:first').text(index + 1);
            });

            calculateGrandTotal();
        });

        $(document).on('input change', '.hours, .rate, .tax', function () {
            var $row = $(this).closest('tr');

            // Get hours and rate values
            var hours = parseFloat($row.find('.hours').val()) || 0;
            var rate = parseFloat($row.find('.rate').val()) || 0;

            // Calculate cost (hours × rate)
            var cost = hours * rate;
            $row.find('.cost').val(cost.toFixed(2)); // show cost

            // Get selected tax percentage
            var taxRate = parseFloat($row.find('.tax').val()) || 0;

            // Calculate total with tax
            var total = cost + (cost * taxRate / 100);
            $row.find('.total').val(total.toFixed(2));

            calculateGrandTotal();
        });

        function calculateProductTotal($row) {
            var quantity = parseFloat($row.find('.product-quantity').val()) || 0;
            var price = parseFloat($row.find('.product-price').val()) || 0;
            var markup = parseFloat($row.find('.product-cost').val()) || 0;
            var tax = parseFloat($row.find('.product-tax').val()) || 0;

            // Step 1: Apply markup to price
            var markedUpPrice = price + (price * markup / 100);

            // Step 2: Subtotal = markedUpPrice × quantity
            var subtotal = markedUpPrice * quantity;

            // Step 3: Tax
            var total = subtotal + (subtotal * tax / 100);

            // Output to final total field
            $row.find('.product-line-price').val(total.toFixed(2));

            calculateGrandTotal();
        }


        $(document).on('input change', '.product-quantity, .product-price, .product-cost, .product-tax', function () {
            var $row = $(this).closest('tr.product');
            calculateProductTotal($row);
        });

        function calculateGrandTotal() {
            var totalLabour = 0;
            var totalParts = 0;
            var totalTax = 0;

            // Labour totals
            $('.labour-row').each(function () {
                var val = parseFloat($(this).find('.total').val()) || 0;
                totalLabour += val;

                var cost = parseFloat($(this).find('.cost').val()) || 0;
                var tax = parseFloat($(this).find('.tax').val()) || 0;
                var counttax = parseFloat(cost * tax ) / 100;
                totalTax += counttax;
            });

            // Product totals
            $('.product-row').each(function () {
                var val = parseFloat($(this).find('.product-line-price').val()) || 0;
                totalParts += val;

                var tax = parseFloat($(this).find('.product-tax').val()) || 0;
                var cost = parseFloat($(this).find('.product-price').val()) || 0;
                var totlcostamount = parseFloat($(this).find('.product-quantity').val()) || 0;
                var sumcostamount = parseFloat( totlcostamount * cost );
                var counttax = parseFloat(sumcostamount * tax ) / 100;
                totalTax += counttax;
            });

            // Total Due Amount
            var totalDue = totalLabour + totalParts;
            var totalDueExceptTax = parseFloat(totalDue - totalTax );

            // Update UI
            $('#txttotallabour').text('$' + totalLabour.toFixed(2));
            $('#txttotalpartsmaterials').text('$' + totalParts.toFixed(2));
            $('#txttotaltax').text('$' + totalTax.toFixed(2));
            $('#txttotalduewamount').text('$' + totalDue.toFixed(2));

            $('#txtsumtotallabour').val(totalLabour.toFixed(2));
            $('#txtsumtotalparts').val(totalParts.toFixed(2));
            $('#txtsumtotaltax').val(totalTax.toFixed(2));
            $('#txtsumtotaldueamount').val(totalDue.toFixed(2));
            $('#txtsumtotaldueamountexcepttax').val(totalDueExceptTax.toFixed(2));
        }

        $(document).on('change', '.product-select', function () {
            var value = $(this).val();
            var text = $(this).find('option:selected').text().trim();
            $(this).closest('tr').find('.txtproducttitle').val(text);
        });    

        $('#frmnewestimateinformation').parsley();
        $('#frmnewestimateinformation').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            if($('#frmnewestimateinformation').parsley().isValid())
            {
                let form = $(this);
                $.ajax({
                    url: baseUrl + '/estimate/store',
                    method: 'POST',
                    data: formData,
                    contentType: false,    // Required for file upload
                    processData: false,    // Required for file upload
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $("#btnnewestimate").prop('disabled', true).text('Creating...');
                    },
                    success: function (res) {
                        $("#btnnewestimate").prop('disabled', false).text('Create');
                        if (res.status === 'success') 
                        {
                            toastr.success(res.message);

                            $('#frmnewestimateinformation').trigger("reset");
                            $('#frmnewestimateinformation').parsley().reset();
                            setTimeout(function() {
                                window.location.href = baseUrl + '/estimate/list';
                            }, 3000);
                        }
                        else
                        {
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "timeOut": "10000"
                            };
                            for (const key in res.message) 
                            {
                                if (res.message.hasOwnProperty(key)) 
                                {
                                    toastr.error(res.message[key].toString());
                                }
                            }
                        }
                    },
                    error: function (xhr) {
                        $("#btnnewestimate").prop('disabled', false).text('Create');
                        let res = xhr.responseJSON;

                        if (res.status === 'error' && typeof res.message === 'object') {
                            for (let field in res.message) {
                                if (res.message.hasOwnProperty(field)) {
                                    toastr.error(res.message[field][0]); // Show the first error for each field
                                }
                            }
                        } else {
                            toastr.error('Something went wrong. Please try again.');
                        }
                    }
                });
            }
        });

        let dataEstimateRoute = $('#garageOwnersEstimateTable').data('route');
        if ($('#garageOwnersEstimateTable').length) 
        {
            $('#garageOwnersEstimateTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:dataEstimateRoute,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                    },
                    error: function(xhr, error, thrown) {
                        if (xhr.status === 401) {
                            alert("Session expired. Redirecting to login...");
                            window.location.href = baseUrl + '/login';
                        } else {
                            console.error("DataTable load error:", xhr.responseText);
                        }
                    }
                },
                stateSave: true,
                columns: [
                    { data: 'estimate_id', name: 'estimate_id' },
                    { data: 'estimate_booking_id', name: 'estimate_booking_id' },
                    { data: 'estimate_estimate_no', name: 'estimate_estimate_no' },
                    { data: 'client_name', name: 'client_name' },
                    { data: 'vehicle', name: 'vehicle' },
                    { data: 'number_plate', name: 'number_plate' },
                    { data: 'estimate_total_inctax', name: 'estimate_total_inctax' },
                    { data: 'estimate_total', name: 'estimate_total' },
                    { data: 'estimate_date', name: 'estimate_date' },
                    { data: 'estimate_carOwnerApproval', name: 'estimate_carOwnerApproval' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'asc']], // Default sorting by ID
                lengthMenu: [10, 25, 50, 100], // Records per page options
                pageLength: 10, // Default records per page
            });
        }

    // End

    // Repair Order Module code start

        $('#frmnewrepairorderinformation').parsley();
        $('#frmnewrepairorderinformation').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            if($('#frmnewrepairorderinformation').parsley().isValid())
            {
                let form = $(this);
                $.ajax({
                    url: baseUrl + '/repair-order/store',
                    method: 'POST',
                    data: formData,
                    contentType: false,    // Required for file upload
                    processData: false,    // Required for file upload
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $("#btncreaterepairorder").prop('disabled', true).text('Creating...');
                    },
                    success: function (res) {
                        $("#btncreaterepairorder").prop('disabled', false).text('Create');
                        if (res.status === 'success') 
                        {
                            toastr.success(res.message);
                            $('#garageOwnersBookingTable').DataTable().ajax.reload(null, false);
                            $('#sidebarNewBooking').offcanvas('hide');
                            // Reset form and Parsley validation
                            $('#frmnewrepairorderinformation').trigger("reset");
                            $('#frmnewrepairorderinformation').parsley().reset();

                            setTimeout(function() {
                                window.location.href = baseUrl + '/repair-order/list';
                            }, 30000);

                        }
                        else
                        {
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "timeOut": "10000"
                            };
                            for (const key in res.message) 
                            {
                                if (res.message.hasOwnProperty(key)) 
                                {
                                    toastr.error(res.message[key].toString());
                                }
                            }
                        }
                    },
                    error: function (xhr) {
                        $("#btncreaterepairorder").prop('disabled', false).text('Create');
                        let res = xhr.responseJSON;

                        if (res.status === 'error' && typeof res.message === 'object') {
                            for (let field in res.message) {
                                if (res.message.hasOwnProperty(field)) {
                                    toastr.error(res.message[field][0]); // Show the first error for each field
                                }
                            }
                        } else {
                            toastr.error('Something went wrong. Please try again.');
                        }
                    }
                });
            }
        });

        let dataRepairOrderRoute = $('#garageOwnersRepairOrderTable').data('route');
        if ($('#garageOwnersRepairOrderTable').length) 
        {
            $('#garageOwnersRepairOrderTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:dataRepairOrderRoute,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                    },
                    error: function(xhr, error, thrown) {
                        if (xhr.status === 401) {
                            alert("Session expired. Redirecting to login...");
                            window.location.href = baseUrl + '/login';
                        } else {
                            console.error("DataTable load error:", xhr.responseText);
                        }
                    }
                },
                stateSave: true,
                columns: [
                    { data: 'repairorder_estimate_id', name: 'repairorder_estimate_id' },
                    { data: 'repairorder_order_no', name: 'repairorder_order_no' },
                    { data: 'repairorder_garage_employee', name: 'repairorder_garage_employee' },
                    { data: 'client_name', name: 'client_name' },
                    { data: 'vehicle', name: 'vehicle' },
                    { data: 'number_plate', name: 'number_plate' },
                    { data: 'vin', name: 'vin' },
                    { data: 'repairorder_amount', name: 'repairorder_amount' },
                    { data: 'repairorder_order_date', name: 'repairorder_order_date' },
                    { data: 'repaiorder_clock_in', name: 'repaiorder_clock_in' },
                    { data: 'repaiorder_clock_out', name: 'repaiorder_clock_out' },
                    { data: 'repairorder_status', name: 'repairorder_status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'asc']], // Default sorting by ID
                lengthMenu: [10, 25, 50, 100], // Records per page options
                pageLength: 10, // Default records per page
            });
        }

    // End

    // Invoice Module code start

        $('#frmnewinvoiceinformation').parsley();
        $('#frmnewinvoiceinformation').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            if($('#frmnewinvoiceinformation').parsley().isValid())
            {
                let form = $(this);
                $.ajax({
                    url: baseUrl + '/invoice/store',
                    method: 'POST',
                    data: formData,
                    contentType: false,    // Required for file upload
                    processData: false,    // Required for file upload
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $("#btnnewinvoice").prop('disabled', true).text('Creating...');
                    },
                    success: function (res) {
                        $("#btnnewinvoice").prop('disabled', false).text('Create');
                        if (res.status === 'success') 
                        {
                            toastr.success(res.message);

                            $('#frmnewinvoiceinformation').trigger("reset");
                            $('#frmnewinvoiceinformation').parsley().reset();
                            setTimeout(function() {
                                window.location.href = baseUrl + '/invoice/list';
                            }, 3000);
                        }
                        else
                        {
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "timeOut": "10000"
                            };
                            for (const key in res.message) 
                            {
                                if (res.message.hasOwnProperty(key)) 
                                {
                                    toastr.error(res.message[key].toString());
                                }
                            }
                        }
                    },
                    error: function (xhr) {
                        $("#btnnewinvoice").prop('disabled', false).text('Create');
                        let res = xhr.responseJSON;

                        if (res.status === 'error' && typeof res.message === 'object') {
                            for (let field in res.message) {
                                if (res.message.hasOwnProperty(field)) {
                                    toastr.error(res.message[field][0]); // Show the first error for each field
                                }
                            }
                        } else {
                            toastr.error('Something went wrong. Please try again.');
                        }
                    }
                });
            }
        });

        let dataInvoiceRoute = $('#garageOwnersInvoiceTable').data('route');
        if ($('#garageOwnersInvoiceTable').length) 
        {
            $('#garageOwnersInvoiceTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:dataInvoiceRoute,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken  // Add CSRF token in headers
                    },
                    error: function(xhr, error, thrown) {
                        if (xhr.status === 401) {
                            alert("Session expired. Redirecting to login...");
                            window.location.href = baseUrl + '/login';
                        } else {
                            console.error("DataTable load error:", xhr.responseText);
                        }
                    }
                },
                stateSave: true,
                columns: [
                    { data: 'invoice_id', name: 'invoice_id' },
                    { data: 'invoice_booking_id', name: 'invoice_booking_id' },
                    { data: 'invoice_no', name: 'invoice_no' },
                    { data: 'client_name', name: 'client_name' },
                    { data: 'vehicle', name: 'vehicle' },
                    { data: 'number_plate', name: 'number_plate' },
                    { data: 'vin', name: 'vin' },
                    { data: 'invoice_total_inctax', name: 'invoice_total_inctax' },
                    { data: 'invoice_total', name: 'invoice_total' },
                    { data: 'invoice_date', name: 'invoice_date' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'asc']], // Default sorting by ID
                lengthMenu: [10, 25, 50, 100], // Records per page options
                pageLength: 10, // Default records per page
            });
        }

        $(document).on('click', '.btndisplayinvoicedetails', function () {
            const invoiceId = $(this).data('invoiceid');
            $.ajax({
                url: baseUrl + '/invoice/getviewinvoicedetails',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    invoiceId: invoiceId
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                beforeSend: function(jqXHR, settings) {
                    $("#sidebarViewInvoice").addClass("offcanvas-loader");
                },
                success: function (data) {
                    $("#sidebarViewInvoice").removeClass("offcanvas-loader");
                    // Populate the form fields
                    $('#customer_name').text(data.customer_name);
                    $('#customer_contact').text(data.customer_contact);
                    $('#customer_email').text(data.customer_email);
                    $('#customer_address').text(data.customer_address);
                    $('#vehicle_name').text(data.vehicle_name);
                    $('#vehicle_reg_no').text(data.vehicle_reg_no);
                    $('#vehicle_vin').text(data.vehicle_vin);
                    $('#total_labour').text(data.total_labour);
                    $('#total_parts').text(data.total_parts);
                    $('#total_tax').text(data.total_tax);
                    $('#grand_total').text(data.grand_total);
                    
                    // Items
                    let part_rows = labour_rows = '';

                    data.item_data.forEach((item, index) => {

                        let productName     = item.product_name ?? 'N/A';
                        let parts_quantity  = item.estimate_parts_quantity;
                        let parts_cost      = item.estimate_parts_cost;
                        let parts_markup    = item.estimate_parts_markup;
                        let parts_tax       = item.estimate_parts_tax;
                        let parts_total     = parseFloat(item.estimate_parts_total);

                        part_rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${productName}</td>
                                <td>${parts_quantity}</td>
                                <td>${parts_cost}</td>
                                <td>${parts_markup}</td>
                                <td>${parts_tax}</td>
                                <td class="text-end">${parts_total}</td>
                            </tr>
                        `;
                    });

                    $('#products-list').html(part_rows);

                    data.labour_data.forEach((labour_item, index) => {

                        let labor_item      = labour_item.estimate_labor_item ?? 'N/A';
                        let labor_rate      = labour_item.estimate_labor_rate;
                        let labor_hours     = labour_item.estimate_labor_hours;
                        let labor_cost      = labour_item.estimate_labor_cost;
                        let labor_tax       = labour_item.estimate_labor_tax;
                        let labor_total     = parseFloat(labour_item.estimate_labor_total);

                        labour_rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${labor_item}</td>
                                <td>${labor_rate}</td>
                                <td>${labor_hours}</td>
                                <td>${labor_cost}</td>
                                <td>${labor_tax}</td>
                                <td class="text-end">${labor_total}</td>
                            </tr>
                        `;
                    });

                    $('#labour-list').html(labour_rows);

                },
                error: function(xhr, error, thrown) {
                    if (xhr.status === 419 || xhr.responseText.includes('CSRF token mismatch')) {
                        toastr.error('Session expired due to inactivity. Redirecting to login...');
                        window.location.href = baseUrl + '/login';
                    } else if (xhr.status === 401) {
                        toastr.error('Unauthorized access. Redirecting to login...');
                        window.location.href = baseUrl + '/login';
                    } else {
                        console.error("AJAX error:", xhr.responseText);
                        toastr.error("AJAX error:", xhr.responseText);
                    }
                }
            });
        });

        $('#printBtn').click(function () {
            var content = $('#printinvoicedata').html(); // get modal content

            var printWindow = window.open();
            printWindow.document.write('<html><head><title>Print Invoice</title>');

            // Optional: Copy Bootstrap CSS from current page (if needed)
            printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');

            // Optional: Add some inline styles for better layout on print
            printWindow.document.write('<style>body{ font-family: Arial; padding: 20px; } .table th, .table td { border: 1px solid #ccc !important; }</style>');

            printWindow.document.write('</head><body>');
            printWindow.document.write(content); // insert your modal content
            printWindow.document.write('</body></html>');

            printWindow.document.close(); // finish writing
            printWindow.focus();

            // Delay print to allow rendering
            setTimeout(function () {
                printWindow.print();
                printWindow.close();
            }, 500);
        });

    // End

        // $(document).on('click', '.plus', function () {
        //     var $qty = $(this).siblings('.product-quantity');
        //     var current = parseInt($qty.val()) || 0;
        //     $qty.val(current + 1).trigger('input');
        // });

        // $(document).on('click', '.minus', function () {
        //     var $qty = $(this).siblings('.product-quantity');
        //     var current = parseInt($qty.val()) || 1;
        //     if (current > 1) {
        //         $qty.val(current - 1).trigger('input');
        //     }
        // });



    // 

});