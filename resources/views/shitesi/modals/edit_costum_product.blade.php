<div class="modal fade" id="staticBackdropedit" tabindex="-1" aria-labelledby="editPartnerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Make it larger like the add modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartnerModalLabel">Edito Produktin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPartnerForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-xxl-3">
                            <div>
                                <label for="product_name" class="form-label">Emri Produktit</label>
                                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Emri i produktit">
                            </div>
                        </div>
                        <div class="col-xxl-3">
                            <div>
                                <label for="product_quantity" class="form-label">Sasia</label>
                                <input type="number" class="form-control" name="product_quantity" id="product_quantity" placeholder="Sasia">
                            </div>
                        </div>
                        <div class="col-xxl-3">
                            <div>
                                <label for="dimension" class="form-label">Permasat</label>
                                <input type="text" class="form-control" name="dimension" id="dimension" placeholder="Permasat">
                            </div>
                        </div>
                        <div class="col-xxl-3">
                            <div>
                                <label for="color" class="form-label">Ngjyra</label>
                                <input type="text" class="form-control" name="color" id="color" placeholder="Ngjyra">
                            </div>
                        </div>

                        <div class="col-xxl-12">
                            <div>
                                <label for="product_description" class="form-label">Pershkrimi</label>
                                <textarea class="form-control" name="product_description" id="product_description" cols="30" rows="3" placeholder="Shkruani komentin..."></textarea>
                            </div>
                        </div>

                        <div class="col-xxl-12">
                            <div>
                                <label for="category_id" class="form-label">Kategoria</label>
                                <select class="form-select js-example-basic-single" name="category_id" id="category_id">
                                    <option value="" disabled selected>Zgjidh </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xxl-12">
                            <div>
                                <label for="file" class="form-label">Ndrysho dokument (jpg, png, pdf)</label>
                                <input type="file" class="form-control" name="product_file" id="file" accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Ruaj Ndryshimet</button>
                </div>
            </form>
        </div>
    </div>
</div>
