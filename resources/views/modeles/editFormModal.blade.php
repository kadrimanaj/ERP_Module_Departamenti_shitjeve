<style>
    #product_dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1061; /* above .modal (1050) and .modal-backdrop (1040) */
    }
    #product_dropdown .dropdown-item small {
        opacity: .7;
    }
</style>


<div class="modal fade" id="modalEditForm" tabindex="-1" aria-labelledby="modalEditFormLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalEditFormLabel" class="modal-title">Edit Form</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body mx-0 flex-grow-0 pt-0 h-100">
                            <form id="formEdit">
                                <div class="row">

                                    <div class="col-md-4">
                                        <label for="model_name" class="form-label">Emri Modelit</label>
                                        <input type="text" class="form-control" name="model_name" id="editmodel_name" required>
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

                                    <div class="col-md-12 mb-5">
                                        <div class="form-group">
                                            <div class="form">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label>{{ _lang('Products') }}</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="text-end">
                                                            <a href="{{ route('products.create') }}" target="_blanked" class="btn btn-sm"
                                                                >
                                                                <i class="ri-add-line align-bottom me-1"></i>{{ _lang('Add Product') }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" class="form-control" id="product_search" placeholder="Search Product..." autocomplete="off">
                                                        <input type="hidden" name="product_name" id="product_name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: none !important;">

                                                <input type="hidden" name="product_id" id="product_id">
                                            </div>
                                            <!-- Dropdown-like container -->
                                            <div id="product_dropdown" class="dropdown-menu w-100 shadow-sm show" style="display: none; max-height: 200px; overflow-y: auto; background-color: #f8f9fa;">
                                                <div id="product_list">
                                                    <!-- AJAX results will be injected here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                        <!-- Example static inputs -->
                                        {{-- <div class="mb-3">
                                            <label class="form-label">Form Name</label>
                                            <input type="text" class="form-control" name="name" id="editName">
                                        </div> --}}
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
                                            <select class="form-select js-example-basic-single" name="module_name" id="editModuleName" >
                                                @foreach ($modules as $module)
                                                    <option value="{{ $module->id }}">{{ $module->module_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3 col-6">
                                            <label for="position" class="form-label">Position</label>
                                            <input type="text" class="form-control" name="placement_position" id="editPosition" placeholder="Enter position (optional)">
                                        </div>

                                                                <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </form>

                                        <!-- 🔒 Hidden template -->
                                        <div id="edit-item-template" class="d-none">
                                            <div class="form-item mb-3 row rounded p-2 position-relative ms-1 me-1" data-index="__INDEX__" style="border: 2px solid #ced4da; padding: 10px; border-radius: 5px;">
                                                <div class="col-3">
                                                    <label class="form-label mt-2">Input Name</label>
                                                    <input type="text" name="items[__INDEX__][input_name]" class="form-control mb-2" placeholder="Input Name">
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label mt-2">Input Type</label>
                                                    <select name="items[__INDEX__][input_type]" class="form-select mb-2">
                                                        <option value="text">Text Input</option>
                                                        <option value="text-area">Text Area</option>
                                                        <option value="checkbox">Checkbox</option>
                                                        <option value="select">Select</option>
                                                        <option value="date">Date</option>
                                                        <option value="number">Number</option>
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <label class="form-label mt-2">Options (Separated by "/")</label>
                                                    <input type="text" name="items[__INDEX__][input_options]" class="form-control mb-2" placeholder="Options">
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label mt-2">Icon</label>
                                                <input type="text" name="items[__INDEX__][icon]" class="form-control mb-2" placeholder="Icon">
                                                </div>
                                                <div class="col-1">
                                                    <label class="form-label mt-2 text-truncate">Column Size</label>
                                                    <input type="number" name="items[__INDEX__][cols]" class="form-control mb-2" placeholder="Cols">
                                                </div>
                                                <div class="col-1 mt-4">
                                                    <button type="button" class="btn btn-danger mt-2 remove-item-btn">-</button>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <button type="button" class="btn btn-sm btn-outline-secondary add-child-btn">+ Add Option</button>
                                                </div>
                                                <div class="children-container ps-4 mt-2"></div>
                                            </div>
                                        </div>

                                        <div id="edit-child-item-template" class="d-none">
                                            <div class="form-item mb-3 row rounded p-2 position-relative ms-1 me-1" style="border: 2px solid #ced4da; padding: 10px; border-radius: 5px;">
                                                <input type="hidden" name="items[__INDEX__][id]" value="">
                                                <input type="hidden" name="items[__INDEX__][modele_item_id]" value="">
                                                <input type="hidden" name="items[__INDEX__][parent_index]" value="">
                                                <div class="col-2">
                                                    <label class="form-label mt-2">Input Name</label>
                                                    <input type="text" name="items[__INDEX__][input_name]" class="form-control mb-2" placeholder="Input Name" required>
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label mt-2">Parent Name</label>
                                                    <input type="text" name="items[__INDEX__][parent_name]" class="form-control mb-2" placeholder="Parent Name">
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label mt-2">Input Type</label>
                                                    <select name="items[__INDEX__][input_type]" class="form-select mb-2" required>
                                                        <option value="text">Text</option>
                                                        <option value="text-area">Textarea</option>
                                                        <option value="checkbox">Checkbox</option>
                                                        <option value="select">Select</option>
                                                        <option value="date">Date</option>
                                                        <option value="number">Number</option>
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label mt-2">Options</label>
                                                    <input type="text" name="items[__INDEX__][input_options]" class="form-control mb-2" placeholder="Options">
                                                </div>
                                                <div class="col-2">
                                                    <label class="form-label mt-2">Icon</label>
                                                    <input type="text" name="items[__INDEX__][icon]" class="form-control mb-2" placeholder="Icon">
                                                </div>
                                                <div class="col-1">
                                                    <label class="form-label mt-2">Cols</label>
                                                    <input type="number" name="items[__INDEX__][cols]" class="form-control mb-2" placeholder="Cols">
                                                </div>
                                                <div class="col-1 mt-4">
                                                    <button type="button" class="btn btn-danger mt-2 remove-item-btn">-</button>
                                                </div>
                                            </div>
                                        </div>

                        
                                    

                            </div>
                        </div>
                    </div>
                </div>

@push('scripts')
<script>
    function enforceColsLimits($row) {
        $row.find('input[name$="[cols]"], input[name*="[cols]"]').each(function () {
            $(this)
                .attr('min', 1)
                .attr('max', 12)
                .on('input', function () {
                    let val = parseInt(this.value);
                    if (val < 1) this.value = 1;
                    if (val > 12) this.value = 12;
                });
        });
    }
</script>



<script>
    let editIndex = 0;
    let tempIdCounter = 1;  // For new parents only


            const renderItem = (item, index, parentIndex = null) => {
            const $newRow = $('<div class="form-item mb-3 row rounded p-2 position-relative ms-1 me-1"></div>');
            $newRow.attr('data-index', index);
            $newRow.css({
                border: '2px solid #ced4da',
                padding: '10px',
                borderRadius: '5px'
            });

            const isParent = parentIndex === null;

            const col12AddBtn = `
                <div class="col-12 mt-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary add-child-btn" data-parent-index="${index}" data-parent-id="${item.id}">+ Add Option</button>
                </div>
            `;

            if (!isParent) {
                // Child layout
                $newRow.html(`
                        <input type="hidden" name="items[${index}][id]" value="${item.id ?? ''}">
                        <input type="hidden" name="items[${index}][modele_item_id]" value="${item.modele_item_id ?? ''}">
                        <input type="hidden" name="items[${index}][parent_index]" value="${parentIndex}">
                    <div class="col-2">
                        <label class="form-label mt-2">Input Name</label>
                        <input type="text" class="form-control" name="items[${index}][input_name]" value="${item.input_name || ''}" required>
                    </div>
                    <div class="col-2">
                        <label class="form-label mt-2">Parent Name</label>
                        <input type="text" class="form-control" name="items[${index}][parent_name]" value="${item.parent_name || ''}">
                    </div>
                    <div class="col-2">
                        <label class="form-label mt-2">Input Type</label>
                        <select class="form-select" name="items[${index}][input_type]" required>
                            <option value="text" ${item.input_type === 'text' ? 'selected' : ''}>Text</option>
                            <option value="text-area" ${item.input_type === 'text-area' ? 'selected' : ''}>Textarea</option>
                            <option value="checkbox" ${item.input_type === 'checkbox' ? 'selected' : ''}>Checkbox</option>
                            <option value="select" ${item.input_type === 'select' ? 'selected' : ''}>Select</option>
                            <option value="date" ${item.input_type === 'date' ? 'selected' : ''}>Date</option>
                            <option value="number" ${item.input_type === 'number' ? 'selected' : ''}>Number</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <label class="form-label mt-2">Options</label>
                        <input type="text" class="form-control" name="items[${index}][input_options]" value="${item.input_options || ''}">
                    </div>
                    <div class="col-2">
                        <label class="form-label mt-2">Icon</label>
                        <input type="text" class="form-control" name="items[${index}][icon]" value="${item.icon || ''}">
                    </div>
                    <div class="col-1">
                        <label class="form-label mt-2">Cols</label>
                        <input type="number" class="form-control" name="items[${index}][cols]" value="${item.cols || ''}">
                    </div>
                    <div class="col-1 mt-4">
                        <button type="button" class="btn btn-danger mt-2 remove-item-btn">-</button>
                    </div>
                    ${col12AddBtn}
                `);
            } else {
                // Parent layout
                $newRow.html(`
                        <input type="hidden" name="items[${index}][id]" value="${item.id ?? ''}">
                        <input type="hidden" name="items[${index}][modele_item_id]" value="${item.modele_item_id ?? ''}">
                        <input type="hidden" name="items[${index}][parent_index]" value="${parentIndex}">
                    <div class="col-3">
                        <label class="form-label mt-2">Input Name</label>
                        <input type="text" class="form-control" name="items[${index}][input_name]" value="${item.input_name || ''}" required>
                    </div>
                    <div class="col-2">
                        <label class="form-label mt-2">Input Type</label>
                        <select class="form-select" name="items[${index}][input_type]" required>
                            <option value="text" ${item.input_type === 'text' ? 'selected' : ''}>Text</option>
                            <option value="text-area" ${item.input_type === 'text-area' ? 'selected' : ''}>Textarea</option>
                            <option value="checkbox" ${item.input_type === 'checkbox' ? 'selected' : ''}>Checkbox</option>
                            <option value="select" ${item.input_type === 'select' ? 'selected' : ''}>Select</option>
                            <option value="date" ${item.input_type === 'date' ? 'selected' : ''}>Date</option>
                            <option value="number" ${item.input_type === 'number' ? 'selected' : ''}>Number</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label class="form-label mt-2">Options</label>
                        <input type="text" class="form-control" name="items[${index}][input_options]" value="${item.input_options || ''}">
                    </div>
                    <div class="col-2">
                        <label class="form-label mt-2">Icon</label>
                        <input type="text" class="form-control" name="items[${index}][icon]" value="${item.icon || ''}">
                    </div>
                    <div class="col-1">
                        <label class="form-label mt-2">Cols</label>
                        <input type="number" class="form-control" name="items[${index}][cols]" value="${item.cols || ''}">
                    </div>
                    <div class="col-1 mt-4">
                        <button type="button" class="btn btn-danger mt-2 remove-item-btn">-</button>
                    </div>
                    ${col12AddBtn}
                    <div class="children-container ps-4 mt-2"></div>
                `);
            }

            // Hidden fields
            if (item.id) {
                $newRow.append(`<input type="hidden" name="items[${index}][id]" value="${item.id}">`);
            }
            // Pass correct modele_item_id (parent id)
            $newRow.append(`<input type="hidden" name="items[${index}][modele_item_id]" value="${item.modele_item_id !== null ? item.modele_item_id : ''}">`);

            return $newRow;
        };
    // Render form items with proper nesting
    function renderFormItems(flatItemsArray) {
        $('#edit-items-container').html('');
        
        const renderedIds = new Set();

        // Helper: parse all indexes currently in flatItemsArray's items
        let maxIndex = -1;
        flatItemsArray.forEach(item => {
            // Try to find the numeric index from input_name or parent_index or a fallback

            // We'll look for numeric indexes on the client-side in the keys when rendering,
            // but since your array here has no explicit index field, use the order in array for now.

            // But better: if your item has 'index' (or you can extend your backend to provide it), use that.

            // As fallback, ignore for now — we will fix later in rendered DOM.

        });

        // Instead, after rendering all items, find max data-index attribute already rendered:
        editIndex = 0;

        // Render grouped children first
        const childrenGrouped = {};
        flatItemsArray.forEach(item => {
            if (item.modele_item_id !== null && item.modele_item_id !== '') {
                if (!childrenGrouped[item.modele_item_id]) {
                    childrenGrouped[item.modele_item_id] = [];
                }
                childrenGrouped[item.modele_item_id].push(item);
            }
        });

        const renderChildrenRecursively = (parentRow, parentItemId, parentIndex) => {
            const childItems = childrenGrouped[parentItemId] || [];
            let $childrenContainer = parentRow.find('.children-container');

            if ($childrenContainer.length === 0) {
                $childrenContainer = $('<div class="children-container ps-4 mt-2"></div>');
                parentRow.append($childrenContainer);
            }

            childItems.forEach(child => {
                if (renderedIds.has(child.id)) return;
                renderedIds.add(child.id);

                const childIndex = editIndex++;
const $childRow = renderItem(child, childIndex, parentIndex);
enforceColsLimits($childRow);
$childrenContainer.append($childRow);

                renderChildrenRecursively($childRow, child.id, childIndex);
            });
        };

        // Render all parents
        flatItemsArray.forEach(parent => {
            if ((parent.modele_item_id === null || parent.modele_item_id === '')) {
                renderedIds.add(parent.id);
                const parentIndex = editIndex++;
const $parentRow = renderItem(parent, parentIndex);
enforceColsLimits($parentRow);
$('#edit-items-container').append($parentRow);
                renderChildrenRecursively($parentRow, parent.id, parentIndex);
            }
        });

        // Now after rendering, find max existing data-index attribute:
        let maxExistingIndex = 0;
        $('#edit-items-container').find('.form-item').each(function () {
            let idx = parseInt($(this).attr('data-index'));
            if (!isNaN(idx) && idx > maxExistingIndex) maxExistingIndex = idx;
        });

        editIndex = maxExistingIndex + 1;
        console.log('Max index after rendering:', editIndex);
    }


    $(document).off('click', '.add-child-btn').on('click', '.add-child-btn', function (e) {
        e.preventDefault();

        const $btn = $(this);
        const $parentRow = $btn.closest('.form-item');
        const parentIndex = $parentRow.attr('data-index');
        const parentId = $parentRow.find(`input[name="items[${parentIndex}][id]"]`).val();

        console.log(parentIndex);
        // Create new child data
        const childItem = {
            id: null,
            modele_item_id: parentId || '',
            parent_index: parentIndex,
            input_name: '',
            parent_name: '',
            input_type: 'text',
            input_options: '',
            icon: '',
            cols: ''
        };

        const childIndex = editIndex++; 
        const $childRow = renderItem(childItem, childIndex, parentIndex);
        console.log($childRow);
        

        // Find or create .children-container only under THIS parent row
        let $childrenContainer = $parentRow.children(`.children-container[data-parent-index="${parentIndex}"]`);
            console.log(parentIndex);

        if ($childrenContainer.length === 0) {
            $childrenContainer = $(`<div class="children-container ps-4 mt-2" data-parent-index="${parentIndex}"></div>`);
            $parentRow.append($childrenContainer);
        }

        // Append only to this container
        $childrenContainer.append($childRow);
    });

    // Add New Item Row button (top-level)
    $('#edit-add-item-btn').on('click', function () {
        let $newRow = $('#edit-item-template').clone();

        $newRow.removeClass('d-none').removeAttr('id').addClass('form-item').attr('data-index', editIndex);

        // Replace all __INDEX__ placeholders inside the template
        $newRow.html($newRow.html().replace(/__INDEX__/g, editIndex));

        // Update add-child-btn data attributes inside new row
        $newRow.find('.add-child-btn').attr('data-parent-index', editIndex).attr('data-parent-id', '');

        // Reset input/select values in the new row
        $newRow.find('input, select').each(function () {
            if ($(this).is(':checkbox')) {
                $(this).prop('checked', false);
            } else {
                $(this).val('');
            }
        });

        // Clear hidden id fields if any
        $newRow.find('input[name$="[id]"]').val('');
        
        $newRow.find('input[name$="[cols]"]')
        .val(4)                            // Default value
        .attr('min', 1)                    // Minimum allowed
        .attr('max', 12)                   // Maximum allowed
        .on('input', function () {        // Enforce limit on user input
            let val = parseInt(this.value);
            if (val < 1) this.value = 1;
            if (val > 12) this.value = 12;
        });

        // Append new row to container
        $('#edit-items-container').append($newRow);

        editIndex++;
    });

    // Remove item button
    $(document).on('click', '.remove-item-btn', function () {
        const visibleItems = $('.form-item:visible');
        if (visibleItems.length <= 1) {
            alert('You cannot remove the only remaining field!');
            return;
        }

        $(this).closest('.form-item').remove();
        // reindexEditItems();
    });

    // Edit form button click (load data)
    $(document).on('click', '.editFormBtn', function () {
        let formId = $(this).data('id');

        $('#edit-items-container').find('.form-item:not(#edit-item-template)').remove();

$.ajax({
    url: '{{ route("departamentishitjes.modeles.edit", ":id") }}'.replace(':id', formId),
    type: 'GET',
    success: function (response) {
        $('#editFormId').val(response.id);
        $('#editmodel_name').val(response.name);
        $('#editModuleName').val(response.module_name);
        $('#editPosition').val(response.placement_position);
        $('#hapsira_category_id').val(response.hapsira_category_id).trigger('change');
        $('#product_category_id').val(response.product_category_id).trigger('change');

        /* ✅ Prefill selected product into the input */
        if (response.product_id && response.product_name) {
            $('#product_id').val(response.product_id);
            $('#product_name').val(response.product_name);
            $('#product_search').val(response.product_name);   // shows the selected name
        } else {
            $('#product_id, #product_name').val('');
            $('#product_search').val('');
        }

        // Render form items with nesting
        renderFormItems(response.items);

        $('#modalEditForm').modal('show');
    },
    error: function (err) {
        alert('{{ _lang('Failed to load form data.') }}');
        console.error(err);
    }
});
    });

    // Submit edit form
    $(document).ready(function () {
        $('#formEdit').on('submit', function (e) {
            e.preventDefault();

            let formId = $('#editFormId').val();
            let csrf_token = "{{ csrf_token() }}";

            $.ajax({
                url: '{{ route("departamentishitjes.modeles.update", ":id") }}'.replace(':id', formId),
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                },
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire({
                        title: 'Success',
                        text: response.message || 'Form updated!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    // ✅ Refresh DataTable (keep current page)
                    if ($.fn.DataTable.isDataTable('#model-datatables')) {
                        $('#model-datatables').DataTable().ajax.reload(null, false);
                    }

                    $('#modalEditForm').modal('hide');
                },
                error: function (xhr) {
                    Swal.fire('Error', 'Unable to update. Please try again.', 'error');
                    console.error(xhr);
                }
            });
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

@endpush
