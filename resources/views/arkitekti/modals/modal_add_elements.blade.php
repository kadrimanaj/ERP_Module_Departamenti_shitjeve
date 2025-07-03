<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Shto Specifim Teknik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('departamentishitjes.elements.store',$id) }}" method="POST">
                    @csrf
                <div class="mb-3">
                    <label for="skiceName" class="form-label">Emri</label>
                    <input type="text" class="form-control" placeholder="Emri" name="item_name" required>
                </div>
                <div class="mb-3">
                    <label for="item_dimensions" class="form-label">Permasat</label>
                    <input type="text" class="form-control" placeholder="Permasat" name="item_dimensions" required>
                </div>
                <div class="mb-3">
                    <label for="skiceName" class="form-label">Sasia</label>
                    <input type="number" class="form-control" placeholder="Sasia" name="item_quantity" required>
                </div>
                <div class="mb-3">
                    <label for="skiceName" class="form-label">Pershkrimi</label>
                    <textarea class="form-control" placeholder="Pershkrimi" name="item_description"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Shto</button>
            </div>
            </form>
        </div>
    </div>
</div>