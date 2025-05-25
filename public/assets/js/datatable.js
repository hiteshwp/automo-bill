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
});