@extends('layouts.new')

@section('content')
    @if (!isModuleEnabled('FormManager'))
        <p>Form Manager is not enabled.</p>
        @return
    @endif

    @isset($form)
        @php
            $key = 0;
            $items = $form->items->where('model_id', $form->id)->whereNull('modele_item_id') ?? collect();
            // dd($items);
        @endphp

        <div class="card p-4">
            <h5 class="fw-bold mb-3">Product Formular Preview</h5>

<div id="formContainer">
    @foreach($items->where('modele_item_id', null) as $item)
        <div class="form-item col-{{ $item->cols ?? 2 }} mt-3" data-item-id="{{ $item->id }}" data-key="{{ $loop->index }}">
            <label class="form-label">{{ $item->input_name }}</label>
            
            @php $options = explode('/', $item->input_options); @endphp

            @if(in_array($item->input_type, ['text', 'number', 'date']))
                <input type="{{ $item->input_type }}" name="extra_fields[{{ $loop->index }}][{{ $item->id }}]" class="form-control">
            @elseif($item->input_type === 'select')
                <select class="form-select trigger-child" name="extra_fields[{{ $loop->index }}][{{ $item->id }}]" data-item-id="{{ $item->id }}">
                    <option value="">-- Select --</option>
                    @foreach($options as $opt)
                        <option value="{{ trim($opt) }}" data-input-value="{{ trim($opt) }}">{{ trim($opt) }}</option>
                    @endforeach
                </select>
            @elseif($item->input_type === 'checkbox')
                <input type="checkbox" class="form-check-input trigger-child" value="{{ $item->input_name }}" 
                    name="extra_fields[{{ $loop->index }}][{{ $item->id }}]" data-item-id="{{ $item->id }}" data-input-value="{{ $item->input_name }}">
            @elseif($item->input_type === 'radio')
                @foreach($options as $opt)
                    <div class="form-check">
                        <input class="form-check-input trigger-child" type="radio" name="extra_fields[{{ $loop->index }}][{{ $item->id }}]" 
                            value="{{ trim($opt) }}" data-item-id="{{ $item->id }}" data-input-value="{{ trim($opt) }}">
                        <label class="form-check-label">{{ trim($opt) }}</label>
                    </div>
                @endforeach
            @elseif($item->input_type === 'text-area')
                <textarea class="form-control" name="extra_fields[{{ $loop->index }}][{{ $item->id }}]" rows="4"></textarea>
            @endif
        </div>
    @endforeach
</div>

        </div>
    @endisset
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async function () {
    const formContainer = document.getElementById('formContainer');
    let items = [];

    try {
        const formItemsUrl = @json(route('form.items.model', ['formId' => $form->id]));
        const response = await fetch(formItemsUrl);

        if (!response.ok) throw new Error('Network error');

        items = await response.json();
    } catch (error) {
        console.error('Failed to load form items:', error);
        return;
    }

        // Utility: create input HTML based on item type and options
        function createInputHTML(item, parentKey) {
            const options = (item.input_options || '').split('/').filter(o => o.trim() !== '');
            let html = `<label class="form-label">${item.input_name}</label>`;

            if (['text', 'number', 'date'].includes(item.input_type)) {
                html += `<input type="${item.input_type}" 
                            name="extra_fields[${parentKey}][${item.id}]" 
                            class="form-control">`;
            } else if (item.input_type === 'checkbox') {
                html += `<input type="checkbox" 
                                name="extra_fields[${parentKey}][${item.id}]" 
                                value="${item.input_name}" 
                                class="form-check-input trigger-child" 
                                data-item-id="${item.id}" 
                                data-input-value="${item.input_name}">`;
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
                html += `<select class="form-select trigger-child" 
                                name="extra_fields[${parentKey}][${item.id}]" 
                                data-item-id="${item.id}">
                            <option value="">-- Select --</option>`;
                options.forEach(opt => {
                    html += `<option value="${opt}" data-input-value="${opt}">${opt}</option>`;
                });
                html += `</select>`;
            } else if (item.input_type === 'text-area') {
                html += `<textarea class="form-control" rows="5" 
                                name="extra_fields[${parentKey}][${item.id}]"></textarea>`;
            }

            return html;
        }

        // Render a form item div (either top-level or child)
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

        // Remove all child elements recursively for a parentId
        function removeAllDescendants(parentId) {
            const descendants = formContainer.querySelectorAll(`[data-parent-id="${parentId}"]`);
            descendants.forEach(child => {
                removeAllDescendants(child.dataset.itemId);
                child.remove();
            });
        }

        // Handle change event on inputs with children
        function handleInputChange(input) {
            const parentId = input.dataset.itemId;
            const selectedValue = input.type === 'checkbox'
                ? (input.checked ? input.value : '')
                : input.value;

            // Remove all child inputs under this parent
            removeAllDescendants(parentId);

            if (!selectedValue) return;

            // Get the parent key from the closest form-item div or fallback to a timestamp
            const parentKey = input.closest('.form-item')?.dataset.key || Date.now();

            // Find children that belong to this parent and match the selected value
            items.forEach(child => {
                if (child.modele_item_id == parentId && child.parent_name === selectedValue) {
                    const childElement = renderFormItem(child, parentKey);

                    // Insert after the parent element
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

        // Attach change listeners to elements with class 'trigger-child'
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

        // Render only top-level items (modele_item_id == null)
        items.forEach((item, index) => {
            if (!item.modele_item_id) {
                const colSize = parseInt(item.cols || 2); // default to 2 if undefined

                if (!currentRow || currentRowCols + colSize > 12) {
                    // Start a new row
                    currentRow = document.createElement('div');
                    currentRow.classList.add('row', 'gx-3'); // you can add spacing like gx-3
                    formContainer.appendChild(currentRow);
                    currentRowCols = 0;
                }

                const formItem = renderFormItem(item, index);
                currentRow.appendChild(formItem);
                currentRowCols += colSize;
            }
        });

        // Attach listeners for dynamically added elements
        attachListeners();
    });

</script>
@endpush

