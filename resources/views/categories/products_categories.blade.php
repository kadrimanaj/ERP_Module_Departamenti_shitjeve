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
                <h4 class="mb-sm-0">Kategorite</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Kategorite Produkteve</li>
                    </ol>
                </div> 
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                        <div class="col-3">
                            <h5 class="card-title mb-0">Lista e Kategorive te produkteve</h5>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModalgrid">
                                + Shto Kategori
                            </button>
                        </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="model-datatables" class="table table-bordered nowrap table-striped align-middle model-datatables" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>
                                    <center>
                                        Emri Kategorise
                                    </center>
                                </th>
                                <th>
                                    <center>
                                        Kategoria Prind
                                    </center>
                                </th>
                                <th>
                                    <center>
                                        Kategoria Hapsires
                                    </center>
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

    {{-- crate modal --}}
    <div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalgridLabel">Shto Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('departamentishitjes.models.products.category.store') }}" method="POST">
                        @csrf
                            <div class="row g-3">
                                <div class="col-xxl-12">
                                    <label class="form-label">Emri Kategorisë</label>
                                    <input type="text" class="form-control" name="product_category_name" placeholder="Emri i Kategorisë" required>
                                </div>

                                <div class="col-xxl-12">
                                    <label class="form-label">Kategori Prind (Opsionale)</label>
                                    <select class="form-select select2" name="parent_id" data-placeholder="Zgjidh kategorinë prind">
                                        <option value="">—</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->product_category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xxl-12">
                                    <label class="form-label">Hapsira (Opsionale)</label>
                                    <select class="form-select select2" name="hapsira_id" data-placeholder="Zgjidh hapsirën">
                                        <option value="">—</option>
                                        @foreach($hapsirat as $hapsira)
                                            <option value="{{ $hapsira->id }}">{{ $hapsira->hapsira_category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-success">Ruaj</button>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- edit modal --}}
<div class="modal fade" id="staticBackdropedit" tabindex="-1" aria-labelledby="staticBackdropeditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('departamentishitjes.models.products.category.update') }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropeditLabel">Edito Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_category_id">

                    <div class="mb-3">
                        <label for="edit_category_name" class="form-label">Emri Kategorisë</label>
                        <input type="text" class="form-control" name="product_category_name" id="edit_category_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_parent_id" class="form-label">Kategoria Prind</label>
                        <select class="form-select" name="parent_id" id="edit_parent_id">
                            <option value="">Zgjidh</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->product_category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_hapsira_id" class="form-label">Hapsira</label>
                        <select class="form-select" name="hapsira_id" id="edit_hapsira_id">
                            <option value="">Zgjidh</option>
                            @foreach($hapsirat as $hapsira)
                                <option value="{{ $hapsira->id }}">{{ $hapsira->hapsira_category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ruaj Ndryshimet</button>
                </div>
            </form>
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

<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dropzone-min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            width: '100%',
            dropdownParent: $('#exampleModalgrid') // attach to modal
        });
    });
</script>

<script>
    $(document).on('click', '.edit-btn', function () {
        let id = $(this).data('id');
        let name = $(this).data('name');
        let parentId = $(this).data('parent-id');
        let hapsiraId = $(this).data('hapsira-id');

        $('#edit_category_id').val(id);
        $('#edit_category_name').val(name);
        $('#edit_parent_id').val(parentId);
        $('#edit_hapsira_id').val(hapsiraId);
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
                    url: "{{ route('models.products.categories.list') }}",
                    data: function (d) {
                        d.client_name = $('#search-client').val();
                        d.arkitekt_name = $('#search-architect').val();
                        d.project_status = $('#search-status').val();
                        d.status = selectedStatus;
                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'product_category_name', product_category_name: 'name', orderable: false },
                    { data: 'parent_id', name: 'parent_id', orderable: false },
                    { data: 'hapsira_id', name: 'hapsira_id', orderable: false },
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

@endsection
@endsection