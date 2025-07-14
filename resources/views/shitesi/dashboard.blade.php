@extends('layouts.new')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <style>
        .disabled-btn {
            opacity: 0.6;
        }
        table.dataTable tbody tr {
            vertical-align: middle;
        }
        table.dataTable tbody td {
            vertical-align: middle !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/libs/dropzone/dropzone.css') }}" type="text/css" />
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div> 
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body d-flex gap-3 align-items-center">
                <div class="avatar-sm">
                    <div class="avatar-title border bg-primary-subtle border-primary border-opacity-25 rounded-2 fs-17">
                        <i data-feather="file-text" class="icon-dual-primary"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h5 class="fs-15">{{ $projects_total }}</h5>
                    <p class="mb-0 text-muted">Ofertat e mia</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body d-flex gap-3 align-items-center">
                <div class="avatar-sm">
                    <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                        <i data-feather="file-text" class="icon-dual-success"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h5 class="fs-15">{{ getStatistics(2) }}</h5>
                    <p class="mb-0 text-muted">Ofertat e Konfirmuara</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body d-flex gap-3 align-items-center">
                <div class="avatar-sm">
                    <div class="avatar-title border bg-warning-subtle border-warning border-opacity-25 rounded-2 fs-17">
                        <i data-feather="file-text" class="icon-dual-warning"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h5 class="fs-15">{{ getStatistics(0)  }}</h5>
                    <p class="mb-0 text-muted">Ofertat Pezull</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body d-flex gap-3 align-items-center">
                <div class="avatar-sm">
                    <div class="avatar-title border bg-danger-subtle border-danger border-opacity-25 rounded-2 fs-17">
                        <i data-feather="file-text" class="icon-dual-danger"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h5 class="fs-15">{{ getStatistics(3)  }}</h5>
                    <p class="mb-0 text-muted">Ofertat e Refuzuara</p>
                </div>
            </div>
        </div>
    </div>
</div>
   


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                    <div class="col-3">
                        <h5 class="card-title mb-0">Lista e Kerkesave</h5>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalgrid">
                            + Shto Kerkese
                        </button>
                    </div>
            </div>
            <div class="card-body">
                <div class="row">
                        <div class="col-3 input-group mb-3" style="max-width: 300px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="ri-search-line"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Kërko Klient..." id="search-client">
                        </div>
                        <div class="col-3 input-group mb-3" style="max-width: 300px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="ri-search-line"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" placeholder="Kërko Arkitekt..." id="search-architect">
                        </div>
                        <div class="col-3 input-group mb-3" style="max-width: 300px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="ri-search-line"></i>
                            </span>
                            <select class="form-select border-start-0" id="search-status">
                                <option value="" disabled selected>Kërko Status...</option>
                                <option value="ne pritje">Ne Pritje</option>
                                <option value="ne perpunim">Ne Perpunim</option>
                                <option value="konfirmuar">Konfirmuar</option>
                                <option value="refuzuar">Refuzuar</option>
                            </select>
                        </div>
                        
                        <div class="col-3 mb-3">
                            <button type="button" class="btn btn-sm btn-outline-primary" id="refresh" style="margin-left: 10px;">
                                <i class="ri-brush-2-fill" style="font-size: 15px"></i>
                            </button>
                        </div>
                </div>
                
                
                <div class="table-responsive">
                <table id="model-datatables" class="table table-bordered nowrap table-striped align-middle model-datatables" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Emri Kerkeses</th>
                            <th>Klienti</th>
                            <th>Arkitekti</th>
                            <th>Pershkrimi</th>
                            <th>Data Krijimit</th>
                            <th>
                                <div class="row d-flex justify-content-between align-items-center">
                                        <div class="col-6">
                                            Status
                                        </div>
                                        <div class="col-6">
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="refresh" style="margin-left: 10px;">
                                                <i class="ri-brush-2-fill" style="font-size: 15px"></i>
                                            </button>
                                        </div>
                                    </div>
                            </th>
                            <th>
                                <center>
                                    Actions
                                </center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                </div>

            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">Lista e Klienteve</h5>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalgrid3">+ Shto Klient</button>
                    </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table id="model-datatables2" class="table table-bordered nowrap table-striped align-middle model-datatables2" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company</th>
                            <th>Contact Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Data Krijimit</th>
                            <th>
                                <center>
                                    Actions
                                </center>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</div>

@include('departamentishitjes::components.modal-add-project')
@include('departamentishitjes::components.modal-edit-project')

@include('departamentishitjes::components.modal-add-client')
@include('departamentishitjes::components.modal-edit-client')

@include('departamentishitjes::shitesi.modal-confirm-shitesi')



@section('js-script')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>


<script>
    $(document).ready(function() {
        $('#project_architect').select2({
            dropdownParent: $('#exampleModalgrid'), // Optional: so it works inside modal
            width: '100%',
            placeholder: "Zgjidh Arkitektin"
        });
    });
    $(document).ready(function () {
        $('#clientSelect').select2({
            dropdownParent: $('#exampleModalgrid'), // Optional: so it works inside modal
            placeholder: 'Zgjidh Klientin',
            allowClear: true,
            width: '100%' // VERY IMPORTANT when used with Bootstrap
        });
    });
</script>

<script>
   $(document).on('click', '.confirm-project-btn', function () {
        const projectId = $(this).data('id'); // Get the project ID
        const form = $('#confirmProjectForm'); // Get the form
        const action = form.attr('action').replace('__ID__', projectId); // Replace __ID__ with the actual project ID
        form.attr('action', action); // Update the form action attribute with the correct URL
        
        // Set the project ID in the modal
        $('#selected-project-id').text(projectId);

        // Show the modal
        $('#confirmProjectModal').modal('show');
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize select2 on page load
        // $('.js-example-basic-single').select2({
        //     dropdownParent: $('#staticBackdropedit') // ensure it works inside modal
        // });

        // Handle click on edit button
        $(document).on("click", ".edit-btn", function () {
            let item = $(this).data("item"); 
            let assetId = $(this).data('id'); 
            let route = @json(route('departamentishitjes.shitesi.update_project', ['id' => 'ID_PLACEHOLDER']));
            let formAction = route.replace('ID_PLACEHOLDER', assetId);

            if (item) {
                $("#edit_project_name").val(item.project_name);
                $("#edit_project_description").val(item.project_description);
                    let rawDate = item.client_limit_date;
                    let formattedDate = rawDate ? rawDate.substring(0, 10) : "";
                    $("#edit_client_limit_date").val(formattedDate);
                    $("#edit_rruga").val(item.rruga);
                    // console.log(item.rruga);
                    $("#edit_qarku").val(item.qarku);
                    $("#edit_bashkia").val(item.bashkia);
                    $("#edit_tipologjia_objektit").val(item.tipologjia_objektit);
                    $("#edit_kate").val(item.kate);
                    $("#edit_lift").val(item.lift);
                    $("#edit_orari_pritjes").val(item.orari_pritjes);
                    $("#edit_address_comment").val(item.address_comment);
                $("#edit_project_client").val(item.project_client).trigger("change");
                $("#edit_project_architect").val(item.project_architect).trigger("change");
            }

            // Update form action
            $("#editForm").attr("action", formAction);
        });

        // Re-initialize select2 every time modal is shown (important for BS modals)
        $('#staticBackdropedit').on('shown.bs.modal', function () {
            $('#edit_project_client, #edit_project_architect', '#edit_priority').select2({
                dropdownParent: $('#staticBackdropedit')
            });
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize select2 in modal
        $('.select2').select2({
            dropdownParent: $('#editPartnerModal')
        });

        // Handle click on edit button
        $(document).on("click", ".edit-btn", function () {
            let item = $(this).data("item");  // Get item data from the button
            let partnerId = $(this).data('id');  // Get partner ID

            // Update form action dynamically (for PUT request)
            let route = "{{ route('partners.update', ['partner' => 'ID_PLACEHOLDER']) }}";
            let formAction = route.replace('ID_PLACEHOLDER', partnerId);
            $('#editPartnerForm').attr('action', formAction);  // Set the action URL

            if (item) {
                // Update the form fields with data from the item
                $("select[name='profile_type']").val(item.type).trigger("change");
                $("select[name='partner_type']").val(item.contact_type).trigger("change");
                $("input[name='company_name']").val(item.company_name);
                $("input[name='nipt']").val(item.nipt);
                $("input[name='contact_name']").val(item.contact_name);
                $("input[name='contact_email']").val(item.contact_email);
                $("input[name='contact_phone']").val(item.contact_phone);

                $("select[name='group_id']").val(item.group_id).trigger("change");
                $("select[name='country']").val(item.country).trigger("change");

                $("input[name='city']").val(item.city);
                $("input[name='state']").val(item.state);
                $("input[name='zip']").val(item.zip);
                $("textarea[name='address']").val(item.address);
                $("textarea[name='remarks']").val(item.remarks);
            }
        });

        // Re-initialize select2 every time modal is shown
        $('#editPartnerModal').on('shown.bs.modal', function () {
            // Re-initialize select2 after the form fields have been populated
            $('.select2').each(function () {
                $(this).select2({
                    dropdownParent: $('#editPartnerModal')
                });
            });
        });
    });
</script>


<script>
    var col = ["1","2","3","4","5"];
    var fil = ["1"];
    let selectedStatus = '';

    $(document).on('click', '.filter-status', function () {
        selectedStatus = $(this).data('project_status');
        $('#model-datatables').DataTable().ajax.reload();
    });

    // Refresh button to reset filters and reload DataTabler
    $(document).on('click', '#refresh', function () {
        // Reset all filters
        $('#search-client').val('');
        $('#search-architect').val('');
        $('#search-status').val('').trigger('change'); // trigger change if using select2 or similar
        selectedStatus = null;

        // Reload the DataTable
        $('#model-datatables').DataTable().ajax.reload();
    });


    $(function() {
        $(document).ready(function() {
            initializeDataTable(null, null);
        });

        function initializeDataTable(itemId, itemName) {
            if ($.fn.DataTable.isDataTable('.model-datatables')) {
                $('.model-datatables').DataTable().destroy();
            }

            $('.model-datatables').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route('shitesi.list') }}",
                    data: function (d) {
                        d.client_name = $('#search-client').val();
                        d.arkitekt_name = $('#search-architect').val();
                        d.project_status = $('#search-status').val();
                        d.status = selectedStatus;
                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'project_name', name: 'project_name', orderable: false },
                    { data: 'client_name', name: 'client_name', orderable: false },
                    { data: 'arkitekt_name', name: 'arkitekt_name', orderable: false },
                    { data: 'project_description', name: 'project_description', orderable: false },
                    { data: 'project_start_date', name: 'project_start_date', orderable: false },
                    { data: 'project_status', name: 'project_status', orderable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                dom: 
                    '<"row mb-3"' +
                        '<"col-sm-6 mt-2"l>' + 
                        '<"col-sm-6 d-flex justify-content-end align-items-center gap-2"' +
                            '<"dt-buttons mt-2"f>' +
                            '<"dt-search"B>' +
                        '>' +
                    '>' +
                    'rt' +
                    '<"row"' +
                        '<"col-sm-6"i>' + 
                        '<"col-sm-6 d-flex justify-content-end"p>' +
                    '>',

                buttons: [
                    {
                    extend: 'excel',
                    text: '<i class="ri-file-excel-2-line"></i> Export Excel',
                    className: 'btn btn-success btn-sm'
                },
                {
                    extend: 'pdf',
                    text: '<i class="ri-file-pdf-line"></i> Export PDF',
                    className: 'btn btn-danger btn-sm'
                },
                {
                    extend: 'print',
                    text: '<i class="ri-printer-line"></i> Print',
                    className: 'btn btn-primary btn-sm'
                }
                ],
                language: {
                    lengthMenu: " _MENU_ ", 
                    search: "",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    }
                },
                info: true ,
                autoWidth: false,
                paging: true,
                ordering: true,
                searching: true,
                initComplete: function () {
                    $('.model-datatables').removeClass('dataTable');
                }
            });
        }

        // Custom search input to filter table
        $('#search-client, #search-architect, #search-status').on('keyup change', function() {
            $('.model-datatables').DataTable().ajax.reload();
        });
        $(document).ready(function() {
        // Select the search input
        $('input[type="search"]').each(function() {
                var icon = '<i class="ri-search-2-line"></i>';

                // Add a wrapper around the input field to position the icon
                $(this).wrap('<div class="input-wrapper" style="position: relative;"></div>');

                // Add the icon inside the input-wrapper and position it absolutely
                $(this).before(icon);

                // Adjust padding of the input field to make space for the icon
                $(this).css('padding-left', '30px');
                
                // Position the icon inside the input field
                $(this).prev('i').css({
                    position: 'absolute',
                    left: '10px',
                    top: '50%',
                    transform: 'translateY(-50%)',
                    color: '#ccc'
                });
            });
        });


        $.fn.dataTable.ext.errMode = 'none';
    });

    $(document).on('click', '.filter-status', function () {
        var status = $(this).data('status'); // Get the status from the button
        var table = $('#model-datatables').DataTable(); // Use your actual table ID

        // Adjust this number to match the index of your 'project_status' column
        var columnIndex = 3;

        table.column(columnIndex).search(status).draw();
        console.log(status);
    });


</script>



<script>
    var col = ["1","2","3","4","5"];
    var fil = ["1"];

    $(function() {
        $(document).ready(function() {
            initializeDataTable(null, null);
        });

        function initializeDataTable(itemId, itemName) {
            if ($.fn.DataTable.isDataTable('.model-datatables2')) {
                $('.model-datatables2').DataTable().destroy();
            }

            $('.model-datatables2').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route('shitesi.clients') }}",
                    data: function(d) {
                        d.name = $('#search-client').val();
                        d.status = $('#search-status').val();
                        d.date = $('#search-date').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'company_name', name: 'company_name', orderable: false },
                    { data: 'contact_name', name: 'contact_name', orderable: false },
                    { data: 'contact_phone', name: 'contact_phone', orderable: false },
                    { data: 'contact_email', name: 'contact_email', orderable: false },
                    { data: 'city', name: 'city', orderable: false },
                    { data: 'created_at', name: 'created_at', orderable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                dom: 
                    '<"row mb-3"<"col-sm-6"l><"col-sm-6 d-flex justify-content-end"B>>' +
                    '<"row"<"col-sm-12 d-flex justify-content-end"f>>' +  // Add search input below buttons
                    'rt' +
                    '<"row"<"col-sm-6"i><"col-sm-6 d-flex justify-content-end"p>>',
                buttons: [
                    { extend: 'copy', text: 'Copy', className: 'btn btn-primary' },
                    { extend: 'csv', text: 'CSV', className: 'btn btn-success' },
                    { extend: 'excel', text: 'Excel', className: 'btn btn-warning' },
                    { extend: 'pdf', text: 'PDF', className: 'btn btn-danger' },
                    { extend: 'print', text: 'Print', className: 'btn btn-info' }
                ],
                language: {
                    lengthMenu: " _MENU_ ", 
                    search: "",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    }
                },
                info: true ,
                autoWidth: false,
                paging: true,
                ordering: true,
                searching: true,
                initComplete: function () {
                    $('.model-datatables').removeClass('dataTable');
                }
            });
        }

        // Custom search input to filter table
        $('#search-client, #search-status, #search-date').on('keyup change', function() {
            $('.model-datatables').DataTable().ajax.reload();
        });
        $(document).ready(function() {
        // Select the search input
        $('input[type="search"]').each(function() {
                var icon = '<i class="ri-search-2-line"></i>';

                // Add a wrapper around the input field to position the icon
                $(this).wrap('<div class="input-wrapper" style="position: relative;"></div>');

                // Add the icon inside the input-wrapper and position it absolutely
                $(this).before(icon);

                // Adjust padding of the input field to make space for the icon
                $(this).css('padding-left', '30px');
                
                // Position the icon inside the input field
                $(this).prev('i').css({
                    position: 'absolute',
                    left: '10px',
                    top: '50%',
                    transform: 'translateY(-50%)',
                    color: '#ccc'
                });
            });
        });


        $.fn.dataTable.ext.errMode = 'none';
    });

</script>


<script>
    $(document).on('click', '.delete-btn', function () {
        let clientId = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/clients/' + clientId, // Laravel resource route
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' // CSRF protection
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Client has been deleted.",
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // Refresh the page
                        });
                    },
                    error: function (xhr) {
                        Swal.fire("Error!", "Something went wrong. Please try again.", "error");
                    }
                });
            }
        });
    });
</script>


<script>
    $(document).on('click', '.delete-btn-project', function () {
        let projectID = $(this).data('id');  // Get the project ID from the button

        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, cancell it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Dynamically generate the URL using JavaScript
                let deleteUrl = '{{ route('projects.destroy', ['id' => 'PROJECT_ID_PLACEHOLDER']) }}';
                deleteUrl = deleteUrl.replace('PROJECT_ID_PLACEHOLDER', projectID); // Replace the placeholder with the actual projectID

                $.ajax({
                    url: deleteUrl,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}'  // CSRF protection
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message, // Show the success message returned from controller
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();  // Refresh the page after successful deletion
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire("Error!", "Something went wrong. Please try again.", "error");
                    }
                });
            }
        });
    });
</script>

@endsection
@endsection