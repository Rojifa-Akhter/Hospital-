<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .sorting {
        background-image: none !important;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Ipd Patient Report</h5>
                <small>Report / Ipd Patient Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <div class=" justify-content-center">

                    <form id="frmPatientIpd" method="post"
                        action="{{ route('report.pharmacy-daily_report_print') }}">
                        @csrf
                        <input type="hidden" name="type" value="Admission" id="type">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="pat_type">Report Type</label>
                                <select class="form-control font_size_12  " id="rep_type" name="rep_type"
                                    width="200px">
                                    <option value='1' >IPD</option>
                                    <option value='2'>OPD</option>

                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_from" name="search_date_from" value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off" >
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_to" name="search_date_to" value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="btnSearchReport"
                                    class="btn btn-md btn-success mt-4">Search</button>
                                <button type="submit" id="pharmacy_finc_report"
                                    class="btn btn-md btn-primary mt-4 print"> Export PDF</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card" id="ipd-patientList">
            @include('admin.ipd.reports.dept_wise_patient_list')
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    $("body").addClass("sidebar-collapse");
    $(document).on('click', '.patClass', function() {
        var selectedValue = $('#pat_type').find(":selected").text();
        $('.updatedHeader').text(selectedValue)
        $('#type').val(selectedValue)
        $("input[type=text]").attr('disabled', false);
    });

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#btnSearchReport", function(e) {
        var formID = $("#frmPatientIpd").attr("id");
        var formMethod = $("#frmPatientIpd").attr("method");

        $("#frmPatientIpd").attr('action', "{{ url('ipd-patient-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('ipd-patient-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#ipd-patientList").html(data);
                $("#frmPatientIpd").attr('action',
                    "{{ route('ipd.patient-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
