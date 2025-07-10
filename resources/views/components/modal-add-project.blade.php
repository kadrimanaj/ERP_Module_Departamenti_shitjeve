<div class="modal fade" id="exampleModalgrid" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Shto Kerkese</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('departamentishitjes.shitesi.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-xxl-6">
                            <div>
                                <label for="firstName" class="form-label">Emri Projektit</label>
                                <input type="text" class="form-control" name="project_name" id="firstName" placeholder="Emri i Projektit">
                            </div>
                        </div><!--end col-->
                        
                        <div class="col-xxl-6">
                            <div>
                                <label for="lastName" class="form-label">Arkitekti</label>
                                <select class="js-example-basic-single" name="project_architect" id="lastName">
                                    <option value="">Zgjidh Arkitektin</option>
                                    @foreach ($workers as $worker)
                                        <option value="{{ $worker->id }}" 
                                            @if (Auth::id() == $worker->user_id) selected @endif>
                                            {{ $worker->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-4">
                            <div>
                                <div class="row">
                                    <div class="col-10">
                                        <label for="firstName" class="form-label">Klienti</label>
                                    </div>
                                    <div class="col-2 d-flex justify-content-end mb-1">
                                        <button class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalgrid3"> + </button>
                                    </div>
                                </div>

                                <select class="js-example-basic-single" name="project_client" id="clientSelect">
                                    <option value="" disabled>Zgjidh Klientin</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->contact_name }}</option>
                                    @endforeach
                                </select>


                            </div>
                        </div>
                        
                        <div class="col-xxl-4">
                            <div>
                                <label for="client_limit_date">Client Limit Date:</label>
                                <input class="form-control mt-1" type="date" id="client_limit_date" name="client_limit_date">
                            </div>
                        </div><!--end col-->
                        <div class="col-xxl-4">
                            <div>
                                <label for="lastName" class="form-label">Prioriteti</label>
                                <select class="form-control select mt-1" name="priority" required>
                                    <option disabled selected>Zgjidh</option>
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
                                <input class="form-check-input" type="checkbox" id="toggleTransportDetails">
                                <label class="form-check-label" for="toggleTransportDetails">Shto detaje rreth transportit</label>
                            </div>
                        
                            <!-- Hidden inputs -->
                            <div id="transportDetailsSection" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="rruga" class="form-label">Rruga</label>
                                        <textarea class="form-control" id="rruga" name="rruga" rows="1"></textarea>
                                    </div>
                                
                                    <div class="col-md-4 mb-3">
                                        <label for="qarku" class="form-label">Qarku</label>
                                        <input type="text" class="form-control" id="qarku" name="qarku">
                                    </div>
                                
                                    <div class="col-md-4 mb-3">
                                        <label for="bashkia" class="form-label">Bashkia</label>
                                        <input type="text" class="form-control" id="bashkia" name="bashkia">
                                    </div>
                                
                                    <div class="col-md-3 mb-3">
                                        <label for="tipologjia_objektit" class="form-label">Tipologjia e Objektit</label>
                                        <input type="text" class="form-control" id="tipologjia_objektit" name="tipologjia_objektit">
                                    </div>
                                
                                    <div class="col-md-3 mb-3">
                                        <label for="kate" class="form-label">Kate</label>
                                        <input type="text" class="form-control" id="kate" name="kate">
                                    </div>
                                
                                    <div class="col-md-3 mb-3">
                                        <label for="lift" class="form-label">Lift</label>
                                        <input type="text" class="form-control" id="lift" name="lift">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="orari_pritjes" class="form-label">Orari i pritjes</label>
                                        <input type="text" class="form-control" id="orari_pritjes" name="orari_pritjes">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="address_comment" class="form-label">Komente mbi adresën</label>
                                        <textarea class="form-control" id="address_comment" name="address_comment" rows="1" placeholder="Writte a comment..."></textarea>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        
                        <script>
                            document.getElementById('toggleTransportDetails').addEventListener('change', function () {
                                const section = document.getElementById('transportDetailsSection');
                                section.style.display = this.checked ? 'block' : 'none';
                            });
                        </script>
                        
                        <div class="col-xxl-12">
                            <div>
                                <label for="lastName" class="form-label">Koment mbi kerkesen</label>
                                <textarea class="form-control" name="project_description" id="" cols="30" rows="3" placeholder="Writte a comment..."></textarea>
                            </div>
                        </div><!--end col-->
                      
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </form>
            </div>
        </div>
    </div>
</div>