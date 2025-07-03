
<div class="modal fade" id="staticBackdropeditproductStatic" tabindex="-1" aria-labelledby="editPartnerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartnerModalLabel">Edito Produktin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPartnerForm2" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="col-12 mb-3">
                        <label for="company_name" class="form-label">Product Name</label>
                        <select name="product_name" id="product_name" class="form-select">
                            <option value="" disabled>Selekto</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->product_id }}">{{ product_name($product->product_id) }} </option>
                            @endforeach
                        </select>  
                    </div>
                    <div class="col-12 mb-3">
                        <label for="company_name" class="form-label">Pershkrim</label>
                        <textarea name="product_description" id="product_description" cols="30" rows="3" class="form-control"></textarea>
                    </div>
     
                    <div class="col-12 mb-3">
                        <label for="company_name" class="form-label">Sasia</label>
                        <input type="number" name="product_quantity" id="product_quantity" class="form-control">
                    </div>
                </div>

                <input type="hidden" name="product_status" value="Ne pritje" class="form-control">

                {{-- </div> --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>