$(document).ready(function() {    
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
        console.log('Button clicked'); // Debug
        const userId = $(this).data('id');
        console.log(userId);
        $.ajax({
            url: `/garage-owner/${userId}/edit`,
            type: 'GET',
            success: function (data) {
                // Populate the form fields
                $('#sidebarEditGarageOwner input[name="name"]').val(data.name);
                $('#sidebarEditGarageOwner input[name="businessname"]').val(data.businessname);
                $('#sidebarEditGarageOwner input[name="email"]').val(data.email);
                $('#sidebarEditGarageOwner input[name="mobilenumber"]').val(data.mobilenumber);
                $('#sidebarEditGarageOwner select[name="country_id"]').val(data.country_id);
                $('#sidebarEditGarageOwner select[name="state_id"]').val(data.state_id);
                $('#sidebarEditGarageOwner select[name="city_id"]').val(data.city_id);
                $('#sidebarEditGarageOwner textarea[name="address"]').val(data.address);
    
                // Update the title
                $('#offcanvasRightLabel span').text(`(${data.name})`);
    
                // Open the offcanvas
                var sidebar = new bootstrap.Offcanvas(document.getElementById('sidebarEditGarageOwner'));
                sidebar.show();
            },
            error: function () {
                alert('Failed to load user data.');
            }
        });
    });

});

