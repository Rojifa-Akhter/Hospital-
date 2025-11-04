<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Monthly Late Report</h5>
                <small> Report / HRM / Monthly Late Report</small>
            </div>
        </div>


        <div class="card ">
            <div class="card-header ">
                <h5> Search</h5>
            </div>

            <div class="card-body">
                <div class="form-group form-row mt-2">
                    <div class="col-md-12 ">
                        <form method="post"  target="_blank" id='searchForm' action="{{ route('hrm.monthly_late_search') }}" data-response-action="">
                            @csrf
                            <input type="hidden" name="id" value="">
                            <div class="form-group  form-row">

                                <label for="year" class=" col-form-label col-form-label-sm">Year</label>
                                <div class="col-md-1">
                                    <select class="form-control font_size_12 " id="year" name="year" required>
                                        <option value="0">Select Year</option>
                                        @php
                                            $date = date('Y');

                                        @endphp

                                        @for ($i = $date - 2; $i < $date + 3; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <label for="year" class="col-form-label col-form-label-sm">Month</label>
                                <div class="col-md-2">
                                    <select class="form-control font_size_12  " id="month" name="month"
                                        width="200px" required>
                                        <option value="00">Select Month</option>
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
                                <label for="status" class="col-form-label col-form-label-sm">Department</label>
                                <div class="col-md-2">
                                    <select class="form-control font_size_12  select2" id="department_name"
                                        name="department_name">
                                        <option value="">Select Department</option>
                                        @if (isset($depart))
                                            @foreach ($depart as $value)
                                                <option value="{{ $value->serviceunit_no_pk }}">
                                                    {{ $value->serviceunit_name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>

                                <label for="card_no" class=" col-form-label col-form-label-sm ">Employee Card</label>
                                <div class=" col-md-2">
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="employee_code" name="employee_code" value=""
                                        placeholder="Employee Code/Name/Phone Number" />
                                    <input type="hidden" class="" id="hdn_item_item_id_0" name="card_num"
                                        value="">
                                    @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                                <div class="col-md-2 text-center">
                                    <button type="button" class="btn btn-md btn-md-global btn-success"
                                        id="btnSearchReport"
                                        data-action="{{ route('hrm.attendence-monthly-search') }}">Search</button>
                                    <button type="submit" class="btn btn-md btn-md-global btn-primary"
                                        id="">Export pdf</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-header ">
                <h5> Monthly Late List </h5>
            </div>

            <div class="card-body">
                <div class="form-group form-row mt-2">
                    <div class="col-md-12 table-responsive" id="month_search">
                        @include('admin.reports.hrm.monthly_late_report_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $('.date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $("#department").focus();
    $('.select2').select2();

    openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');


    $(document).on("click", "#btnSearchReport", function(e) {
        var formID = $("#searchForm").attr("id");
        // var formAction = $("#frmSearch").attr("action");
        var formMethod = $("#searchForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('hrm/monthly_late_search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#month_search").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

</script>
