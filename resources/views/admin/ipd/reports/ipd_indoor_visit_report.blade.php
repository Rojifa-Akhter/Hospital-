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
                <h5 class="mt-2 mb-0">IPD Doctor Visit</h5>
                <small>Report / IPD Doctor Visit</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">


                <form id="formVisitPatient" method="post" action="{{ route('ipd.indoor-patient-report-pdf') }}">
                    @csrf
                    <div class=" justify-content-center form-row">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Doctor Name</label>
                                <input type="text" class="form-control form-control-sm " id="card_no"
                                    name="card_no" value="" placeholder="Enter Doctor Name">
                                <input type="hidden" name="card_hidn" id="card_hidn">
                                <div><strong>
                                        <p id="autocomplete_data"></p>
                                    </strong></div>
                            </div>

                            {{-- <div class="col-md-2">
                                <label for="add_id" class=" col-form-label col-form-label-sm">Admission ID</label>
                                <input type="text" class="form-control form-control-sm " id="add_id"
                                    name="add_id" value="" placeholder="Enter Admission ID">
                            </div> --}}

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_from" name="search_date_from" value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="search_date_to" name="search_date_to" value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" id="btnVisitSearch"
                                    class="btn btn-md btn-success mt-4">Search</button>
                                <button type="submit" id="pharmacy_finc_report"
                                    class="btn btn-md btn-primary mt-4 print"> Export PDF</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <div class="card" id="ipdVisitPatientList">
            @include('admin.ipd.reports.ipd_indoor_visit_fee_list')
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#card_no', 'card_hidn');
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#btnVisitSearch", function(e) {
        var formID = $("#formVisitPatient").attr("id");
        var formMethod = $("#formVisitPatient").attr("method");
        $("#formVisitPatient").attr('action', "{{ url('ipd/indoor/patient/visit/report-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('ipd/indoor/patient/visit/report-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#ipdVisitPatientList").html(data);
                $("#formVisitPatient").attr('action',
                    "{{ route('ipd.indoor-patient-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
