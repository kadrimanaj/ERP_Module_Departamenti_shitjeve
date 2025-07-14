<div class="modal fade" id="addMaterialModal2" tabindex="-1" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <form id="addMaterialForm2" method="POST" action="{{ route('kostoisti.second.materiale.store',$id) }}">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="addMaterialModalLabel">Shto Material</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Mbyll"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-4 mb-3">
                  <label class="form-label">Select Category</label>
                  <select class="form-select js-example-basic-single category-select" id="category_id_ndihmese"
                      data-url="{{ route('kostoisti.getProductsByCategory', ['id' => '__ID__']) }}"
                      data-target="product_id_ndihmese">
                      <option value="" selected disabled>Zgjidh</option>
                      <option value="all">All</option>
                      @foreach ($categories as $category)
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col-4 mb-3">
                  <label class="form-label">Select Product</label>
                  <select class="form-select js-example-basic-single" id="product_id_ndihmese" name="product_id">
                      <option value="" selected disabled>Zgjidh Produktin</option>
                  </select>
              </div>

              <div class="col-4 mb-3">
                  <label for="quantity_ndihmese" class="form-label">Quantity<span id="product_id_ndihmese_unitLabel"></span></label>
                  <input type="number" class="form-control" step="0.01" name="quantity" id="quantity_ndihmese" required>
              </div>

             <table id="product-details-table2" class="table table-bordered mt-4" style="display: none;">
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

