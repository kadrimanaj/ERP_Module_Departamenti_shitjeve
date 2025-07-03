@extends('layouts.new')

@section('content')



    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <a href="{{ route('departamentishitjes.arkitekti.statistic') }}">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <div class="avatar-sm">
                            <div
                                class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                                <i data-feather="users" class="icon-dual-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15">17.6k</h5>
                            <p class="mb-0 text-muted">Ofeerta ne total</p>
                        </div>
                    </div>
                </a>
            </div>
        </div><!--end col-->
        <div class="col-lg-4">
            <div class="card">
                <a href="{{ route('departamentishitjes.arkitekti.statistic') }}">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <div class="avatar-sm">
                            <div
                                class="avatar-title border bg-warning-subtle border-warning border-opacity-25 rounded-2 fs-17">
                                <i data-feather="file-text" class="icon-dual-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15">149</h5>
                            <p class="mb-0 text-muted">Oferta te aprovuara</p>
                        </div>
                    </div>
                </a>

            </div>
        </div><!--end col-->
        <div class="col-lg-4">
            <div class="card">
                <a href="{{ route('departamentishitjes.arkitekti.statistic') }}">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <div class="avatar-sm">
                            <div
                                class="avatar-title border bg-danger-subtle border-danger border-opacity-25 rounded-2 fs-17">
                                <i data-feather="heart" class="icon-dual-danger"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15">24</h5>
                            <p class="mb-0 text-muted">Oferta te rishikuara</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{-- <div class="row"> --}}
                    <div class="col-3">
                        <h5 class="card-title mb-0">Lista e Ofertave</h5>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-sm btn-outline-success">Te Aprovuara</button>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-sm btn-outline-warning">Te Rishikuara</button>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-sm btn-outline-primary">Te Gjitha</button>
                    </div>
                    {{-- </div> --}}
                </div>
                <div class="card-body">
                    <table id="model-datatables"
                        class="table table-bordered nowrap table-striped align-middle model-datatables" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ _lang('ID') }}</th>
                                <th>{{ _lang('Emri Ofertes') }}</th>
                                <th>{{ _lang('Pershkrimi') }}</th>
                                <th>{{ _lang('Data Krijimit') }}</th>
                                <th>{{ _lang('Status') }}</th>
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




    <script>
        var col = ["1", "2", "3", "4", "5"];
        var fil = ["1"];

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
                        url: "{{ route('assets.lists') }}",
                        data: function(d) {
                            d.name = $('#search-client').val();
                            d.status = $('#search-status').val();
                            d.date = $('#search-date').val();
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
                            data: 'serial_number',
                            name: 'serial_number',
                            orderable: false
                        },
                        {
                            data: 'name',
                            name: 'name',
                            orderable: false
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6 d-flex justify-content-end"B>>' +
                        '<"row"<"col-sm-12"f>>' + // Add search input below buttons
                        'rt' +
                        '<"row"<"col-sm-6"i><"col-sm-6 d-flex justify-content-end"p>>',
                    buttons: [{
                            extend: 'copy',
                            text: 'Copy',
                            className: 'btn btn-primary'
                        },
                        {
                            extend: 'csv',
                            text: 'CSV',
                            className: 'btn btn-success'
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            className: 'btn btn-warning'
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            className: 'btn btn-danger'
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            className: 'btn btn-info'
                        }
                    ],
                    language: {
                        lengthMenu: "Show _MENU_ entries",
                        search: "",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        paginate: {
                            previous: "Prev",
                            next: "Next"
                        }
                    },
                    autoWidth: false,
                    paging: true,
                    ordering: true,
                    searching: true,
                    initComplete: function() {
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
@endsection
@endsection
