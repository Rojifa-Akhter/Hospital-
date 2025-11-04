<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (in_array(Session::get('user.ses_hospital_code'),['UNICO','DMHL']) )
                @php
                    $action = 'v1.hrm.store_leave_application';
                @endphp
            @else
                @php
                    $action = 'leave.store';
                @endphp
            @endif
            {{-- <form action="{{ route('leave.store') }}" method="post" id="leave-edit-new"> --}}
                <form action="{{ route($action) }}" method="post" id="leave-edit-new">
                @csrf
                <input type="hidden" name="id" value="{{ $data->leave_no_pk ? $data->leave_no_pk : '' }}">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="leave_name" class="col-form-label col-form-label-sm">Leave Name <span
                                class="text-danger">*</span></label>
                        <select class="form-control keep_me" id="leave_name" name="leave_name"  >>

                            <option value="">Select Leave Name</option>
                           
                            @if (!empty($leave_type))
                                @foreach ($leave_type as $leave_data)
                                    <option value="{{ $leave_data->leave_type_lkp_no_fk.'-'.$leave_data->leave_type_lkp_name. '-'. $leave_data->balance }}"
                                        @if ($data->leave_type_lkp_no_fk == $leave_data->leave_type_lkp_no_fk) selected  @endif>
                                        {{ $leave_data->leave_type_lkp_name }}
                                        
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label col-form-label-sm" for="leave_reason">Reason <span
                                class="text-danger">*</span> </label>
                        <input class="form-control form-control-sm m-0 " id="leave_reason" name="leave_reason"
                            value="{{ $data->leave_reason }}"
                            {{-- {{ $approvalCnt > 0 ? 'readonly' : '' }} --}}
                            required />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label class="col-form-label col-form-label-sm" for="from_date">Day
                            From <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control form-control-sm m-0 from_datechk date_picker" id="from_dates"
                            name="from_date"
                            value="{{ $data->from_date ? date('d-m-Y', strtotime($data->from_date)) : '' }}" 
                            {{-- {{ $approvalCnt > 0 ? 'style=color:red;' : 'style=color:green;' }}
                            {{ $approvalCnt > 0 ? 'readonly' : '' }} --}}
                            required />
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label col-form-label-sm" for="to_date">Day To
                            <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="to_dates"
                            name="to_date"
                            value="{{ $data->to_dates ? date('d-m-Y', strtotime($data->to_dates)) : '' }}" 
                            {{-- {{ $approvalCnt > 0 ? 'style=color:red;' : 'style=color:green;' }}
                            {{ $approvalCnt > 0 ? 'readonly' : '' }} --}}
                            required />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label class="col-form-label col-form-label-sm" for="">Assign To</label>
                        <input type="text" class="form-control form-control-sm m-0 keep_me search_employee_code"
                            name="search_employee_code" placeholder="Search Employee"
                            value="{{ $data->full_name ? $data->full_name : '' }}" />
                        <input type="hidden" class="keep_me hdn_item_item_id_0_search"
                            id="hdn_item_item_id_0_search_edit" name="hdn_item_item_id_0_search"
                            value="{{ $data->leave_for_extra_assignto ? $data->leave_for_extra_assignto : '' }}" />
                        {{-- @error('employee_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> --}}
                        {{-- @enderror --}}

                    </div>
                    <div class="col-md-6">
                        {{-- <label class="col-form-label col-form-label-sm" for="">Extra Duty
                            On</label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="extra_duty_on"
                            name="extra_duty_on" placeholder="Extra Duty Date"
                            value="{{ $data->leave_for_extra_duty ? date('d-m-Y', strtotime($data->leave_for_extra_duty)) : '' }}" /> --}}

                    <label class="col-form-label col-form-label-sm" for="total_days">Total Days</label>
                    <input type="text" class="form-control form-control-sm m-0" id="total_dayss" name="total_days"
                    value="{{ $data->leave_days ? $data->leave_days : '' }}" 
                    readonly/>   

                    </div>

                <div class="form-group row leave_file1 d-none">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                    <label class="col-form-label col-form-label-sm" for="leave_file1">Attachment <span
                            class="text-danger">*</span></label>
                    <input type="file" class="form-control form-control-sm m-0" id="leave_file1"
                            name="leave_file1" required/>
                    </div>
                </div>
                </div>
                <div class="modal-footer mt-1">
                    @php
                        $response_action = url('v1/hrm/employee-portalv1');
                    @endphp
                    <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
                    {{-- <button type="button" class="btn btn-sm btn-success"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.btnSaveUpdateUpload,'{{ $response_action }}')">Save
                    </button> --}}
                    <button type="button" class="btn btn-success btn-md uhl_save_btn" {{ $approvalCnt > 0 ? 'disabled' : '' }}
                    onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                    type="submit">Save
                </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function(){

        openDoctorAutocomplete(".search_employee_code", 'hdn_item_item_id_0_search_edit');
    $('.select2').select2({});

    $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
            // beforeShow: function(input, inst) {
            //     return !$(input).prop('readonly');
        });
    });

    
    $(document).on("change", ".from_datechk", function(e){
    var currentForm = $(this).closest('form');
    var leaveTypeSelect = currentForm.find("#leave_name");
    var leave_type = leaveTypeSelect.val();
    // var leave_type = $("#leave_name").val();
    var leave_type_value = leave_type.split('-');
    
    var from_date = $(this).val();
    var to_date_input = $("#to_dates");
    to_date_input.datepicker('destroy');

    if (leave_type_value[1] == 'Casual Leave') {
        var fromDateParts = from_date.split('-');
        var maxDay = parseInt(fromDateParts[0]) + 2;
        var maxToDate = maxDay + '-' + fromDateParts[1] + '-' + fromDateParts[2];

        to_date_input.datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: false,
            clearBtn: true,
            startDate: from_date,
            endDate: maxToDate
        });

        to_date_input.prop('disabled', false);
    } else if(leave_type_value[1] == 'Earned Leave') {
        var fromDateParts = from_date.split('-');
        var maxDay = parseInt(fromDateParts[0]) + 4;
        var maxToDate = maxDay + '-' + fromDateParts[1] + '-' + fromDateParts[2];

        to_date_input.datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: false,
            clearBtn: true,
            startDate: from_date,
            endDate: maxToDate
        });

        to_date_input.prop('disabled', false);

    } else {
         to_date_input.prop('disabled', false);

            to_date_input.datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

    }
});


function updateTotalDay() {
        var fromDates = $("#from_dates").datepicker("getDate");
        var toDates = $("#to_dates").datepicker("getDate");

        if (fromDates && toDates) {
          var timeDiffs = toDates - fromDates;
          var daysDiffs = Math.ceil(timeDiffs / (1000 * 3600 * 24));

          var t = $("#total_dayss").val(daysDiffs + 1);
        }
        var tt = t ? t.val() : 0;

            if (tt < 1) {
            $("#from_dates").val("");
            }
      }

         $("#from_dates, #to_dates").change(function () {
        updateTotalDay();
      });


      $(document).on("change", "#to_dates, #leave_name", function(e){
        var currentForm = $(this).closest('form');
           var total_days_for_file = $("#total_dayss").val();
           var leave_type_for_file = currentForm.find("#leave_name").val();
           var leave_type_value_for_file = leave_type_for_file.split('-');
        // console.log(leave_type_value_for_file[1]);
           if (leave_type_value_for_file[1] == 'Sick Leave' && total_days_for_file > 2) {
            $('.leave_file1').removeClass('d-none');
           }else{
            $('.leave_file1').addClass('d-none');
           }

      });



</script>
