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
            url: baseUrl + '/garage-owners/removedetails/'+userId,
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

    
});