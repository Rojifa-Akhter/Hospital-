<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
{{-- @php

    $room = isset($room) && !empty($room) ? $room : [];

    $room_no_pk = $room ? $room->room_no_pk : '';
    $room_code = $room ? $room->room_code : '';
    $room_name = $room ? $room->room_name : '';
    $room_description = $room ? $room->room_description : '';
    $room_capacity = $room ? $room->room_capacity : '';
    $category_lookup = $room ? $room->room_category_lookup_no_fk : '';
    $room_size = $room ? $room->room_size : '';
    $serviceunit_no_fk = $room ? $room->serviceunit_no_fk : '';
    $ipd_ind = $room ? $room->ipd_ind : '';
    $opd_ind = $room ? $room->opd_ind : '';
    $ot_ind = $room ? $room->ot_ind : '';
    $physio_ind = $room ? $room->physio_ind : '';
    $store_location_ind = $room ? $room->store_location_ind : '';
    $open_loction_ind = $room ? $room->open_location_ind : '';
    $status = $room ? $room->status : '';
    $physicalstrucure_no_fk = $room ? $room->physicalstrucure_no_fk : '';
    $asset_location_ind = $room ? $room->asset_location_ind : '';
    $duty_location_ind = $room ? $room->duty_location_ind : '';
@endphp --}}
{{-- <div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{ route('room.store') }}" method="post" id="room-create">
            @csrf



    </div>
</div> --}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('leave.store') }}" method="post" id="leave-edit">
                @csrf
                <input type="hidden" name="id" value="{{ $data->leave_no_pk ? $data->leave_no_pk : '' }}">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="leave_name" class="col-form-label col-form-label-sm">Leave Name <span
                            class="text-danger">*</span></label>
                            <select class="form-control keep_me" id="leave_name" name="leave_name">
                                <option value="">Select Leave Name</option>
                                @if (!empty($leave_info))
                                    @foreach ($leave_info as $leave_data)
                                        <option value="{{ $leave_data->leave_type_lkp_no_fk }}" @if($data->leave_type_lkp_no_fk == $leave_data->leave_type_lkp_no_fk) selected @endif>
                                            {{ $leave_data->leave_type_lkp_name }}({{ $leave_data->leave_code }})-{{ $leave_data->no_of_days }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label col-form-label-sm" for="leave_reason">Reason <span
                            class="text-danger">*</span> </label>
                    <input class="form-control form-control-sm m-0 " id="leave_reason"
                        name="leave_reason" value="{{$data->leave_reason}}" required />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label class="col-form-label col-form-label-sm" for="from_date">Day
                            From <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                            id="from_date" name="from_date" value="{{$data->from_date ? date('d-m-Y', strtotime($data->from_date)) : ""}}"
                            placeholder="{{ date('d-m-Y') }}" required />
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label col-form-label-sm" for="to_dates">Day To
                            <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                            id="to_dates" name="to_dates" value="{{$data->to_dates ? date('d-m-Y', strtotime($data->to_dates)) : ""}}" required
                            placeholder="{{ date('d-m-Y') }}" required />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label class="col-form-label col-form-label-sm" for="">Assign To</label>
                        <input type="text" class="form-control form-control-sm m-0 keep_me"
                            id="search_employee_code" name="search_employee_code"
                            placeholder="Search Employee" value="{{$data->assignto_name ? $data->assignto_name:""}}"/>
                        <input type="hidden" class="keep_me" id="hdn_item_item_id_0_search"
                            name="hdn_item_item_id_0_search" value="{{$data->leave_for_extra_assignto ? $data->leave_for_extra_assignto : ""}}">
                        @error('employee_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label col-form-label-sm" for="">Extra Duty
                            On</label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                            id="extra_duty_on" name="extra_duty_on" placeholder="Extra Duty Date" value="{{$data->leave_for_extra_duty ? date('d-m-Y', strtotime($data->leave_for_extra_duty)) : ""}}" />
                    </div>
                </div>
                <div class="modal-footer mt-1">
                    @php
                        $response_action = url('/leavelist');
                    @endphp
                    <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
                    <button type="submit" class="btn btn-sm btn-success"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
                        </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
        openDoctorAutocomplete("#search_employee_code", 'hdn_item_item_id_0_search');
    // getDropdownListByCondition("#","","");
    $('.select2').select2({});

</script>
<script>
    $(function() {
        $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });
   });

</script>
