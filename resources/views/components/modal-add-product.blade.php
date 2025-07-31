<div class="modal fade" id="exampleModalgridproductproduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shto Produkt me Porosi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('departamentishitjes.product.store', $id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-xxl-12">
                            <!-- Row to hold selected tags (Hapsira + Categories) -->
                            <div class="row g-2 mt-2" id="selected-tags-row"></div>
                            <!-- Hapsira Selection Row -->
                            <div class="row g-2 mt-2" id="hapsira-select-container">
                                @foreach ($hapsirat as $hapsira)
                                    <div class="col-2 d-flex">
                                        <button type="button"
                                            class="btn btn-outline-primary w-100 hapsira-box"
                                            data-id="{{ $hapsira->id }}"
                                            data-name="{{ $hapsira->hapsira_category_name }}">
                                            {{ $hapsira->hapsira_category_name }}
                                            <hr>
                                            <h6 class="text-center mb-0">Hapsira</h6>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Container to hold category selection rows -->
                            <div id="categories-container-wrapper" class="mt-2"></div>

                                <div class="table-responsive" id="modeles-table-container" style="display:none;">
                                    <table id="model-datatables-modeles"
                                        class="table table-bordered nowrap table-striped align-middle model-datatables-modeles"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>{{ _lang('ID') }}</th>
                                                <th>{{ _lang('Foto') }}</th>
                                                <th>{{ _lang('Emri Produktit') }}</th>
                                                <th>{{ _lang('Hapsira') }}</th>
                                                <th>{{ _lang('Kategoria') }}</th>
                                                <th>{{ _lang('Modeli') }}</th>
                                                <th>{{ _lang('Moduli') }}</th>
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

                            <div id="form-preview-container" class="mt-4" style="display:none;"></div>
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
