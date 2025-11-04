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
                <h5 class="mt-2 mb-0">IPD Patient Report</h5>
                <small>Report / IPD Patient Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <div class=" justify-content-center">

                    <form id="frmPatientIpd" method="post" target="_blank"
                        action="{{ route('ipd.patient-report-pdf') }}">
                        @csrf
                        <input type="hidden" name="type" value="Admission" id="type">
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label for="pat_type">Report Type</label>
                                <select class="form-control font_size_12  " id="pat_type" name="pat_type"
                                    width="200px">
                                    <option value='2' > Admitted Patient </option>
                                    <option value='3'> Current Patient </option>
                                    <option value='4' > Discharge Patient </option>
                                    <option value='5' > Death Patient </option>
                                    <option value='6' > Total Patient </option>

                                </select>
                            </div>

                            <div class="col-md-1">
                                <label for="emr_pat_type">Patient Type</label>
                                <select class="form-control font_size_12  " id="emr_pat_type" name="emr_pat_type"
                                    width="200px">
                                    <option value='3' >All</option>
                                    <option value='1' > IPD</option>
                                    <option value='2'> Emergency</option>

                                </select>
                            </div>

                            <div class="col-md-3">
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

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="card_no" class=" col-form-label col-form-label-sm">Doctor Name</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                        name="primary_doctor" maxlength="50" value=""
                                        placeholder="Enter Doctor Name" />
                                    <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                                    <div><strong>
                                            <p id="autocomplete_data"></p>
                                        </strong></div>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="card_no" class="col-form-label col-form-label-sm">Referral Name</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="referred_doctor"
                                        name="primary_doctor" maxlength="50" value=""
                                        placeholder="Enter Referral Name" />
                                    <input type="hidden" id="referred_id" name="referred_id" value="" />
                                    <div><strong>
                                            <p id="autocomplete_data"></p>
                                        </strong></div>
                                </div>
                            </div>

                            <div class="col-md-1 col-form-label col-form-label-sm">
                                <label for="ward_name">Ward Name</label>
                                <select class="form-control font_size_12  " id="ward_name" name="ward_name"
                                    width="200px">
                                    <option value="">Select</option>
                                    @if (!empty($ward_name))
                                    @foreach ($ward_name as $wards)
                                        <option value="{{ $wards->ward_no_pk }}" >{{ $wards->ward_name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="button" id="btnSearchReport"
                                    class="btn btn-md btn-success mt-4">Search</button>
                            
                                <button type="submit" 
                                    class="btn btn-md btn-primary mt-4 print" 
                                    data-action="{{ route('ipd.patient-report-pdf') }}">
                                    PDF
                                </button>
                            
                                <button type="submit" 
                                    class="btn btn-md btn-primary mt-4 print" 
                                    data-action="{{ route('ipd.patient-payment-report-pdf') }}">
                                    Payment Report
                                </button>
                            
                                <button type="submit" 
                                    class="btn btn-md btn-primary mt-4 print" 
                                    data-action="{{ route('ipd-patient-dept-wise-report-pdf') }}">
                                    PDF Dept.
                                </button>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card" id="ipd-patientList">
            @include('admin.ipd.reports.ipd_patient_list')
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
openDoctorAutocomplete('#primary_doctor', 'doctor_id');
openDoctorAutocomplete('#referred_doctor', 'referred_id');
    $("body").addClass("sidebar-collapse");
    $(document).on('click', '.patClass', function() {
        $("input[type=text]").attr('disabled', false);
    });
    $('.print').on('click', function () {
        let action = $(this).data('action'); 
        $('#frmPatientIpd').attr('action', action);
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
