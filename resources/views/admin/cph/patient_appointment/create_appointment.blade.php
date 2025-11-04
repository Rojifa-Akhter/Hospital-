<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
   *::after, *::before {
    margin: 0;
    padding: 3px !important;
    box-sizing: border-box;
    
}
/* .bg-primary{
background: #38c172 !important;
} */
</style>
<section id="full_appointment">
    <div class="container-fluid">
    <div
        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Appointment</h5>
            <small>Appointment / Patient Appointment</small>
        </div>
    </div>

        <div class="card mt-2" style="width: 100%; margin: auto">
            <div class="card-header" style="background: #2f1385;">
                <h5><span style="color: #fff;">Search</span></h5>
            </div>
            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 col-sm-12">
                        <form method="post" id="frmSearchV1" data-response-action="" action=""  target="_blank">
                            @csrf
                            <div class="justify-content-center form-row">
                                <input type="hidden" name="id" value="">

                                <div class="col-md-1">
                                    <label for="bp" class=" col-form-label col-form-label-sm">B.P</label>
                                    <input type="text" class="form-control form-control-sm " id="bp" name="bp"
                                        value="" placeholder="BP No.">
                                </div>

                                <div class="col-md-2">
                                    <label for="civ_no" class=" col-form-label col-form-label-sm">CIV No.</label>
                                    <input type="text" class="form-control form-control-sm " id="civ_no" name="civ_no"
                                        value="" placeholder="CIV No.">
                                </div>

                                <div class="col-md-2">
                                    <label for="patient_id" class=" col-form-label col-form-label-sm">Patient ID</label>
                                    <input type="text" class="form-control form-control-sm " id="patient_id" name="patient_id"
                                        value="" placeholder="Patient ID">
                                </div>

                                <div class="col-md-2">
                                    <label for="patient_mobile_no" class=" col-form-label col-form-label-sm">Patient Mobile No.</label>
                                    <input type="text" class="form-control form-control-sm " id="patient_mobile_no" name="patient_mobile_no"
                                        value="" placeholder="Patient Mobile No.">
                                </div>

                                <div class="col-md-3">
                                    <label for="other_mobile" class=" col-form-label col-form-label-sm">Others No.(Mobile)  
                                        <a data-modal="common-modal" data-action="{{ route('add_new_appointment_popup_cph') }}" class="btn mb-1 btn-info btn-sm open-modal modal-lg"
                                        data-title="Add Others Patient Information">+ New Patient
                                    </a>
                                </label>
                                    <input type="text" class="form-control form-control-sm " id="other_mobile" name="other_mobile"
                                        value="" placeholder="Others No.(Mobile)">
                                </div>

                                <div class="col-md-2 mt-4">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-md btn-success btn-md-global btn-block mt-0"
                                            id="dailyAttSearchReportV1" onclick=""> <i class="fas fa-search"></i> Search</button>
                                        <button type="reset" class="btn btn-md btn-info btn-md-global btn-block mt-0" title="Click here to Clear form data"><i class="fa fa-redo"></i> Clear</button>
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
            <div class="card-header"></div>
            <div class="card-body">

                <div class="form-row mt-2">
                    {{-- table-responsive --}}
                    <div class="col-md-12 " id="daily-attend-container">
                        @include('admin.cph.patient_appointment.search_appointment_info')
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    openDoctorAutocomplete("#card_no", 'card_hidn');
    // $("body").addClass("sidebar-collapse");

    $('.select2').select2();
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    // $(document).on("click", "#dailyAttSearchReportV1", function(e) {
    //     var formID = $("#frmSearchV1").attr("id");
    //     // var formAction = $("#frmSearchV1").attr("action");
    //     var formMethod = $("#frmSearchV1").attr("method");

    //     $.ajax({
    //         data: $('#' + formID).serialize(),
    //         url: "{{ url('hrm/daily_attendance_report_searchV1') }}",
    //         type: formMethod,
    //         beforeSend: function() {
    //             blockUI();

    //         },
    //         success: function(data) {
    //             $("#daily-attend-container").html(data);
    //         },
    //         complete: function() {
    //             $.unblockUI();
    //         }
    //     });
    //     e.stopImmediatePropagation();
    // });

</script>
