<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Acceptance Report</h5>
                <small>Report / Acceptance Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <div class="form-row justify-content-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="card_no" class=" col-form-label col-form-label-sm">Patient ID</label>
                            <input type="hidden" class="" id="hdn_patient_id" name="hdn_patient_id" />
                            <input type="text" class="form-control form-control-sm m-0 mb-0 " id="service_number"
                                name="service_number" placeholder="Patient ID" required />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openPatientAutocomplete('#service_number', 'patient_name', patientId);

    function patientId(item, obj) {
        var patient_code = item.patient_code;
        var url = "acceptance-form-data/"+patient_code;
                window.open(url, "_blank");
        // console.log(patient_code)
        // $.ajax({
        //     url: "{{ route('Acceptance-form-data') }}",
        //     type: 'POST',
        //     data: {
        //         patient_code: patient_code
        //     },
        //     beforeSend: function() {
        //         blockUI();
        //     },
        //     success: function(data) {

        //     },
        //     complete: function() {
        //         $.unblockUI();
        //     }
        // });
    }
</script>
