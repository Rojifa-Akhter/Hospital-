<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container">
    <div class="row">
        <div class="col-md-12">
                <form action="{{ route('v1.hrm.save-manual-leave') }}" method="post" id="manual-leave-edit">
                @csrf
                <input type="hidden" name="id" value="{{ $data->leave_no_pk ? $data->leave_no_pk : '' }}">
                <div class="form-group row">

                    <div class="col-md-12">
                        <label class="col-form-label col-form-label-sm" for="leave_reason">Employee Name<span
                            class="text-danger">*</span> </label>
                        <input type="text" class="form-control form-control-sm m-0 keep_me employee_code"
                            id="employee_code" name="employee_code"
                            placeholder="Search Employee" value="{{ $data->p_full_name }}"/>
                     <input type="hidden" class="keep_me" id="hdn_item_item_id_0"
                            name="hdn_item_item_id_0" value="{{ $data->person_no_fk ? $data->person_no_fk : '' }}">
                    </div>

                    <div class="col-md-6">
                        <label for="leave_name" class="col-form-label col-form-label-sm">Leave Name <span
                                class="text-danger">*</span></label>
                        <select class="form-control keep_me" id="leave_name" name="leave_name">
                            <option value="">Select Leave Name</option>
                            @if (!empty($leave_type))
                                @foreach ($leave_type as $leave_data)
                                    <option value="{{ $leave_data->leave_type_lkp_no_fk.'-'.$leave_data->leave_type_lkp_name }}"
                                        @if ($data->leave_type_lkp_no_fk == $leave_data->leave_type_lkp_no_fk) selected @endif>
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
                            value="{{ $data->leave_reason }}" required />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label class="col-form-label col-form-label-sm" for="from_date">Day
                            From <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control form-control-sm m-0 from_datechk date_picker" id="from_dates"
                            name="from_date"
                            value="{{ $data->from_date ? date('d-m-Y', strtotime($data->from_date)) : '' }}" required />
                    </div>
                    <div class="col-md-6">
                        <label class="col-form-label col-form-label-sm" for="to_date">Day To
                            <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm m-0 date_picker" id="to_dates"
                            name="to_dates"
                            value="{{ $data->to_dates ? date('d-m-Y', strtotime($data->to_dates)) : '' }}" required />
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
                    </div>
                    <div class="col-md-6">
                    <label class="col-form-label col-form-label-sm" for="total_days">Total Days</label>
                    <input type="text" class="form-control form-control-sm m-0" id="total_dayss" name="total_days" readonly/>     
                    </div>
                </div>
                <div class="modal-footer mt-1">
                    @php
                        $response_action = url('v1/hrm/manual-leave');
                    @endphp
                    <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
                    <button type="button" class="btn btn-success btn-md uhl_save_btn"
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
        openDoctorAutocomplete(".employee_code", 'hdn_item_item_id_0');
        openDoctorAutocomplete(".search_employee_code", 'hdn_item_item_id_0_search_edit');
        
    $('.select2').select2({});

    $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

        $("#from_dates, #to_dates").change(function () {
        updateTotalDay();
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

            // if (tt < 1) {
            // $("#from_dates").val("");
            // }
      }

     
    });

</script>
