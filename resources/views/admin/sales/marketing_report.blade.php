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
                    Month Wise OPD & IPD Patient
                </h5>
                <small>Marketing Department / Month Wise OPD & IPD Patient</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('marketing/marketing-report-summaryPdf') }}" id="searchMarketingReportId"
                    method="post" target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="emp_type" class="col-form-label col-form-label-sm">Employee Type</label>
                                <select class="form-control form-control-sm select2" id="emp_type" name="emp_type">
                                    <option value="1">Internal</option>
                                    <option value="2">External</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="card_no" class="col-form-label col-form-label-sm">Employee Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                    name="primary_doctor" maxlength="50" value="" placeholder="Employee Name" />
                                <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                                <div><strong>
                                        <p id="autocomplete_data"></p>
                                    </strong></div>
                            </div>
                        </div>
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
                        <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                        <div class="col-md-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="marketing_report_search"
                                    class="btn btn-md btn-success btn-block mt-4">Search</button>
                                <button type="submit" id="" value="1"
                                    class="btn btn-md btn-primary btn-block mt-4 print">Export PDF</button>
                                <button type='submit' class="btn btn-info btn-block btn-sm mt-4 print" target="_blank"
                                    value="2">Export Excel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="marketing_report_data">
                        @include('admin.sales.marketing_report_list')
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

    $(document).on("click", "#marketing_report_search", function(e) {
        var formID = $("#searchMarketingReportId").attr("id");
        var formMethod = $("#searchMarketingReportId").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('marketing.marketing-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#marketing_report_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".print", function(e) {
        var print = $(this).val();
        if (print == 1) {
            $('#hdn_report_type').val('PDF');
        }
        if (print == 2) {
            $('#hdn_report_type').val('EXCEL');
        }
    });
</script>
