@extends('layouts.new')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="row">
                    <div class="col-4 d-flex justify-content-center">
                        <button class="btn btn-sm btn-primary"><i class="ri-printer-line" style="font-size: 16px;"></i> Pronto
                            Kontrate</button>
                    </div>
                    <div class="col-4 d-flex justify-content-center">
                        <button class="btn btn-sm btn-primary"><i class="ri-printer-line" style="font-size: 16px;"></i>
                            Pronto Projekt</button>
                    </div>
                    <div class="col-4 d-flex justify-content-center">
                        <button class="btn btn-sm btn-primary"><i class="ri-printer-line" style="font-size: 16px;"></i>
                            Pronto Oferte</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">Lista e produkteve me porosi</h5>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            + Shto produkt me porosi
                        </button>
                        {{-- @include('assetmanagement::assets_list.create') --}}
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
                                <th>{{ _lang('Dokumenti') }}</th>
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
        <div class="col-12">
            <span>Komente te tjera</span><br>
            <textarea name="comment" class="form-control" cols="30" rows="3"></textarea>
        </div>
    </div>


    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">Lista e produkteve te gatshme</h5>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            + Shto produkt
                        </button>
                        {{-- @include('assetmanagement::assets_list.create') --}}
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
                                <th>{{ _lang('Sasia') }}</th>
                            </tr>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Historiku i komenteve</h4>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-soft-primary btn-sm">
                            View All
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div data-simplebar class="mx-n3 px-3" style="height: 375px;">
                        <div class="vstack gap-3">
                            <div class="d-flex gap-3">
                                <img src="{{ asset('assets/images/users/avatar-3.jpg') }}" alt=""
                                    class="avatar-sm rounded flex-shrink-0">
                                <div class="flex-shrink-1">
                                    <h6 class="mb-2">Diana Kohler <span class="text-muted">Has commented</span></h6>
                                    <p class="text-muted mb-0">" Really well-written and informative. The emotional
                                        connection strategy is something I’ll be testing out more! "</p>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <img src="{{ asset('assets/images/users/avatar-5.jpg') }}" alt=""
                                    class="avatar-sm rounded flex-shrink-0">
                                <div class="flex-shrink-1">
                                    <h6 class="mb-2">Tonya Noble <span class="text-muted">Has commented</span></h6>
                                    <p class="text-muted mb-0">" Incredibly helpful tips, especially about adding a call to
                                        action. I’ve been missing that step and will implement it in my next post! "</p>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <img src="{{ asset('assets/images/users/avatar-6.jpg') }}" alt=""
                                    class="avatar-sm rounded flex-shrink-0">
                                <div class="flex-shrink-1">
                                    <h6 class="mb-2">Donald Palmer <span class="text-muted">Has commented</span></h6>
                                    <p class="text-muted mb-0">" Fantastic read! The power of visuals and trends really
                                        stood out to me. Thanks for sharing these useful insights! "</p>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <img src="{{ asset('assets/images/users/avatar-7.jpg') }}" alt=""
                                    class="avatar-sm rounded flex-shrink-0">
                                <div class="flex-shrink-1">
                                    <h6 class="mb-2">Joseph Parker <span class="text-muted">Has commented</span></h6>
                                    <p class="text-muted mb-0">" Great post! Simple yet powerful tips that I can start using
                                        immediately. Thanks for sharing your expertise! "</p>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <img src="{{ asset('assets/images/users/avatar-9.jpg') }}" alt=""
                                    class="avatar-sm rounded flex-shrink-0">
                                <div class="flex-shrink-1">
                                    <h6 class="mb-2">Timothy Smith <span class="text-muted">Has commented</span></h6>
                                    <p class="text-muted mb-0">" Wow, this has opened my eyes to a new perspective on
                                        creating content. Emotional triggers—such a smart way to engage users! "</p>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <img src="{{ asset('assets/images/users/avatar-10.jpg') }}" alt=""
                                    class="avatar-sm rounded flex-shrink-0">
                                <div class="flex-shrink-1">
                                    <h6 class="mb-2">Alexis Clarke <span class="text-muted">Has commented</span></h6>
                                    <p class="text-muted mb-0">" Fantastic read! The power of visuals and trends really
                                        stood out to me. Thanks for sharing these useful insights! "</p>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <img src="{{ asset('assets/images/users/avatar-2.jpg') }}" alt=""
                                    class="avatar-sm rounded flex-shrink-0">
                                <div class="flex-shrink-1">
                                    <h6 class="mb-2">Thomas Taylor <span class="text-muted">Has commented</span></h6>
                                    <p class="text-muted mb-0">" Loved the section on visual storytelling. It’s true that
                                        images speak louder on social media platforms. More visuals in my next posts for
                                        sure! "</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
