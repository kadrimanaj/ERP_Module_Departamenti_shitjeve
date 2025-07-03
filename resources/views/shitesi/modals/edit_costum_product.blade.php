
<div class="modal fade" id="staticBackdropedit" tabindex="-1" aria-labelledby="editPartnerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartnerModalLabel">Edito Produktin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPartnerForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Company Name -->
                    <div class="col-12 mb-3">
                        <label for="file" class="form-label">Ndrysho dokument (jpg, png, pdf)</label>
                        <input type="file" class="form-control" name="product_file" id="file" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="company_name" class="form-label">Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="company_name" class="form-label">Pershkrim</label>
                        <textarea name="product_description" id="product_description" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                    {{-- <div class="col-12 mb-3">
                        <label for="product_status" class="form-label">Status</label>
                        <select name="product_status" id="product_status" class="form-select">
                            <option value="" disabled>Selekto</option>
                            <option value="Ne pritje">Ne pritje</option>
                            <option value="Konfirmuar">Konfirmuar</option>
                            <option value="Refuzuar">Refuzuar</option>
                        </select>                    
                    </div> --}}
                    <div class="col-12 mb-3">
                        <label for="company_name" class="form-label">Sasia</label>
                        <input type="number" name="product_quantity" id="product_quantity" class="form-control">
                    </div>
                </div>

                {{-- </div> --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>