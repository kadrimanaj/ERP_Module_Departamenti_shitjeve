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

        .hapsira-box.active,
        .category-box.active {
            border: 2px solid #000;
            background-color: #f0f0f0;
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
                                <th>Details</th>
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
    $(document).ready(function() {
        $('#hapsira_id').select2({
            placeholder: 'Select category',
            allowClear: true,
            width: '100%', // 'resolve' sometimes has issues, '100%' is safer inside modals
            dropdownParent: $('#exampleModalgridproductproduct')
        });
    });
</script>

<script>
    $(document).ready(function () {
        const getCategoriesUrl = "{{ route('shitesi.getCategories') }}";

        function appendTagBox(id, name, type, level, parent) {
            // Prevent duplication
            if ($('#tag-box-' + type + '-' + level).length) return;
               const label = (parent === null) ? 'Kategori' : (parent != null) ? 'Nënkategori' : type.charAt(0).toUpperCase() + type.slice(1);

            const tagBox = $(`
                <div class="col-2 d-flex" id="tag-box-${type}-${level}">
                    <div class="position-relative border border-black p-2 w-100 text-center">
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2 tag-close"
                            data-type="${type}" data-level="${level}" aria-label="Close"></button>
                        <div class="w-100 mt-4">
                            <div class="badge bg-outline-primary text-black text-wrap w-100">${name}</div>
                            <hr class="my-2">
                              <h6 class="mb-0">${label}</h6>
                        </div>
                    </div>
                </div>
            `);
            $('#selected-tags-row').append(tagBox);
        }

        // Close tag logic
        $(document).on('click', '.tag-close', function () {
            const level = parseInt($(this).data('level'));
            const type = $(this).data('type');

            $('#modeles-table-container').hide();
            $('#form-preview-container').hide();
            // Remove this tag and all after it (but keep before)
            $(`#tag-box-${type}-${level}`).remove();
            $(`#selected-tags-row`).find(`[id^=tag-box-${type}]`).each(function () {
                const tagLevel = parseInt($(this).find('.tag-close').data('level'));
                if (tagLevel > level) {
                    $(this).remove();
                }
            });
            $('#categories-container-wrapper').show();
            $(`.category-level-row[data-level="${level}"]`).removeClass('d-none');
            $(`.category-level-row[data-level="${level}"]`).nextAll().remove();
            if (type === 'hapsira') {
                $('#hapsira-select-container').removeClass('d-none');
                $('#categories-container-wrapper').empty();
                $('#selected-tags-row').find(`[id^=tag-box-category]`).remove();
            }
        });

        // Hapsira select
        $('.hapsira-box').on('click', function () {
            const selectedId = $(this).data('id');
            const selectedName = $(this).data('name');

            // Reset everything
            $('#hapsira-select-container').addClass('d-none');
            $('#categories-container-wrapper').empty();
            $('#selected-tags-row').find(`[id^=tag-box-hapsira]`).remove();
            $('#selected-tags-row').find(`[id^=tag-box-category]`).remove();

            appendTagBox(selectedId, selectedName, 'hapsira', 0);
            loadCategories(selectedId, 'hapsira', 0);
        });

        // Load categories/subcategories
        function loadCategories(parentId, type, level) {
            $.ajax({
                url: getCategoriesUrl,
                method: 'GET',
                data: {
                    hapsira_id: parentId,
                    type: type
                },
                success: function (response) {
                    if (response.categories && response.categories.length > 0) {
                        const levelRow = $(`
                            <div class="row g-2 mt-2 category-level-row" data-level="${level}"></div>
                        `);

                        response.categories.forEach(cat => {
                            const isSubCategory = typeof cat.parent_id !== 'undefined' && cat.parent_id !== null;
                            const label = isSubCategory ? 'Nënkategori' : 'Kategori';

                            const box = $(`
                                <div class="col-2 d-flex">
                                    <button type="button"
                                        class="btn btn-outline-success w-100 h-100 category-box text-center"
                                        data-id="${cat.id}"
                                        data-name="${cat.product_category_name}"
                                        data-parent_id="${cat.parent_id}"
                                        data-level="${level}"
                                        data-type="category">
                                        ${cat.product_category_name}
                                        <hr>
                                       <h6 class="text-center mb-0">${label}</h6>
                                    </button>
                                </div>
                            `);
                            levelRow.append(box);
                        });

                        $('#categories-container-wrapper').append(levelRow);

                        // Category click handler
                        levelRow.find('.category-box').on('click', function () {
                            const categoryId = $(this).data('id');
                            const parent = $(this).data('parent_id');
                            const categoryName = $(this).data('name');
                            const currentLevel = parseInt($(this).data('level'));

                            // Remove deeper levels
                            $(`.category-level-row[data-level="${currentLevel}"]`).nextAll().remove();
                            appendTagBox(categoryId, categoryName, 'category', currentLevel, parent);

                            // Hide current level row
                            $(`.category-level-row[data-level="${currentLevel}"]`).addClass('d-none');
                            $('#modeles-table-container').show();
                            $('#form-preview-container').hide();


                            // Load subcategories
                            loadCategories(categoryId, 'category', currentLevel + 1);
                        });
                    }
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
                    { data: 'product_details', name: 'product_details', orderable: false },
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
                    { data: 'product_id', name: 'product_id', orderable: false },
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
        $('#categories-container-wrapper').hide();
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>


<script>
    $(document).ready(function () {
        let selectedCategoryId = null;

        // Initialize DataTable with optional category filter
        function initializeDataTable(categoryId) {
            if ($.fn.DataTable.isDataTable('.model-datatables-modeles')) {
                $('.model-datatables-modeles').DataTable().destroy();
            }

            $('.model-datatables-modeles').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route('departamentishitjes.modeles.category.products', ['id' => $id]) }}".replace('{{ $id }}', categoryId || '0'),
                    data: function (d) {
                        d.name = $('#search-client').val();
                        d.status = $('#search-status').val();
                        d.date = $('#search-date').val();
                    },
                    // If categoryId is null, send an invalid ID or empty to get no data or default data
                    dataSrc: function (json) {
                        return json.data || [];
                    }
                },
                columns: [
                    { data: 'id', name: 'id', orderable: false },
                    { data: 'image', name: 'image', orderable: false },
                    { data: 'product_name', name: 'product_name', orderable: false },
                    { data: 'hapsira_category_id', name: 'hapsira_category_id', orderable: false },
                    { data: 'product_category_id', name: 'product_category_id', orderable: false },
                    { data: 'model_name', name: 'model_name', orderable: false },
                    { data: 'module_name', name: 'module_name', orderable: false },
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
                buttons: [],
                language: {
                    lengthMenu: " _MENU_ ",
                    search: "",
                    paginate: {
                        previous: "Prev",
                        next: "Next"
                    }
                },
                info: false,
                autoWidth: false,
                paging: true,
                ordering: true,
                searching: true,
            });
        }

        // Initial load without category filter or with default
        initializeDataTable(null);

        // When a category is selected in your modal (example selector, adjust if needed)
        $(document).on('click', '.category-box', function () {
            selectedCategoryId = $(this).data('id');
            
            // Reload the DataTable with new category ID
            initializeDataTable(selectedCategoryId);
        });

        // Refresh button logic (if you have it)
        $(document).on('click', '#refresh', function () {
            $('#search-client').val('');
            $('#search-architect').val('');
            $('#search-status').val('').trigger('change');
            initializeDataTable(selectedCategoryId);
        });
    });

    // Swal function remains the same
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
</script>



<script>
    $(document).on('click', '.add-to-cart-btn', function () {
        const modeleId = $(this).data('id');

        // Hide DataTable
        $('#modeles-table-container').hide();

        // Show loading spinner while fetching the form
        $('#form-preview-container').html('<div class="text-center p-4"><div class="spinner-border text-primary"></div></div>').show();

        // Fetch form preview
        fetch(`{{ route('departamentishitjes.modeles.formPreview', ['id' => '__ID__']) }}`.replace('__ID__', modeleId))
            .then(response => response.text())
            .then(async html => {
                $('#form-preview-container').html(html);

                // ---- Begin dynamic form rendering ----
                const formContainer = document.getElementById('formContainer');
                let items = [];

                try {
                    const formItemsUrl = `{{ route('form.items.model', ['formId' => '__FORM_ID__']) }}`.replace('__FORM_ID__', modeleId);
                    const response = await fetch(formItemsUrl);
                    if (!response.ok) throw new Error('Network error');
                    items = await response.json();
                } catch (error) {
                    console.error('Failed to load form items:', error);
                    return;
                }

                function createInputHTML(item, parentKey) {
                    const options = (item.input_options || '').split('/').filter(o => o.trim() !== '');
                    let html = `<label class="form-label">${item.input_name}</label>`;

                    if (['text', 'number', 'date'].includes(item.input_type)) {
                        html += `<input type="${item.input_type}" name="extra_fields[${parentKey}][${item.id}]" class="form-control">`;
                    } else if (item.input_type === 'checkbox') {
                        html += `<input type="checkbox" name="extra_fields[${parentKey}][${item.id}]" value="${item.input_name}" class="form-check-input trigger-child" data-item-id="${item.id}" data-input-value="${item.input_name}">`;
                    } else if (item.input_type === 'radio') {
                        options.forEach((opt, i) => {
                            const id = `radio_${item.id}_${i}`;
                            html += `<div class="form-check">
                                        <input class="form-check-input trigger-child" type="radio"
                                            name="extra_fields[${parentKey}][${item.id}]"
                                            id="${id}" value="${opt}"
                                            data-item-id="${item.id}" data-input-value="${opt}">
                                        <label class="form-check-label" for="${id}">${opt}</label>
                                    </div>`;
                        });
                    } else if (item.input_type === 'select') {
                        html += `<select class="form-select trigger-child" name="extra_fields[${parentKey}][${item.id}]" data-item-id="${item.id}">
                                    <option value="">-- Select --</option>`;
                        options.forEach(opt => {
                            html += `<option value="${opt}" data-input-value="${opt}">${opt}</option>`;
                        });
                        html += `</select>`;
                    } else if (item.input_type === 'text-area') {
                        html += `<textarea class="form-control" rows="5" name="extra_fields[${parentKey}][${item.id}]"></textarea>`;
                    }

                    return html;
                }

                

                function renderFormItem(item, parentKey) {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('form-item', `col-${item.cols || 2}`, 'mt-3');
                    if (item.modele_item_id) {
                        wrapper.classList.add(`child-of-${item.modele_item_id}`);
                    }
                    wrapper.dataset.itemId = item.id;
                    wrapper.dataset.parentId = item.modele_item_id;
                    wrapper.dataset.inputType = item.input_type;
                    wrapper.dataset.inputName = item.input_name;
                    wrapper.dataset.key = parentKey;

                    wrapper.innerHTML = createInputHTML(item, parentKey);
                    return wrapper;
                }

                function removeAllDescendants(parentId) {
                    const descendants = formContainer.querySelectorAll(`[data-parent-id="${parentId}"]`);
                    descendants.forEach(child => {
                        removeAllDescendants(child.dataset.itemId);
                        child.remove();
                    });
                }

                function handleInputChange(input) {
                    const parentId = input.dataset.itemId;
                    const selectedValue = input.type === 'checkbox'
                        ? (input.checked ? input.value : '')
                        : input.value;

                    removeAllDescendants(parentId);
                    if (!selectedValue) return;

                    const parentKey = input.closest('.form-item')?.dataset.key || Date.now();

                    items.forEach(child => {
                        if (child.modele_item_id == parentId && child.parent_name === selectedValue) {
                            const childElement = renderFormItem(child, parentKey);
                            const parentElement = formContainer.querySelector(`[data-item-id="${parentId}"]`);
                            if (parentElement.nextSibling) {
                                parentElement.parentNode.insertBefore(childElement, parentElement.nextSibling);
                            } else {
                                parentElement.parentNode.appendChild(childElement);
                            }
                        }
                    });

                    attachListeners();
                }

                function attachListeners() {
                    document.querySelectorAll('.trigger-child').forEach(el => {
                        el.removeEventListener('change', listener);
                        el.addEventListener('change', listener);
                    });
                }

                function listener(e) {
                    handleInputChange(e.target);
                }

                formContainer.innerHTML = '';
                let currentRow = null;
                let currentRowCols = 0;
                let imageInserted = false;

                items.forEach((item, index) => {
                    if (!item.modele_item_id) {
                        const colSize = parseInt(item.cols || 2);
                    const modelName = $(this).data('model-name');
                    const productImage = $(this).data('product-image');
                    const productName = $(this).data('product-name');

                        // First time only: insert col-3 + item together if colSize <= 9
                        if (!imageInserted) {
                            if (colSize <= 9) {
                                // Put col-3 + item in same row
                                currentRow = document.createElement('div');
                                currentRow.classList.add('row', 'gx-3');

                                const col3 = document.createElement('div');
                                col3.classList.add('col-3', 'mb-3');
                                col3.innerHTML = `<div class="text-center border p-3" style="background-color: #f8f9fa; border-color: #ced4da;">
                                    <h5 class="fw-bold mb-2">${modelName}</h5>
                                    <img src="${productImage}" alt="Image" width="80" height="80"
                                        style="cursor:pointer;"
                                        onclick="showImageSwal('${productImage}', '${productName}')"></div>
                                `;

                                const formItem = renderFormItem(item, index);

                                currentRow.appendChild(col3);
                                currentRow.appendChild(formItem);
                                formContainer.appendChild(currentRow);
                                currentRowCols = 3 + colSize;
                            } else {
                                // Put col-3 in its own row
                                const imageRow = document.createElement('div');
                                imageRow.classList.add('row', 'gx-3');
                                const col3 = document.createElement('div');
                                col3.classList.add('col-3', 'mb-3');
                                col3.innerHTML = `<div class="text-center border p-3" style="background-color: #f8f9fa; border-color: #ced4da;">
                                    <h5 class="fw-bold mb-2">${modelName}</h5>
                                    <img src="${productImage}" alt="Image" width="100" height="100"
                                        style="cursor:pointer;"
                                        onclick="showImageSwal('${productImage}', '${productName}')"></div>
                                `;
                                imageRow.appendChild(col3);
                                formContainer.appendChild(imageRow);

                                // Then add form item in a new row
                                currentRow = document.createElement('div');
                                currentRow.classList.add('row', 'gx-3');
                                const formItem = renderFormItem(item, index);
                                currentRow.appendChild(formItem);
                                formContainer.appendChild(currentRow);
                                currentRowCols = colSize;
                            }

                            imageInserted = true;
                            return; // Skip rest of loop for first item
                        }

                        // Normal logic for the rest of items
                        if (!currentRow || currentRowCols + colSize > 12) {
                            currentRow = document.createElement('div');
                            currentRow.classList.add('row', 'gx-3');
                            formContainer.appendChild(currentRow);
                            currentRowCols = 0;
                        }

                        const formItem = renderFormItem(item, index);
                        currentRow.appendChild(formItem);
                        currentRowCols += colSize;
                    }
                });


                attachListeners();
                // ---- End dynamic form rendering ----
            })
            .catch(error => {
                console.error(error);
                $('#form-preview-container').html('<p class="text-danger">Form could not be loaded.</p>');
            });
    });
</script>






@endsection
@endsection