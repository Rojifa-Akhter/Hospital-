<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">
                    @if (!empty($type) != 'DEPT')
                        OPD Doctor Performance
                    @else
                        OPD Department Wise Performance
                    @endif
                    Summary
                </h5>
                <small>PCRP / Report / @if (!empty($type) != 'DEPT')
                        OPD Doctor Performance
                    @else
                        OPD Department Wise Performance
                    @endif Summary </small>
            </div>
        </div>
        <div class="card mt-2" style="margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>

            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 ">
                        <form method="post" id="frmRefSearch"
                            action="{{ route('pcrm.doctor-wise-performance-summary-report-pdf') }}"
                            data-response-action="">
                            @csrf
                            <div class="form-group  form-row justify-content-center">

                                <input type="hidden" name="type" value="{{ $type }}">
                                @if ($type != 'DEPT')
                                    <label for="card_no" class=" col-form-label col-form-label-sm ">Doctor</label>
                                    <div class=" col-md-2">
                                        <input type="text" class="form-control form-control-sm " id="doctor_id"
                                            name="doctor_id" value="" placeholder="Doctor Name">
                                        <input type="hidden" name="doctor_hidn" id="doctor_hidn">

                                    </div>
                                @endif


                                <label for="code" class=" col-form-label col-form-label-sm ">Department</label>
                                <div class=" col-md-2">
                                    <select class="form-control form-control-sm select2" id="request_department"
                                        name="department">
                                        <option value="">Select Department</option>
                                        @if (!empty($requestDepts))
                                            @foreach ($requestDepts as $rd)
                                                <option value="{{ $rd->serviceunit_no_pk }}">
                                                    {{ $rd->serviceunit_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From
                                    Date</label>
                                <div class=" col-md-1">
                                    <input type="text" autocomplete="off"
                                        class="form-control form-control-sm date_picker" id="date_pic" name="date_pic"
                                        value="" placeholder="DD-MM-YYYY">
                                    <span class="focus_input"></span>
                                </div>
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To Date</label>
                                <div class=" col-md-1">

                                    <input type="text" autocomplete="off"
                                        class="form-control form-control-sm date_picker" id="date_pic2" name="date_pic2"
                                        value="" placeholder="DD-MM-YYYY">
                                    <span class="focus_input"></span>
                                </div>
                                <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                                <div class="col-md-3">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-md btn-success"
                                            id="monthlySalarySheet" onclick=""> <i class="fas fa-search"></i>
                                            Search</button>

                                        {{-- <button type='submit' class="btn btn-info btn-block btn-md mt-0 "
                                            target="_blank" value="2"> Export PDF</button> --}}




                                            <button type="button" id="IPD" class="btn btn-info btn-md"
                                            target="_blank" onclick="exportPDFIPD()"><i class="fa fa-print"></i> Export In
                                            Report</button>

                                        <button type="button" id="exportinexcel" onclick="exportexcel(this)"
                                            class="btn btn-primary btn-md"><i
                                                class="fa
                                                         fa-file-excel"></i>
                                            Export In
                                            Excel</button>








                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <!--
            <div class="card-header">Individual Doctor wise Performance Details</div>
        -->
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="referral_summary_report_list">
                        @include('admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_report_list')
                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    openDoctorAutocomplete("#doctor_id", 'doctor_hidn');
    $("body").addClass("sidebar-collapse");
    $('.select2').select2();
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $(document).on('keyup', '#doctor_id', function() {

        if ($(this).val() == '') {



            $('#doctor_hidn').val('');

        }

    })
    $(document).on("click", "#monthlySalarySheet", function(e) {
        // if ($('#card_hidn').val() =="") {
        //     alert('Enter Referral Code');
        //     return;
        // }

        var formID = $("#frmRefSearch").attr("id");
        var formMethod = $("#frmRefSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('pcrm.doctor-wise-performance-summary-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#referral_summary_report_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    function exportexcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#frmRefSearch").submit();
    }

    function exportPDFIPD(element) {
        console.log('exportPDFIPD')
        $("#hdn_report_type").val("PDF");
        $("#frmRefSearch").submit();
    }
    /*
    $(document).on("click", ".print", function(e) {

        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('hrm.monthly_salary_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('hrm.monthly_salary_print_bank_wise') }}");
        }

    });
    */

    // delete
</script>
