<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
@php
   $data = isset($previous) && !empty($previous) ? $previous : [];
   $attendance_date_update = $data ? date('d-m-Y', strtotime($data->attendance_date)) : '';
   $in_time_update = $data && $data->in_time ? date('H:i', strtotime($data->in_time)) : '';
   $out_time_update = $data && $data->out_time ? date('H:i', strtotime($data->out_time)) : ''; 
   $remarks_update = $data ? $data->remarks : '';
//    @dd($out_time_update)
@endphp
<main id="page-content">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Attendance</h5>
                    </div>
                </div>
    <form action="{{ route('v1.hrm.save-my-attendance') }}" id="edit-my-attendance-form" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="form-group">
                                <input type="hidden" name="req_no_pk" value="{{ $requsition_no_pk ? $requsition_no_pk : '' }}">
                            <label for="attendance_date" class="col-form-label">Attendance Date</label>
                            <input type="text" class="form-control form-control-sm date_picker" id="attendance_date" name="attendance_date" 
                            value="{{ $attendance_date_update ? $attendance_date_update : ($attendance_date ? date('d-m-Y', strtotime($attendance_date)) : '') }}" />
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-6 col-12">
                                <div class="form-group">
                                <label for="in_time" class="col-form-label">In Time</label>
                                    <input type="text" class="form-control form-control-sm timepicker" id="in_time"
                                        name="in_time" placeholder="" value="{{ $in_time_update ? $in_time_update : ($in ? date('H:i', strtotime($in)) : '' ) }}" />
                                </div>
                            </div>


                            <div class="col-lg-2 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="out_time" class="col-form-label">Out Time</label>
                                    <input type="text" class="form-control form-control-sm timepicker" id="out_time"
                                        name="out_time" placeholder="" value="{{ $out_time_update ? $out_time_update : ($out ? date('H:i', strtotime($out)) : '' ) }}" />
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="remarks" class="col-form-label">Remarks</label>
                                    <input type="text" class="form-control form-control-sm" id="out_time"
                                        name="remarks" value="{{ $remarks_update }}" placeholder="Remarks"/>
                                </div>
                            </div>

                            <div class="col-md-2 mt-1">
                                @php
                                    $response_action = route('v1.hrm.employee-portalv1');
                                    // $response_action = ''
                                @endphp
                                {{-- <li class="list-inline-item mb-0 mt-0"> --}}
                                <button type="button" class="btn btn-success uhl_save_btn mt-3"
                                    onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                    id="">Save</button>
                                {{-- </li> --}}
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    </div>
    </section>
</main>
    <div class="col-md-12">
        <div class="modal-footer mt-1">
            <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button>
        </div>
    </div>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script>
    $(document).ready(function() {

        $(function() {
    	$('.date_picker').datepicker({
    		format: 'dd-mm-yyyy',
    		todayHighlight: true,
    		clearBtn: true,
    		autoclose: true
    	});
    	$('body').on('focus',".timepicker", function(){
    		$(this).timepicker({
    			// showInputs: false,
    			// showMeridian: false,
    			// setTime: null

    		}); 
        });
    })
    });
