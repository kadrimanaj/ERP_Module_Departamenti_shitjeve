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


        .blink {
            padding: 5px 15px;
            border-radius: 10px;
            background-color: red;
            color: white;
            font-size: 10px;
            font-weight: bold;
            animation: pulseBorder 1.5s infinite;
            display: inline-block;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }

        @keyframes pulseBorder {
            0% {
                box-shadow: 0 0 0 0 #ff5757;
            }

            70% {
                box-shadow: 0 0 0 20px rgba(255, 193, 7, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
            }
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
            <div class="card filter-status" data-project_status="2">
                <div class="card-body d-flex gap-3 align-items-center">
                    <div class="avatar-sm">
                        <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                            <i data-feather="file-text" class="icon-dual-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fs-15">{{ getStatistics(2) }}</h5>
                        <p class="mb-0 text-muted">Produktet e Konfirmuara</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card filter-status" data-project_status="3">
                <div class="card-body d-flex gap-3 align-items-center">
                    <div class="avatar-sm">
                        <div class="avatar-title border bg-danger-subtle border-danger border-opacity-25 rounded-2 fs-17">
                            <i data-feather="file-text" class="icon-dual-danger"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fs-15">{{ getStatistics(3) }}</h5>
                        <p class="mb-0 text-muted">Produktet e Refuzuara</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card filter-status" data-project_status="0">
                <div class="card-body d-flex gap-3 align-items-center">
                    <div class="avatar-sm">
                        <div class="avatar-title border bg-warning-subtle border-warning border-opacity-25 rounded-2 fs-17">
                            <i data-feather="file-text" class="icon-dual-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fs-15">{{ getStatistics(0) }}</h5>
                        <p class="mb-0 text-muted">Produktet Pezull</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card filter-status" data-project_status="4">
                <div class="card-body d-flex gap-3 align-items-center">
                    <div class="avatar-sm">
                        <div class="avatar-title border bg-danger-subtle border-danger border-opacity-25 rounded-2 fs-17">
                            <i data-feather="file-text" class="icon-dual-danger"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fs-15">{{ getStatistics(4) }}</h5>
                        <p class="mb-0 text-muted">Produktet e refuzuara nga kryeinxhinieri</p>
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
                        <h5 class="card-title mb-0">Lista e Ofertave</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="model-datatables"
                            class="table table-bordered nowrap table-striped align-middle model-datatables"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ _lang('ID') }}</th>
                                    <th>{{ _lang('Foto') }}</th>
                                    <th>{{ _lang('Emri Produktit') }}</th>
                                    <th>{{ _lang('Projekti/Prioriteti') }}</th>
                                    <th>{{ _lang('Permasat') }}</th>
                                    <th>{{ _lang('Ngjyra') }}</th>
                                    <th>
                                        <center>{{ _lang('Pershkrimi') }}</center>
                                    </th>
                                    <th>{{ _lang('Sasia') }}</th>
                                    <th>{{ _lang('Total/Njesi') }}</th>
                                    <th>
                                        <div class="row d-flex justify-content-between align-items-center">
                                            <div class="col-6">
                                                {{ _lang('Status') }}
                                            </div>
                                            <div class="col-6">
                                                <button type="button" class="btn btn-sm btn-outline-primary" id="refresh"
                                                    style="margin-left: 10px;">
                                                    <i class="ri-brush-2-fill" style="font-size: 15px"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </th>
                                    <th>{{ _lang('Arsyeja Refuzimit') }}</th>
                                    <th>{{ _lang('Afati Dorezimit') }}</th>
                                    <th>
                                        <center>{{ _lang('Actions') }}</center>
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
    $(document).on('click', '.popover-trigger, .popover-trigger2', function () {
        $(this).popover({
            html: true,
            trigger: 'focus',
            container: 'body'
        }).popover('toggle');
    });
</script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".clickable-image").forEach(function(img) {
                img.addEventListener("click", function() {
                    const src = this.getAttribute("data-src");
                    document.getElementById("modalImage").setAttribute("src", src);
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.confirm-project-btn', function() {
            const projectId = $(this).data('id'); // Get the project ID
            const form = $('#confirmProjectForm'); // Get the form
            const action = form.attr('action').replace('__ID__',
            projectId); // Replace __ID__ with the actual project ID
            form.attr('action', action); // Update the form action attribute with the correct URL

            // Set the project ID in the modal
            $('#selected-project-id').text(projectId);

            // Show the modal
            $('#confirmProjectModal').modal('show');
        });
    </script>

    {{-- <script>
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
                    url: "{{ route('kostoisti.projektet.list_dashboard') }}",
                    data: function(d) {
                        d.name = $('#search-client').val();
                        d.status = $('#search-status').val();
                        d.date = $('#search-date').val();
                        d.project_name = $('#search-project-name').val();
                        d.status = selectedStatus;

                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'project_name', name: 'project_name', orderable: false },
                    { data: 'client_name', name: 'client_name', orderable: false },
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


</script> --}}

    <script>
        var col = ["1", "2", "3", "4", "5"];
        var fil = ["1"];
        let selectedStatus = '';

        $(document).on('click', '.filter-status', function() {
            selectedStatus = $(this).data('project_status');
            $('#model-datatables').DataTable().ajax.reload();
        });

        // Refresh button to reset filters and reload DataTabler
        $(document).on('click', '#refresh', function() {
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
                        url: "{{ route('kostoisti.projektet.list_dashboard') }}",
                        data: function(d) {
                            d.name = $('#search-client').val();
                            d.status = $('#search-status').val();
                            d.date = $('#search-date').val();
                            d.status = selectedStatus;

                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            orderable: false
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: false
                        },
                        {
                            data: 'product_name',
                            name: 'product_name',
                            orderable: false
                        },
                        {
                            data: 'project',
                            name: 'project',
                            orderable: false
                        },
                        {
                            data: 'dimension',
                            name: 'dimension',
                            orderable: false
                        },
                        {
                            data: 'color',
                            name: 'color',
                            orderable: false
                        },
                        {
                            data: 'product_description',
                            name: 'product_description',
                            orderable: false
                        },
                        {
                            data: 'product_quantity',
                            name: 'product_quantity',
                            orderable: false
                        },
                        {
                            data: 'total_cost',
                            name: 'total_cost',
                            orderable: false
                        },
                        {
                            data: 'product_status',
                            name: 'product_status',
                            orderable: false
                        },
                        {
                            data: 'refuse_comment',
                            name: 'refuse_comment',
                            orderable: false
                        },
                        {
                            data: 'client_limit_date',
                            name: 'client_limit_date',
                            orderable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    dom: '<"row mb-3"' +
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

                    buttons: [{
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
                    info: true,
                    autoWidth: false,
                    paging: true,
                    ordering: true,
                    searching: true,
                    initComplete: function() {
                        $('.model-datatables').removeClass('dataTable');
                    }
                });
            }
        });
    </script>
@endsection
@endsection
