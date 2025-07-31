
        @php
            $key = 0;
            $items = $form->items->where('model_id', $form->id)->whereNull('modele_item_id') ?? collect();
            // dd($items);
        @endphp

       <div class="card p-4 border">
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
