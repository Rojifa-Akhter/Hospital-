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
                    Profit Loss Report (Invoice Wise)
                </h5>
                <small>Report / Profit Loss Report (Invoice Wise)</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('invoice-wise-profil-loss-report-pdf') }}" id="searchForm" method="post"
                    target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">

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
                            <div class="col-md-4">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="sup_item_cashier_report_summary_search"
                                        class="btn btn-md btn-success btn-block mt-4">Search</button>
                                    <button type="submit" id="phr_cashier_report_summary"
                                        class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="sup_item_cashier_report_summary_data">
                        @include('admin.reports.profit_loss.invoice_wise_profit_loss_report_list')
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
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#sup_item_cashier_report_summary_search", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('search-invoice-wise-profil-loss-report') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#sup_item_cashier_report_summary_data").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
