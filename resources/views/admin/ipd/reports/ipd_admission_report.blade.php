<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">OPD Admission Report</h5>
                <small>Report / OPD Admission Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('lohs-report-pdf') }}" id="opd_fORM" method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">
                            <div class=" col-md-2">
                                <label for="request_department"
                                    class=" col-form-label col-form-label-sm ">Department</label>
                                <select class="form-control form-control-sm select2" id="request_department"
                                    name="request_department">
                                    <option value="">Select Department</option>
                                    @if (!empty($serviceDepts))
                                        @foreach ($serviceDepts as $rd)
                                            <option value="{{ $rd->serviceunit_no_pk }}">
                                                {{ $rd->serviceunit_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class=" col-md-2">
                                <label for="intervention"
                                    class=" col-form-label col-form-label-sm ">Intervention</label>
                                <select class="form-control form-control-sm select2" id="intervention"
                                    name="intervention">
                                    <option value="">Select Intervention</option>
                                    @if (!empty($intervention))
                                        @foreach ($intervention as $data)
                                            <option value=" {{ $data->pres_lookupdata_name }}">
                                                {{ $data->pres_lookupdata_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class=" col-md-2">
                                <label for="card_no" class=" col-form-label col-form-label-sm ">Doctor Name /
                                    Code</label>
                                <input type="text" class="form-control form-control-sm " id="card_no"
                                    name="card_no" value="" placeholder="Card no / name">
                                <input type="hidden" name="card_hidn" id="card_hidn">

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Admission
                                        Date</label>
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
                            <div class="col-md-2">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="OPD_search_btn"
                                        class="btn btn-md btn-success btn-block mt-4">Search</button>
                                    <button type="submit" id="cashier_report"
                                        class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button>

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="opd_search_data">
                        @include('admin.ipd.reports.ipd_admission_report_data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
   openDoctorAutocomplete("#card_no", 'card_hidn');
   $(document).ready(function() {
        $('.select2').select2();
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

    $(document).on("click", "#OPD_search_btn", function(e) {
        var formID = $("#opd_fORM").attr("id");
        var formMethod = $("#opd_fORM").attr("method");
        $("#opd_fORM").attr('action', "{{ url('opd-admission-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('opd-admission-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#opd_search_data").html(data);
                $("#opd_fORM").attr('action', "{{ route('opd-admission-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
