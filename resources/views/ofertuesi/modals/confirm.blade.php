                                        <form method="POST" action="{{ route('offer.confirm',$id) }}" class="modal-content" style="border-radius:10px; border:none; box-shadow: 0 0 20px rgb(0 0 0 / 0.2);">
                                             @csrf
                                            <div class="modal fade" id="confirmOfferModal" tabindex="-1" aria-labelledby="confirmOfferModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
                                                    <div class="modal-content" style="border-radius:10px; border:none; box-shadow: 0 0 20px rgb(0 0 0 / 0.2);">
                                                        <div class="modal-header justify-content-center" style="border-bottom:none; padding-top:1.5rem; padding-bottom:0;">
                                                            <i class="ri-alert-line" style="font-size: 3.5rem; color: #f8bb86;"></i>
                                                        </div>
                                                        <div class="modal-body text-center" style="padding: 0 2rem 1.5rem;">
                                                            <h4 style="font-weight:600; color:#444;">Jeni të sigurt?</h4>
                                                            <p style="color:#666; font-size:1rem; margin-top:0.25rem; margin-bottom:1rem;">
                                                                Ky veprim është i pakthyeshëm!
                                                            </p>
                                                        </div>

                                                        <div class="modal-footer justify-content-center" style="border-top:none; padding-bottom:1.5rem; gap:1rem;">

                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" style="background-color:#d33; border:none; font-weight:600; padding:0.5rem 1.5rem; border-radius:4px; min-width:100px;">
                                                                Anullo
                                                            </button>

                                                            <button type="submit" class="btn btn-primary btn-sm" style="background-color:#3085d6; border:none; font-weight:600; padding:0.5rem 1.5rem; border-radius:4px; min-width:100px;">
                                                                Po, konfirmo oferten!
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>