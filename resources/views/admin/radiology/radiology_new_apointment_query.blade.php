<div class="col-sm-12 col-lg-4 col-xl-4" id="patient-radiology-container">
    @include('admin.radiology.radiology_search_data')
</div>


<div class="col-sm-12 col-lg-4 col-xl-4">
    <div class="card">
        <div class="card-header">Add to Queue</div>
        <div class="card-body">
            {{-- <form action="{{route('radiology.save-radiology-appointment')}}" id="formdata" method="POST"> --}}
            <form action="{{ route('radiology.save-radiology-appointment') }}" id="formdata" method="POST">
                @csrf
                <input type="hidden" class="form-control" id="inv_voucher_no" name="inv_voucher_no" value="" />
                <div class="row">
                    <div class="col-md-12 justify-content-center">
                        <div class="form-group ">

                            <label for="radio_room_no" class="col-form-label col-form-label-sm">Room <span
                                    class="text-danger"> *</span></label>
                            <select class="form-control form-control-sm room_ddl required" name="radio_room_no"
                                id="search_data" required='required' onchange="selectedRoom(this)">

                                @if (isset($rooms))
                                    @foreach ($rooms as $record)
                                        <option value="{{ $record->room_no_pk }}">{{ $record->room_name }}</option>
                                    @endforeach
                                @endif
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="radio_priority" class="col-form-label col-form-label-sm">Priority</label>
                            <select class="form-control form-control-sm select2 " id="radio_priority"
                                name="radio_priority">
                                <option value="0">Select Priority</option>
                                {{-- <option value="1">Priority-1</option>
                                <option value="2">Priority-2</option> --}}
                                @if (isset($priority))
                                    @foreach ($priority as $key => $value)
                                        <option value="{{ $key }}"
                                            @if ($priority == $key) selected @endif>
                                            {{ $value }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="radio_appointment_date" class="col-form-label col-form-label-sm">Appointment
                                Date <span class="text-danger"> *</span></label>
                            <input type="text" class="form-control form-control-sm date_picker required"
                                id="radio_appointment_date" name="radio_appointment_date" value="{{ date('d-m-Y') }}"
                                readonly="readonly" placeholder="Appointment Date" onchange="dateChange(this)">
                        </div>

                        {{-- <div class="form-group">
                                <label for="radio_delivery_date" class="col-form-label col-form-label-sm">Delivery
                                Date</label>
                                <input type="text" class="form-control form-control-sm date_picker" id="radio_delivery_date"
                                name="radio_delivery_date" value="{{ date('d-m-Y') }}" readonly="readonly"
                                placeholder="Delivery Date">
                            </div> --}}
                        <div class="queue_button mt-3" style="display: none;">
                            @php

                                $app_id = '';
                                $response_action = route('radiology-appointment-card', $app_id);
                            @endphp
                            <input type="hidden" name="app_id" value="{{ $app_id }}" id="app_id">
                            {{-- <button class="btn btn-success btn-md uhl_save_btn" type="button" id="save_buttonRad"
                                onclick="btnSaveUpdate(this , 'afterSaveModal', '{{ $response_action }}', 'common-modal-sm', 'Rediology Appointment Card', searchRadiologyInfoByVouchar)">

                                Save
                            </button> --}}


                            <button class="btn btn-success btn-md uhl_save_btn" type="button" id="save_buttonRad"
                                onclick="radStoreFunction(this)"
                                data-action="{{ route('radiology.save-radiology-appointment') }}">

                                Save
                            </button>


                            <a href="" type="reset" class="btn btn-danger btn-md"
                                title="Click here to Clear form data">Cancel</a>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


</div>



<div class="col-sm-12 col-lg-4 col-xl-4" id="schedule" style="max-height: 50px;">

    <div class="card">
        <div class="card-header">
            <h5>Book Schedule Time <span class="text-danger" id="roomSelection"></span></h5>
        </div>
        <div class="card-body">
            <!-- Schedule Information -->
            {{-- <div>
                <div class="row">
                    <div class="col-md-6"><p><strong>Start Time:</strong> 8:00</p></div>
                    <div class="col-md-6"><p><strong>End Time:</strong> 2:30 PM</p></div>
                    <div class="col-md-6"> <p><strong>Avg Time:</strong> 10 Minutes</p></div>
                    <div class="col-md-6"> <p><strong>Number of Slots:</strong><span id="total_slot"></span></p></div>
                </div>
            </div> --}}

            <!-- Wrapper for table to enable scrolling -->
            <div style="max-height: 450px; overflow-y: auto; border: 1px solid #ddd; border-radius: 0.25rem;">
                <table class="table table-bordered table-hover table-success table-striped mb-0"
                    style="width: 100%; border-collapse: separate; border-spacing: 0;">
                    <thead style="position: sticky; top: 0; background: #f8f9fa; z-index: 1;">
                        <tr>
                            <th class="text-center">SL</th>
                            <th class="text-center">Start Time</th>
                            <th class="text-center">End Time</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="interval_data">
                        @include('admin.radiology.radiology_schedule')
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>



<script>
    $(function() {
        var date = new Date();
        date.setDate(date.getDate());

        $('.date_picker').datepicker({
            startDate: date,
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

        $("#invoice_code").focus();
        // $('.select2').select2();
    });





    function selectedRoom(thisElement) {
        const selectedText = $(thisElement).find('option:selected').text();
        $("#roomSelection").text(selectedText);


        var radio_appointment_date = $('#radio_appointment_date').val()
        var radio_room_no = $("#search_data").val();
        $.ajax({
            url: "{{ route('date-wise-schedule-intervals') }}",
            type: "get",
            data: {
                radio_appointment_date: radio_appointment_date,
                radio_room_no: radio_room_no,
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#interval_data").html(data);
                $('#total_slot').val('')
                // $('#appointment_id').focus()
            },
            complete: function() {
                $.unblockUI();
            }
        });


    }


    function radStoreFunction(element) {
    var action = $(element).attr("data-action");
    var radio_room_no = $("#search_data").val();
    var radio_priority = $("#radio_priority").val();
    var radio_appointment_date = $("#radio_appointment_date").val();
    var inv_voucher_no = $("#inv_voucher_no").val();

    $.ajax({
        async: true,
        url: action,
        type: "POST",
        data: {
            radio_room_no: radio_room_no,
            radio_priority: radio_priority,
            radio_appointment_date: radio_appointment_date,
            inv_voucher_no: inv_voucher_no,
        },
        beforeSend: function() {
            blockUI(); // Show a loading indicator
        },
        success: function(data) {
            console.log(data);
            $("#appointment_id").val(''); // Clear the appointment ID input field

            // Construct the URL for the appointment card
           // Define the URL you want to open
            var routeUrl = "{{ route('radiology-appointment-card-print') }}/" + data.insert_id;

            // Use setTimeout to delay the execution by 3000 milliseconds (3 seconds)
            setTimeout(function() {
                window.open(routeUrl, "_blank", 'noopener,noreferrer');
            }, 3000);

            // Optionally, use a function to reload or update the page content
            dynamicFunc.afterSaveLoadPage("{{ route('radiology.create-appointment') }}");

            // Hide any open modals
            $(".modal").modal("hide");
        },
        complete: function() {
            $.unblockUI(); // Hide the loading indicator
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            console.error("Error:", status, error);
            $.unblockUI(); // Ensure UI is unblocked even if there's an error
        }
    });
}


    function dateChange(thisElement) {
        var radio_appointment_date = $(thisElement).val()
        var radio_room_no = $("#search_data").val();
        $.ajax({
            url: "{{ route('date-wise-schedule-intervals') }}",
            type: "get",
            data: {
                radio_appointment_date: radio_appointment_date,
                radio_room_no: radio_room_no,
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#interval_data").html(data);
                $('#total_slot').val('')
                // $('#appointment_id').focus()
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function tringgerSingleItem() {
        var rowCount = $('#myTable tr.myTest').length;
        console.log(rowCount)
        // If there is only one row
        if (rowCount === 1) {
            // Find the radio input in that row and trigger the function
            var radioInput = $('#myTable tr.myTest input[type="radio"]');
            if (radioInput.length) {
                get_add_que(radioInput[0]);
            }
        }
    }
</script>
