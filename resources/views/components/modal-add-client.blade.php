<div class="modal fade" id="exampleModalgrid3" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel3">Shto Klient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" class="validate" autocomplete="off" action="{{ route('partners.store') }}"
                enctype="multipart/form-data">
                @csrf
    <hr>
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="card mt-xxl-n5">
                            <div class="card-body p-4">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('Profile Type') }}</label>
                                                    <select class="form-control select2" name="profile_type" id="profile_type"
                                                        required>
                                                        <option value="c" {{ request()->has('client') ? 'selected' : '' }}>
                                                            {{ _lang('Client') }}</option>
                                                        <option value="s" {{ request()->has('supplier') ? 'selected' : '' }}>
                                                            {{ _lang('Supplier') }}</option>
                                                        <option value="cs">{{ _lang('Client and Supplier') }}</option>
                                                    </select>
                                                </div>
                                            </div>
        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('Partner Type') }}</label>
                                                    <select class="form-control select2" name="partner_type" required>
                                                        <option value="i">{{ _lang('Individual') }}</option>
                                                        <option value="b">{{ _lang('Business') }}</option>
                                                    </select>
                                                </div>
                                            </div>
        
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('Company Name') }}</label>
                                                    <input type="text" class="form-control" name="company_name"
                                                        id="company_name" value="{{ old('company_name') }}"
                                                        placeholder="Enter company name">
                                                </div>
                                            </div>
        
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('NIPT') }}</label>
                                                    <input type="text" class="form-control" name="nipt"
                                                        value="{{ old('nipt') }}" placeholder="Enter NIPT">
                                                </div>
                                            </div>
        
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('Name') }}</label>
                                                    <input type="text" class="form-control" name="contact_name"
                                                        value="{{ old('contact_name') }}" required placeholder="Enter full name">
                                                </div>
                                            </div>
        
                                            <div class="{{ isModuleEnabled('DentalClinic') ? 'col-md-4' : 'col-md-6' }}">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('Email') }}</label>
                                                    <input type="text" class="form-control" name="contact_email"
                                                        value="{{ old('contact_email') }}" placeholder="Enter email address">
                                                </div>
                                            </div>
        
                                            <div class="{{ isModuleEnabled('DentalClinic') ? 'col-md-4' : 'col-md-6' }}">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('Phone') }}</label>
                                                    <input type="text" class="form-control" name="contact_phone"
                                                        value="{{ old('contact_phone') }}" placeholder="Enter phone number">
                                                </div>
                                            </div>
        
                                            @if (isModuleEnabled('DentalClinic'))
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">{{ _lang('Birthday') }}</label>
                                                        <input type="date" class="form-control" name="birthday"
                                                            value="{{ old('birthday') }}">
                                                    </div>
                                                </div>
                                            @endif
        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('Group') }}</label>
                                                    <select class="form-control select2" name="group_id">
                                                        <option value="" selected disabled>{{ _lang('Choose') }}
                                                        </option>
                                                        {{ create_option('contact_groups', 'id', 'name', old('group_id'), ['company_id=' => company_id()]) }}
                                                    </select>
                                                </div>
                                            </div>
        
        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('Country') }}</label>
                                                    <select class="form-control select2" name="country">
                                                        {{ get_country_list(old('country')) }}
                                                    </select>
                                                </div>
                                            </div>
        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('City') }}</label>
                                                    <input type="text" class="form-control" name="city"
                                                        value="{{ old('city') }}" placeholder="Enter city">
                                                </div>
                                            </div>
        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('State') }}</label>
                                                    <input type="text" class="form-control" name="state"
                                                        value="{{ old('state') }}" placeholder="Enter state">
                                                </div>
                                            </div>
        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('Zip') }}</label>
                                                    <input type="text" class="form-control" name="zip"
                                                        value="{{ old('zip') }}" placeholder="Enter zip code">
                                                </div>
                                            </div>
        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('Address') }}</label>
                                                    <textarea class="form-control" name="address" placeholder="Enter address">{{ old('address') }}</textarea>
                                                </div>
                                            </div>
        
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{ _lang('Comment') }}</label>
                                                    <textarea class="form-control" name="remarks" placeholder="Type any comment...">{{ old('remarks') }}</textarea>
                                                </div>
                                            </div>
        
                                            <div class="col-md-12 mt-4 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-success btn"><i class="ti-save-alt"></i>
                                                    {{ _lang('Save Contact') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>