<div class="modal fade" id="staticBackdropedit" tabindex="-1" aria-labelledby="editModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ndrysho Kerkesen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                        <input type="hidden" name="id" id="edit_id">
                        <div class="row">

                        <div class="col-6 mb-2">
                            <div>
                                <label for="firstName" class="form-label">Emri Projektit</label>
                                <input type="text" class="form-control"  name="project_name" id="edit_project_name" placeholder="Emri i Projektit">
                            </div>
                        </div><!--end col-->
                        <div class="col-6">
                            <label class="form-label">Arkitekti</label>
                            <select class="form-select js-example-basic-single" name="project_architect" id="edit_project_architect">
                                <option disabled>Zgjidh Arkitektin</option>
                                @foreach ($workers as $worker)
                                    <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Klienti</label>
                            <select class="form-select js-example-basic-single" name="project_client" id="edit_project_client">
                                <option disabled>Zgjidh Klientin</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->contact_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        
                        <div class="col-4">
                            <div>
                                <label for="client_limit_date">Client Limit Date:</label>
                                <input class="form-control mt-1" type="date" id="edit_client_limit_date" name="client_limit_date">
                            </div>
                        </div><!--end col-->
                        <div class="col-4">
                            <div>
                                <label for="lastName" class="form-label">Prioriteti</label>
                                <select class="form-select js-example-basic-single" id="edit_priority" name="priority" required>
                                    <option disabled >Zgjidh</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="hight">Hight</option>
                                    <option value="extremly important">extremly important</option>
                                </select>
                            </div>
                        </div><!--end col-->

                        <div class="col-xxl-12">
                            <!-- Switch -->
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="toggleTransportDetailsEdit">
                                <label class="form-check-label" for="toggleTransportDetailsEdit">Perditeso detaje rreth transportit</label>
                            </div>
                        
                            <!-- Hidden inputs -->
                            <div id="toggleTratransportDetailsSectionEditnsportDetailsEdit" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="rruga" class="form-label">Rruga</label>
                                        <textarea class="form-control" id="edit_rruga" name="rruga" rows="1"></textarea>
                                    </div>
                                
                                    <div class="col-md-4 mb-3">
                                        <label for="qarku" class="form-label">Qarku</label>
                                        <input type="text" class="form-control" id="edit_qarku" name="qarku">
                                    </div>
                                
                                    <div class="col-md-4 mb-3">
                                        <label for="bashkia" class="form-label">Bashkia</label>
                                        <input type="text" class="form-control" id="edit_bashkia" name="bashkia">
                                    </div>
                                
                                    <div class="col-md-3 mb-3">
                                        <label for="tipologjia_objektit" class="form-label">Tipologjia e Objektit</label>
                                        <input type="text" class="form-control" id="edit_tipologjia_objektit" name="tipologjia_objektit">
                                    </div>
                                
                                    <div class="col-md-3 mb-3">
                                        <label for="kate" class="form-label">Kate</label>
                                        <input type="text" class="form-control" id="edit_kate" name="kate">
                                    </div>
                                
                                    <div class="col-md-3 mb-3">
                                        <label for="lift" class="form-label">Lift</label>
                                        <input type="text" class="form-control" id="edit_lift" name="lift">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="orari_pritjes" class="form-label">Orari i pritjes</label>
                                        <input type="text" class="form-control" id="edit_orari_pritjes" name="orari_pritjes">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="address_comment" class="form-label">Komente mbi adresën</label>
                                        <textarea class="form-control" id="edit_address_comment" name="address_comment" rows="1" placeholder="Writte a comment..."></textarea>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        
                        <script>
                            document.getElementById('toggleTransportDetailsEdit').addEventListener('change', function () {
                                const section = document.getElementById('toggleTratransportDetailsSectionEditnsportDetailsEdit');
                                section.style.display = this.checked ? 'block' : 'none';
                            });
                        </script>
                        
                        <div class="col-xxl-12">
                            <div>
                                <label for="lastName" class="form-label">Koment mbi kerkesen</label>
                                <textarea class="form-control" name="project_description" id="edit_project_description" cols="30" rows="3" placeholder="Writte a comment..."></textarea>
                            </div>
                        </div><!--end col-->

                        <div class="col-lg-12 mt-3">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Ruaj Ndryshimet</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>








