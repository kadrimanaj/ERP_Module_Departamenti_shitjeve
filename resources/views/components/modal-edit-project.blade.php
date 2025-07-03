<div class="modal fade" id="staticBackdropedit" tabindex="-1" aria-labelledby="editModalLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered">
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
                    <div class="row g-3">
                        <div class="col-xxl-12">
                            <label class="form-label">Emri Projektit</label>
                            <input type="text" class="form-control" name="project_name" id="edit_project_name">
                        </div>
                        <div class="col-xxl-12">
                            <label class="form-label">Klienti</label>
                            <select class="form-select js-example-basic-single" name="project_client" id="edit_project_client">
                                <option value="">Zgjidh Klientin</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->contact_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xxl-12">
                            <label class="form-label">Arkitekti</label>
                            <select class="form-select js-example-basic-single" name="project_architect" id="edit_project_architect">
                                <option value="">Zgjidh Arkitektin</option>
                                @foreach ($workers as $worker)
                                    <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xxl-12">
                            <label class="form-label">Komenti</label>
                            <textarea class="form-control" name="project_description" id="edit_project_description" rows="5"></textarea>
                        </div>
                        <div class="col-lg-12">
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