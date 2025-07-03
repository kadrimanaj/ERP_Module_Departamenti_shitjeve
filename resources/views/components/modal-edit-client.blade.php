<!-- Modal for Editing Partner -->
<div class="modal fade" id="editPartnerModal" tabindex="-1" aria-labelledby="editPartnerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartnerModalLabel">Edit Partner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPartnerForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Profile Type -->
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="profile_type" class="form-label">Profile Type</label>
                                <select name="profile_type" id="profile_type" class="form-select select2">
                                    <option value="c">Client</option>
                                    <option value="s">Supplier</option>
                                    <option value="cs">Client and Supplier</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Partner Type -->
                            <div class="mb-3">
                                <label for="partner_type" class="form-label">Partner Type</label>
                                <select name="partner_type" class="form-select select2">
                                    <option value="">Select Partner Type</option>
                                    <option value="i">{{ _lang('Individual') }}</option>
                                    <option value="b">{{ _lang('Business') }}</option>
                                </select>
                            </div>
                        </div>




                    <!-- Company Name -->
                    <div class="col-4 mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-control">
                    </div>

                    <!-- Nipt -->
                    <div class="col-4 mb-3">
                        <label for="nipt" class="form-label">NIPT</label>
                        <input type="text" name="nipt" id="nipt" class="form-control">
                    </div>

                    <!-- Contact Name -->
                    <div class="col-4 mb-3">
                        <label for="contact_name" class="form-label">Contact Name</label>
                        <input type="text" name="contact_name" id="contact_name" class="form-control">
                    </div>

                    <!-- Contact Email -->
                    <div class="col-6 mb-3">
                        <label for="contact_email" class="form-label">Contact Email</label>
                        <input type="email" name="contact_email" id="contact_email" class="form-control">
                    </div>

                    <!-- Contact Phone -->
                    <div class="col-6 mb-3">
                        <label for="contact_phone" class="form-label">Contact Phone</label>
                        <input type="text" name="contact_phone" id="contact_phone" class="form-control">
                    </div>

                    <!-- Group ID -->
                    <div class="col-6 mb-3">
                        <label for="group_id" class="form-label">Group</label>
                        <select name="group_id" class="form-select select2">
                            <option value="">Select Group</option>
                            <!-- Populate groups here -->
                        </select>
                    </div>

                    <!-- Country -->
                    <div class="col-6 mb-3">
                        <label for="country" class="form-label">Country</label>
                        <select name="country" class="form-select select2">
                            {{ get_country_list(old('country')) }}

                        </select>
                    </div>

                    <!-- City -->
                    <div class="col-6 mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" name="city" id="city" class="form-control">
                    </div>

                    <!-- State -->
                    <div class="col-6 mb-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text" name="state" id="state" class="form-control">
                    </div>

                    <!-- ZIP -->
                    <div class="col-6 mb-3">
                        <label for="zip" class="form-label">ZIP</label>
                        <input type="text" name="zip" id="zip" class="form-control">
                    </div>

                    <!-- Address -->
                    <div class="col-6 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Remarks -->
                    <div class="col-12 mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
