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
                <h4 class="mb-sm-0">Modelet e Formulareve</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div> 
            </div>
        </div>
    </div>


{{-- <div class="container mt-4"> --}}
    <div class="card shadow">
        <div class="card-header bg-primary">
            <h5 class="mb-0 text-white">Shto Model të Ri</h5>
        </div>

        <form  id="modelId">
            @csrf
            <div class="card-body">
                <div class="row g-3">
                            
                    <div class="col-md-6">
                        <label for="model_name" class="form-label">Emri Modelit</label>
                        <input type="text" class="form-control" name="model_name" id="model_name" required>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form">
                                <div class="row">
                                    <div class="col-6">
                                        <label>{{ _lang('Products') }}</label>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <a class="btn btn-sm ml-auto ajax-modal-xl"
                                                data-title="{{ _lang('Add Product') }}">
                                                <i class="ri-add-line align-bottom me-1"></i>{{ _lang('Add Product') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="product_search" placeholder="Search Product..." autocomplete="off">
                                        <input type="hidden" name="product_id" id="product_id">
                                        <input type="hidden" name="product_name" id="product_name">
                                    </div>
                                </div>
                            </div>

                            <!-- Dropdown-like container -->
                            <div id="product_dropdown" class="dropdown-menu w-100 shadow-sm show" style="display: none; max-height: 200px; overflow-y: auto; background-color: #f8f9fa;">
                                <div id="product_list">
                                    <!-- AJAX results will be injected here -->
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <label for="hapsira_category_id" class="form-label">Kategoria Hapsirës</label>
                        <select class="form-select select2" name="hapsira_category_id" id="hapsira_category_id" required>
                            <option value="" disabled selected>Zgjidh Kategorinë e Hapsirës</option>
                            @foreach ($hapsiraCategories as $hc)
                                <option value="{{ $hc->id }}">{{ $hc->hapsira_category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="product_category_id" class="form-label">Kategoria Produktit</label>
                        <select class="form-select select2" name="product_category_id" id="product_category_id" required>
                            <option value="" disabled selected>Zgjidh Kategorinë e Produktit</option>
                            @foreach ($productCategories as $pc)
                                <option value="{{ $pc->id }}">{{ $pc->product_category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="module_name" class="form-label">Formulari Modelit</label>
                        <select class="form-select select2" name="module_name" id="module_name" required>
                            <option value="" disabled selected>Zgjidh Formularin e Modelit</option>
                            @foreach ($modules as $module)
                                <option value="{{ $module->id }}">{{ $module->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div> <!-- /.row -->
            </div>
            <div class="card-footer">
                            <div>
                                <div id="modalEditForm" class="d-none" style="max-width: 100%;">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 id="modalEditFormLabel" class="mb-0">Edit Form</h5>
                                        </div>
                                        <div class="card-body mx-0 flex-grow-0 pt-0 h-100">
                                            <div class="row">
                                                <!-- Example static inputs -->
                                                <div class="mb-3 mt-2">
                                                    <label class="form-label">Form Name</label>
                                                    <input type="text" class="form-control" name="name" id="editName">
                                                </div>
                                                <input type="hidden" id="editFormId" name="id">
                                                <!-- 🔻 Dynamic input section -->
                                                <div id="edit-items-container" class="col-11"></div>
                                                <div class="col-1 mt-4">
                                                    <button type="button" class="btn btn-secondary mt-2" id="edit-add-item-btn">+</button>
                                                </div>
                                                
                                                <div class="mb-3 col-6">
                                                    <label for="module_name" class="form-label">Module</label>
                                                    @php
                                                        $modules = \DB::table('module_statuses')->where('status', 1)->get();
                                                    @endphp
                                                    <select class="form-select js-example-basic-single" name="module_name" id="editModuleName" required>
                                                        @foreach ($modules as $module)
                                                            <option value="{{ $module->module_name }}">{{ $module->module_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label for="position" class="form-label">Position</label>
                                                    <input type="text" class="form-control" name="placement_position" id="editPosition" placeholder="Enter position (optional)">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Ruaj</button>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- </div> --}}
                @include('departamentishitjes::modeles.editForm')





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
            width: '100%'
        });
    });
</script>



<script>
    $('#product_search').on('input', function () {
        let query = $(this).val();

        if (query.length > 1) {
            $.ajax({
                url: '{{ route('search.products') }}',
                method: 'GET',
                data: { search: query },
                success: function (response) {
                    let $dropdown = $('#product_dropdown');
                    let $list = $('#product_list');
                    $list.html('');

                    if (response.length > 0) {
                        response.forEach(product => {
                            $list.append(`
                                <button class="dropdown-item" type="button" data-id="${product.id}">
                                    ${product.product_name}
                                </button>
                            `);
                        });
                        $dropdown.show();
                    } else {
                        $list.html('<div class="dropdown-item text-muted">Asnjë produkt nuk u gjet.</div>');
                        $dropdown.show();
                    }
                }
            });
        } else {
            $('#product_dropdown').hide();
        }
    });

    // Optional: Hide dropdown when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#product_search, #product_dropdown').length) {
            $('#product_dropdown').hide();
        }
    });

    // Optional: handle click on product
    $(document).on('click', '#product_list .dropdown-item', function () {
        let productId = $(this).data('id');
        let productName = $(this).text().trim();

        $('#product_search').val(productName);
        $('#product_id').val(productId);
        $('#product_name').val(productName);
        $('#product_dropdown').hide();
    });
</script>


<script>
    $('#module_name').on('change', function () {
        let moduleId = $(this).val();

        if (!moduleId) return;

        // Clear previous content
        $('#edit-items-container').empty();
        $('#editFormId').val('');
        $('#editName').val('');
        $('#editModuleName').val(moduleId);
        $('#editPosition').val('');

        // Load form data for selected module ID
        let url = "{{ route('formManager.edit', ':id') }}".replace(':id', moduleId);

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                // Populate fields if response contains data
                if (response) {
                    $('#editFormId').val(response.id);
                    $('#editName').val(response.name);
                    $('#editModuleName').val(response.module_name);
                    $('#editPosition').val(response.placement_position);
                }

                if (response.items) {
                    renderFormItems(response.items);
                }

                // ✅ Show the normal div (not a modal)
                $('#modalEditForm').removeClass('d-none');
            },
            error: function () {
                alert('Nuk mund të ngarkohet formulari për modulin.');
            }
        });
    });
</script>


<script>
    $(document).ready(function () {
        $('#modelId').on('submit', function (e) {
            e.preventDefault();

            var csrf_token = "{{ csrf_token() }}";

            $.ajax({
                url: "{{ route('departamentishitjes.formModelStore') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrf_token,
                },
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $('#errorForm-add-' + key).text(value[0]);
                        });
                    } else {
                        alert('Ndodhi një gabim i papritur.');
                    }
                }
            });
        });
    });
</script>


@endsection
@endsection