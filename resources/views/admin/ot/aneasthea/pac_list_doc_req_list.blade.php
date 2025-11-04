{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<style>
    .bed_list_data_table tbody tr td,
    .bed_list_data_table thead tr th {
        font-size: 12px !important;
        padding: .3rem .5rem !important;
    }

    .sticky-navbar {
        position: sticky;
        top: 0;
        z-index: 1020;
    }

    /* Optional: limit card width */
    .card-centered {
        max-width: 600px;
        width: 100%;
    }
</style>

<nav class="navbar bg-white border-bottom sticky-navbar shadow-sm">
    <div class="container-fluid">
        <div>
            <h5 class="mb-0">Slot Booking</h5>
            <small class="text-muted">Slot Booking</small>
        </div>
    </div>
</nav>

<div class="container-fluid flex-grow-1 d-flex justify-content-center align-items-start mt-4">
    <div class="card card-centered shadow-sm border-top">
        <div class="card-header form-label fw-bold">
            <h5><i class="fa fa-search"></i> Slot Booking</h5>
        </div>
        <div class="card-body">
            <form id="slotBookingForm" action="{{ route('slot.book-by-doc') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-12">
                    <label for="ot_item" class="form-label fw-bold">Name of Operation</label>
                    <input type="text" id="ot_item" name="ot_item" class="form-control form-control-sm"
                        placeholder="Enter OT Name" value="{{ !empty($pac_data->ot_item) ? $pac_data->ot_item : '' }}">
                    <input type="hidden" value="{{ !empty($pac_data->ot_item) ? $pac_data->ot_item : '' }}"
                        id="item_hidden_id">
                </div>

                <div class="col-md-6">
                    <label for="room_no" class="form-label fw-bold">OT Room No. <span
                            class="text-danger">*</span></label>
                    <select id="room_no" name="room_no" class="form-select form-select-sm form-control "
                        onchange="getOTRequsition(1)">
                        <option value="">Select Room</option>
                        @foreach ($room_data as $data)
                            <option value="{{ $data->room_no_pk }}">{{ $data->room_name }}
                                ({{ $data->room_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="ot_date_time" class="form-label fw-bold">OT Date <span
                            class="text-danger">*</span></label>
                    <input type="text" id="ot_date_time" name="ot_date_time"
                        class="form-control form-control-sm date_picker" onchange="getOTRequsition(1)">
                    <input type="hidden" name="ot_slot_id" id="ot_slot_id">
                </div>

                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-header text-white bg-secondary">OT Room Info</div>
                        <div class="card-body p-2">
                            <div id="ot_data" class="text-center text-success">
                                Schedule Fetching …
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <label for="advice" class="form-label fw-bold">Advice</label>
                    <textarea id="advice" name="advice" class="form-control form-control-sm" rows="3"></textarea>
                </div>

                <div class="col-12 text-end mt-2">
                    <button type="submit" class="btn btn-primary" id="submitBtn">Save & Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    openItemAutocompleteWithList($("#ot_item"), "SUR,PROCEDURE", "", "122", "PROCEDURE"); //PROCDUREot
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    function getOTRequsition(search = null) {
        const hasItems = $('#item_hidden_id').val();

        if (!hasItems) {
            alert('Please add at least one OT item before proceeding.');
            return; // stop further execution
        }


        let ot_date_time = $('#ot_date_time').val();
        let room_no = $('#room_no').val();

        // Check if both fields are available (optional but safer)
        if (ot_date_time && room_no) {
            // Prepare FormData object
            let formData = new FormData();
            formData.append('ot_date', ot_date_time);
            formData.append('ot_room_pk', room_no);
            formData.append('doc', 'DOC');
            formData.append('_token', $('meta[name="csrf-token"]').attr('content')); // Ensure CSRF token is included

            $.ajax({
                url: "{{ route('v2.ipd.get-ot-slot') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    if (search !== null) {
                        blockUI();
                    }
                },
                success: function(response) {
                    $.unblockUI();

                    // Populate values from response
                    $("#procedure_name").val(response.procedure_name || '');
                    $("#ot_id").val(response.ot_id || '');
                    $("#ot_req_no_fk").val(response.ot_req_no_fk || '');
                    $("#doctor_name").val(response.doctor_name || '');
                    $("#doctor_id").val(response.doctor_id || '');

                    // Handle schedule list
                    if (Array.isArray(response.data) && response.data.length > 0) {
                        setOTRequsition(response.data);
                    } else {
                        emptySchedule();
                    }
                },
                error: function(err) {
                    emptySchedule();
                    let error = err.responseJSON || {
                        message: 'Something went wrong!'
                    };
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }


    function setOTRequsition(data) {


        var tbl = ``;
        var patient_id = '{{ @$patient_info->patient_no_pk }}';
        data.forEach(function(item, index) {
            if (item.time.length > 0) {
                tbl += `
                        <div class="col-4 p-0" style="max-height:300px; overflow-y:auto; border:1px solid #ccc;">
                            <table style="width:100%" class="table table-bordered table-striped mb-0 room_table">
                                <thead class="thead-light">
                                <tr>
                                    <th class="text-center" colspan="2"><h5 class="mb-0">${item.room_name}</h5></th>
                                </tr>
                                </thead>
                                <tbody>`;

                item.time.forEach(function(item2, index) {
                    title =
                        `Patient Name : ${item2.patient_name} &#10;UHID : ${item2.patient_code} &#10;IP No : ${item2.admission_no_fk} &#10;Bed Name : ${item2.bed_name} &#10;Ward Name : ${item2.ward_name} &#10;Surgeon Name : ${item2.person_no_pk} - ${item2.full_name}`;

                    tbl += `<tr class="${item2.available_ind == 0 ? 'bg-success text-white' : ''}">
                                                <td class="w-20" style="padding-top: 7px !important"><input type="checkbox" id="${item2.ot_slot_no_pk}" value="${item2.ot_slot_no_pk}" name="ot_time[]" form="ot_requsition" ${item2.available_ind == 0 ? 'checked' : ''} ${patient_id != item2.patient_no_fk && item2.available_ind == 1 ? '' : (patient_id == item2.patient_no_fk ? '' : 'disabled')}></td>
                                                <td class="w-80 text-left fs-15" style="padding-left:6px !important;vertical-align:center" title="${item2.available_ind == 0 ? title : ''}"><label for="${item2.ot_slot_no_pk}">${item2.start_time} - ${item2.end_time} </b></label></td>
                                            </tr>`;
                })


                tbl += `</tbody>
                        </table>
                    </div>`;
            }
        });

        $('#ot_data').html(tbl)


    }

    function emptySchedule() {
        $('#ot_data').html(
            `<div class="col-12 "><h4 class="text-center text-danger py-5">Schedule Not Found</h4></div>`);
    }



    $(document).on('click', "input[name='ot_time[]']", function() {
        // Uncheck all other checkboxes in the group
        $("input[name='ot_time[]']").not(this).prop('checked', false);

        // Update hidden input with selected slot ID or clear if none
        const selected = $(this).is(':checked') ? this.value : '';
        $("#ot_slot_id").val(selected);

        // Optional: notify if none selected
        if (!selected) {
            alert('Please select a schedule!');
        }
    });

    $(function() {
        $('#slotBookingForm').on('submit', function(e) {
            e.preventDefault();
            let $form = $(this),
                url = $form.attr('action'),
                data = $form.serialize();

            // Disable button to prevent multiple submits
            $('#submitBtn').prop('disabled', true).text('Saving...');

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        alert('Slot booked successfully.');
                        // Optionally reset, redirect, or update page
                    } else {
                        alert('Error: ' + (res.message || 'Unknown error'));
                    }
                },
                error: function(xhr) {
                    let err = xhr.responseJSON?.errors;
                    if (err) {
                        // Display validation errors
                        Object.keys(err).forEach(key => {
                            let msg = err[key][0];
                            $(`[name="${key}"]`).addClass('is-invalid')
                                .after(
                                `<div class="invalid-feedback">${msg}</div>`);
                        });
                    } else {
                        alert('AJAX error: ' + xhr.status);
                    }
                },
                complete: function() {
                    $('#submitBtn').prop('disabled', false).text('Save & Continue');
                }
            });
        });
    });


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
            display: 'ot_item',
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
            $('#item_hidden_id').val(item.item_id); // Set hidden/input field value
            $('#ot_item').val(item.item_name); // For input field
            $('#ot_item').text(item.item_name); // For span/div/etc. (only one is needed)
            $('#ot_item').attr('placeholder', item.item_name); // For span/div/etc. (only one is needed)

            $("#investigation_item").css('display', 'none'); // Hide investigation item container
            $("#ot_item").css('display', ''); // Show item name container



            $("#item_hidden_id").val(item.item_id)

            // Clear input after selection
            $(element).typeahead('val', '');

            obj.stopImmediatePropagation();
        });
    }
</script>
