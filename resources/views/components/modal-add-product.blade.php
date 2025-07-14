<div class="modal fade" id="exampleModalgridproductproduct" tabindex="-1" aria-labelledby="exampleModalgridproductLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridproductLabel">Shto Produkt me Porosi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('departamentishitjes.product.store', $id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-xxl-3">
                            <div>
                                <label for="name" class="form-label">Emri Produktit</label>
                                <input type="text" class="form-control" name="product_name" id="name" placeholder="Emri i produktit">
                                <input type="hidden" class="form-control" name="product_type" id="product_type" value="custom">
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
                                <label for="product_quantity" class="form-label">Ngjyra</label>
                                <input type="text" class="form-control" name="color" id="color" placeholder="Color">
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div>
                                <label for="product_description" class="form-label">Komenti</label>
                                <textarea class="form-control" name="product_description" id="product_description" cols="30" rows="3" placeholder="Writte a comment..."></textarea>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div>
                                <label for="category_id" class="form-label">Kategoria</label>
                                <select class="form-select js-example-basic-single" name="category_id" id="category_id">
                                    <option value="" disabled selected>Zgjidh </option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" >
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-12">
                            <div>
                                <label for="file" class="form-label">Ngarko dokument (jpg, png, pdf)</label>
                                <input type="file" class="form-control" name="product_file" id="file" accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>