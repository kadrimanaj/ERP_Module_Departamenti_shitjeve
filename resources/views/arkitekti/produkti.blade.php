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

        /*
                .swal2-confirm{
                    background-color: green !important;
                } */
    </style>
    <link rel="stylesheet" href="{{ asset('assets/libs/dropzone/dropzone.css') }}" type="text/css" />
@endsection
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4><a href="{{ route('departamentishitjes.arkitekti.projekti', $product->product_project_id) }}"><i
                            class="ri-arrow-left-fill"></i> Back</a></h4>
                <h4 class="mb-sm-0">Project Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('departamentishitjes.arkitekti.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('departamentishitjes.arkitekti.projekti', $product->product_project_id) }}">Project
                                Details</a></li>
                        <li class="breadcrumb-item active">Product Details</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-12">


            <div class="card page-title-box d-sm-flex  justify-content-between p-3" style="background-color: #fef4e4;">
                <div class="row mb-1">
                    <div class="col-9">
                        <div class="row align-items-center g-3">
                            <div class="col-md-auto">
                                <div class="avatar-md me-3">
                                    <div class="avatar-title bg-white rounded-circle d-flex align-items-center justify-content-center overflow-hidden"
                                        style="width: 70px; height: 70px; margin-top: 10px; margin-left: 20px">
                                        @if ($image && file_exists(public_path($image->file_path)))
                                            <img src="{{ asset($image->file_path) }}" class="img-thumbnail clickable-image"
                                                alt="Image" data-bs-toggle="modal" data-bs-target="#imageModal"
                                                data-src="{{ asset($image->file_path) }}"
                                                style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;" />
                                        @else
                                            <div class="d-flex justify-content-center align-items-center border rounded"
                                                style="width: 100%; height: 100%; background-color: #f8f9fa;">
                                                <i class="ri-image-line" style="font-size: 3rem; color: #adb5bd;"></i>
                                            </div>
                                        @endif
                                        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content bg-transparent border-0">
                                                    <div class="modal-body p-0 text-center">
                                                        <img id="modalImage" src="" alt="Enlarged image"
                                                            class="img-fluid rounded"
                                                            style="max-height: 80vh; object-fit: contain;" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md">
                                <div class="row">
                                    <div class="col-12">
                                        <h4 class="fw-bold mb-1">{{ $product->product_name }} -
                                            {{ $product->product_quantity }} cope</h4>
                                    </div>
                                    <div class="col-12">
                                        <div
                                            class="badge rounded-pill bg-{{ getStatusColor($product->product_status) }} fs-12">
                                            Status: {{ getStatusName($product->product_status) }} </div>
                                    </div>
                                    <div class="col-12">
                                        <i class="ri-paint-brush-fill"></i> Ngjyra: {{ $product->color }}<span
                                            class="fw-medium"></span>
                                    </div>
                                    <div class="col-12">
                                        <i class="ri-ruler-fill"></i> Permasat: {{ $product->dimension }}<span
                                            class="fw-medium"></span>
                                    </div>
                                    <div class="col-12">
                                        <i class="ri-text-block align-bottom"></i> Pershkrimi: <span
                                            class="fw-medium">{{ $product->product_description }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        @if ($project_products->count() > 1)
                            Lista e produkteve per: <a
                                href="{{ route('departamentishitjes.arkitekti.projekti', $product->product_project_id) }}">{{ getProjectName($product->product_project_id) }}</a>
                            <br>
                            <select class="form-select select2" id="product-select" style="width: 100%;">
                                <option value="" disabled selected>Zgjidh një produkt</option>
                                @foreach ($project_products as $project)
                                    <option value="{{ route('departamentishitjes.arkitekti.produkti', $project->id) }}"
                                        {{ $project->id == $id ? 'selected disabled' : '' }}>
                                        {{ $project->product_name }} / {{ getStatusName($project->product_status) }}
                                    </option>
                                @endforeach

                            </select>
                        @endif


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
                        <h5 class="card-title mb-0">Specifikime teknike per: {{ $product->product_name }}</h5>
                    </div>
                    <div>
                        @if ($product->product_confirmation != 1)
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                + Shto specifim teknik
                            </button>
                            <button type="button" class="btn btn-success btn-sm" id="confirmButton">
                                Konfirmo
                            </button>
                        @else
                            <button type="button" class="btn btn-success btn-sm">
                                Confirmed
                            </button>
                        @endif
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
                                    <th>{{ _lang('Emri Specifikimit') }}</th>
                                    <th>{{ _lang('Sasia') }}</th>
                                    <th>{{ _lang('Permasat') }}</th>
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
    </div>


    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-0">Lista e skicave</h5>
                    </div>
                    <div>
                        @if ($product->product_confirmation != 1)
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#skiceModal">
                                + Shto skice
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="model-datatables2"
                            class="table table-bordered nowrap table-striped align-middle model-datatables2"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ _lang('ID') }}</th>
                                    <th>{{ _lang('Dokumenti') }}</th>
                                    <th>{{ _lang('Emri') }}</th>
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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Historiku i komenteve</h4>
                </div>
                <div class="card-body">
                    <div data-simplebar class="mx-n3 px-3">
                        <div class="vstack gap-3">
                            @if ($comments_product->count())
                                @foreach ($comments_product as $comment)
                                    <div class="d-flex gap-3 mb-3">
                                        <div class="avatar-sm rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                            style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($comment->user_id ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="flex-shrink-1">
                                            <h6 class="mb-2">{{ $comment->user_id }} <span
                                                    class="text-muted">{{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y H:i') }}</span>
                                            </h6>
                                            <p class="text-muted mb-0">" {{ $comment->comment }}"</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">Ky produkt nuk ka komente te mepareshme.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <span>Komente te tjera</span><br>
            <form action="{{ route('departamentishitjes.comment.store', $id) }}" method="POST">
                @csrf

                <input type="hidden" name="comment_type" value="specifikime_teknike"> {{-- or change to any type you want --}}

                <div class="form-group mb-3">

                    <textarea name="comment" class="form-control" cols="30" rows="3" placeholder="Shkruaj një koment..."></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Ruaj Komentin</button>
                </div>
            </form>
        </div>
    </div>

    @include('departamentishitjes::arkitekti.modals.modal_add_elements')
    @include('departamentishitjes::arkitekti.modals.modal_add_skica')
    @include('departamentishitjes::arkitekti.modals.modal_edit_elements')
    @include('departamentishitjes::arkitekti.modals.modal_edit_skica')


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
        $(document).ready(function() {
            $('.select2').select2();

            $('#product-select').on('change', function() {
                var url = $(this).val();
                if (url) {
                    window.location.href = url;
                }
            });
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
        document.getElementById('confirmButton').addEventListener('click', function() {
            let productId = "{{ $id }}";

            Swal.fire({
                title: 'Konfirmo!',
                text: "Jeni i sigurt per konfirmimin e ketij produkti?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Po, konfirmo!',
                cancelButtonText: 'Anullo',
                cancelButtonText: "Cancel",
                reverseButtons: true // <-- this flips the buttons
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to the Laravel route
                    let url = "{{ route('product.arkitekti.confirm', ':id') }}".replace(':id', productId);

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Konfirmuar!', data.message, 'success').then(() => {
                                    location.reload(); // Optional: reload page after success
                                });
                            } else {
                                Swal.fire('Error!', data.message, 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error!', 'Ndodhi nje gabim. Provo perseri.', 'error');
                        });
                }
            });
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
                if ($.fn.DataTable.isDataTable('.model-datatables')) {
                    $('.model-datatables').DataTable().destroy();
                }

                $('.model-datatables').DataTable({
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: {
                        url: "{{ route('departamentishitjes.elements.list', ['id' => $id]) }}",
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
                            data: 'item_name',
                            name: 'item_name',
                            orderable: false
                        },
                        {
                            data: 'item_quantity',
                            name: 'item_quantity',
                            orderable: false
                        },
                        {
                            data: 'item_dimensions',
                            name: 'item_dimensions',
                            orderable: false
                        },
                        {
                            data: 'item_description',
                            name: 'item_description',
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
                        lengthMenu: "_MENU_",
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
            // });
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
                        url: "{{ route('departamentishitjes.skicat.list', ['id' => $id]) }}",
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
                            data: 'item_document',
                            name: 'item_document',
                            orderable: false
                        },
                        {
                            data: 'item_name',
                            name: 'item_name',
                            orderable: false
                        },
                        {
                            data: 'item_description',
                            name: 'item_description',
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
                        lengthMenu: "_MENU_",
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
        $(document).on('click', '.delete-btn-product', function() {
            let productNomalId = $(this).data('id');
            let deleteUrl = '{{ route('produkti.item.destroy', ':id') }}'.replace(':id', productNomalId);

            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                reverseButtons: true // <-- this flips the buttons
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Product has been removed.",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", "Something went wrong. Please try again.",
                                "error");
                        }
                    });
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Handle click on edit button
            $(document).on("click", ".edit-btn", function() {
                let item = $(this).data("item");
                let itemId = $(this).data('id');

                let route =
                    "{{ route('departamentishitjes.produkti.item.update', ['id' => 'ID_PLACEHOLDER']) }}";
                let formAction = route.replace('ID_PLACEHOLDER', itemId);
                $('#editPartnerForm').attr('action', formAction); // Set the action URL

                if (item) {
                    $("input[name='item_name']").val(item.item_name);
                    $("textarea[name='item_description']").val(item.item_description);
                    $("input[name='item_quantity']").val(item.item_quantity);
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Handle click on edit button
            $(document).on("click", ".edit-btn2", function() {
                let item = $(this).data("item");
                let itemId = $(this).data('id');

                let route =
                    "{{ route('departamentishitjes.produkti.item.update', ['id' => 'ID_PLACEHOLDER']) }}";
                let formAction = route.replace('ID_PLACEHOLDER', itemId);
                $('#editPartnerForm2').attr('action', formAction); // Set the action URL

                if (item) {
                    $("input[name='item_name']").val(item.item_name);
                    $("textarea[name='item_description']").val(item.item_description);
                    $("input[name='item_quantity']").val(item.item_quantity);
                }
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
@endsection
