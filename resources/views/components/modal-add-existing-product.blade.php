<style>
    .modal-custom-size {
        max-width: 85% !important;
        /* or 100% */
        width: auto;
    }
</style>

<div class="modal fade" id="exampleModalgridproductproduct2" tabindex="-1" aria-labelledby="exampleModalgridproductLabel"
    aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-xl  modal-custom-size">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridproductLabel">Shto Produkt</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('departamentishitjes.product.store', $id) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="model-datatables-products"
                                    class="table table-bordered nowrap table-striped align-middle model-datatables-products"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>{{ _lang('ID') }}</th>
                                            <th>{{ _lang('Foto') }}</th>
                                            <th>{{ _lang('Emri Produktit') }}</th>
                                            <th>{{ _lang('Kategoria') }}</th>
                                            <th>{{ _lang('Sasia') }}</th>
                                            <th>{{ _lang('Cmimi') }}</th>
                                            <th>
                                                <center>{{ _lang('Actions') }}</center>
                                            </th>
                                        </tr>

                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-center">
                                <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Perfundo</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
