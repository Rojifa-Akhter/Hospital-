<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form method="post" id="frm-pat-registration" action="{{ route('physiotherapy.store') }}">
            @csrf
            <div class="card mt-0 bg-light">
                <div class="card-header">Prescribed Physiotherapy</div>
                <div class="card-body p-1">
                    @php
                        $sc_info = explode(',', $sc_data);
                    @endphp
                    @if (!empty($prescription_service))
                        @foreach ($prescription_service as $pt_row)
                            @if (!in_array($pt_row->item_lookupdata_no_fk, $sc_info))
                                <div class="custom-control custom-checkbox"
                                    title="{{ $pt_row->itemtype_lookupdata_code }}">
                                    @php
                                        $unit_session_no = $pt_row->itemtype_lookupdata_code == 'PTET' || $pt_row->itemtype_lookupdata_code == 'ACUP' ?  $pt_row->unit_intensity :  $pt_row->no_of_session;

                                        $unit_session_no_val = $pt_row->itemtype_lookupdata_code == 'PTTE' ? $pt_row->unit_intensity : "$pt_row->no_of_session";
                                        // dd($unit_session_no );
                                    @endphp
                                    <input type="checkbox" class="custom-control-input pt_services"
                                        id="pt_service_{{ $loop->iteration }}" name="pt_service[]"
                                        value="{{ $pt_row->item_lookupdata_no_fk }}"
                                        data-name="{{ $pt_row->presdtl_data }}"
                                        data-session="{{ $unit_session_no }}"
                                        data-duration="{{ $pt_row->session_duration }}" data-session_mu_name="{{ $pt_row->session_mu_name }}">
                                    <label class="custom-control-label"
                                        for="pt_service_{{ $loop->iteration }}">{{ $pt_row->presdtl_data }},
                                        <small> No of session: {{  $pt_row->session_duration }}
                                            , duration :  {{$unit_session_no}} {{ $pt_row->session_mu_name }}</small></label>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body pt-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="no_of_session">  Number of Session <span
                                            class="text-danger">*</span></label>
                                            <input type="text" class="form-control required" id="session_duration"
                                            name="no_of_session" placeholder="Enter Duration Of Session"
                                            required="required">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="session_duration"> Session Duration (Hour) <span
                                            class="text-danger">*</span></label>

                                        <input type="text" class="form-control required" id="no_of_session"
                                        name=" session_duration" placeholder="Enter No of Session" required="required">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body pt-2">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- doctor input add --}}
                            <div class="form-group row">
                                <label for="doctor_id" class="col-sm-4 col-form-label">Physiotherapist</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="doctor_id" name="doctor_id">
                                        <option value="0">Select</option>
                                        @if (!empty($doctor_info))
                                            @foreach ($doctor_info as $doctor)
                                                <option value="{{ $doctor->person_no_pk }}">
                                                    {{ $doctor->full_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            {{-- doctor input end --}}
                            <div class="form-group row">
                                <label for="cmb_room" class="col-sm-4 col-form-label">Room</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="cmb_room" name="cmb_room">
                                        <option value="0">Select</option>
                                        @if (!empty($room_list))
                                            @foreach ($room_list as $room)
                                                <option value="{{ $room->room_no_pk }}">{{ $room->room_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row" id="date-con">
                                <label for="start_date" class="col-sm-4 col-form-label">Start Date-Time <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <input type="text" class="form-control date_picker required" id="start_date"
                                                name="start_date" placeholder="Start Date" required="required">
                                        </div>
                                        <input type="text" class="form-control timepicker" id="start_time"
                                            name="start_time" placeholder="Start Time">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card pt-1 bg-primary">
                <div class="form-group m-auto">
                    <div class="input-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input days" name="schedule_day[]" type="checkbox" id="day_sat"
                                value="Sat">
                            <label class="form-check-label" for="day_sat">Sat</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input days" name="schedule_day[]" type="checkbox" id="day_sun"
                                value="Sun">
                            <label class="form-check-label" for="day_sun">Sun</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input days" name="schedule_day[]" type="checkbox" id="day_mon"
                                value="Mon">
                            <label class="form-check-label" for="day_mon">Mon</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input days" name="schedule_day[]" type="checkbox" id="day_tue"
                                value="Tue">
                            <label class="form-check-label" for="day_tue">Tue</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input days" name="schedule_day[]" type="checkbox" id="day_wed"
                                value="Wed">
                            <label class="form-check-label" for="day_wed">Wed</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input days" name="schedule_day[]" type="checkbox" id="day_thu"
                                value="Thu">
                            <label class="form-check-label" for="day_thu">Thu</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input days" name="schedule_day[]" type="checkbox" id="day_fri"
                                value="Fri">
                            <label class="form-check-label" for="day_fri">Fri</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" name="schedule_day[]" type="checkbox" id="day_all"
                                value="All">
                            <label class="form-check-label" for="day_all">All</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer mt-2">
                <input type="hidden" name="hdn_prescription_id" value="{{ $prescription_mst->prescription_no_pk }}">
                <input type="hidden" name="hdn_patient_id" value="{{ $prescription_mst->patient_no_fk }}">
                <input type="hidden" name="hdn_pt_service_names" id="hdn_pt_service_names" value="">

                <button class="btn btn-md btn-save btn-success"
                    onclick="btnSaveUpdate(this,'', '', '', '', appointmentByDate,'');"
                    title="Create Service Schedule">Save</button>
                <button class="btn btn-md btn-danger" data-dismiss="modal" title="Close Popup Window">Close</button>
                <a href="{{ route('home') }}" data-dismiss="modal" class="btn btn-info btn-md" rel="tab"
                    title="Click here to go back to Dashboard">Exit</a>
            </div>
        </form>
    </div>

</div>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script>
    $(function() {
        $('#start_date').datepicker({
            autoclose: true,
            container: '#date-con',
            format: 'dd-mm-yyyy',
            todayHighlight: true
        });
        $('.timepicker').timepicker();
    });
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    $(document).on('click','#day_all', function(){
        if ($(this).is(':checked')) {
            $('.days').attr('checked','checked');
        }else{
            $('.days').removeAttr('checked','checked');
        }
    })

</script>
