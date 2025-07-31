


                                    <!-- 🔒 Hidden template -->
                        <div id="edit-item-template" class="d-none">
                            <div class="form-item mb-3 row rounded p-2 position-relative ms-1 me-1" data-index="__INDEX__" style="border: 2px solid #ced4da; padding: 10px; border-radius: 5px;">
                                <div class="col-3">
                                    <label class="form-label mt-2">Input Name</label>
                                    <input type="text" name="items[0][input_name]" class="form-control mb-2" placeholder="Input Name">
                                </div>
                                <div class="col-2">
                                    <label class="form-label mt-2">Input Type</label>
                                    <select name="items[0][input_type]" class="form-select mb-2">
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
                                    <input type="text" name="items[0][input_options]" class="form-control mb-2" placeholder="Options">
                                </div>
                                <div class="col-2">
                                    <label class="form-label mt-2">Icon</label>
                                   <input type="text" name="items[0][icon]" class="form-control mb-2" placeholder="Icon">
                                </div>
                                <div class="col-1">
                                    <label class="form-label mt-2 text-truncate">Column Size</label>
                                    <input type="number" name="items[0][cols]" class="form-control mb-2" placeholder="Cols">
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
                                <input type="hidden" name="items[__INDEX__][form_item_id]" value="">
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

@push('scripts')

<script>
    let editIndex = 0;

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
                        <input type="hidden" name="items[${index}][form_item_id]" value="${item.form_item_id ?? ''}">
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
                        <input type="hidden" name="items[${index}][form_item_id]" value="${item.form_item_id ?? ''}">
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
            // Pass correct form_item_id (parent id)
            $newRow.append(`<input type="hidden" name="items[${index}][form_item_id]" value="${item.form_item_id !== null ? item.form_item_id : ''}">`);

            return $newRow;
        };
    // Render form items with proper nesting
    function renderFormItems(flatItemsArray) {
        $('#edit-items-container').html('');
        editIndex = 0;
        const renderedIds = new Set();
        // Group children by form_item_id
        const childrenGrouped = {};
        flatItemsArray.forEach(item => {
            if (item.form_item_id !== null && item.form_item_id !== '') {
                if (!childrenGrouped[item.form_item_id]) {
                    childrenGrouped[item.form_item_id] = [];
                }
                childrenGrouped[item.form_item_id].push(item);
            }
        });
        // Recursive children rendering
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
                $childrenContainer.append($childRow);

                renderChildrenRecursively($childRow, child.id, childIndex);
            });
        };

        // Render all top-level parents, then their children recursively
        flatItemsArray.forEach(parent => {
            if ((parent.form_item_id === null || parent.form_item_id === '') && !renderedIds.has(parent.id)) {
                renderedIds.add(parent.id);
                const parentIndex = editIndex++;
                const $parentRow = renderItem(parent, parentIndex);
                $('#edit-items-container').append($parentRow);
                renderChildrenRecursively($parentRow, parent.id, parentIndex);
            }
        });
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
            form_item_id: parentId || '',
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
        // <-- Put your code here -->
        $newRow.find('input, select').each(function () {
            let name = $(this).attr('name');
            if (name) {
                let newName = name.replace(/\[\d+\]/, `[${editIndex}]`);
                $(this).attr('name', newName);
            }
            // Reset values
            if ($(this).is(':checkbox')) {
                $(this).prop('checked', false);
            } else {
                $(this).val('');
            }
        });
        // **IMPORTANT: Clear the id hidden input to prevent overwriting existing rows**
        $newRow.find('input[name$="[id]"]').val('');
        console.log(editIndex);

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
    });
</script>




@endpush
