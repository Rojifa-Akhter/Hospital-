<style>
    .sticky_header {
        position: sticky;
        top: 90px;

    }
</style>



@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">
                    Referred Dotor Wise Patient Report
                </h5>
                <small>Report / Referred Dotor Wise Patient Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('doctor-refered-wise-report-pdf') }}" id="searchFormReffered" method="post"
                    target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="card_no" class=" col-form-label col-form-label-sm">Doctor Name</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                        name="primary_doctor" maxlength="50" value="" placeholder="Doctor Name" />
                                    <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                                    <div><strong>
                                            <p id="autocomplete_data"></p>
                                        </strong></div>
                                </div>
                            </div>
                             <div class="col-md-2">
                                <div class="form-group">
                                    <label for="card_no" class=" col-form-label col-form-label-sm">Department Name</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                        name="primary_doctor" maxlength="50" value="" placeholder="Doctor Name" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="card_no" class=" col-form-label col-form-label-sm">Item Name</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                        name="primary_doctor" maxlength="50" value="" placeholder="Item Name" />
                                </div>
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
                            <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                            <div class="col-md-4">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="referred_patient_search_btn"
                                        class="btn btn-md btn-success mt-4">Search</button>
                                    <button type="submit" id="cashier_report" class="btn btn-md btn-primary mt-4 print"
                                        onclick="exportPdf()"><i class="fa fa-file-excel-o"></i> Export PDF</button>
                                    <button type="button" id="summary" class="btn btn-info btn-md mt-4"
                                        onclick="exportExcel()"><i class="fa fa-print"></i>Export Excel</button>

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="reffered_doctor_data">
                        @include('admin.reports.referred.referred_doctor_item_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#referred_patient_search_btn", function(e) {
        var formID = $("#searchFormReffered").attr("id");
        var formMethod = $("#searchFormReffered").attr("method");
        $("#searchFormReffered").attr('action', "{{ url('doctor-refered-wise-report-search-data') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('doctor-refered-wise-report-search-data') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#reffered_doctor_data").html(data);
                $("#searchFormReffered").attr('action',
                    "{{ route('doctor-refered-wise-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function exportExcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#searchFormReffered").submit();
    }

    function exportPdf(element) {
        $("#hdn_report_type").val("PDF");
        $("#searchFormReffered").submit();
    }
</script>
