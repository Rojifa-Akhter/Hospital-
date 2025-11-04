
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white justify-content-between align-items-center border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
            <div class="col-md-8 mb-1">
                <h5 class="mt-2 mb-0"> Process Attendance</h5>
                <small>HRM / Process Attendance List</small>
            </div>

            <div class="col-md-4">
                <form action="{{route('hrm.check_in_out_process')}}" method="post" id="checkInOut">
                    @php
                    $response_action = route('hrm.process_attendance');
                    @endphp

                        <button type="button" class="btn btn-md btn-success float-right uhl_common_btn" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Check In / Out</button>
                </form>

            </div>

        </div>


        <div class="form-row justify-content-center">

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <div class="card mt-2">
                            <div class="card-header "> <h5> Monthly Process Attendance Store</h5> </div>

                            <div class="card-body mr-1">
                                <div class=" form-group" >
                                    <form action="{{route('hrm.month-process-attendence-store')}}" method="post" id="leave-setup-create">
                                        @csrf
                                        <input type="hidden" name="id" value="">
                                        <div class="form-group form-row ml-2 form-row">

                                            <div class="col-md-5">
                                                <label for="year" class=" col-form-label col-form-label-sm">Year</label>
                                                <select class="form-control font_size_12 m-auto" id="year" name="year" required>
                                                    <option value="0">Select Year</option>
                                                    @php
                                                    $date=date('Y');

                                                    @endphp

                                                    @for($i=($date-2); $i<($date+3); $i++) <option value="{{$i}}">{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>


                                            <div class="col-md-5">
                                                <label for="year" class="col-form-label col-form-label-sm ">Month</label>
                                                <select class="form-control font_size_12 m-auto" id="month" name="month" width="200px" required>
                                                    <option value="0">Select Month</option>
                                                    <option value="01">January</option>
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>

                                                </select>
                                            </div>

                                            @php
                                            $response_action = route('hrm.process_attendance');
                                            @endphp
                                            <div class="col-md-2 mt-4">
                                                <button type="submit" class="btn btn-success btn-md btn-md-global uhl_common_btn" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Monthly</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header "> <h5> Daily Process Attendance Store </h5> </div>
                            <div class="row ml-2">
                                <div class="card-body">
                                    <div class=" form-group form-row " >
                                        <form action="{{route('hrm.process-attendance-daily-store')}}" method="post" id="process-attendance-create">
                                            @csrf
                                            <input type="hidden" name="id" value="">

                                                <div class="row">
                                                    <div class="col-md-1 mt-4">
                                                       <div class="input-group">
                                                        <input type="checkbox" class="form-control form-control-sm m-0 " id="daily_date" name="daily_date" value="1" placeholder="" >
                                                      </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div id="form_to_date" class="mr-1">
                                                            <label for="from_date" class="col-form-label col-form-label-sm ">From</label>
                                                        <input type="text" class="form-control form-control-sm m-0 date-picker date-picker" id="from_date" name="from_date" value="" placeholder="dd-mm-yyyy" autocomplete="off">
                                                    </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div id="date_only"  class="">
                                                            <label for="from_date" class="col-form-label col-form-label-sm ">To</label>

                                                            <input type="text" class="form-control form-control-sm m-0 date-picker date-picker" id="to_date" name="to_date" value="" placeholder="dd/mm/yyyy" autocomplete="off">

                                                        </div>
                                                        </div>
                                                    @php
                                                    $response_action = route('hrm.process_attendance');
                                                    @endphp
                                                    <div class="col-md-1 mt-4">
                                                        <button class="btn btn-md btn-md-global btn-success uhl_common_btn" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Daily</button>
                                                    </div>

                                               </div>

                                        </div>

                                    </div>

                                </form>
                            </div>


                    </div>

                     </div>

                 </div>
                 </div>

     </div>




<div class="row">
    <div class="col-md-12">
        <div class="card">
         <div class="card-header "> <h5> Search</h5> </div>
         <div class="card-body">
             <div class="form-row mt-2 justify-content-center border-bottom">
                 <div class="col-md-12">
                     <form method="post" id='searchForm' action="" data-response-action="">
                         @csrf
                         <div class="form-group form-row">
                             <input type="hidden" name="id" value="">
                             <label for="user_expire_date" class=" col-form-label col-form-label-sm col-md-1">Date</label>

                             <div class=" col-md-2">
                                 <input type="text" class="form-control form-control-sm date-picker" id="date_pic" name="date_pic" value="" placeholder="dd/mm/yyyy">
                                 <span class="focus_input"></span>
                             </div>

                             <label for="card_no" class=" col-form-label col-form-label-sm col-md-1">Card No</label>

                             <div class=" col-md-3">
                              <input type="text" class="form-control form-control-sm m-0 keep_me" id="employee_code"
                              name="employee_code"
                              value="" placeholder="Employee Code/Name/Phone Number" />
                              <input type="hidden" class="keep_me" id="hdn_item_item_id_0" name="card_num" value="" >
                              @error('employee_id')
                              <span class="invalid-feedback" role="alert">
                                 <strong>{{ $message }}</strong>
                             </span>
                             @enderror
                         </div>

                         <label for="status" class="col-form-label col-form-label-sm col-md-1">Status</label>
                         <div class="col-md-2">
                             <select class="form-control font_size_12 m-auto" id="status" name="status" required>
                                 <option value="0">Select Status</option>
                                 @if(isset($status))
                                 @foreach($status as $key=>$value)
                                 <option value="{{$key}}">{{$value}}</option>

                                 @endforeach
                                 @endif

                             </select>
                         </div>

                         <div class="col-md-2">
                          <button type="button" class="btn btn-md btn-md-global btn-success" id="btnSearchReport" data-action="{{ route('hrm.process-attendence-search') }}" ><i class="fa fa-search"></i>Search</button>
                      </div>



                  </div>
              </form>
          </div>
      </div>




      <div class="form-row mt-2">
         <div class="col-md-12 table-responsive" id="sample-container">
             @include('admin.hrm.attendence.process_attendance_list')

         </div>
     </div>
</div>
</div>


</div>
</div>
</div>

</section>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>

<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>

<script type="text/javascript">
 openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');

 $('.select2').select2({});

 $('.date_picker').datepicker({
     todayHighlight: true,
     clearBtn: true,
     autoclose: true,
     format: 'yyyy-mm-dd',
 });
  $('.date-picker').datepicker({
     todayHighlight: true,
     clearBtn: true,
     autoclose: true,
     format: 'dd-mm-yyyy',
 });

 $(document).on("click", "#btnSearchReport", function(e) {
    var formID = $("#searchForm").attr("id");
        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#searchForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('hrm/process-attendence-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#sample-container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

 $("#daily_date").change(function() {
    if($(this).is(':checked')) {
        $('#date_only').addClass('d-none');
    } else {
        $('#date_only').removeClass('d-none');

    }
});

</script>
