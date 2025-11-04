<div class="row">
    <div class="col-md-3 col-lg-3 col-sm-3">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="card mt-0 bg-none">
                    <div class="card-header">
                        <span id="favourit_list_title" data-append-to="">Favourite List</span>
                        <span class="loading-img"></span>
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow:scroll;">
                        <div class="form-group mt-2">
                            <input type="search" class="form-control form-control-sm " id="favListSearch"
                                name="" onkeyup="favoriteListSearch(this)" searcAttrvalue=''
                                placeholder="Search Favourite Item">
                        </div>
                        <table class="table m-0">
                            <tbody id="pres-favourit-list-ot" style="word-break: break-all;">
                                @include('admin.prescription.uhl.pres_favourit_list')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9 col-lg-9 col-sm-9 p-0 border-left shadow-sm mt-3">
        <div class="card-body border-top">
            <div class="form-row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="form-group">
                        <div class="card mt-0">
                            <div class="card-body p-0">
                                <div class="form-group mt-3">
                                    <label for="ot_name" class="col-form-label col-form-label-sm">OT / Procedure Name</label>
                                    {{-- <input type="text" id="ot_name" name="ot_name" class="form-control form-control-sm"> --}}
                                    <input type="text" class="form-control form-control-sm m-0 p-0 item_element mb-0"
                                        id="ot_item" name="ot_item" placeholder="Enter OT Name"
                                        lookup-code="PROCEDURE"
                                        onclick="prescriptionV2.loadToPresFavouritListV2(this,'PROCEDURE','OT Fav. List','#ot_list', '{{ $action_url }}','#pres-favourit-list-ot')"
                                        data-append-id="ot_list">

                                    {{-- @php
                                        $class = !empty($pr_arr) ? ' border p-1' : '';
                                    @endphp
                                    <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="ot_list">
                                    </ul> --}}
                                    @if (!empty($pr_arr))
                                        @php
                                            $class = !empty($pr_arr) ? ' border p-1' : '';
                                        @endphp
                                        <ul class="list-unstyled mb-0 pt-1 {{ $class }}" id="ot_list"
                                            style="width: 98%">
                                            @foreach ($pr_arr as $rows)
                                                @foreach ($rows as $row)
                                                    @php
                                                        $row_data = explode('_', $row);
                                                    @endphp
                                                    <li id="item-{{ $row_data[0] }}">
                                                        <input type="hidden" name="item_id[]"
                                                            value="{{ $row_data[0] }}" readonly="readonly">
                                                        <input class="left-element" type="hidden" name="item_name[]"
                                                            value="{{ $row_data[1] }}" readonly="readonly">
                                                        <input type="hidden" name="lookup_id[]"
                                                            value="{{ $row_data[2] }}" readonly="readonly">
                                                        <input type="hidden" name="lookup_code[]" value="PROCEDURE"
                                                            readonly="readonly">
                                                        <input type="hidden" name="lookupdata_code[]" value="PROCEDURE"
                                                            readonly="readonly">
                                                        <input type='hidden' name='unit_intensity[]'>
                                                        <input type='hidden' name='session_duration[]'>
                                                        <input type='hidden' name='no_of_session[]'>
                                                        <input type='hidden' name='session_mu[]'>
                                                        <input type='hidden' name='frequency[]'>
                                                        <input type='hidden' name='mode[]'>
                                                        <input type='hidden' name='in_m_duration[]'>
                                                        <input type='hidden' name='in_m_repetition[]'>
                                                        <input type='hidden' name='in_e_location[]'>
                                                        <i class="fa fa-angle-double-right"></i>
                                                        {{ $row_data[1] }}&nbsp;&nbsp;
                                                        <span class="float-right text-danger cursor-pointer"
                                                            title="Remove This Item"
                                                            onclick="removeParentElement(this)">
                                                            <i class="fa fa-times"></i>
                                                        </span>&nbsp;
                                                        <span class="float-right text-secondary mr-1 cursor-pointer"
                                                            style="font-size:11px;" title="Add To Favourite List"
                                                            onclick="prescriptionFunc.addToPresFavouritList(this)"
                                                            data-url="{{ $add_to_pres_url }}"
                                                            data-id="{{ $row_data[0] }}"
                                                            data-name="{{ $row_data[1] }}" data-type="PROCEDURE">
                                                            <i class="fa fa-star text-primary"></i>
                                                        </span>
                                                    </li>
                                                @endforeach
                                            @endforeach
                                        </ul>
                                    @else
                                        <ul class="list-unstyled mb-0 pt-1" id="ot_list" style="width: 98%"></ul>
                                    @endif
                                </div>

                                <div class="form-row align-items-end">
                                    <div class="form-group col-md-6">
                                        <label for="room_no" class="col-form-label col-form-label-sm">OT Room No.
                                            <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-sm font_size_12" id="room_no"
                                            name="room_no" onchange="getOTRequsition(1)">
                                            <option value="">Select Room</option>
                                            @foreach ($room_data as $data)
                                                <option value="{{ $data->room_no_pk }}">{{ $data->room_name }}
                                                    ({{ $data->room_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ot_date_time" class="col-form-label col-form-label-sm">OT
                                            Date <span class="text-danger">*</span></label>
                                        <input type="text" id="ot_date_time" name="ot_date_time"
                                            class="form-control form-control-sm"
                                            value="{{ old('ot_date_time', $ot_date_time ? \Carbon\Carbon::parse($ot_date_time)->format('d/m/Y') : '') }}"
                                            onchange="getOTRequsition(1)">


                                        <input type="hidden" name="ot_slot_id" id="ot_slot_id">
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">OT Room Info</div>
                                            <div class="card-body p-1">

                                                <div class="row py-0" id="ot_data">
                                                    <div class="col-12">
                                                        <h4 class="text-center text-success py-5">Schedule Fetching ...
                                                        </h4>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="advice" class="col-form-label col-form-label-sm">Advice</label>
                                    <textarea id="advice" name="advice" class="form-control form-control-sm" rows="3"> {{ $ot_advice ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getOTRequsition(search = null) {



        const otList = document.getElementById('ot_list');
        // Check if otList has any <li> children
        const hasItems = otList && otList.querySelectorAll('li').length > 0;

        if (!hasItems) {
            alert('Please add at least one OT item before proceeding.');
            return; // stop further execution
        }


        let ot_date_time = $('#ot_date_time').val();


        let room_no = $('#room_no').val();

        // Check if both fields are available (optional but safer)
        if (ot_date_time) {
            // Prepare FormData object
            let formData = new FormData();
            formData.append('ot_date', ot_date_time);
            formData.append('ot_room_pk', room_no);
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
                        <div class="col-3 py-0 pr-0" style="max-height:300px; overflow-y:auto; border:1px solid #ccc;">
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




</script>
