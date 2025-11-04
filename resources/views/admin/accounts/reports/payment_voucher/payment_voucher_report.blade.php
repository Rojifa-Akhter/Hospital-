<h2>@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

    <div class="card">
        <div class="card-header">
            <h5><i class="fa fa-search"></i> Search</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('financial-statement-print') }}" id="financialStateSearchForm" method="post">
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
                        <input type="hidden" value="" name="hdn_report_type_financial" id="hdn_report_type_financial">
                        <div class="col-md-6 mt-2">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="payment_voucher_searchbtn"
                                    class="btn btn-md btn-success mt-4">Search</button>
                                <button type="submit" id="pdf" class="btn btn-md btn-primary mt-4 print"
                                    onclick="exportPdfFinancial()"> Export PDF</button>
                                <button type="button" id="excel" class="btn btn-info btn-md mt-4"
                                    onclick="exportExcelFinancial()"><i class="fa fa-print"></i> Export
                                    Excel</button>

                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-2">
            <div class="form-row">
                <div class="col-md-12" id="financial_paymentDt">
                    @include('admin.accounts.reports.payment_voucher.financial_payment_search_dt')
                </div>
            </div>
        </div>
    </div>
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

        $(document).on("click", "#payment_voucher_searchbtn", function(e) {
            var formID = $("#financialStateSearchForm").attr("id");
            var formMethod = $("#financialStateSearchForm").attr("method");
            $("#financialStateSearchForm").attr('action', "{{ url('financial-statement-search-v1') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('financial-statement-search-v1') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#financial_paymentDt").html(data);
                    $("#financialStateSearchForm").attr('action',
                        "{{ route('financial-statement-print') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

        function exportExcelFinancial(element) {
            $("#hdn_report_type_financial").val("EXCEL");
            $("#financialStateSearchForm").submit();
        }

        function exportPdfFinancial(element) {
            $("#hdn_report_type_financial").val("PDF");
            $("#financialStateSearchForm").submit();
        }
    </script>
</h2>
