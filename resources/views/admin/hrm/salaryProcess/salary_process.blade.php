
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Salary process</h5>
                <small>HRM / Salary process</small>
            </div>
        </div>


        <div class="form-row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-2">
                    <div class="card-header "> <h5> Salary process</h5> </div>

                    <div class="card-body">
                        <div class=" form-group form-row " >
                            <div class="col-md-12" >
                                <form action="{{route('hrm.salary_process_store')}}" method="post" id="salary-process-setup">
                                    @csrf
                                    <input type="hidden" name="id" value="">

                                    <div class="form-group form-row mt-2 form-row">

                                        <div class="col-md-5">
                                            <label for="year" class=" col-form-label col-form-label-sm ">Year</label>
                                            <select class="form-control font_size_12 m-auto" id="year" name="year" required>
                                                <option value="">Select Year</option>
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
                                                <option value="">Select Month</option>

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
                                        $response_action = route('hrm.salary_process');
                                        @endphp
                                        <div class="col-md-2 mt-4">
                                            <button type="submit" class="btn btn-success btn-md btn-md-global" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Process</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mt-2">
                    <div class="card-header "> <h5> Salary  Search</h5> </div>

                    <div class="card-body">
                        <div class=" form-group form-row " >
                            <div class="col-md-12" >
                                <form action="{{route('hrm.salary_process_search')}}" method="post" id="salary_process_search">
                                    @csrf
                                    <input type="hidden" name="id" value="">

                                    <div class="form-group form-row mt-2 form-row">

                                        <div class="col-md-5">
                                            <label for="year" class=" col-form-label col-form-label-sm ">Year</label>
                                            <select class="form-control font_size_12 m-auto required" id="year2" name="year" required>
                                                <option value="">Select Year</option>
                                                @php
                                                $date=date('Y');

                                                @endphp

                                                @for($i=($date-2); $i<($date+3); $i++) <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>


                                        <div class="col-md-5">
                                          <label for="year" class="col-form-label col-form-label-sm ">Month</label>

                                          <select class="form-control font_size_12 m-auto required" id="month2" name="month" width="200px" required>
                                            <option value="">Select Month</option>

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
                                    <div class="col-md-2 mt-4">
                                        <button type="button" id="salary_search" class="btn btn-success btn-md btn-md-global">Search</button>
                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">

    </div>
    <div class="card">
        <div class="card-header "> <h5> Salary Process</h5> </div>
        <div class="card-body">
            <div class="form-row mt-2">
                <div class="col-md-12 table-responsive" id="salary-container">
                    @include('admin.hrm.salaryProcess.salary_process_list')

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
    $('.date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });


    $(document).on("click", "#salary_search", function(e) {
        var formID = $("#salary_process_search").attr("id");
// var formAction = $("#frmSearch").attr("action");
var formMethod = $("#salary_process_search").attr("method");

if ( $('#year2').val()  && $('#month2').val() != "") {
$.ajax({
    data: $('#' + formID).serialize(),
    url:"{{ url('hrm/salary_process_search') }}",
    type: formMethod,
    beforeSend: function() {
        blockUI();

    },
    success: function(data) {
        $("#salary-container").html(data);
    },
    complete: function() {
        $.unblockUI();
    }
});
}
});

</script>
