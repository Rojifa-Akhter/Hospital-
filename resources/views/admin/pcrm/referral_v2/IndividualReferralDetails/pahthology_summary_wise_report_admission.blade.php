<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">IPD Pathology Report History</h5>
                <small>Report / IPD Pathology Report History</small>
            </div>
        </div>
        <div class="card mt-2" style="width: 20%; margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>

            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 ">
                        <form method="post" id="frmSummaryAdmission" data-response-action="" target="_blank">
                            @csrf
                            <div class="form-group  form-row">

                                <div class="form-group col-md-12">
                                    <label class="col-form-label col-form-label-sm" for="admission_id">Admission
                                        ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="admission_id"
                                        name="admission_id" value="" placeholder="Admission ID">
                                </div>

                                {{-- <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From
                                    Date</label>
                                <div class=" col-md-2">
                                    <input type="text" autocomplete="off"
                                        class="form-control form-control-sm date_picker" id="date_from" name="date_from"
                                        value="" placeholder="DD-MM-YYYY">
                                    <span class="focus_input"></span>
                                </div>
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To Date</label>
                                <div class=" col-md-2">

                                    <input type="text" autocomplete="off"
                                        class="form-control form-control-sm date_picker" id="date_to" name="date_to"
                                        value="" placeholder="DD-MM-YYYY">
                                    <span class="focus_input"></span>
                                </div>
                                <div class="col-md-3">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-sm btn-success btn-block mt-0"
                                            id="pathologyAdmissionSummarySearch" onclick=""> <i class="fas fa-search"></i>
                                            Search</button>

                                            <button type='submit' class="btn btn-info btn-block btn-sm mt-0 print" value="1"><i class="fa fa-file-pdf"></i> Export PDF</button>
                                             <button type='submit' class="btn btn-primary btn-block btn-sm mt-0 print" value="2"><i class="far fa-file-excel"></i> Export EXCEL</button> 
                                    </div>
                                </div> --}}

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
                    <div class="col-md-12 table-responsive" id="pathologySummaryList">
                        @include('admin.pcrm.referral_v2.IndividualReferralDetails.pathologySummaryWiseDeptDataIp')
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
    // openDoctorAutocomplete("#card_no", 'card_hidn');
    // $("body").addClass("sidebar-collapse");
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
            $('#frmSummaryAdmission').attr('action', "{{  route('pathology-summary-report-pdf-admission')  }}");
        }
        if (print == 2) {
            $('#frmSummaryAdmission').attr('action', "{{ route('dept-wise-summary-performance-report-excel') }}");
        }
    });

    $(document).on("click", "#pathologyAdmissionSummarySearch", function(e) {

        var formID = $("#frmSummaryAdmission").attr("id");
        var formMethod = $("#frmSummaryAdmission").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('pathology-summary-report-search-admission') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#pathologySummaryList").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
