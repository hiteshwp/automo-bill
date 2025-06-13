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
                $('#updateadmineditstate').val(data.state_id);
                $('#updateadmineditcity').val(data.city_id);
                $('#updateadminid').val(data.id);
                $('#profileimage').prop("src",data.user_profile_pic);
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

    // $("#btnnewaddclient").on('click', function () {
    //     console.log("Hello");
    // });

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
                { data: 'products', name: 'products' },
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
    // End

    // Manage Supplier Section
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

});