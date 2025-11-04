<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<style>
    .dataTables_wrapper .dataTables_filter input {
        width: 190px;
        margin-top: 10px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Leave Entry</h5>
            <small>HR / Leave / Manual Leave</small>
        </div>
    </div>
    <form action="{{ route('v1.hrm.save-manual-leave') }}" method="post" id="search-employee">
         @csrf
        <div class="form-row">

            {{-- <div class="col-md-2">
            </div> --}}

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Manual Leave Entry</h5>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="id" value="">
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="leave_reason">Employee Name<span
                                            class="text-danger">*</span> </label>
                                    <input type="text" class="form-control form-control-sm m-0 keep_me"
                                            id="employee_code" name="employee_code"
                                            placeholder="Search Employee" />
                                    <input type="hidden" class="keep_me" id="hdn_item_item_id_0"
                                            name="hdn_item_item_id_0" value="">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="department">Department</label>
                                    <input type="text" class="form-control form-control-sm m-0 keep_me"
                                            id="department" name="department"/>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="leave_name" class="col-form-label col-form-label-sm">Leave Name <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2 keep_me" id="leave_name" name="leave_name">
                                        <option value="">Select Leave Name</option>
                                        @if (!empty($leave_type))
                                            @foreach ($leave_type as $leave_data)
                                                <option value="{{ $leave_data->leave_type_lkp_no_fk }}">
                                                    {{ $leave_data->leave_type_lkp_name }} - ({{ $leave_data->no_of_days }})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="from_date">Day
                                        From <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="from_date" name="from_date" value=""
                                        placeholder="dd-mm-yyyy" required />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="to_dates">Day To
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="to_dates" name="to_dates" value="" required
                                        placeholder="dd-mm-yyyy" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="leave_reason">Reason <span
                                            class="text-danger">*</span> </label>
                                    <input class="form-control form-control-sm m-0 " id="leave_reason"
                                        name="leave_reason" value="" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="">Assign To</label>
                                    <input type="text" class="form-control form-control-sm m-0 keep_me"
                                        id="search_employee_code" name="search_employee_code"
                                        placeholder="Search Employee" />
                                    <input type="hidden" class="keep_me" id="hdn_item_item_id_0_search"
                                        name="hdn_item_item_id_0_search" value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="">Extra Duty On</label>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="extra_duty_on" name="extra_duty_on" placeholder="dd-mm-yyyy" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="">Total Days</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="total_days" name="total_days" placeholder="Total Days" readonly/>
                                </div>
                            </div>

                            @php
                             $response_action = route('v1.hrm.manual-leave');
                            @endphp

                            <div class="col-md-2 offset-md-10 mt-2">
                                <button class="btn btn-success btn-md uhl_save_btn" type="button"
                                onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
                                </button>
                                <button type="reset" class="btn btn-md btn-info">Clear</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
{{-- 
            <div class="col-md-2">
            </div> --}}
        </div>
    </form>
</div>


<div class="container-fluid">
    <section class="fixed_asset">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" id="manualLeaveWorklistSearch" method="POST">
                                @csrf
                                <div class="form-row">

                                    <div class="col-lg-2 col-md-6 col-12">
                                      
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="card_no" class="col-form-label">Employee Card</label>
                                            <input type="text" class="form-control form-control-sm m-0"
                                            id="search_employee" name="search_employee"
                                            placeholder="Search Employee" />
                                        <input type="hidden" class="keep_me" id="hdn_item_item_id_1_search"
                                            name="hdn_item_item_id_1_search" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="from_date" class="col-form-label">Date</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">From</div>
                                                </div>
                                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="date_from" name="date_from" value="" placeholder="dd-mm-yyyy"  autocomplete="off" />
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">To</div>
                                                </div>
                                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="date_to" name="date_to" value="" placeholder="dd-mm-yyyy"  autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" id="manual_leave_search_button" class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover data-table" width="100%">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th class="text-left">Employee Name</th>
                                            <th class="text-left">Leave Type</th>
                                            <th class="text-left">Leave Reason</th>
                                            <th class="text-center">From Date</th>
                                            <th class="text-center">To Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="manualLeaveSearchTable">
                                        @include("admin.v1.hrm.manual-leave.search-manual-leave-hr")
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $(document).ready(function() {
        function updateTotalDays() {
        var fromDate = $("#from_date").datepicker("getDate");
        var toDate = $("#to_dates").datepicker("getDate");

        if (fromDate && toDate) {
          var timeDiff = toDate - fromDate;
          var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

          var t = $("#total_days").val(daysDiff + 1);
        }
        var tt = t ? t.val() : 0;

      }

         $("#from_date, #to_dates").change(function () {
        updateTotalDays();
      });

      $('.data-table').DataTable({
            "ordering": false,
            "searching": true,
            // "pageLength": 20,
            // "bPaginate": true,
            "pageLength": 10

        });

    });

    openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');
    openDoctorAutocomplete("#search_employee_code", 'hdn_item_item_id_0_search');
    openDoctorAutocomplete("#search_employee", 'hdn_item_item_id_1_search');

    $('.select2').select2({});
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    // function personInfo(item, obj) {
    //     console.log(obj)
        // person_info
        // var su = item.su_name != null ? item.su_name : '';
        // var deg = item.designation != null ? item.designation : '';
        // $("#department").val(su);
        // var info = `${item.su_name+'</br> '+item.designation}`;
        // var info = `${su+'</br> '+deg}`;
        // $('#person_info').html(info);
    // }


    $(document).on("click", "#manual_leave_search_button", function(e) {

    var formID = $("#manualLeaveWorklistSearch").attr("id");
    var formMethod = $("#manualLeaveWorklistSearch").attr("method");
    console.log('ok');

    $.ajax({
       data: $('#' + formID).serialize(),
       url: "{{ route('v1.hrm.search-manual-leave') }}",
       type: "post",
       beforeSend: function() {
        blockUI();

       },
       success: function(data) {
        $("#manualLeaveSearchTable").html(data);
        },

       complete: function() {
        $.unblockUI();
    }
   });
   });

</script>
