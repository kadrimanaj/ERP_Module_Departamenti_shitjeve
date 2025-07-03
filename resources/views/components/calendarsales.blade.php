@props([
    'id' => null,
    'ajaxUrl' => null,
    'headers' => [],
    'columns' => [],
    'modalType' => null,
    'addModal' => null,
    'editModal' => null,
    'addnewTarget' => null,
    'tableName' => null,
    'filterNames' => null,
    'linkTarget' => null,
    'action' => null,
    'addDownload' => null,
    'downloadLink' => null,
    'notification' => false,
    'view' => null,
])
<style>
    .fc-event {
        height: 70px;
        /* Adjust the height as needed */
        width: 200px;
    }

    .color-menu {
        border: 1px solid #ddd;
        padding: 10px;
        background-color: #fff;
        z-index: 1000;
    }

    .color-menu ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 10px;
    }

    .color-menu ul li {
        width: 30px;
        height: 30px;
        cursor: pointer;
        border-radius: 50%;
    }
</style>




<div class="col-xl-12">
    <div class="row">
        <div class="col-xl-3">
            <div class="card card-h-100">
                <div class="card-body">
                    @if ($addnewTarget)
                        <button class="btn btn-primary w-100" id="btn-new-event" data-bs-toggle="{{ $modalType }}"
                            data-bs-target="#{{ $addModal }}" aria-controls="addEventSidebar-{{ $id }}">
                            {{-- <i class="ti ti-plus me-1"></i> --}}
                            <i class="mdi mdi-plus"></i>{{ $addnewTarget }}
                        </button>
                    @endif

                    
                    @if ($filterNames)
                        <!-- Filter -->
                        <div class="mb-3 ms-3 mt-4">
                            <h4 class="text-small text-muted text-uppercase align-middle">Filter</h4>
                        </div>

                        <div class="form-check mb-2 ms-3">
                            <input class="form-check-input select-all" type="checkbox"
                                id="selectAll-{{ $id }}" data-value="all" checked>
                            <label class="form-check-label" for="selectAll-{{ $id }}">View All</label>
                        </div>

                        <div class="app-calendar-events-filter ms-3">
                            @foreach ($filterNames as $item)
                                <div class="card">
                                    <div class="card-body bg-{{ $item['color'] }}-subtle">


                                        <div class="form-check mb-2" style="color: {{ $item['color'] }};">
                                            <input class="form-check-input input-filter-{{ $id }} "
                                                type="checkbox" id="select-{{ $item['name'] }}-{{ $id }}"
                                                data-value="{{ $item['key'] }}" checked
                                                style="color: {{ $item['color'] }};"> <!-- Dynamic border color -->

                                            <label class="form-check-label text-{{ $item['color'] }}"
                                                for="select-{{ $item['name'] }}-{{ $id }}"
                                                style="color: {{ $item['color'] }};">
                                                <span
                                                    class="text-{{ $item['color'] }}-subtle">{{ $item['name'] }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        
        </div>
        <div class="col-xl-9 col-12">
            <div class="card card-h-100">
                <div class="card-body">
                    <div id="{{ $id }}"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script>
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        (function() {
            const id = "{{ $id }}";
            const view = "{{ $view }}";
            const modalAdd = "{{ $addModal }}";

            const calendarEl = document.getElementById(id);
            // const appCalendarSidebar = document.querySelector('#app-calendar-sidebar-' + id);
            const addEventSidebar = document.getElementById('addEventSidebar');
            const appOverlay = document.querySelector('.app-overlay');
            const offcanvasTitle = document.querySelector('.offcanvas-title');
            // const btnToggleSidebar = document.querySelector('.btn-toggle-sidebar');
            const btnSubmit = document.querySelector('#add-meetingButton');
            const btnDeleteEvent = document.querySelector('.btn-delete-event');


            // const btnCancel = document.querySelector('.btn-cancel');
            const btnGeneratePreventiv = document.querySelector('#btn-preventiv');

            // const eventTitle = document.querySelector('#eventTitle');
            const eventStartDate = document.querySelector('#eventStartDate');
            const eventEndDate = document.querySelector('#eventEndDate');
            // const eventUrl = document.querySelector('#eventURL');
            // const eventLocation = document.querySelector('#eventLocation');
            const eventDescription = document.querySelector('#eventDescription');
            const eventPacient = document.querySelector('#pacient_id');

            const clientType = document.querySelector('#client_type');
            const primaryVisit = document.querySelector('#primary_visit');
            const pacientName = document.querySelector('#pacient_name');
            const pacientContact = document.querySelector('#pacient_contact');
            // console.log(eventPacient);
            // const eventClinic = document.querySelector('#clinic_id');
            const eventPhase = document.querySelector('#work_plan_id');
            // const eventService = document.querySelector('#product_id');
            const selectedTreatments = [];
            // document.querySelector('#product_id').addEventListener('change', () => {
            //     const selectedTreatments = [];
            //     const eventService = document.querySelectorAll('#product_id option:checked');
            //     eventService.forEach((option) => {
            //         selectedTreatments.push({
            //             id: option.value,
            //             name: option.dataset
            //                 .name, // ensure these data attributes exist
            //             price: option.dataset.price,
            //             qty: 1

            //         });
            //     });
            //     console.log(selectedTreatments, 'eventService');
            // });

            const eventDoctor = document.querySelector('#doctor_id');
            const eventRoom = document.querySelector('#room_id');
            const eventLab = document.querySelector('#lab_id');
            const eventReminder = document.querySelector('#eventReminder');
            const eventForm = document.getElementById('eventForm');
            // const allDaySwitch = document.querySelector('.allDay-switch');
            const selectAll = document.querySelector('#selectAll-' + id);
            const filterInput = [].slice.call(document.querySelectorAll('.input-filter-' + id));
            const inlineCalendar = document.querySelector('.inline-calendar-' + id);

            let ajaxUrl = "{{ $ajaxUrl }}";
            let eventToUpdate;
            let currentEvents = [];
            let isFormValid = false;
            let inlineCalInstance;
            const timeline = document.querySelector('#timeline');

            const bsAddEventSidebar = new bootstrap.Modal(addEventSidebar);


            //! TODO: Update Event label and guest code to JS once select removes jQuery dependency
            // Event Label (select2)
            // if (eventLabel.length) {
            //     function renderBadges(option) {
            //         if (!option.id) {
            //             return option.text;
            //         }
            //         var $badge =
            //             "<span class='badge badge-dot bg-" + $(option.element).data('label') + " me-2'> " +
            //             '</span>' + option.text;

            //         return $badge;
            //     }
            //     eventLabel.wrap('<div class="position-relative"></div>').select2({
            //         placeholder: 'Select value',
            //         dropdownParent: eventLabel.parent(),
            //         templateResult: renderBadges,
            //         templateSelection: renderBadges,
            //         minimumResultsForSearch: -1,
            //         escapeMarkup: function(es) {
            //             return es;
            //         }
            //     });
            // }


            let start;
            // Event start (flatpicker)
            if (eventStartDate) {
                const timeline = document.querySelector('#timeline'); // Get the timeline input element
                let startDate = null; // Track the selected start date
                start = eventStartDate.flatpickr({
                    enableTime: true,
                    altFormat: 'Y-m-dTH:i:S',
                    onChange: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            instance.mobileInput.setAttribute('step', null);
                        }

                        // Store the selected start date
                        if (selectedDates.length > 0) {
                            startDate = selectedDates[0];
                            updateEndDate
                                (); // Update end date based on the selected start date and timeline value
                        }
                    },
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            instance.mobileInput.setAttribute('step', null);
                        }
                    }
                });

                // Function to update the end date
                function updateEndDate() {
                    if (startDate) {

                        // Read timeline value and convert it to minutes (fallback to 0 if invalid)
                        var minutesToAdd = parseInt(timeline.value) || 0;

                        var endDate = new Date(startDate.getTime() + minutesToAdd * 60 * 1000);

                        // Set this date as the default for the end date picker
                        if (end) {
                            end.setDate(endDate,
                                true); // true will trigger onChange for the end date picker
                        }
                    }
                }

                // Add an event listener to the timeline input
                timeline.addEventListener('input', updateEndDate);
            }

            // Event end (flatpicker)
            if (eventEndDate) {
                var end = eventEndDate.flatpickr({
                    enableTime: true,
                    altFormat: 'd-m-YTH:i:S',
                    onReady: function(selectedDates, dateStr, instance) {
                        if (instance.isMobile) {
                            instance.mobileInput.setAttribute('step', null);
                        }
                    }
                });
            }

            // Inline sidebar calendar (flatpicker)
            // if (inlineCalendar) {
            //     inlineCalInstance = inlineCalendar.flatpickr({
            //         monthSelectorType: 'static',
            //         inline: true
            //     });
            // }

            // Event click function
            function eventClick(info) {

                // console.log(info.event.extendedProps, 'tets');
                eventToUpdate = info.event;
                console.log(info.event);

                const clickToggleProp = eventToUpdate.extendedProps.clickToggle ?? true;
                console.log(clickToggleProp, 'clickToggle');

                // If clickToggle is false, prevent further actions
                if (clickToggleProp === false) {
                    console.log('clickToggle is false. Action prevented.');
                    return; // Exit the function early
                }
                if (eventToUpdate.url) {
                    info.jsEvent.preventDefault();
                    window.open(eventToUpdate.url, '_blank');
                }

                bsAddEventSidebar.show();

                // For update event set offcanvas title text: Update Event
                if (offcanvasTitle) {
                    offcanvasTitle.innerHTML = 'Edito Takim';
                }
                btnSubmit.innerHTML = 'Update';
                btnSubmit.classList.add('btn-update-event');
                btnSubmit.classList.remove('btn-add-event');
                btnSubmit.type = "submit";
                btnDeleteEvent.classList.remove('d-none');

                // eventTitle.value = eventToUpdate.title || '';
                // eventLocation.value = eventToUpdate.location || '';
                eventDescription.value = eventToUpdate.extendedProps.description || '';
                eventReminder.value = eventToUpdate.extendedProps.reminder || '';
                timeline.value = eventToUpdate.extendedProps.timeline || '';

                // Plain JavaScript to set the value and trigger the change event

                // document.querySelector('#clinic_id').value = eventToUpdate.extendedProps.clinic_id || '';
                // document.querySelector('#clinic_id').dispatchEvent(new Event('change'));

                let serviceIds = eventToUpdate.extendedProps.product_id;
                // Could be an array, a single object, or a single string

                $('#product_id').val(serviceIds).trigger('change');


                // document.querySelector('#product_id').value = eventToUpdate.extendedProps.product_id || '';
                // document.querySelector('#product_id').dispatchEvent(new Event('change'));

                document.querySelector('#doctor_id').value = eventToUpdate.extendedProps.doctor_id || '';
                document.querySelector('#doctor_id').dispatchEvent(new Event('change'));

                document.querySelector('#room_id').value = eventToUpdate.extendedProps.room_id || '';
                document.querySelector('#room_id').dispatchEvent(new Event('change'));
                document.querySelector('#pacient_id').value = eventToUpdate.extendedProps.pacient_id || '';
                document.querySelector('#pacient_id').dispatchEvent(new Event('change'));

                document.querySelector('#client_type').value = eventToUpdate.extendedProps.client_type ||
                    '';
                document.querySelector('#client_type').dispatchEvent(new Event('change'));
                document.querySelector('#primary_visit').value = eventToUpdate.extendedProps
                    .primary_visit || '';
                document.querySelector('#primary_visit').dispatchEvent(new Event('change'));
                document.querySelector('#work_plan_id').value = eventToUpdate.extendedProps.work_plan_id ||
                    '';
                document.querySelector('#work_plan_id').dispatchEvent(new Event('change'));

                document.querySelector('#pacient_name').value = eventToUpdate.extendedProps.pacient_name ||
                    '';
                document.querySelector('#pacient_name').dispatchEvent(new Event('change'));

                document.querySelector('#pacient_contact').value = eventToUpdate.extendedProps
                    .pacient_contact || '';
                document.querySelector('#pacient_contact').dispatchEvent(new Event('change'));
                const laboratoryId = eventToUpdate.extendedProps.laboratory_id !== null ? eventToUpdate
                    .extendedProps.laboratory_id : '';
                if (laboratoryId) {
                    document.querySelector('#laboratory_id').value = laboratoryId;
                    document.querySelector('#laboratory_id').dispatchEvent(new Event('change'));
                }


                start.setDate(eventToUpdate.start, true, 'Y-m-d');

                // allDaySwitch.checked = eventToUpdate.allDay === true;

                if (eventToUpdate.end !== null) {
                    end.setDate(eventToUpdate.end, true, 'Y-m-d');
                } else {
                    end.setDate(eventToUpdate.start, true, 'Y-m-d');
                }

                // if (eventToUpdate.extendedProps.location !== undefined) {
                //     eventLocation.value = eventToUpdate.extendedProps.location || '';
                // }

                if (eventToUpdate.extendedProps.guests !== undefined) {
                    document.querySelector('#guests_id').value = eventToUpdate.extendedProps.guests || '';
                    document.querySelector('#guests_id').dispatchEvent(new Event('change'));
                }

                if (eventToUpdate && eventToUpdate.extendedProps && eventToUpdate.extendedProps
                    .description !== undefined) {
                    eventDescription.value = eventToUpdate.extendedProps.description || '';
                }


                // Call removeEvent function (commented out in your code)
                btnDeleteEvent.addEventListener('click', e => {
                    console.log('ee', e);
                    removeEvent(parseInt(eventToUpdate.id));
                    bsAddEventSidebar.hide();
                });
            }


            // Modify sidebar toggler
            function modifyToggler() {
                const fcSidebarToggleButton = document.querySelector('.fc-sidebarToggle-button');
                fcSidebarToggleButton.classList.remove('fc-button-primary');
                fcSidebarToggleButton.classList.add('d-lg-none', 'd-inline-block', 'ps-0');
                while (fcSidebarToggleButton.firstChild) {
                    fcSidebarToggleButton.firstChild.remove();
                }
                fcSidebarToggleButton.setAttribute('data-bs-toggle', 'sidebar');
                fcSidebarToggleButton.setAttribute('data-overlay', '');
                fcSidebarToggleButton.setAttribute('data-target', '#app-calendar-sidebar-' + id);
                fcSidebarToggleButton.insertAdjacentHTML('beforeend',
                    '<i class="ti ti-menu-2 ti-sm text-heading"></i>');
            }

            function selectedCalendars() {
                let selected = [];
                let filterInputChecked = [].slice.call(document.querySelectorAll('.input-filter-' + id +
                    ':checked'));

                filterInputChecked.forEach(item => {
                    selected.push(item.getAttribute('data-value'));
                });

                return selected;
            }

            function fetchEvents(info, successCallback, failureCallback) {
                $.ajax({
                    url: ajaxUrl,
                    type: 'GET',
                    success: function(result) {
                        if (result && Array.isArray(result.events)) {
                            // console.log(result.events, 'mhjura');
                            let currentEvents = result.events;
                            var calendars = selectedCalendars();
                            let selectedEvents = currentEvents.filter(function(event) {
                                return calendars.includes(event.calendar);
                            });
                            selectedEvents.forEach(function(event) {
                                if (event.color) {
                                    // Set the background and border color for FullCalendar event object
                                    event.backgroundColor = event.color;
                                    event.borderColor = event.color;
                                }
                            });
                            successCallback(selectedEvents);
                        } else {
                            console.error('Unexpected response structure:', result);
                            failureCallback('Error: Unexpected response structure');
                        }
                    },
                    error: function(error) {

                        failureCallback('Error: Could not fetch events');
                    }
                });
            }


            const filterNames = @json($filterNames);


            // const calendarsColor = {
            //     Business: 'success',
            //     Holiday: 'success',
            //     Personal: 'danger',
            //     Family: 'warning',
            //     ETC: 'info'
            // };
            const calendarsColor = {};
            filterNames.forEach(filter => {
                calendarsColor[filter.key] = filter.color;
            });

            // Init FullCalendar
            // ------------------------------------------------

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: view || 'timeGridWeek',
                events: fetchEvents,
                // plugins: [dayGridPlugin, interactionPlugin, listPlugin, timegridPlugin],
                editable: false,
                dragScroll: false,
                dayMaxEvents: 2,
                eventResizableFromStart: true,
                customButtons: {
                    sidebarToggle: {
                        text: 'Sidebar'
                    }
                },
                headerToolbar: {
                    start: 'sidebarToggle, prev,next, title',
                    end: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                direction: 'ltr',
                initialDate: new Date(),
                navLinks: true,
                eventClassNames: function({
                    event: calendarEvent
                }) {
                    const colorName = calendarsColor[calendarEvent._def.extendedProps.calendar];



                    // // Background Color
                    // return ['fc-event-' + colorName];
                    const eventColor = calendarEvent.backgroundColor ||
                        colorName; // Fallback to default color if not set

                    const eventBackgroundColor = eventColor ?? colorName;
                    return ['fc-event-' + eventBackgroundColor];
                },
                dateClick: function(info) {
                    let date = moment(info.date).format('YYYY-MM-DD hh:mm');
                    resetValues();

                    // addEventSidebar melisa
                    // bsAddEventSidebar.show();
                    if (modalAdd === 'addEventSidebar') {

                        bsAddEventSidebar.show();
                    }
                    // For new event set offcanvas title text: Add Event
                    if (offcanvasTitle) {
                        offcanvasTitle.innerHTML = 'Add Event';
                    }
                    btnSubmit.innerHTML = 'Add';
                    btnSubmit.classList.remove('btn-update-event');
                    btnSubmit.classList.add('btn-add-event');
                    btnSubmit.type = "submit";
                    btnDeleteEvent.classList.add('d-none');
                    eventStartDate.value = date;
                    eventEndDate.value = date;
                },
                eventClick: function(info) {

                    eventClick(info);

                },
                datesSet: function() {
                    modifyToggler();
                },
                viewDidMount: function() {
                    modifyToggler();
                },
                eventDidMount: (info) => {
                    const eventId = info.event.id; // Correctly using 'info' instead of 'arg'


                    // Add context menu event listener to the event element

                },
            });

            // Render calendar
            calendar.render();
            // Modify sidebar toggler
            modifyToggler();



            // if (btnToggleSidebar) {
            //     btnToggleSidebar.addEventListener('click', e => {
            //         btnCancel.classList.remove('d-none');
            //     });
            // }

            function addEvent(eventData) {

                var csrf_token = "{{ csrf_token() }}";
                $.ajax({
                    url: '/calendar/meeting/create',
                    type: 'POST',
                    data: JSON.stringify(eventData),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    success: function(result) {
                        currentEvents.push(result.event);
                        calendar.refetchEvents();
                        Swal.fire({
                            title: 'Success',
                            text: "Success!", // Using response.message from the server
                            icon: 'success',
                        }).then(() => {
                            resetValues();
                            // window.dispatchEvent(new Event('refreshDataTable'));
                            bsAddEventSidebar.hide();
                            // Reloads the page after user clicks OK
                            if (result.url) {
                                window.location.href = result.url;
                            } else {
                                window.location
                                    .reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        // Clear previous error messages:
                        $('.text-danger').html('');

                        // If the error status is 422 (Unprocessable Entity), it's likely a validation error.
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            // Loop through each error and display it in the corresponding container.
                            $.each(errors, function(field, messages) {
                                // The server keys should match your property names (e.g., start, end, pacient_id, etc.)
                                let errorContainer = $('#error-' + field);
                                if (errorContainer.length) {
                                    errorContainer.html(messages.join('<br>'));
                                }
                            });
                        } else {
                            // Handle any other errors with a general error message.
                            Swal.fire({
                                title: 'Error',
                                text: xhr.responseJSON?.message ||
                                    'An unexpected error occurred.',
                                icon: 'error',
                            }).then(() => {
                                resetValues();
                                // window.dispatchEvent(new Event('refreshDataTable'));
                                bsAddEventSidebar.hide();
                                window.location
                                    .reload();
                            });
                        }
                    }
                });
            }
            // Update Event
            // ------------------------------------------------
            function updateEvent(eventData) {
                var csrf_token = "{{ csrf_token() }}";
                $.ajax({
                    url: '/calendar/meeting/update',
                    type: 'POST',
                    data: JSON.stringify(eventData),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    success: function(result) {
                        currentEvents.push(result.event);
                        calendar.refetchEvents();
                        Swal.fire({
                            title: 'Success',
                            text: "Success!", // Using response.message from the server
                            icon: 'success',
                        }).then(() => {
                            resetValues();
                            // window.dispatchEvent(new Event('refreshDataTable'));
                            bsAddEventSidebar.hide();
                            window.location
                                .reload(); // Reloads the page after user clicks OK
                        });
                    },
                    error: function(xhr) {
                        // This will handle errors, including when a meeting already exists
                        Swal.fire({
                            title: 'Error',
                            text: xhr.responseJSON?.message ||
                                'An unexpected error occurred.', // Show error message
                            icon: 'error',
                        }).then(() => {
                            resetValues();
                            bsAddEventSidebar.hide();
                            window.location
                                .reload(); // Reloads the page after user clicks OK
                        });
                    }

                });
                // ? Update existing event data to current events object and refetch it to display on calender
                // ? You can write below code to AJAX call success response
                eventData.id = parseInt(eventData.id);
                currentEvents[currentEvents.findIndex(el => el.id === eventData.id)] =
                    eventData; // Update event by id
                calendar.refetchEvents();

                // ? To update event directly to calender (won't update currentEvents object)
                // let propsToUpdate = ['id', 'title', 'url'];
                // let extendedPropsToUpdate = ['calendar', 'guests', 'location', 'description'];

                // updateEventInCalendar(eventData, propsToUpdate, extendedPropsToUpdate);
            }

            function updateEventColor(eventData) {
                var csrf_token = "{{ csrf_token() }}";
                $.ajax({
                    url: '/calendar/updateMeetingColor',
                    type: 'POST',
                    data: JSON.stringify(eventData),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    success: function(result) {
                        currentEvents.push(result.event);
                        calendar.refetchEvents();
                        Swal.fire({
                            title: 'Success',
                            text: "Success!", // Using response.message from the server
                            icon: 'success',
                            // confirmButtonText: 'OK'
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: xhr.responseJSON.message ||
                                'An unexpected error occurred.', // Show error message
                            icon: 'error',
                        });
                        console.error('Error adding event:', error);
                    }
                });
                // ? Update existing event data to current events object and refetch it to display on calender
                // ? You can write below code to AJAX call success response
                eventData.id = parseInt(eventData.id);
                currentEvents[currentEvents.findIndex(el => el.id === eventData.id)] =
                    eventData; // Update event by id
                calendar.refetchEvents();

                // ? To update event directly to calender (won't update currentEvents object)
                // let propsToUpdate = ['id', 'title', 'url'];
                // let extendedPropsToUpdate = ['calendar', 'guests', 'location', 'description'];

                // updateEventInCalendar(eventData, propsToUpdate, extendedPropsToUpdate);
            }

            // Remove Event
            // ------------------------------------------------

            function removeEvent(eventId) {
                var csrf_token = "{{ csrf_token() }}";
                $.ajax({
                    url: '/calendar/meeting/delete',
                    type: 'POST',
                    data: JSON.stringify({
                        id: eventId
                    }),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': csrf_token,
                    },
                    success: function(result) {
                        currentEvents = currentEvents.filter(function(event) {
                            return event.id != eventId;
                        });
                        calendar.refetchEvents();
                        Swal.fire({
                            title: 'Success',
                            text: result
                                .message, // Using response.message from the server
                            icon: 'success',
                            // confirmButtonText: 'OK'
                        });

                        // window.dispatchEvent(new Event('refreshDataTable'));
                    },
                    error: function(error) {
                        console.error('Error adding event:', error);
                        Swal.fire({
                            title: 'Success',
                            text: error, // Using response.message from the server
                            icon: 'success',
                            // confirmButtonText: 'OK'
                        });
                    }
                });




            }

            const updateEventInCalendar = (updatedEventData, propsToUpdate, extendedPropsToUpdate) => {
                const existingEvent = calendar.getEventById(updatedEventData.id);
                for (var index = 0; index < propsToUpdate.length; index++) {
                    var propName = propsToUpdate[index];
                    existingEvent.setProp(propName, updatedEventData[propName]);
                }
                existingEvent.setDates(updatedEventData.start, updatedEventData.end, {
                    allDay: updatedEventData.allDay
                });
                for (var index = 0; index < extendedPropsToUpdate.length; index++) {
                    var propName = extendedPropsToUpdate[index];
                    existingEvent.setExtendedProp(propName, updatedEventData.extendedProps[propName]);
                }
            };

            function removeEventInCalendar(eventId) {
                calendar.getEventById(eventId).remove();
            }

            // Add new event
            // ------------------------------------------------
            btnSubmit.addEventListener('click', e => {
                e.preventDefault();
                if (btnSubmit.classList.contains('btn-add-event')) {
                    const selectedTreatments = [];
                    document.querySelectorAll('#product_id option:checked').forEach((option) => {
                        selectedTreatments.push({
                            id: option.value,
                            qty: 1,

                            name: option.dataset
                                .name, // Make sure these attributes exist in your HTML
                            price: option.dataset
                                .price // Make sure these attributes exist in your HTML
                        });
                    });
                    let newEvent = {
                        id: calendar.getEvents().length + 1,

                        start: eventStartDate.value,
                        end: eventEndDate.value,
                        pacient_id: eventPacient.value ?? null,
                        // clinic_id: eventClinic.value,
                        work_plan_id: eventPhase.value,
                        product_id: selectedTreatments,
                        doctor_id: eventDoctor.value,
                        room_id: eventRoom.value,
                        lab_id: eventLab.value,
                        startStr: eventStartDate.value,
                        endStr: eventEndDate.value,
                        description: eventDescription.value,
                        reminder: eventReminder.value,
                        client_type: clientType.value ?? null,
                        primary_visit: primaryVisit.value ?? null,
                        pacient_name: pacientName.value ?? null,
                        pacient_contact: pacientContact.value ?? null,
                        timeline: timeline.value ?? null,



                        display: 'block',
                        extendedProps: {
                            // location: eventLocation.value ?? null,
                            description: eventDescription.value ?? null,
                        }
                    };
                    // if (eventUrl.value) {
                    //     newEvent.url = eventUrl.value;
                    // }
                    // if (allDaySwitch.checked) {
                    //     newEvent.allDay = true;
                    // }
                    addEvent(newEvent);


                } else {
                    document.querySelectorAll('#product_id option:checked').forEach((option) => {
                        selectedTreatments.push({
                            id: option.value,
                            qty: 1,

                            name: option.dataset
                                .name, // Make sure these attributes exist in your HTML
                            price: option.dataset
                                .price // Make sure these attributes exist in your HTML
                        });
                    });
                    if (!eventToUpdate) {
                        console.error('No event to update!');
                        return;
                    }
                    let eventData = {
                        id: eventToUpdate.id,

                        start: eventStartDate.value,
                        end: eventEndDate.value,
                        // url: eventUrl.value,
                        pacient_id: eventPacient.value ?? '',
                        // clinic_id: eventClinic.value,
                        work_plan_id: eventPhase.value,
                        // product_id: eventService.value,
                        product_id: selectedTreatments,
                        room_id: eventRoom.value,
                        lab_id: eventLab.value,
                        reminder: eventReminder.value,
                        client_type: clientType.value,
                        primary_visit: primaryVisit.value,
                        pacient_name: pacientName.value,
                        pacient_contact: pacientContact.value,
                        timeline: timeline.value,


                        extendedProps: {
                            // location: eventLocation.value,
                            description: eventDescription.value
                        },
                        description: eventDescription.value,
                        display: 'block',
                        // allDay: allDaySwitch.checked ? true : false
                    };
                    updateEvent(eventData);


                }
            });

            btnGeneratePreventiv.addEventListener('click', e => {
                e.preventDefault();
                if (btnSubmit.classList.contains('btn-add-event')) {
                    const selectedTreatments = [];
                    document.querySelectorAll('#product_id option:checked').forEach((option) => {
                        selectedTreatments.push({
                            id: option.value,
                            qty: 1,
                            name: option.dataset
                                .name, // Make sure these attributes exist in your HTML
                            price: option.dataset
                                .price // Make sure these attributes exist in your HTML
                        });
                    });
                    let newEvent = {
                        id: calendar.getEvents().length + 1,
                        type: 'preventiv-preview',
                        start: eventStartDate.value,
                        end: eventEndDate.value,
                        pacient_id: eventPacient.value ?? null,
                        // clinic_id: eventClinic.value,
                        work_plan_id: eventPhase.value,
                        product_id: selectedTreatments,
                        doctor_id: eventDoctor.value,
                        room_id: eventRoom.value,
                        lab_id: eventLab.value,
                        startStr: eventStartDate.value,
                        endStr: eventEndDate.value,
                        description: eventDescription.value,
                        reminder: eventReminder.value,
                        client_type: clientType.value ?? null,
                        primary_visit: primaryVisit.value ?? null,
                        pacient_name: pacientName.value ?? null,
                        pacient_contact: pacientContact.value ?? null,
                        timeline: timeline.value ?? null,



                        display: 'block',
                        extendedProps: {
                            // location: eventLocation.value ?? null,
                            description: eventDescription.value ?? null,
                        }
                    };
                    // if (eventUrl.value) {
                    //     newEvent.url = eventUrl.value;
                    // }
                    // if (allDaySwitch.checked) {
                    //     newEvent.allDay = true;
                    // }
                    addEvent(newEvent);


                } else {

                    let eventData = {
                        id: eventToUpdate.id,

                        start: eventStartDate.value,
                        end: eventEndDate.value,
                        // url: eventUrl.value,
                        pacient_id: eventPacient.value ?? '',
                        // clinic_id: eventClinic.value,
                        work_plan_id: eventPhase.value,
                        // product_id: eventService.value,
                        product_id: selectedTreatments.value,
                        doctor_id: eventDoctor.value,
                        room_id: eventRoom.value,
                        lab_id: eventLab.value,
                        reminder: eventReminder.value,
                        client_type: clientType.value,
                        primary_visit: primaryVisit.value,
                        pacient_name: pacientName.value,
                        pacient_contact: pacientContact.value,
                        timeline: timeline.value,


                        extendedProps: {
                            // location: eventLocation.value,
                            description: eventDescription.value
                        },
                        description: eventDescription.value,
                        display: 'block',
                        // allDay: allDaySwitch.checked ? true : false
                    };
                    updateEvent(eventData);


                }
            });



            // btnDeleteEvent.addEventListener('click', e => {
            //     removeEvent(parseInt(eventToUpdate.id));
            //     bsAddEventSidebar.hide();
            // });

            function resetValues() {
                if (eventEndDate._flatpickr) {
                    eventEndDate._flatpickr.clear();
                }

                if (eventStartDate._flatpickr) {
                    eventStartDate._flatpickr.clear();
                }
                eventEndDate.value = '';
                // eventUrl.value = '';
                eventStartDate.value = '';

                // eventLocation.value = '';
                // allDaySwitch.checked = false;
                eventDescription.value = '';
                eventReminder.value = '';



                // Reset dropdowns (select elements)
                document.querySelector('#pacient_id').value = '';
                // document.querySelector('#clinic_id').value = '';
                document.querySelector('#work_plan_id').value = '';
                document.querySelector('#product_id').value = '';
                document.querySelector('#doctor_id').value = '';
                document.querySelector('#room_id').value = '';
                document.querySelector('#timeline').value = '';

                // document.querySelector('#laboratory_id').value = '';
                // document.querySelector('#label_id').value = '';
                // document.querySelector('#guests_id').value = '';

                // Optionally trigger change events if required
                document.querySelector('#pacient_id').dispatchEvent(new Event('change'));
                // document.querySelector('#clinic_id').dispatchEvent(new Event('change'));
                document.querySelector('#work_plan_id').dispatchEvent(new Event('change'));
                document.querySelector('#product_id').dispatchEvent(new Event('change'));
                document.querySelector('#doctor_id').dispatchEvent(new Event('change'));
                document.querySelector('#room_id').dispatchEvent(new Event('change'));
                document.querySelector('#timeline').dispatchEvent(new Event('change'));

                // document.querySelector('#laboratory_id').dispatchEvent(new Event('change'));
                // document.querySelector('#label_id').dispatchEvent(new Event('change'));
                // document.querySelector('#guests_id').dispatchEvent(new Event('change'));
            }

            addEventSidebar.addEventListener('hidden.bs.modal', function() {
                resetValues();
            });

            // btnToggleSidebar.addEventListener('click', e => {
            //     if (offcanvasTitle) {
            //         offcanvasTitle.innerHTML = 'Add Event';
            //     }
            //     // btnGeneratePreventiv.innerHTML = 'Generate Invoice';
            //     // btnGeneratePreventiv.classList.remove('btn-update-event');
            //     // btnGeneratePreventiv.classList.add('btn-add-event');
            //     // btnGeneratePreventiv.type = "submit";

            //     btnSubmit.innerHTML = 'Add';
            //     btnSubmit.classList.remove('btn-update-event');
            //     btnSubmit.classList.add('btn-add-event');
            //     // btnSubmit.type = "submit";
            //     btnDeleteEvent.classList.add('d-none');
            //     appCalendarSidebar.classList.remove('show');
            //     appOverlay.classList.remove('show');
            // });

            if (selectAll) {
                selectAll.addEventListener('click', e => {
                    if (e.currentTarget.checked) {
                        document.querySelectorAll('.input-filter-' + id).forEach(c => (c.checked =
                            1));
                    } else {
                        document.querySelectorAll('.input-filter-' + id).forEach(c => (c.checked =
                            0));
                    }
                    calendar.refetchEvents();
                });
            }

            if (filterInput) {
                filterInput.forEach(item => {
                    item.addEventListener('click', () => {
                        document.querySelectorAll('.input-filter-' + id + ':checked')
                            .length < document.querySelectorAll('.input-filter-' + id)
                            .length ?
                            (selectAll.checked = false) :
                            (selectAll.checked = true);
                        calendar.refetchEvents();
                    });
                });
            }

            // inlineCalInstance.config.onChange.push(function(date) {
            //     calendar.changeView(calendar.view.type, moment(date[0]).format('YYYY-MM-DD'));
            //     modifyToggler();
            //     appCalendarSidebar.classList.remove('show');
            //     appOverlay.classList.remove('show');
            // });
        })();
    });
</script>
{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
<script>
    $(document).ready(function() {
        $(document).off('change', 'input[type="checkbox"][name="notification_status"]').on('change',
            'input[type="checkbox"][name="notification_status"]',
            function() {
                var itemId = $(this).data('id');
                var status = $(this).is(':checked') ? 23 : 22;

                $.ajax({
                    url: '/update-notification-status', // Your endpoint to handle the request
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token
                        id: itemId,
                        status: status
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Notification status updated successfully.',
                        }).then(() => {
                            // Remove the notification item from the DOM
                            $('#notification_item_' + itemId).remove();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'There was an issue updating the notification status.',
                        });
                    }
                });
            });
    });
</script>
</div>
