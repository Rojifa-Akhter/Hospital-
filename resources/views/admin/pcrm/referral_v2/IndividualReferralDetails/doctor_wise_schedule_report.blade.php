<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Shift Wise Patient's Report</h5>
                <small>PCRP / Report / Shift Wise Patient's Report</small>
            </div>
        </div>
        <div class="card mt-2" style="width: 90%; margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>
            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 ">
                        <form method="post" id="frmRefSearch" data-response-action="" target="_blank">
                            @csrf
                            <div class="form-group  form-row">
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">Department</label>
                                <div class=" col-md-2">
                                    <select class="form-control form-control-sm select2" id="request_department" name="request_department">
                                        <option value="">Select Department</option>
                                        @if (!empty($serviceDepts))
                                            @foreach ($serviceDepts as $rd)
                                                <option value="{{ $rd->serviceunit_no_pk }}">
                                                    {{ $rd->serviceunit_name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From Date</label>
                                <div class=" col-md-2">
                                    <input type="text" autocomplete="off"
                                        class="form-control form-control-sm date_picker" id="date_pic" name="date_pic"
                                        value="" placeholder="DD-MM-YYYY" required />
                                    <span class="focus_input"></span>
                                </div>
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To Date</label>
                                <div class=" col-md-2">
                                    <input type="text" autocomplete="off"
                                        class="form-control form-control-sm date_picker" id="date_pic2" name="date_pic2"
                                        value="" placeholder="DD-MM-YYYY" required />
                                    <span class="focus_input"></span>
                                </div>
                                <div class="col-md-3">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-sm btn-success btn-block mt-0"
                                            id="deptWiseSearch" onclick=""> <i class="fas fa-search"></i>
                                            Search</button>
                                        <button type='submit' class="btn btn-info btn-block btn-md mt-0 print"
                                            value="1"><i class="fa fa-file-pdf"></i> Export PDF</button>
                                        <button type='submit' class="btn btn-primary btn-block btn-md mt-0 print"
                                            value="2"><i class="far fa-file-excel"></i> Export EXCEL</button>
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
            <div class="card-header">Shift Wise Patient's Report</div>
            <div id="doctorWiseScheduleReportTable">
                @include('admin.pcrm.referral_v2.IndividualReferralDetails.doctorWiseScheduleReportTable')
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    // openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $('.select2').select2();

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();

        if (print == 1) {
            $('#frmRefSearch').attr('action', "{{ route('reports.doctorWiseScheduleReportPdf') }}");
        }
        if (print == 2) {
            $('#frmRefSearch').attr('action', "{{ route('reports.doctorWiseScheduleReportExcel') }}");
        }
    });

    $(document).on("click", "#deptWiseSearch", function(e) {

        var formID = $("#frmRefSearch").attr("id");
        var formMethod = $("#frmRefSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('reports.doctorWiseScheduleReportFilter') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#doctorWiseScheduleReportTable").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
