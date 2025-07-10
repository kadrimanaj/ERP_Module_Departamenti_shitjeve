@php
    $doctors = Modules\HR\Models\Workers::all();
    // $labs = App\Models\Lab::all();
    $pacients = App\Models\Partners::all();
    // $workPlans = Modules\DentalManager\Models\DentalClinicWorkPlan::orderby('created_at', 'desc');
    if(isset($contact)){
        $workPlans = App\Models\Partners::all();
    }else{
        $workPlans = App\Models\Partners::all();
    }
    $services = App\Models\ProductForWarehouse::join('products', 'products.id', 'product_for_warehouses.product_id')
        ->select('product_for_warehouses.id as id', 'products.name as name')
        ->get();
    // $services = App\Products::orderby('created_at', 'desc')->get();
    // dd($services);
    // $clinics = App\Models\Clinic::all();
    $rooms = App\Models\Partners::all();
@endphp
<div class="modal fade event-sidebar" tabindex="-1" id="addEventSidebar" aria-labelledby="addEventSidebarLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header my-1">
                <h5 class="modal-title offcanvas-title" id="offcanvas-title">{{ _lang('Add Meeting') }}</h5>
                <button type="button" class="btn btn-close text-reset" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <form class="event-form pt-0" id="eventForm">

                    <div class="mb-3">
                        <label class="form-label" for="eventTitle">{{ _lang('Title') }}</label>
                        <input type="text" class="form-control" id="eventTitle" name="eventTitle"
                            value="Takim me Klientin" placeholder="Event Title" required />
                        <span class="text-danger" id="error-title"></span>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label" for="client_type">{{ _lang('Client Type') }}<span
                                    style="color: red;">*</span></label>
                            <select class="js-example-basic-single form-select" id="client_type" name="client_type"  {{ isset($contact)  ? 'disabled' : '' }}
                                required>
                                <option data-label="primary" selected value="">Select</option>


                                <option data-label="primary" value="new_client">Klient i ri
                                </option>
                                <option data-label="primary"
                                {{ isset($contact)  ? 'selected' : '' }}
                                    value="existing_client">Klient Ekzistues
                                </option>
                            </select>
                            <span class="text-danger" id="error-client_type"></span>
                        </div>
                        <div class="col-6 mb-3 row" id="new_client" style="display: none;">

                            <div class="col-6">
                                <label class="form-label" for="pacient_name">{{ _lang('Name') }} <span
                                        style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="pacient_name" name="pacient_name"
                                    aria-label="John Doe" />
                                <span class="text-danger" id="error-pacient_name"></span>

                            </div>

                            <div class="col-6">
                                <label class="form-label" for="pacient_contact">{{ _lang('Contact') }}<span
                                        style="color: red;">*</span></label>
                                <input type="text" id="pacient_contact" class="form-control phone-mask"
                                    value="+355" placeholder="+355" aria-label="leads@dms.com"
                                    name="pacient_contact" />
                                <span class="text-danger" id="error-pacient_contact"></span>
                            </div>

                        </div>
                        <div class="col-6 mb-3" id="existing_client" style="display: none;">
                            <div class=" mb-3 select2-primary">
                                <label class="form-label" for="">{{ _lang('Klienti') }}</label>
                                <select class="js-example-basic-single form-select" id="pacient_id" name="pacient_id"   >
                                    <option data-label="primary" value="">Select</option>

                                    @foreach ($pacients as $pacient)
                                        <option data-label="primary" value="{{ $pacient->id }}"
                                            @isset($contact)
                                          
                                             {{ (isset($contact) && $contact->id == $pacient->id) ? 'selected' : '' }}
                                                    @endisset>
                                            {{ $pacient->contact_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="error-pacient_id"></span>
                            </div>

                        </div>
                    </div>
                    <div id="primary_visit_container">
                        <div class=" mb-3 select2-primary">
                            <label class="form-label"for="primary_visit">
                                <input type="checkbox" checked id="primary_visit" value="1">
                                Vizite Fillestare</label>
                        </div>
                    </div>
                    <div class="mb-3" id="work_plan_container">
                        <label class="form-label" for="work_plan_id">{{ _lang('Work Plan') }}<span
                                style="color: red;">*</span></label>
                        <select class="js-example-basic-single  form-select" id="work_plan_id" name="work_plan_id">
                            <option data-label="primary" value="">Select</option>
                            @foreach ($workPlans as $workPlan)
                                <option data-label="primary" value="{{ $workPlan->id }}">
                                    {{ $workPlan->wp_name }}-
                                    ({{ Carbon\Carbon::parse($workPlan->created_at)->format('d-m-y') }})
                                </option>
                            @endforeach

                        </select>
                    </div>
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label class="form-label" for="eventStartDate">{{ _lang('Start Date') }}<span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="eventStartDate" name="eventStartDate"
                                placeholder="Start Date" />
                            <span class="text-danger" id="error-start"></span>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label" for="timeline">{{ _lang('Kohezgjatja min') }}<span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="timeline" name="timeline"
                                placeholder="30" />

                        </div>

                        <div class="col-4 mb-3">
                            <label class="form-label" for="eventEndDate">{{ _lang('End Date') }}<span
                                    style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="eventEndDate" name="eventEndDate"
                                placeholder="End Date" />
                            <span class="text-danger" id="error-end"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="product_id">{{ _lang('Sherbimi') }}<span
                                    style="color: red;">*</span></label>
                            <select class="js-example-basic-single form-select js-example-basic-multiple" multiple
                                id="product_id" name="product_id[]">
                                <option data-label="primary" value="">Select</option>
                                @foreach ($services as $service)
                                    <option data-label="primary" data-name="{{ $service->name }}"
                                        data-price="{{ $service->price }}" value="{{ $service->id }}">
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>

                            <span class="text-danger" id="error-product_id"></span>
                        </div>
                        {{-- <div class="col-sm-6 pe-2 ps-0 ps-sm-2 mt-4">

                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#offcanvasAddServiceProcess">+</button>
                        </div> --}}
                        <div class="col-6 mb-3">
                            <label class="form-label" for="doctor_id">{{ _lang('Arkitekti') }}<span
                                    style="color: red;">*</span></label>
                            <select class="js-example-basic-single form-select" id="doctor_id" value=""
                                name="doctor_id">
                                <option data-label="primary">Select</option>

                                @foreach ($doctors as $key => $doctor)
                                    <option @if (count($doctors) == 1) selected @endif data-label="primary"
                                        value="{{ $doctor->id }}">
                                        {{ $doctor->name }}-{{ $doctor->title }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="error-doctor_id"></span>
                        </div>
                        <div class=" col-6 mb-3">
                            <label class="form-label" for="room_id">{{ _lang('Vendndodhja') }}<span
                                    style="color: red;">*</span></label>
                            <select class="js-example-basic-single form-select" id="room_id" name="room_id">
                                <option data-label="primary" selected value="0">Select</option>

                                @foreach ($rooms as $room)
                                    <option data-label="primary" value="{{ $room->id }}">
                                        {{ $room->room_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="error-room_id"></span>
                        </div>
                    </div>
                    <div class="mb-3" style="display: none;">
                        <label class="form-label" for="lab_id">{{ _lang('Laboratori') }}</label>
                        <select class="js-example-basic-single form-select" id="lab_id" name="lab_id">
                            <option data-label="primary" selected value="">Select</option>

                            {{-- @foreach ($labs as $lab)
                                <option data-label="primary" value="{{ $lab->id }}">{{ $lab->lab_name }}
                                </option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="eventDescription">{{ _lang('Description') }}</label>
                        <textarea class="form-control" name="eventDescription" id="eventDescription"></textarea>
                        <span class="text-danger" id="error-description"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="eventReminder">{{ _lang('Reminder(hour)') }}</label>
                        <input class="form-control w-25" name="eventReminder" type="number"
                            id="eventReminder"></input>
                        <span class="text-danger" id="error-reminder"></span>

                    </div>
                    <div class="mb-3 d-flex justify-content-sm-between justify-content-start my-4">
                        <div>
                            <button id="add-meetingButton" type="submit"
                                class="btn btn-primary btn-add-event me-sm-3 me-1">{{ _lang('Add') }}</button>
                            <button type="reset" class="btn btn-label-secondary btn-cancel me-sm-0 me-1"
                                data-bs-dismiss="modal">{{ _lang('Cancel') }}</button>
                        </div>
                        <div>
                            <button
                                class="btn btn-label-danger btn-delete-event d-none">{{ _lang('Delete') }}</button>
                        </div>
                        <div>
                            <button id="btn-preventiv" type="submit"
                                class="btn btn-label-danger btn-preventiv  btn-secondary">{{ _lang('Preview invoice') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {


        // Function to toggle the Work Plan visibility
        function toggleWorkPlan() {
            if ($('#primary_visit').is(':checked')) {
                // Hide the Work Plan container
                $('#work_plan_container').hide();
            } else {
                // Show the Work Plan container
                $('#work_plan_container').show();
            }
        }

        // Initial toggle on page load
        toggleWorkPlan();

        // Event listener for checkbox state change
        $('#primary_visit').change(function() {
            toggleWorkPlan();
        });
    });

    $(document).ready(function() {
        // Add an event listener to the select element
        $('#client_type').change(function() {
            // Get the selected option value
            var selectedOption = $(this).val();
            console.log(selectedOption);

            // console.log(city);
            // Check if the selected option is 'Vizite qyteti'
            if (selectedOption === 'new_client') {
                $('#new_client').closest('.mb-3').show();
                $('#existing_client').closest('.mb-3').hide();
                $('#work_plan_container').hide();
                $('#primary_visit').prop('checked', true);


            } else if (selectedOption === 'existing_client') {
                $('#existing_client').closest('.mb-3').show();
                $('#new_client').closest('.mb-3').hide();
                $('#work_plan_container').show();
                $('#primary_visit').prop('checked', false);

            }
            // Add more conditions as needed

        });

        // Trigger change event on page load to handle default selection
        $('#client_type').trigger('change');
    });

    function populateWorkPlans(workPlans, selectedWorkPlanId) {
        var $workPlanSelect = $('#work_plan_id');
        $workPlanSelect.empty(); // Clear existing options

        // Add default 'Select' option
        $workPlanSelect.append('<option value="">Select</option>');

        // Iterate through the workPlans and append options
        $.each(workPlans, function(index, workPlan) {
            var selected = (workPlan.id === selectedWorkPlanId) ? 'selected' : '';
            $workPlanSelect.append(
                $('<option>', {
                    value: workPlan.id,
                    text: workPlan.wp_name,
                    selected: selected
                })
            );
        });

        // If you're using Select2 or similar plugins, you might need to trigger an update
        $workPlanSelect.trigger('change');
    }

    // Function to clear patient info fields
    function clearPatientInfo() {
        $('#work_plan_id').empty().append('<option value="">Select</option>').trigger('change');
        $('#lab_id').val('').trigger('change');
        $('#doctor_id').val('').trigger('change');
        $('#room_id').val('').trigger('change');
    }

    // Trigger change event on page load to handle default selection if any


</script>
