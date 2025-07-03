<div class="modal fade" id="staticBackdropedit2" tabindex="-1" aria-labelledby="editPartnerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
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
                        <label for="company_name" class="form-label">Ndrysho Dokumentin</label>
                        <input type="file" name="product_file" id="product_file" class="form-control">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="company_name" class="form-label">Emri</label>
                        <input type="text" name="item_name" id="item_name" class="form-control">
                    </div>

                    <div class="col-12 mb-3">
                        <label for="company_name" class="form-label">Pershkrim</label>
                        <textarea name="item_description" id="item_description" cols="30" rows="3" class="form-control"></textarea>
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