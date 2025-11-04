<style>
    .sticky_header {
        position: sticky;
        top: 90px;

    }
</style>
<div class="card" style="overflow-x: scroll;">
    <div class="card-body">

        @if (!empty($schedule))
        {{-- <table style="width:30%">
                <tr> --}}
        <div class="d-inline-flex">

            @php
            $sl = 0;
            @endphp

            @if (count($schedule) > 0)
            @foreach ($schedule as $key => $value)
            @if ($value->isNotEmpty())
            {{-- @dd($value);
                    @dd('ok'); --}}
            @php
            $date_explode = explode('_', $key);
            $sl++;
            @endphp

            <div style=" width: 330px;">
                <div class="card mt-0">
                    <div class="card-body" style="padding-top:0; ">
                        <div class="">
                            <h5>{{ ucwords($date_explode[1]) }}</h5>
                            <div style="border-top:1px solid black">


                                <button type="button" class="btn btn-danger block"
                                    id="block_{{ $sl }}" data-sl="{{ $sl }}"
                                    data-docno='{{ $date_explode[0] }}' data-toggle="modal"
                                    data-target="#exampleModal" onclick="setData(this)">Block</button>
                                <button type="button" class="btn btn-warning unblock"
                                    id="unblock_{{ $sl }}" data-sl="{{ $sl }}"
                                    data-docno='{{ $date_explode[0] }}' data-toggle="modal"
                                    data-target="#exampleModal" onclick="setData(this)">Unblock</button>
                            </div>
                        </div>


                        <div class="table-responsive table-y-overflow patient__table">
                            <table class="table table-bordered table-hover table-striped time_slot">
                                <thead class="sticky_header">
                                    <tr>
                                        <th class="" colspan="4"></th>
                                    </tr>
                                </thead>
                                <tbody id="slot_list">
                                    @if (!empty($value))
                                    @php
                                    $data_ind = 0;
                                    @endphp
                                    {{-- @if (isset($value['block_reason']))
                                                    <tr>
                                                        <td>{{ $value['block_date'] }}</td>
                                    </tr>
                                    <tr class="table-row">
                                        <td>{{ $value['block_reason'] }}</td>
                                    </tr>
                                    @else --}}
                                    {{-- {{dd($value)}} --}}



                                    @foreach ($value as $row)
                                    @php
                                    $data_ind = !empty($row) ? 1 : 0;
                                    @endphp
                                    @if ($row->available_ind != 1)
                                    @php
                                    $app_status_color = '';

                                    if (
                                    !empty($row->ot_comfirmation_ind) &&
                                    $row->ot_comfirmation_ind == 1
                                    ) {
                                    $app_status_color =
                                    'background-color:gray; color:white; border-radius:5px;';
                                    } elseif (
                                    !empty($row->available_ind) &&
                                    $row->available_ind == 1
                                    ) {
                                    $app_status_color =
                                    'background-color:green; color:white; border-radius:5px;';
                                    }

                                    $startTime = !empty($row->start_time)
                                    ? date('h:i a', strtotime($row->start_time))
                                    : '--';
                                    $endTime = !empty($row->end_time)
                                    ? date('h:i a', strtotime($row->end_time))
                                    : '--';
                                    @endphp

                                    <tr class="table-row @if ($row->ot_status_ind == 1) bg-danger  @elseif($row->ot_status_ind == 2) bg-success @endif"
                                        id="table-row-{{ $row->ot_slot_no_pk }}"
                                        data-slot_id="{{ $row->ot_slot_no_pk }}">
                                        <th></th>
                                        <th style="width: 150px;">
                                            {{ $startTime }}-{{ $endTime }}
                                            {{-- <sup>{{ $startTime }}-{{ $endTime }}</sup> --}}
                                            <input type="hidden" id="app_info"
                                                data-slot_no="{{ $row->ot_slot_no_pk }}"
                                                value="{{ $row->start_time }}">
                                        </th>
                                        <td colspan="3" class="text-left"
                                            style="{{ $app_status_color }}"
                                            title="{{ $row->patient_code ?? '' }}&#10;{{ $row->patient_name ?? '' }}&#10;{{ $row->appoint_type_code ?? '' }} : {{ $startTime }}-{{ date('h:i a', strtotime($row->end_time)) }}">
                                            {{ $row->patient_name ?? '' }}
                                        </td>
                                    </tr>

                                    <div class="context-menu"
                                        id="context-menu-{{ $row->ot_slot_no_pk }}">
                                        <ul>
                                            @if ($row->ot_comfirmation_ind == 1)
                                            <li>
                                                @if ($row->ot_book_ind == 1)
                                                <a target="_blank"
                                                    class="text-success"
                                                    href="{{ route('ot.booking.pdf', $row->ot_req_no_pk) }}">
                                                    OT Booked (Form)
                                                </a>
                                                @else
                                                <a target="_blank"
                                                    href="{{ route('ot.ot-booking-form', $row->ot_req_no_pk) }}">
                                                    OT BOOKING
                                                </a>
                                                @endif

                                            </li>
                                            @endif
                                            {{-- <li>
                                                                            <a target="_blank"
                                                                                href="{{ route('uhl.requisition_details_form', $row->ot_slot_no_pk) }}">
                                            REQUISITION DETAILS
                                            </a>
                                            </li> --}}

                                            @if (!empty($row->patient_no_fk))
                                            <li>
                                                <span class="open-modal"
                                                    data-modal="common-modal"
                                                    data-id="{{ $row->patient_no_fk }}"
                                                    data-title="Patient Information"
                                                    data-action="{{ route('registration.show', $row->patient_no_fk) }}"
                                                    rel="tab">
                                                    PATIENT DETAILS
                                                </span>
                                            </li>
                                            @endif



                                            @if ($row->ot_comfirmation_ind == 1)



                                            <li style="background: greenyellow;">
                                                <span class="text-success">OT
                                                    Confirmed </span>
                                            </li>
                                            @if (!in_array($row->ot_status_ind,[1,2]))

                                            <li>
                                                <span
                                                    style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                    class=" open-modal"
                                                    data-modal="common-modal-sm"
                                                    {{-- data-id="{{ $row->appoint_no_pk }}" --}}
                                                    data-title="CANCEL APPOINTMENT"
                                                    data-action="{{ route('ot.cancel-booking', $row->ot_slot_no_pk) }}"
                                                    rel="tab">OT CANCELLATION
                                                </span>
                                            </li>
                                            @endif
                                            @else
                                            <li>
                                                @if(session('user.ses_hospital_code') != 'UNICO')

                                                @inject('checkBill', 'App\Http\Controllers\OTController')
                                                @php
                                                $checkBill = $checkBill->getBillAndOtConfirmed($row->ot_slot_no_pk);
                                                @endphp

                                                @if($checkBill && $checkBill->bill_clearence_ind === '1' && $checkBill->pac_clearence_ind === '1')
                                                <span
                                                    data-id="{{ $row->ot_req_no_pk }}"
                                                    data-title="OT Confirmation"
                                                    onClick="changeStatus({{ $row->ot_req_no_pk }}, 'Confirm')">
                                                    OT CONFIRMATION
                                                </span>
                                                @else
                                                <span style=" color: red; text-decoration: none;background-color: ;">Bill and PAC is not Clear Yet</span>
                                                @endif


                                                @else

                                                <span
                                                    data-id="{{ $row->ot_req_no_pk }}"
                                                    data-title="OT Confirmation"
                                                    onClick="changeStatus({{ $row->ot_req_no_pk }}, 'Confirm')">
                                                    OT CONFIRMATION
                                                </span>

                                                @endif

                                            </li>
                                            <li>
                                                <span
                                                    style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                    class=" open-modal"
                                                    data-modal="common-modal-sm"
                                                    {{-- data-id="{{ $row->appoint_no_pk }}" --}}
                                                    data-title="CANCEL APPOINTMENT"
                                                    data-action="{{ route('ot.cancel-booking', $row->ot_slot_no_pk) }}"
                                                    rel="tab">OT CANCELLATION
                                                </span>
                                            </li>
                                            @endif



                                            <li>
                                                @if ($row->appoint_type_code == 'IPD')
                                                <a href="{{ route('ipd.admission-print-pdf', $row->admission_no_fk) }}"
                                                    target="_blank"
                                                    data-id="{{ $row->admission_no_fk }}"
                                                    id="admission_id"
                                                    title="Admission request form">
                                                    ADMISSION DETAILS
                                                </a>
                                                @endif

                                            </li>

                                            @inject('findAdmissionDetails', 'App\Http\Controllers\OTController')

                                            @php
                                            $ckAdmission = $findAdmissionDetails->findAdmissionDetails(
                                            $row->patient_no_fk,
                                            );
                                            @endphp



                                            @if ($ckAdmission)
                                            @if ($row->admission_no_fk == '')
                                            <li>
                                                <span
                                                    style="cursor: pointer; color: green;"
                                                    data-admission-id="{{ $ckAdmission->admission_no_pk }}"
                                                    data-title="OT Confirmation"
                                                    onClick="updateAdmission({{ $row->ot_req_no_pk }}, 'Update IPD',{{ $ckAdmission->admission_no_pk }})">
                                                    Admission Update
                                                </span>
                                            </li>
                                            @else
                                            <li style=" background: greenyellow;">
                                                <span style="color: red;">
                                                    IPD Admitted </span>
                                            </li>

                                            @if ($row->ot_status_ind == 0 || $row->ot_status_ind == '')
                                            <li
                                                style=" background: rgb(246, 247, 245); border: 1px solid #000;;">
                                                <span
                                                    style="cursor: pointer; color: green;"
                                                    data-admission-id="{{ $ckAdmission->admission_no_pk }}"
                                                    data-title="OT Start"
                                                    onClick="otStatusChange({{ $row->ot_req_no_pk }}, 'START',{{ $ckAdmission->admission_no_pk }})">
                                                    OT Start
                                                </span>
                                            </li>
                                            @elseif($row->ot_status_ind == 1)
                                            <li
                                                style=" background: rgb(235, 41, 99); border: 1px solid #000;;">
                                                <span
                                                    style="cursor: pointer; color: green;"
                                                    data-admission-id="{{ $ckAdmission->admission_no_pk }}"
                                                    data-title="OT Start"
                                                    onClick="otStatusChange({{ $row->ot_req_no_pk }}, 'END',{{ $ckAdmission->admission_no_pk }})">
                                                    OT End
                                                </span>
                                            </li>
                                            @elseif($row->ot_status_ind == 2)
                                            <li
                                                style=" background: greenyellow;">
                                                <span style="color: red;">
                                                    OT COMPLETED </span>
                                            </li>
                                            @endif
                                            @endif
                                            @endif





                                        </ul>
                                    </div>
                                    @else
                                    @php
                                    $block_ind =
                                    $row->status == 'Blocked'
                                    ? ''
                                    : '<input type="checkbox" class="block_ind" value="' .
                                                                                htmlspecialchars($row->ot_slot_no_pk) .
                                                                                '">';

                                    $startTime = !empty($row->start_time)
                                    ? date('h:i a', strtotime($row->start_time))
                                    : '--';
                                    $endTime = !empty($row->end_time)
                                    ? date('h:i a', strtotime($row->end_time))
                                    : '--';
                                    @endphp
                                    <tr class="table-row"
                                        id="table-row-{{ $row->ot_slot_no_pk }}"
                                        data-slot_id="{{ $row->ot_slot_no_pk }}">
                                        <th>@php echo $block_ind @endphp</th>
                                        <th style="width: 150px;">
                                            {{ $startTime }}-{{ $endTime }}
                                            {{-- <sup>{{ $startTime }}-{{ $endTime }}</sup> --}}
                                            <input type="hidden" id="app_info"
                                                data-slot_no="{{ $row->ot_slot_no_pk }}"
                                                value="{{ $row->start_time }}">
                                        </th>
                                        <td colspan="3"
                                            class="{{ $row->status == 'blocked' ? 'badge badge-danger d-block' : '' }}">
                                            <span
                                                title="{{ $row->status == 'blocked' ? 'Block Reason: ' . $row->block_reason . '. This slot is blocked by ' . $row->user_fullname : '' }}"
                                                class="{{ $row->status == 'blocked' ? 'text-warning' : '' }}">{{ $row->status == 'blocked' ? 'Blocked' : '' }}</span>
                                        </td>
                                    </tr>

                                    @if ($row->status == 'blocked')
                                    <div class="context-menu"
                                        id='context-menu-{{ $row->ot_slot_no_pk }}'>
                                        <ul>

                                            <li>
                                                <span
                                                    style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                    data-id="{{ $row->ot_slot_no_pk }}"
                                                    data-title="UNDO SLOT BLOCK REASON"
                                                    data-action="{{ route('ot.slot-book', $row->ot_slot_no_pk) }}"
                                                    rel="tab">Undo
                                                    Break/Block/Reserve</span>
                                            </li>


                                        </ul>
                                    </div>
                                    @else
                                    <div class="context-menu"
                                        id='context-menu-{{ $row->ot_slot_no_pk }}'>
                                        <ul>
                                            <!-- <li>
                                                 <button type="button"
                                                                                    class="btn btn-info js-book-slot"
                                                                                    data-slot_id="{{ $row->ot_slot_no_pk }}"
                                                data-req_id="{{ $req_id }}"
                                                data-pres_id="{{ $prescription_no_fk }}"
                                                data-url="{{ route('ot.slot-book', $row->ot_slot_no_pk) }}">
                                                New Slot Book
                                                </button

                                                <a href="{{ route('ot.slot-book', $row->ot_slot_no_pk) }}"
                                                    rel="tab">New Slot Book</a>
                                            </li> -->
                                            {{-- <li>
                                                                                <span
                                                                                    style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                                                    class=" open-modal"
                                                                                    data-modal="common-modal-sm"
                                                                                    data-id="{{ $row->ot_slot_no_pk }}"
                                            data-title="SLOT BLOCK REASON"
                                            data-action="{{ route('uhl.slot-block', $row->ot_slot_no_pk) }}"
                                            rel="tab">Break/Block/Reserve</span>
                                            </li>

                                            <li>
                                                <span
                                                    style=" color: rgb(52, 144, 220); text-decoration: none;background-color: transparent;"
                                                    class=" open-modal"
                                                    data-modal="common-modal-md"
                                                    data-id="{{ $date_explode[0] }}"
                                                    data-title="Doctor Information"
                                                    data-action="{{ route('employees.show', $date_explode[0]) }}"
                                                    rel="tab">Doctor
                                                    Profile</span>
                                            </li> --}}

                                        </ul>
                                    </div>
                                    @endif
                                    @endif
                                    @endforeach
                                    {{-- @if ($data_ind == 1)
                                                            @if (Session::get('user.ses_hospital_code') == 'UNICO')
                                                                @if (Session::get('user.inv_hod_ind') == 1)
                                                                    <tr>
                                                                        <th colspan="2"><strong>Add Slot</strong>
                                                                        </th>
                                                                        <td style="text-align: right">
                                                                            <button type="button"
                                                                                class="btn btn-primary cursor-pointer"
                                                                                onclick="add_slot(this)"> <i
                                                                                    class="fa fa-plus"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @else
                                                                <tr>
                                                                    <th colspan="2"><strong>Add Slot</strong></th>
                                                                    <td style="text-align: right">
                                                                        <button type="button"
                                                                            class="btn btn-primary cursor-pointer"
                                                                            onclick="add_slot(this)"> <i
                                                                                class="fa fa-plus"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif --}}
                                    {{-- @endif --}}
                                    @endif

                                </tbody>
                            </table>
                            <input type='hidden' value='' id='txt_id'>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        {{-- </tr>
        </table> --}}

        @endif
        @else
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body" style="padding-top:0;height: 468px;">
                            <div class="appointment-box">
                                <h3> OT BOOKING</h3>
                                <img src="{{ asset('images/ot.png') }}" alt="appointment" style="width: 30%;" ;>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif


    </div>

</div>
<div class="card">
    <div class="card-body">
        <div class="form-row">
            <div class="col-md-12">
                <ul class="grid__box">
                    <li class="bg_patient">
                        <div class="inner__box">
                            <div class="count">
                                <h4 class="number">
                                    {{ isset($total_app_count->pending_count) ? $total_app_count->pending_count : '0' }}
                                </h4>
                                <span class="icon"><i class="fas fa-user-injured"></i></span>
                            </div>
                            <p>Pending</p>
                        </div>
                    </li>
                    <li class="bg_appointment">
                        <div class="inner__box">
                            <div class="count">
                                <h4 class="number">
                                    {{ isset($total_app_count->booked_count) ? $total_app_count->booked_count : '0' }}
                                </h4>
                                <span class="icon"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <p>Booked</p>
                        </div>
                    </li>
                    {{-- <li class="bg_confirmed">
                        <div class="inner__box">
                            <div class="count">
                                <h4 class="number">
                                    {{ isset($total_app_count->confirmed) ? $total_app_count->confirmed : '0' }}</h4>
                    <span class="icon"><i class="fas fa-calendar-check"></i></span>
            </div>
            <p>Confirmed</p>
        </div>
        </li>
        <li class="bg_checked">
            <div class="inner__box">
                <div class="count">
                    <h4 class="number">
                        {{ isset($total_app_count->chk) ? $total_app_count->chk : '0' }}
                    </h4>
                    <span class="icon"><i class="fas fa-spell-check"></i></span>
                </div>
                <p>Checked In</p>
            </div>
        </li> --}}
        <li class="bg_cancel">
            <div class="inner__box">
                <div class="count">
                    <h4 class="number">
                        {{ isset($total_app_count->cancel_count) ? $total_app_count->cancel_count : '0' }}
                    </h4>
                    <span class="icon"><i class="fas fa-window-close"></i></span>
                </div>
                <p>Cancelled</p>
            </div>
        </li>
        <li class="bg_payment">
            <div class="inner__box">
                <div class="count">
                    <h4 class="number">
                        {{ isset($total_app_count->available_count) ? $total_app_count->available_count : '0' }}
                    </h4>
                    <span class="icon"><i class="fas fa-money-check-alt"></i></span>
                </div>
                <p>Available</p>
            </div>
        </li>
        <li class="bg_seen">
            <div class="inner__box">
                <div class="count">
                    <h4 class="number">
                        {{ isset($total_app_count->total_count) ? $total_app_count->total_count : '0' }}
                    </h4>
                    <span class="icon"><i class="fas fa-user-md"></i></span>
                </div>
                <p>Total</p>
            </div>
        </li>
        </ul>
    </div>
</div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <div class="modal-body">
            <label for="message-text" class="col-form-label">Reason:</label>
            <textarea class="form-control" id="reasonText" data-reason="" name="" id="message-text" required></textarea>

        </div> --}}
            <div class="modal-footer">
                {{-- <label for="message-text" class="col-form-label text-left">Reason:</label> --}}
                <textarea class="form-control" id="reasonText" name="" id="message-text" required></textarea>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-sm btn-danger" id="block_{{$sl}}" data-docno='{{$date_explode[0]}}' onclick="saveBlock(this)">Block</button>
                <button type="button" class="btn btn-sm btn-warning" id="unblock_{{$sl}}" data-docno='{{$date_explode[0]}}' onclick="saveBlock(this)">Unblock</button> --}}
                <input type="hidden" name="idSlNo" id="idSlNo" value="">
                <input type="hidden" name="docNo" id="docNo" value="">
                <button type="button" class="btn  btn-danger" data-dismiss="modal" id="save_block"
                    onclick="saveBlock(this)">Block</button>
                <button type="button" class="btn  btn-warning" data-dismiss="modal" id="save_unblock"
                    onclick="saveBlock(this)">Unblock</button>
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>

<script>
    function setData(element) {
        let sl = $(element).data('sl');
        let docno = $(element).data('docno');
        let idName = $(element).attr('id');
        $('#idSlNo').val(sl);
        $('#docNo').val(docno);
        if (idName == "block_" + sl) {
            $('#save_block').removeClass('d-none');
            $('#save_unblock').addClass('d-none');
        } else {
            $('#save_block').addClass('d-none');
            $('#save_unblock').removeClass('d-none');
        }
    }

    function saveBlock(element) {
        // let doc_no=$(element).data('docno');
        let doc_no = $(element).siblings('#docNo').val();
        let reasonText = $(element).siblings('#reasonText').val();
        let findSiblingsSl = $(element).siblings('#idSlNo').val();
        let type = $(element).attr('id') == 'save_block' ? 1 : 0;
        var slot_no = $('#block_' + findSiblingsSl)
            .parents('div')
            .parents('div')
            .siblings('div')
            .children('table')
            .children('tbody')
            .find('.block_ind:checked')
            .map(function() {
                return $(this).val(); // Get the value of each '.block_ind' element
            })
            .get();


        if (slot_no.length === 0) {
            alert('Select Slot');
            return false;
        }
        if (reasonText == '') {
            alert('Enter Reason');
            return false;
        }
        console.log(reasonText, type, slot_no)
        // return false;
        var url = "{{ route('uhl.array-slot-block') }}";


        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: {
                    slot_no: slot_no,
                    doc_no: doc_no,
                    cancel_reason: reasonText,
                    type: type,
                },
                url: url,
                type: "post",
                cache: false,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    //  $('#search_btn').click();
                },
                complete: function() {
                    // $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $('#search_btn').click();
                $.unblockUI();
                // dynamicFunc.afterSaveLoadPage($(element).attr('data-res-url'));
            });
        }
    }

    function add_slot(element) {
        var slot_no = $(element).parents('tr').prev().find('#app_info').attr('data-slot_no');
        var time = $(element).parents('tr').prev().find('#app_info').val();
        var url = "{{ route('uhl.add-slot') }}";
        console.log(slot_no)
        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: {
                    slot_no: slot_no,
                },
                url: url,
                type: "post",
                cache: false,
                beforeSend: function() {

                    blockUI();
                },
                success: function(data) {
                    $('#search_btn').click();
                },
                complete: function() {
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();
                dynamicFunc.afterSaveLoadPage($(element).attr('data-res-url'));
            });
        }
    }
    $(document).ready(function() {
        var slot_id_open = '';
        // disable right click and show custom context menu
        $(".time_slot tr").bind('contextmenu', function(e) {
            var id = this.id; //$(this).attr('class');
            var slot_id = $(this).data('slot_id');
            $("#context-menu-" + slot_id).hide();

            $("#txt_id").val(id);

            var top = e.pageY;
            var left = e.pageX;

            // Show contextmenu
            $(".context-menu").hide();
            $("#context-menu-" + slot_id).toggle(100)
                .css({
                    top: top - 200 + "px",
                    //left: left + "px"
                });

            // disable default context menu
            return false;
        });

        // Hide context menu
        $(document).bind('contextmenu click', function() {

            $(".context-menu").hide();
            $("#txt_id").val("");
        });

        // disable context-menu from custom menu
        $('.context-menu').bind('contextmenu', function() {
            return false;
        });

        // Clicked context-menu item
        $('.context-menu li').click(function() {
            var className = $(this).find("span:nth-child(1)").attr("class");
            var titleid = $('#txt_id').val();
            $("." + titleid).css("background-color", className);
            $(".context-menu").hide();
        });

    });

    function statusChange(element) {
        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: {
                    ot_req_no_pk: $(element).attr('data-appoint'),
                    type: $(element).attr('data-type'),
                },
                url: $(element).attr('data-url'),
                type: "post",
                cache: false,
                beforeSend: function() {

                    blockUI();
                },
                success: function(data) {
                    if (data.title == 'Success') {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    } else {
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(data.title);
                        $('.common-modal-notify-error .modal-body').html(data.msg);
                    }
                },
                complete: function() {

                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();
                dynamicFunc.afterSaveLoadPage($(element).attr('data-res-url'));
            });
        }
    }


    function changeStatus(ot_req_id, status) {
        if (!confirm('Are you sure to change status to ' + status + '?')) return;

        $.ajax({
            url: "{{ route('ot.ot-requisition-status-update-v2') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                ot_req_id: ot_req_id,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    alert('Status updated successfully');
                    location.reload();
                } else {
                    alert('Failed to update status');
                }
            },
            error: function() {
                alert('Something went wrong');
            }
        });
    }

    function updateAdmission(ot_req_id, status, admissionId) {
        if (!confirm('Are you sure to change status to ' + status + '?')) return;
        console.log(ot_req_id, status, admissionId)
        $.ajax({
            url: "{{ route('ot.ot-admission-status-update-v2') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                ot_req_id: ot_req_id,
                admissionId: admissionId,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    alert('updated successfully');
                    location.reload();
                } else {
                    alert('Failed to update status');
                }
            },
            error: function() {
                alert('Something went wrong');
            }
        });
    }

    function otStatusChange(ot_req_id, status, admissionId) {
        if (!confirm('Are you sure to change status to ' + status + '?')) return;
        console.log(ot_req_id, status, admissionId)
        $.ajax({
            url: "{{ route('ot.ot-running-status-status-v2') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                ot_req_id: ot_req_id,
                admissionId: admissionId,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    alert('updated successfully');
                    location.reload();
                } else {
                    alert('Failed to update status');
                }
            },
            error: function() {
                alert('Something went wrong');
            }
        });
    }

    $(document).on('click', '.js-book-slot', function(e) {
        e.preventDefault(); // prevent default button behavior

        const $btn = $(this);

        const slotId = $btn.data('slot_id');
        const reqId = $btn.data('req_id');
        const presId = $btn.data('pres_id');

        // alert(`slotId=${slotId}, reqId=${reqId}, presId=${presId}`);

        const urlTemplate = "{{ route('ot.slot-book-store') }}";

        $.ajax({
                url: urlTemplate,
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    reqId: reqId,
                    slotId: slotId,
                    presId: presId,
                },
            })
            .done(data => {
                alert(data.message || 'Slot booked successfully.');
                window.location.href = "{{ route('ot/today-patient-list') }}";
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.error('Booking error:', textStatus, errorThrown);
                alert('Failed to book slot. Please try again.');
            });
    });
</script>