<div class="modal fade" id="addMaterialModal3" tabindex="-1" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="addMaterialForm3" method="POST" action="{{ route('kostoisti.third.materiale.store',$id) }}">
            @csrf
            <div class="modal-header">
              <h5 class="modal-title" id="addMaterialModalLabel">Shto Material</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Mbyll"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="product_name" class="form-label">Cost Name</label>
                <input type="text" class="form-control" name="product_name" id="product_name">
              </div>
    
              <div class="mb-3">
                <label for="unit_id" class="form-label">Unit</label>
                <select class="form-select js-example-basic-single" name="unit_id" id="unit_id">
                  <option value="">Zgjidh Njesinë</option>
                  @foreach ($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                  @endforeach
                </select>
              </div>
              
    
              <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" step="0.01" name="quantity" id="quantity" required>
              </div>
    
              <div class="mb-3">
                <label for="cost" class="form-label">Cost</label>
                <input type="number" step="0.01" class="form-control" name="cost" id="cost">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Ruaj</button>
            </div>
          </form>
      </div>
    </div>
  </div>