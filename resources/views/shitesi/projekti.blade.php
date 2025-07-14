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

        .select2-container--default .select2-selection--single {
            height: calc(1.5em + .5rem + 2px);
            padding: .25rem .5rem;
            font-size: .700rem;
            line-height: 1.5;
            border: 1px solid #ced4da;
            border-radius: .2rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/libs/dropzone/dropzone.css') }}" type="text/css" />
@endsection
@section('content')
   
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4><a href="{{ route('departamentishitjes.shitesi.dashboard') }}"><i class="ri-arrow-left-fill"></i> Back</a></h4>
            <h4 class="mb-sm-0">Request Details</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('departamentishitjes.shitesi.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Request Details</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5 class="card-title mb-0">Lista e produkteve me porosi</h5>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        @if($projects->project_status >= 2 && $projects->project_status != 3) 
                        <button type="button" class="btn btn-success btn-sm">
                            Konfirmuar
                        </button>
                        @elseif($projects->project_status == 3)
                        <button type="button" class="btn btn-danger btn-sm">
                            Anulluar
                        </button>
                        @else
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalgridproductproduct">
                            + Shto produkt me porosi
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="model-datatables" class="table table-bordered nowrap table-striped align-middle model-datatables" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Foto</th>
                                <th>Emri Produktit</th>
                                <th>Permasat</th>
                                <th>Ngjyra</th>
                                <th>Pershkrimi</th>
                                <th>Sasia</th>
                                <th>Status</th>
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
    @if ($comments_costum_product->count() > 0)
    <div class="col-xl-12">
        <div class="card">
           <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Historiku i komenteve</h4>
            </div>

            <div class="card-body">
                <div data-simplebar class="mx-n3 px-3">
                    <div class="vstack gap-3">
                        @foreach ($comments_costum_product as $comment)
                        <div class="d-flex gap-3">
                            <div class="avatar-sm rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($comment->user_id ?? 'U', 0, 1)) }}
                            </div>  
                            <div class="flex-shrink-1">
                                <h6 class="mb-2">{{$comment->user_id  }} <span class="text-muted">{{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y H:i') }}</span></h6>
                                <p class="text-muted mb-0">" {{ $comment->comment }}"</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="col-12">
        {{-- <span>Komente te tjera</span><br> --}}
        <form action="{{ route('departamentishitjes.comment.store', $id) }}" method="POST">
            @csrf
        
            <input type="hidden" name="comment_type" value="costum"> {{-- or change to any type you want --}}
            
            <div class="form-group mb-3">
                
                <textarea name="comment" class="form-control" cols="30" rows="3" placeholder="Shkruaj një koment..."></textarea>
            </div>
        
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Ruaj Komentin</button>
            </div>
        </form>
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
                    @if($projects->project_status >= 2 && $projects->project_status != 3) 
                    <button type="button" class="btn btn-success btn-sm">
                        Konfirmuar
                    </button>
                    @elseif($projects->project_status == 3)
                    <button type="button" class="btn btn-danger btn-sm">
                        Anulluar
                    </button>
                    @else
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalgridproductproduct2">
                        + Shto produkt
                    </button>
                    @endif
                    {{-- @include('assetmanagement::assets_list.create') --}}
                </div>
            </div>
            <div class="card-body">
                <table id="model-datatables2" class="table table-bordered nowrap table-striped align-middle model-datatables2" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Produkti</th>
                            <th>Sasia</th>
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
    @if ($comments_normal_product->count() > 0)
        
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Historiku i komenteve</h4>
            </div>
            <div class="card-body">
                <div data-simplebar class="mx-n3 px-3">
                    <div class="vstack gap-3">
                        @foreach ($comments_normal_product as $comment)
                        <div class="d-flex gap-3">
                            <div class="avatar-sm rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($comment->user_id ?? 'U', 0, 1)) }}
                            </div>  
                            <div class="flex-shrink-1">
                                <h6 class="mb-2">{{$comment->user_id  }} <span class="text-muted">{{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y H:i') }}</span></h6>
                                <p class="text-muted mb-0">" {{ $comment->comment }}"</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="col-12">
        {{-- <span>Komente te tjera</span><br> --}}
        <form action="{{ route('departamentishitjes.comment.store', $id) }}" method="POST">
            @csrf
        
            <input type="hidden" name="comment_type" value="normal"> {{-- or change to any type you want --}}
            
            <div class="form-group mb-3">
                
                <textarea name="comment" class="form-control" cols="30" rows="3" placeholder="Shkruaj një koment..."></textarea>
            </div>
        
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Ruaj Komentin</button>
            </div>
        </form>
    </div>
</div>



@include('departamentishitjes::shitesi.modals.edit_costum_product')
@include('departamentishitjes::shitesi.modals.edit_product_normal')


@include('departamentishitjes::components.modal-add-product')
@include('departamentishitjes::components.modal-add-existing-product')


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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('#exampleModalgridproductproduct').on('show.bs.modal', function () {
            // Clear all input fields and textareas
            $(this).find('input[type="text"], input[type="number"], input[type="file"], textarea').val('');
            
            // Reset the select dropdowns
            $(this).find('select').val('').trigger('change');
        });
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
            if ($.fn.DataTable.isDataTable('.model-datatables')) {
                $('.model-datatables').DataTable().destroy();
            }

            $('.model-datatables').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route('shitesi.preorder.list_preorder', ['id' => $id]) }}",
                    data: function(d) {
                        d.name = $('#search-client').val();
                        d.status = $('#search-status').val();
                        d.date = $('#search-date').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'image', name: 'image', orderable: false },
                    { data: 'product_name', name: 'product_name', orderable: false },
                    { data: 'dimension', name: 'dimension', orderable: false },
                    { data: 'color', name: 'color', orderable: false },
                    { data: 'product_description', name: 'product_description', orderable: false },
                    { data: 'product_quantity', name: 'product_quantity', orderable: false },
                    { data: 'product_status', name: 'product_status', orderable: false },
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
                    url: "{{ route('product.preorder.product_list', ['id' => $id]) }}",
                    data: function(d) {
                        d.name = $('#search-client').val();
                        d.status = $('#search-status').val();
                        d.date = $('#search-date').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'product_description', name: 'product_description', orderable: false },
                    { data: 'product_name', name: 'product_name', orderable: false },
                    { data: 'product_quantity', name: 'product_quantity', orderable: false },
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
                autoWidth: false,
                paging: true,
                ordering: true,
                searching: true,
                initComplete: function () {
                    $('.model-datatables2').removeClass('dataTable');
                }
            });
        }
    });

</script>

<script>
    $(document).on('click', '.delete-btn-product', function () {
        let productNomalId = $(this).data('id');
        let deleteUrl = '{{ route("normal_product.destroy", ":id") }}'.replace(':id', productNomalId);

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
                    success: function (response) {
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
                    error: function (xhr) {
                        Swal.fire("Error!", "Something went wrong. Please try again.", "error");
                    }
                });
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize select2 in modal
        // $('.js-example-basic-single').select2({
        //     dropdownParent: $('#staticBackdropedit')
        // });

        // Handle click on edit button
        $(document).on("click", ".edit-btn", function () {
            let item = $(this).data("item");  // Get item data from the button
            let partnerId = $(this).data('id');  // Get partner ID

            // Update form action dynamically (for PUT request)
            let route = "{{ route('departamentishitjes.shitesi.update_product_normal', ['id' => 'ID_PLACEHOLDER']) }}";
            let formAction = route.replace('ID_PLACEHOLDER', partnerId);
            $('#editPartnerForm').attr('action', formAction);  // Set the action URL

            if (item) {
                $("input[name='product_name']").val(item.product_name);
                $("textarea[name='product_description']").val(item.product_description);
                $("input[name='dimension']").val(item.dimension);
                $("input[name='color']").val(item.color);
                $("select[name='category_id']").val(item.category_id).trigger("change");
                $("input[name='product_quantity']").val(item.product_quantity);
            }
        });

        // Re-initialize select2 every time modal is shown
        // $('#editPartnerModal').on('shown.bs.modal', function () {
        //     $('.js-example-basic-single').select2({
        //         dropdownParent: $('#staticBackdropedit')
        //     });
        // });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize select2 in modal
        $('.select2').select2({
            dropdownParent: $('#editPartnerModal')
        });

        // Handle click on edit button
        $(document).on("click", ".edit-btn2", function () {
            let item = $(this).data("item");  // Get item data from the button
            let partnerId = $(this).data('id');  // Get partner ID

            // Update form action dynamically (for PUT request)
            let route = "{{ route('departamentishitjes.shitesi.update_product_normal', ['id' => 'ID_PLACEHOLDER']) }}";
            let formAction = route.replace('ID_PLACEHOLDER', partnerId);
            $('#editPartnerForm2').attr('action', formAction);  // Set the action URL

            if (item) {
                $("input[name='product_name']").val(item.product_name);
                $("textarea[name='product_description']").val(item.product_description);
                $("select[name='product_status']").val(item.product_status).trigger("change");
                $("select[name='product_name']").val(item.product_name).trigger("change");
                $("input[name='product_quantity']").val(item.product_quantity);
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



    // Refresh button to reset filters and reload DataTabler
    $(document).on('click', '#refresh', function () {
        // Reset all filters
        $('#search-client').val('');
        $('#search-architect').val('');
        $('#search-status').val('').trigger('change'); // trigger change if using select2 or similar


        // Reload the DataTable
        $('#model-datatables-products').DataTable().ajax.reload();
    });
    $(function() {
            $(document).ready(function() {
                initializeDataTable(null, null);
            });

        function initializeDataTable(itemId, itemName) {
            if ($.fn.DataTable.isDataTable('.model-datatables-products')) {
                $('.model-datatables-products').DataTable().destroy();
            }

            $('.model-datatables-products').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                // pageLength: 5, 
                ajax: {
                    url: "{{ route('products.list', ['id' => $id]) }}",
                    data: function(d) {
                        d.name = $('#search-client').val();
                        d.status = $('#search-status').val();
                        d.date = $('#search-date').val();

                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'image', name: 'image', orderable: false },
                    { data: 'product_name', name: 'product_name', orderable: false },
                    { data: 'category_id', name: 'category_id', orderable: false },
                    { data: 'qty', name: 'qty', orderable: false },
                    { data: 'price', name: 'price', orderable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                dom:
                    '<"row mb-3"' +
                        '<"col-sm-6 mt-2"l>' + 
                        '<"col-sm-6 d-flex justify-content-end align-items-center gap-2"' +
                        '<"category-filter ms-2">' + // 👈 Add this
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
                   
                ],
                language: {
                    lengthMenu: " _MENU_ ", 
                    search: "",
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    }
                },
                info: false ,
                autoWidth: false,
                paging: true,
                ordering: true,
                searching: true,
                initComplete: function () {
                    $('.model-datatables-products').removeClass('dataTable');

                    $('.category-filter').html(`{!! 
                        '<select id="categorySearch" class="form-select form-select-sm  js-example-basic-single" style="min-width: 200px;">' .
                        $categories->map(fn($c) => "<option value='{$c->id}'>{$c->name}</option>")->implode('') .
                        '</select>' 
                    !!}`);

                    $('#categorySearch').select2({
                        placeholder: '🔍 Select category',
                        allowClear: true,
                        width: 'resolve',
                        dropdownParent: $('.category-filter') // 👈 Required for dropdown inside DataTable header
                    });

                    $('#categorySearch').on('change', function () {
                        var selected = $(this).val();
                        $('.model-datatables-products').DataTable().column(3).search(
                            selected ? '^' + selected + '$' : '', true, false
                        ).draw();
                    });
                }  
            });
        }
    });

    function showImageSwal(imageUrl, productName) {
        Swal.fire({
            title: productName,
            imageUrl: imageUrl,
            imageWidth: 400,
            imageAlt: 'Product Image',
            showCloseButton: false,
            confirmButtonText: 'Close',
            confirmButtonColor: '#405189'
        });
    }




    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();

        let form = $(this).closest('form');
        let url = form.data('url');
        let formData = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Shtuar!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Refresh DataTable without reloading page
                    $('#model-datatables2').DataTable().ajax.reload(null, false);
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gabim!',
                    text: 'Nuk u shtua produkti.',
                });
            }
        });
    });
</script>

@endsection
@endsection