<!-- CSS Links -->
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .room-box {
        min-width: 250px;
        max-width: 250px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-right: 15px;
        padding: 10px;
        background: #f8f9fa;
    }

    .room-header {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .slot-btn {
        width: 100%;
        margin-bottom: 5px;
    }

    .scroll-container {
        overflow-x: auto;
        display: flex;
        padding-bottom: 10px;
    }

    .blocked-slot {
        background-color: #6c757d !important;
        color: #fff !important;
        cursor: not-allowed !important;
    }

    .slot-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .slot-scroll::-webkit-scrollbar-thumb {
        background-color: #999;
        border-radius: 3px;
    }

    .scroll-container::-webkit-scrollbar {
        width: 6px;
    }

    .scroll-container::-webkit-scrollbar-thumb {
        background-color: #007bff;
        border-radius: 4px;
    }

    .disabled {
        background-color: #f8d7da !important;
        color: #721c24 !important;
        pointer-events: none;
        /* Disable clicking */
        cursor: not-allowed;
        /* Change cursor to indicate disabled state */
    }

    button i.fas.fa-times-circle {
        margin-right: 5px;
    }

    button .mt-2.text-danger p {
        font-size: 12px;
        margin: 0;
    }
</style>
<div class="container my-4">
    <h3 class="text-center mb-4 text-primary fw-bold">🩻 Radiology Appointment & Advance Booking</h3>

    <div class="row g-4">
        <!-- Left: Appointment (Invoice ID) -->
        <div class="col-md-6">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-primary text-white fw-semibold">
                    📄 Appointment (Invoice ID)
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="invoice_id" id="invoicecode"
                            placeholder="🔍 Enter Invoice ID" />
                        <button class="btn btn-primary ml-1" id="invoicecodeBtn">Search</button>
                    </div>

                    <div id="invoiceResult" class="item-list"></div>
                </div>
            </div>
        </div>

        <!-- Right: Advance Appointment (UHID) -->
        <div class="col-md-6">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-success text-white fw-semibold">
                    📝 Advance Appointment (UHID)
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" id="uhidSearch" class="form-control" placeholder="🔍 Enter UHID">
                        {{-- <button class="btn btn-success ml-1" id="uhidSearchBtn">Search</button> --}}
                    </div>

                    <div id="uhidFormArea"></div>
                    <input type="hidden" id="patentIdHidden" value="">
                    <div id="uhidItemList" class="item-list mt-2"></div>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card shadow border-0 h-100">
                <div
                    class="card-header bg-info text-white fw-semibold d-flex justify-content-between align-items-center">
                    <span>🏥 Available Rooms & Schedule</span>

                    <div class="d-flex align-items-center">
                        <label for="scheduleDate" class="me-2 mb-0">📅 Date:</label>
                        <input type="date" id="scheduleDate" class="form-control w-auto" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="card-body">
                    <div class="scroll-container p-2 border rounded bg-light" id="roomsContainer"
                        style="min-height:200px; max-height:450px; overflow-y:auto;"></div>
                </div>
            </div>
        </div>

        <input type="hidden" id="selectedItemId" value="">
        <input type="hidden" id="selectedInvoiceHidden" value="">
        <input type="hidden" id="radinvoicedtl_no_fk" value="">
        <div class="col-md-4">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-warning text-dark fw-semibold">
                    📋 Pre-requisition
                </div>
                <div class="card-body">
                    <ul id="preRequisitionList" class="list-group mt-3"></ul>

                </div>
            </div>
        </div>
    </div>
</div>



<!-- JS Links -->
<script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

<script>
    var uhidItemList = []; // Advance appointment items
    var selectedItem = null; // Currently selected Item
    var selectedSlotData = {}; // Store booking slot info

    $(document).ready(function() {
        const today = new Date().toISOString().split('T')[0];
        $('#scheduleDate').val(today);
    });

    // Render items
    function renderItems(targetDiv, items) {
        $(targetDiv).empty(); // Clear the target div
        $.each(items, function(i, item) {
            // Create a button element
            var btn = $('<button class="btn btn-outline-primary w-100 item-btn mt-1" id="selectedItemId_' + item
                .item_no_pk +
                '" data-id="' + item.item_no_pk +
                '" data-room-id="' + item.room_no_fk + '">');

            // Append item name
            btn.append(item.item_name);

            // Check if the item is already booked
            if (item.is_booked) {
                // Add a disabled class to disable the button
                btn.addClass('disabled');

                // Append "Already Booked" icon and show the booking times
                var icon = $(
                    '<span class="ml-2 text-danger"> <i class="fas fa-times-circle"></i> Already Booked</span>'
                );
                btn.append(icon);

                // Display booking times below the button
                var bookingDetails = $('<div class="mt-2 text-danger">');
                $.each(item.bookings, function(j, booking) {
                    var bookingText = 'Booked from ' + booking.start_time + ' to ' + booking.end_time;
                    bookingDetails.append('<p>' + bookingText + '</p>');
                });
                btn.append(bookingDetails);
            }

            // Append the button to the target div
            $(targetDiv).append(btn);
        });
    }



    // Render Rooms & Slots
    function renderRooms(item) {
        var item_id = $(item).attr('data-id');
        if (item_id == '' || item_id == undefined) {
            item_id = $('#selectedItemId').val()
        }

        var scheduleDate = $("#scheduleDate").val()
        console.log(scheduleDate)

        var room_id = $(item).attr('data-room-id');
        var selectedInvoiceHidden = $("#selectedInvoiceHidden").val();

        $('#selectedItemId').val(item_id);
        $('#roomsContainer').empty(); // Clear the container before loading new data

        $.ajax({
            url: "{{ route('radiology-fetch-room-wise-slots') }}", // Adjust route if needed
            method: 'POST',
            data: {
                item_no_pk: item_id,
                room_id: room_id,
                scheduleDate: scheduleDate,
                selectedInvoiceHidden: selectedInvoiceHidden,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                $('#roomsContainer').html('<div class="text-center">Loading rooms & slots...</div>');
            },
            success: function(response) {
                console.log(response)
                // var radinvoicedtl_no_pk = response.radinvoicedtl_no_pk
                // console.log(radinvoicedtl_no_pk)
                $('#roomsContainer').empty(); // Clear the loading message

                if (response.success && response.rooms.length > 0) {
                    // Loop through each room
                    response.rooms.forEach(function(roomObj) {
                        var roomName = roomObj.room_name;
                        var room_no_fk = roomObj.room_no_fk;
                        var radinvoicedtl_no_pk = roomObj.radinvoicedtl_no_pk;
                        var slots = roomObj.slots; // Array of slot objects [{time, blocked}]

                        // Create a container for each room
                        var box = $(
                            '<div class="room-box mb-3 p-2 border rounded shadow-sm"></div>');
                        box.append('<h5 class="room-header mb-2 text-primary">' + roomName +
                            '</h5>');

                        // Create the container for the slots (scrollable)
                        var slotContainer = $(
                            '<div class="slot-scroll d-flex flex-wrap gap-2"></div>');

                        // Loop through each slot and add a button
                        slots.forEach(function(slot) {
                            var btnClass = slot.blocked ? 'btn-secondary blocked-slot' :
                                'btn-outline-primary';
                            var disabledAttr = slot.blocked ? 'disabled' :
                                ''; // Disable button if blocked

                            // Create the slot button with appropriate classes and data attributes
                            var slotBtn = $('<button class="btn btn-sm slot-btn ' +
                                btnClass + '" ' + disabledAttr +
                                ' data-room="' + roomName + '" data-time="' + slot
                                .time + '" data-room-id="' + room_no_fk +
                                '" data-radinvoicedtl_no_pk="' + radinvoicedtl_no_pk +
                                '">' +
                                slot.time + '</button>');

                            // Append the slot button to the slot container
                            slotContainer.append(slotBtn);
                        });

                        // Append the slot container to the room box
                        box.append(slotContainer);

                        // Append the room box to the main container
                        $('#roomsContainer').append(box);
                    });

                    // CSS apply (scroll limit)
                    $('.slot-scroll').css({
                        'max-height': '400px',
                        'overflow-y': 'auto',
                        'border': '1px solid #ddd',
                        'padding': '5px'
                    });

                } else {
                    // If no rooms or slots are found
                    $('#roomsContainer').html(
                        '<div class="alert alert-warning text-center">No rooms or slots found for this item</div>'
                    );
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX error
                $('#roomsContainer').html(
                    '<div class="alert alert-danger text-center">An error occurred. Please try again later.</div>'
                );
            }
        });
    }




    // Generate slots (15 min interval)
    function generateSlots(start, end) {
        var slots = [];
        var startTime = moment(start, 'HH:mm');
        var endTime = moment(end, 'HH:mm');
        var serial = 1;

        while (startTime < endTime) {
            var slotEnd = startTime.clone().add(15, 'minutes');
            slots.push(serial + '. ' + startTime.format('HH:mm') + '-' + slotEnd.format('HH:mm'));
            startTime.add(15, 'minutes');
            serial++;
        }
        return slots;
    }


    // Render Pre-requisition
    function renderPreRequisition(item_id) {
        var item_id = $("#selectedItemId").val(); // অথবা সরাসরি parameter ব্যবহার করতে পারেন

        $.ajax({
            url: "{{ route('get-pre-requisition') }}",
            method: "POST",
            data: {
                item_id: item_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response)
                if (response.success && response.pre_requisition) {
                    showPreRequisitionList(response.pre_requisition);
                } else {
                    $('#preRequisitionList').html(
                        '<li class="list-group-item text-muted">No pre-requisition found.</li>'
                    );
                }
            },
            error: function(xhr) {
                console.error('Error fetching pre-requisition:', xhr);
                $('#preRequisitionList').html(
                    '<li class="list-group-item text-danger">Failed to load data.</li>'
                );
            }
        });
    }

    // 🟦 Helper function to show the list
    function showPreRequisitionList(preRequisition) {
        $('#preRequisitionList').empty();

        if (typeof preRequisition === 'string') {
            const lines = preRequisition.split(/\r?\n/);
            lines.forEach(line => {
                if (line.trim() !== '') {
                    $('#preRequisitionList').append('<li class="list-group-item">' + line.trim() + '</li>');
                }
            });
        } else {
            $('#preRequisitionList').append('<li class="list-group-item text-muted">No instructions available.</li>');
        }
    }


    // Invoice Search (AJAX)
    $('#invoicecodeBtn').on('click', function() {
        var invoiceID = $('#invoicecode').val().trim();
        // if (invoiceID === '') {
        //     alert('Please enter Invoice ID');
        //     return;
        // }
        $('#uhidResult, #uhidFormArea, #uhidItemList').empty();
        $("#selectedInvoiceHidden").val(invoiceID)
        $.ajax({
            url: "{{ route('radiology-search-by-invoice-wise-item') }}",
            method: 'POST',
            data: {
                invoice_id: invoiceID,
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            beforeSend: function() {
                $('#invoiceResult').html('<div class="text-center">Loading...</div>');
            },
            success: function(response) {
                if (response.success && response.items.length > 0) {
                    renderItems('#invoiceResult', response.items);

                } else {
                    $('#invoiceResult').html(
                        '<div class="alert alert-warning">No items found for this Invoice ID</div>'
                    );
                }
            },
            error: function() {
                $('#invoiceResult').html(
                    '<div class="alert alert-danger">Error fetching data</div>');
            }
        });
    });

    // UHID Search
    $('#uhidSearchBtn').on('click', function() {
        $('#invoiceResult').empty();
        $('#uhidFormArea').html(`
            <input type="text" id="uhidItemInput" class="form-control mb-2" placeholder="Enter Item Name">
            <button class="btn btn-warning w-100 mb-2" id="addUhidItemBtn">Add Item</button>
        `);
        $('#uhidItemList').empty();
        uhidItemList = [];
    });

    // Add item in UHID Section (manual)
    $(document).on('click', '#addUhidItemBtn', function() {
        var itemName = $('#uhidItemInput').val().trim();
        if (itemName === '') {
            alert('Please enter item name.');
            return;
        }

        $.ajax({
            url: "{{ route('radiology-find-item-by-name') }}",
            method: 'POST',
            data: {
                item_name: itemName,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success && response.item) {
                    var foundItem = response.item;

                    if (!uhidItemList.find(it => it.item_no_pk === foundItem.item_no_pk)) {
                        uhidItemList.push(foundItem);
                        renderItems('#uhidItemList', uhidItemList);
                        $('#uhidItemInput').val('');
                    } else {
                        alert('Item already added.');
                    }
                } else {
                    alert('Item not found.');
                }
            },
            error: function() {
                alert('Server error.');
            }
        });
    });

    // Item Click → Load Room & Pre-requisition
    $(document).on('click', '.item-btn', function() {
        var item_id = $(this).data('data-id');
        var selectedItem = $(this).data('item');
        // Store item_no_pk in hidden input
        $('#selectedItemId').val(item_id);
        renderRooms(this);

        renderPreRequisition(item_id);
    });


    $(document).on('click', '.slot-btn', function() {
        var btn = $(this);
        var slotText = btn.data('time'); // slot time like: "09:00 AM - 09:15 AM"
        var roomName = btn.data('room'); // room name identifier
        var roomId = btn.data('room-id'); // room name identifier
        var radinvoicedtl_no_pk = btn.data('radinvoicedtl_no_pk'); // room name identifier
        var action = btn.hasClass('blocked-slot') ? 'unbook' : 'book';
        var confirmText = action === 'book' ? 'Are you sure to book this slot?' :
            'Are you sure to unbook this slot?';
        var selectedItem = $("#selectedItemId").val();

        if (!selectedItem) {
            alert('Please select an item first');
            return;
        }

        // Optional: check invoice/app ID before booking
        var app_id = $('#selectedInvoiceHidden').val();
        var inv_voucher_no = $('#selectedInvoiceHidden').val();

        // if (!inv_voucher_no) {
        //     alert('Please search invoice first to get appointment ID');
        //     return;
        // }

        // === Extract start and end time directly from slotText ===
        var timeParts = slotText.split(' - ');
        var startLabel = timeParts[0]; // Example: "09:00 AM"
        var endLabel = timeParts[1]; // Example: "09:15 AM"

        // Using moment.js to format properly
        var startMoment = moment(startLabel, 'hh:mm A');
        var endMoment = moment(endLabel, 'hh:mm A');

        var startTime = startMoment.format('HH:mm');
        var endTime = endMoment.format('HH:mm');
        var selectedItemId = $("#selectedItemId").val()
        var selectedInvoiceHidden = $("#selectedInvoiceHidden").val()
        var patentIdHidden = $("#patentIdHidden").val()

        // === Calculate slot serial within the same room (excluding blocked slots) ===
        var roomSlots = $('.slot-btn').filter(function() {
            return $(this).data('room') === roomName && !$(this).hasClass('blocked-slot');
        });

        var slotSerial = roomSlots.index(btn) + 1; // room wise serial excluding blocked

        if (confirm(confirmText)) {
            $.ajax({
                url: "{{ route('radiology-appointment-book-slot') }}",
                method: 'POST',
                data: {
                    id: selectedItem.item_no_pk, // item ID used as radt_app_sl
                    start: startTime,
                    end: endTime,
                    app_id: app_id,
                    roomId: roomId,
                    selectedItemId: selectedItemId,
                    selectedInvoiceHidden: selectedInvoiceHidden,
                    patentIdHidden: patentIdHidden,
                    radinvoicedtl_no_pk: radinvoicedtl_no_pk,
                    radio_appointment_date: $('#scheduleDate').val(), // optional date
                    serial: slotSerial, // <-- Room wise serial
                    room: roomName, // <-- Room name
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response)
                    if (response.success) {
                        const isNotBiller = response.notbiller && response.notbiller.trim() !== '';
                        const insertId = response.insert_id;
                        const routeUrl = isNotBiller ?
                            "{{ route('radiology/appointment-card-print-not-bill') }}/" +
                            insertId :
                            "{{ route('radiology-appointment-card-print-V2') }}/" + insertId;

                        if (action === 'book') {
                            btn.removeClass('btn-outline-primary').addClass(
                                'btn-secondary blocked-slot');
                            // setTimeout(() => {
                                window.open(routeUrl, "_blank", 'noopener,noreferrer');
                            // }, 3000);
                            $('#invoicecodeBtn').trigger('click');
                            $('#uhidResult, #uhidFormArea, #uhidItemList, #roomsContainer').empty();
                        } else {
                            btn.removeClass('btn-secondary blocked-slot').addClass(
                                'btn-outline-primary');
                        }
location.reload();
                        // alert(response.message);
                       
                    } else {
                        alert('Failed: ' + response.message);
                    }

                },
                complete:function(xhr){
                    // location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Request processing error'));
                }
            });
        }
    });


    // যখন item select করবেন
    $('#selectedItemId').on('change', function() {
        var selectedItemId = $(this).val();
        var inv_voucher_no = $('#selectedInvoiceHidden').val();

        if (!selectedItemId || !inv_voucher_no) {
            return;
        }

        $.ajax({
            url: "{{ route('radiology-appointment-fetch-booked-slots') }}", // <-- নিজের route
            method: 'GET',
            data: {
                item_id: selectedItemId,
                inv_voucher_no: inv_voucher_no,
                appointment_date: $('#appointment_date').val()
            },
            success: function(response) {
                // response.booked_slots = array of booked times Example: ['09:15', '09:45']

                // আগে সব slot reset করে দিই
                $('.slot-btn').removeClass('btn-secondary blocked-slot').addClass(
                    'btn-outline-primary').prop('disabled', false);

                // এখন booked slot গুলো mark করি
                response.booked_slots.forEach(function(bookedTime) {
                    $('.slot-btn').each(function() {
                        var btn = $(this);
                        var slotText = btn.data('time'); // "09:00 AM - 09:15 AM"
                        var timeParts = slotText.split(' - ');
                        var startLabel = timeParts[0];
                        var startMoment = moment(startLabel, 'hh:mm A');
                        var startTimeFormatted = startMoment.format('HH:mm');

                        if (startTimeFormatted === bookedTime) {
                            btn.removeClass('btn-outline-primary').addClass(
                                'btn-secondary blocked-slot');
                            btn.prop('disabled', true);
                            btn.append(
                                '<br><small class="text-danger">Booked</small>');
                        }
                    });
                });
            }
        });
    });







    // Advance Appointment Part 
    openPatientAutocomplete('#uhidSearch', 'patient_name', patientInfo);

    function patientInfo(item, obj) {
        console.log(item, 'Selected patient');

        $("#patentIdHidden").val(item.patient_id);

        // Clear previous areas
        $('#invoiceResult, #uhidItemList, #roomsContainer').empty();

        // Render Item search field only (No Add button)
        $('#uhidFormArea').html(`
        <h2 style="color: red;display:none;" id="item_name" >${item.item_name}</h2>
        <input type="text" id="investigation_item" class="form-control mb-2" placeholder="Enter Item Name">
    `);

        // Enable Item autocomplete on investigation_item input (activate only after patient select)
        openItemAutocompleteWithList(
            $('#investigation_item'), // Input selector
            'RAD,LAB,SUR,PROCEDURE,PROC', // Search type
            '#investigation', // Optional target div (not used here but kept as placeholder)
            "121", // Hospital code / dept code (if required)
            "INVFIND" // Search mode
        );
    }

    // ===================
    // Item Autocomplete function (with direct renderRooms call)
    // ===================
    function openItemAutocompleteWithList(element, item_type, append_to, lookup_id, lookup_code) {
        $(element).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 50,
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-name') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {
                suggestion: function(item) {
                    return '<div class="clearfix border-bottom">' +
                        '<div><strong>' + item.item_code + '</strong> - ' + item.item_name + '</div></div>';
                },
                empty: function(context) {
                    if ($(element).typeahead('val') != "") {
                        var search_label = $(element).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ' in this Prescription. Click the below button to add. </div> <div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="prescriptionFunc.addNotFoundInvItem(event,this)"> + Add for this Prescription only</div></div>'
                        );
                        $('.tt-menu').css({
                            'padding': '15px'
                        });
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            console.log(item, 'Selected Item');

            // Store selected item id (optional, if needed)
            $('#selectedItemId').val(item.item_id); // Set hidden/input field value
            $('#item_name').val(item.item_name); // For input field
            $('#item_name').text(item.item_name); // For span/div/etc. (only one is needed)

            $("#investigation_item").css('display', 'none'); // Hide investigation item container
            $("#item_name").css('display', ''); // Show item name container


            // Directly load room & slots
            renderRooms(item.item_id); // Call renderRooms with item_id
            renderPreRequisition(item.item_id); // Call renderPreRequisition with item_id

            $("#selectedItemId").val(item.item_id)

            // Clear input after selection
            $(element).typeahead('val', '');

            obj.stopImmediatePropagation();
        });
    }

    // ===================
    // Dummy renderRooms function (আপনার মূল ফাংশনের সাথে মিলিয়ে নিবেন)
    // ===================
    function renderRoomsByItem(selectedItem) {
        const item_id = $('#selectedItemId').val();
        const selectedDate = $(this).val();

        console.log(item_id, selectedDate);
        renderRooms(item_id); // Call renderRooms with item_id
        renderPreRequisition(item_id); // Call renderPreRequisition with item_id

        $("#selectedItemId").val(item_id)
        // console.log('Loading rooms and slots for item:', selectedItem.item_name);

        // $.ajax({
        //     url: "{{ route('get-rooms-schedule-by-item') }}",
        //     type: 'POST',
        //     data: {
        //         item_id: selectedItem.item_id,
        //         _token: '{{ csrf_token() }}'
        //     },
        //     success: function(response) {
        //         $('#roomsContainer').html(response.html);
        //     },
        //     error: function() {
        //         alert('Failed to load rooms.');
        //     }
        // });
    }

    // Item Autocomplete

    $(document).on('change', '#scheduleDate', function() {
        const item_id = $('#selectedItemId').val();
        const selectedDate = $(this).val();

        console.log(item_id, selectedDate);

        // Call the functions when date changes
        renderRooms(item_id); // Call renderRooms with item_id
        renderPreRequisition(item_id); // Call renderPreRequisition with item_id

        $("#selectedItemId").val(item_id)
    });
</script>
