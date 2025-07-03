<div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <form id="addMaterialForm" method="POST" action="{{ route('kostoisti.first.materiale.store',$id) }}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="addMaterialModalLabel">Shto Material</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Mbyll"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-4 mb-3">
                  <label class="form-label">Select Category</label>
                  <select class="form-select select2 category-select"
                      data-url="{{ route('kostoisti.getProductsByCategory', ['id' => '__ID__']) }}"
                      data-target="product_id_first">
                      <option value="">Zgjidh</option>
                      <option value="all">All</option>
                      @foreach ($categories as $category)
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col-4 mb-3">
                  <label class="form-label">Select Product</label>
                  <select class="form-select select2" id="product_id_first" name="product_id">
                      <option value="">Zgjidh Produktin</option>
                  </select>
              </div>
              <div class="col-4 mb-3">
                  <label for="quantity_first" class="form-label">Quantity<span id="product_id_first_unitLabel"></span></label>
                  <input type="number" class="form-control" step="0.01" name="quantity" id="quantity_first" required>
              </div>
                <table id="product-details-table" class="table table-bordered mt-4" style="display: none;">
                  <thead>
                      <tr>
                        <th>Image</th>
                          <th>Product Name</th>
                          <th>Stock</th>
                          <th>Price</th>
                      </tr>
                  </thead>
                  <tbody id="product-details-body">
                      <!-- Filled dynamically -->
                  </tbody>
              </table>

            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Ruaj</button>
          </div>
        </form>
      </div>
    </div>
  </div> 