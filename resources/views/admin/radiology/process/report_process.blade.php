<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />


<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Radiology Report Process</h5>
            <small>Radiology / Radiology Report Process</small>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="pending-sample" role="tabpanel"
                    aria-labelledby="received-by-challan-tab">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            @include('admin.radiology.process.result_process_search_panel')
                        </div>
                    </div>
                    <div id="rad_search_data">
                        <?php
                        $hospital_code = Session::get('user.ses_hospital_code');
                        ?>
                        @if ($hospital_code != 'UNICO')
                            @include('admin.radiology.process.report_process_list')
                        @else
                            @include('admin.radiology.process.report_process_list_uhl')
                        @endif



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    // All Script Here
    openInvoiceAutocomplete("#prescription_id");
    openPatientAutocomplete('#patient_id');
    openAdmissionAutocomplete('#admission_no');
    $("body").addClass("sidebar-collapse");

    $('.select2').select2();
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    // Search
    $(document).on("click", "#rad_process_search", function(e) {
        var formID = $("#frm_result_search").attr("id");
        var formMethod = $("#frm_result_search").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('rad/result-process-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#rad_search_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
