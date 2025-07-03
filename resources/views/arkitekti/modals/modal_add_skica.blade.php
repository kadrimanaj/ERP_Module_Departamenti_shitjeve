                <!-- Modal -->
                <div class="modal fade" id="skiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="skiceModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="skiceModalLabel">Shto Skicë</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('departamentishitjes.skicat.store',$id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="skiceName" class="form-label">Emri</label>
                                        <input type="text" class="form-control" id="skiceName" name="item_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="skiceDescription" class="form-label">Përshkrimi</label>
                                        <textarea class="form-control" id="skiceDescription" name="item_description" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="skiceFile" class="form-label">Ngarko Dokumentin</label>
                                        <input type="file" class="form-control" id="skiceFile" name="product_file" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Shto</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>