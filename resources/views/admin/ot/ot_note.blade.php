<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link href="{{ asset('css/redactor.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .redactor_box {
        margin-bottom: 0px;
    }
</style>

<div class="form-row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
        <div class="card mt-0">
            <div class="card-header">
                <h5><i class="fa fa-user"></i>&nbsp; Patient information</h5>
            </div>
            <div class="card-body border-bottom-3 p-2 d-flex align-items-center">
                <div class="patient-infos">
                    <table class="table mb-0 table-borderless">
                        <tbody>
                            <tr>
                                <th class="text-left">Name</th>
                                <td colspan="3" class="text-left">
                                    @if (!empty($ot_patient_info->patient_code))
                                        {{ $ot_patient_info->patient_name }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-left">Mobile Number</th>
                                <td colspan="3" class="text-left">
                                    {{ !empty($ot_patient_info->mobile1) ? $ot_patient_info->mobile1 : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-left">Age</th>
                                <td class="text-left">{{ !empty($ot_patient_info->age) ? $ot_patient_info->age : 'N/A' }}
                                </td>
                                <th class="text-left">Gender</th>
                                <td class="text-left">
                                    {{ !empty($ot_patient_info->gender_txt) ? $ot_patient_info->gender_txt : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="text-left">Blood Group</th>
                                <td class="text-left">
                                    {{ !empty($ot_patient_info->blood_group_txt) ? $ot_patient_info->blood_group_txt : 'N/A' }}
                                </td>
                                <th class="text-left">Marital Status</th>
                                <td class="text-left">
                                    {{ !empty($ot_patient_info->marital_status_txt) ? $ot_patient_info->marital_status_txt : 'N/A' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="patient-img text-center">
                    @if (!empty($ot_patient_info) && $ot_patient_info->patient_photo != '')
                        <img class="w-75 rounded"
                            src="{{ asset('img/uploads/patient_images/thumb/') }}/{{ $ot_patient_info->patient_photo }}"
                            alt="">
                    @else
                        @if (!empty($ot_patient_info) && $ot_patient_info->gender_txt == 'Male')
                            <img class="w-75 rounded" src="{{ asset('img/boy.jpg') }}" alt="">
                        @else
                            <img class="w-75 rounded" src="{{ asset('img/girl.jpg') }}" alt="">
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
        <div class="card mt-0">
            <div class="card-header">
                <h5><i class="fa fa-notes-medical"></i>&nbsp; Admission Details</h5>
            </div>
            <div class="card-body border-bottom-3 p-2 d-flex align-items-center">
                <div class="patient-infos border-right-0">
                    <table class="table mb-0 table-borderless">
                        <tbody>
                            <tr>
                                <th class="text-left">Admission ID</th>
                                <td colspan="3" class="text-left">
                                    {{ !empty($ot_patient_info->admission_uid) ? $ot_patient_info->admission_uid : 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <th class="text-left">Ward</th>
                                <td colspan="3" class="text-left">
                                    {{ !empty($ot_patient_info->ward_name) ? $ot_patient_info->ward_name : 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th class="text-left">Bed</th>
                                <td class="text-left">
                                    {{ !empty($ot_patient_info->bed_name) ? $ot_patient_info->bed_name : 'N/A' }}</td>
                            </tr>

                            <tr>
                                <th class="text-left">Doctor Name</th>
                                <td class="text-left">
                                    {{ !empty($ot_patient_info->surg_doctor_name) ? $ot_patient_info->surg_doctor_name : 'N/A' }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="ot-note-form" action="{{ route('ot.store-ot-note') }}" method="post">
    <div class="form-row">
        <input type="hidden" id="hidden_ot_req_no_pk" name ="hidden_ot_req_no_pk" value="{{ $ot_req_no_pk }}">
        <div class="col-md-6 pt-2">
            <div class="card p-0 m-0 border-0">
                <div class="card-header p-0 m-0 bg-navy">Pre OT Note</div>
                <div class="card-body p-0 m-0">
                    <textarea id="pre-ot" name ="pre_ot_note">{{ !empty($ot_patient_info->pre_ot_note) ? $ot_patient_info->pre_ot_note : '' }}</textarea>
                </div>
            </div>


            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="prepared_by">Prepared By</label>
                <input type="text" class="form-control form-control-sm" id="prepared_by" name="prepared_by"
                    value="{{ $prepared_by }}" placeholder="Prepared By" readonly>
                <input type="hidden" id="hidden_prepared_by_id" name="hidden_prepared_by_id"
                    value="{{ $prepared_by_id }}">
            </div>


            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="anest_name">Anest. Name</label>
                <select class="form-control form-control-sm select2" id="anest_name" name="anest_name">
                    @if (!empty($ot_patient_info->anest_doc_person_no_fk))
                        <option value="{{ $ot_patient_info->anest_doc_person_no_fk }}">
                            {{ $ot_patient_info->actual_anest_name }}</option>
                    @else
                        <option value="">Select Anesthesiologist Name</option>
                    @endif
                    @if (!empty($anesthesiologists))
                        @foreach ($anesthesiologists as $anest)
                            <option value="{{ $anest->person_no_pk }}">{{ $anest->full_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="ot_room">OT Room</label>
                <select class="form-control form-control-sm select2" id="ot_room" name="ot_room">
                    @if (!empty($ot_patient_info->ot_room_no_fk))
                        <option value="{{ $ot_patient_info->ot_room_no_fk }}">{{ $ot_patient_info->ot_room_uid }}
                        </option>
                        <input type="hidden" name="ot_room_name" value="{{ $ot_patient_info->ot_room_uid }}">
                    @else
                        <option value="">Select Room Name</option>
                        @if (!empty($ot_room_list))
                            @foreach ($ot_room_list as $ot_room)
                                <option value="{{ $ot_room->room_no_pk }}">{{ $ot_room->room_name }}</option>
                            @endforeach
                        @endif
                    @endif
                </select>
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="in_ot_date">In OT Date</label>
                        <input type="text" class="form-control form-control-sm date_picker" id="in_ot_date"
                            name="in_ot_date"
                            value="{{ !empty($ot_patient_info->ot_in_time) ? date('d-m-Y', strtotime($ot_patient_info->ot_in_time)) : '' }}"
                            placeholder="dd/mm/yyyy">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="in_ot_time">In OT Time</label>
                        <input type="text" class="form-control form-control-sm timepicker" id="in_ot_time"
                            name="in_ot_time"
                            value="{{ !empty($ot_patient_info->ot_in_time) ? date('H:i:s', strtotime($ot_patient_info->ot_in_time)) : '' }}"
                            placeholder="--:--:--">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 pt-2">
            <div class="card p-0 m-0 border-0">
                <div class="card-header p-0 m-0 bg-navy">Post OT Note</div>
                <div class="card-body p-0 m-0">
                    <textarea id="post-ot" name ="post_ot_note">{{ !empty($ot_patient_info->post_ot_note) ? $ot_patient_info->post_ot_note : '' }}</textarea>
                </div>
            </div>


            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="surgeon_name">Surgeon Name</label>
                <select class="form-control form-control-sm select2" id="surgeon_name" name="surgeon_name">
                    @if (!empty($ot_patient_info->surg_doc_person_no_fk))
                        <option value="{{ $ot_patient_info->surg_doc_person_no_fk }}">
                            {{ $ot_patient_info->surg_doctor_name }}</option>
                    @else
                        <option value="">Select Surgeon Name</option>
                    @endif
                    @if (!empty($surgeons))
                        @foreach ($surgeons as $surgeon)
                            <option value="{{ $surgeon->person_no_pk }}">{{ $surgeon->full_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="form-group">
                <label class="col-form-label col-form-label-sm" for="operation_name">Operation Name</label>
                <input type="text" class="form-control form-control-sm" id="operation_name" name="operation_name"
                    value="{{ !empty($ot_patient_info->item_name) ? $ot_patient_info->item_name : '' }}"
                    placeholder="Operation Name" readonly>
                <input type="hidden" id="hidden_operation_id" name="hidden_operation_id"
                    value="{{ !empty($ot_patient_info->item_no_fk) ? $ot_patient_info->item_no_fk : '' }}">
                <!-- <select class="form-control form-control-sm" id="operation_name" name="operation_name">
     <option value="">Choose Operation</option>
     <option value="">Operation-1</option>
     <option value="">Operation-2</option>
    </select> -->
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="ot_date">OT Date and Time</label>
                        <input type="text" class="form-control form-control-sm date_picker" id="ot_date"
                            name="ot_date"
                            value="{{ !empty($ot_patient_info->ot_date) ? date('d-m-Y', strtotime($ot_patient_info->ot_date)) : '' }}"
                            placeholder="dd/mm/yyyy">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="ot_time">&nbsp;</label>
                        <input type="text" class="form-control form-control-sm timepicker" id="ot_time"
                            name="ot_time"
                            value="{{ !empty($ot_patient_info->ot_date) ? date('H:i:s', strtotime($ot_patient_info->ot_date)) : '' }}"
                            placeholder="--:--:--">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="out_ot_date">Out OT Date</label>
                        <input type="text" class="form-control form-control-sm date_picker" id="out_ot_date"
                            name="out_ot_date"
                            value="{{ !empty($ot_patient_info->ot_out_time) ? date('d-m-Y', strtotime($ot_patient_info->ot_out_time)) : '' }}"
                            placeholder="dd/mm/yyyy">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label col-form-label-sm" for="out_ot_time">Out OT Time</label>
                        <input type="text" class="form-control form-control-sm timepicker" id="out_ot_time"
                            name="out_ot_time"
                            value="{{ !empty($ot_patient_info->ot_out_time) ? date('H:i:s', strtotime($ot_patient_info->ot_out_time)) : '' }}"
                            placeholder="--:--:--">
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--    Baby Note start --}}

    <div class="form-row">
        <div class="col-md-6 pt-2">
            <div class="card">
                <div class="card-header p-0 m-0 bg-navy">
                    <h5> 1st Baby Note </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-form-label col-form-label-sm">1st baby birthDate</label>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                name="first_baby_birth_date" placeholder="dd-mm-yy"
                                value="{{ !empty($ot_patient_info->first_baby_birthdate) ? date('d-m-Y', strtotime($ot_patient_info->first_baby_birthdate)) : '' }}">

                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-form-label col-form-label-sm">1st baby Time</label>

                            <input type="text" class="form-control form-control-sm m-0 timepicker"
                                name="first_baby_time" placeholder="--:--:--"
                                value="{{ !empty($ot_patient_info->first_baby_time) ? date('H:i:s', strtotime($ot_patient_info->first_baby_time)) : '' }}">

                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">1st baby Gen.</label>
                            <select class="form-control form-control-sm select2 m-0 p-0" id=""
                                name="first_baby_gender">
                                <option value="">Select</option>
                                @if (!empty($gender))
                                    @foreach ($gender as $key => $value)
                                        <option value="{{ $key }}"
                                            @if ($key == $ot_patient_info->first_baby_gender_no) selected @endif> {{ $value }}
                                        </option>
                                    @endforeach
                                @endif

                            </select>

                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">1st baby Wt</label>
                            <input type="text" class="form-control form-control-sm m-0" name="first_baby_wt"
                                placeholder=""
                                value="{{ !empty($ot_patient_info->first_baby_wt) ? $ot_patient_info->first_baby_wt : '' }}">
                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">1st baby A/s</label>
                            <input type="text" class="form-control form-control-sm m-0" name="first_baby_as"
                                placeholder=""
                                value="{{ !empty($ot_patient_info->first_baby_as) ? $ot_patient_info->first_baby_as : '' }}">
                        </div>
                    </div>
                    <textarea id="first_baby_note" name="first_baby_note">{{ !empty($ot_patient_info->first_baby_note) ? $ot_patient_info->first_baby_note : '' }}</textarea>
                </div>

            </div>
        </div>
        <div class="col-md-6 pt-2">
            <div class="card">
                <div class="card-header p-0 m-0 bg-navy">
                    <h5> 2nd Baby Note </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-form-label col-form-label-sm">2nd baby birthDate</label>
                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                name="second_baby_birth_date" placeholder="dd-mm-yy"
                                value="{{ !empty($ot_patient_info->second_baby_birthdate) ? date('d-m-Y', strtotime($ot_patient_info->second_baby_birthdate)) : '' }}">

                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-form-label col-form-label-sm">2nd baby Time</label>

                            <input type="text" class="form-control form-control-sm m-0 timepicker"
                                name="second_baby_time" placeholder="--:--:--"
                                value="{{ !empty($ot_patient_info->second_baby_time) ? date('H:i:s', strtotime($ot_patient_info->second_baby_time)) : '' }}">

                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">2nd baby Gen.</label>
                            <select class="form-control form-control-sm select2 m-0 p-0" id=""
                                name="second_baby_gender">
                                <option value="">Select</option>
                                @if (!empty($gender))
                                    @foreach ($gender as $key => $value)
                                        <option value="{{ $key }}"
                                            @if ($key == $ot_patient_info->first_baby_gender_no) selected @endif>{{ $value }}
                                        </option>
                                    @endforeach
                                @endif

                            </select>

                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">2nd baby Wt</label>
                            <input type="text" class="form-control form-control-sm m-0" name="second_baby_wt"
                                placeholder=""
                                value="{{ !empty($ot_patient_info->second_baby_wt) ? $ot_patient_info->second_baby_wt : '' }}">
                        </div>
                        <div class="col-md-4">
                            <label for="" class="col-form-label col-form-label-sm">2nd baby A/s</label>
                            <input type="text" class="form-control form-control-sm m-0" name="second_baby_as"
                                placeholder=""
                                value="{{ !empty($ot_patient_info->second_baby_as) ? $ot_patient_info->second_baby_as : '' }}">
                        </div>
                    </div>
                    <textarea id="second_baby_note" name="second_baby_note">{{ !empty($ot_patient_info->second_baby_note) ? $ot_patient_info->second_baby_note : '' }}</textarea>
                </div>

            </div>
        </div>
    </div>
    {{--    Baby Note End --}}

    <div class="m-0 pt-2 text-right border-top">
        @php
            $response_action = route('ot.ot-execution');
        @endphp
        <button type="submit"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
            class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
        <button type="reset" class="btn btn-info btn-sm" title="Click here to Clear form data">Clear</button>
        <a href="{{ $response_action }}" class="btn btn-danger btn-sm" rel="tab"
            title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
    </div>

</form>
<script type="application/javascript" src="{{ asset('js/redactor.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>


<script>
    loadEditor("pre-ot");
    loadEditor("post-ot");
    loadEditor("first_baby_note");
    loadEditor("second_baby_note");



    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
    $('.select2').select2({});

    $('body').on('focus', ".timepicker", function() {
        $(this).timepicker({
            // showInputs: false,
            // showMeridian: false,
            // setTime: null

        });
    });
</script>
