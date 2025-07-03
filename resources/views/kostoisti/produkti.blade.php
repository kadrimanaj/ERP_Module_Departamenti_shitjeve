@extends('layouts.new')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">Specifikime Teknike Per:</h5>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            + Krijo Preventiv
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="model-datatables"
                        class="table table-bordered nowrap table-striped align-middle model-datatables" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ _lang('ID') }}</th>
                                <th>{{ _lang('Emri Produktit') }}</th>
                                <th>{{ _lang('Pershkrimi') }}</th>
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


    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">Lista e skicave</h5>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#skiceModal">
                            + Shto skice
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="skiceModal" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="skiceModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="skiceModalLabel">Shto Skicë</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="mb-3">
                                                <label for="skiceName" class="form-label">Emri</label>
                                                <input type="text" class="form-control" id="skiceName" name="name"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="skiceDescription" class="form-label">Përshkrimi</label>
                                                <textarea class="form-control" id="skiceDescription" name="description" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="skiceFile" class="form-label">Ngarko Imazh</label>
                                                <input type="file" class="form-control" id="skiceFile" name="file"
                                                    accept="image/*" required>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Mbyll</button>
                                        <button type="submit" class="btn btn-primary">Ruaj ndryshimet</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <table id="model-datatables2"
                        class="table table-bordered nowrap table-striped align-middle model-datatables2" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{ _lang('ID') }}</th>
                                <th>{{ _lang('Produkti') }}</th>
                                <th>{{ _lang('Pershkrimi') }}</th>
                                <th>{{ _lang('Dokumenti') }}</th>
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
        <div class="col-12">
            <span>Komente te tjera</span><br>
            <textarea name="comment" class="form-control" cols="30" rows="3"></textarea>
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
        });
    </script>


    <script>
        var col = ["1", "2", "3", "4", "5"];
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
                            data: 'name',
                            name: 'name',
                            orderable: false
                        },
                        {
                            data: 'serial_number',
                            name: 'serial_number',
                            orderable: false
                        },
                        {
                            data: 'image',
                            name: 'image',
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
                        $('.model-datatables2').removeClass('dataTable');
                    }
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@endsection
