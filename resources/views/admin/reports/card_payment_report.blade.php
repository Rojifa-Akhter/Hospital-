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
                <h5 class="mt-2 mb-0">{{ $counter }} Banking Payment Details</h5>
                <small>Report / {{ $counter }} Banking Payment Details</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <form id="frmCardPaymentSearch" method="post"
                    action="{{ route('report.card-payment-details-print') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Cashier Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                    name="primary_doctor" maxlength="50" value=""
                                    placeholder="Cashier Name" />
                                <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                                <div><strong>
                                        <p id="autocomplete_data"></p>
                                    </strong></div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="bank_id">Bank</label>
                            <select class="form-control font_size_12  " id="bank_id" name="bank_id" width="200px">
                                <option value="">Select Bank Name</option>
                                @if (!empty($bank_name))
                                    @foreach ($bank_name as $pk => $bank)
                                        <option value="{{ $bank }}">{{ $bank }}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                        <input type="hidden" name="module" value="{{ $counter }}">
                        <div class="col-md-2">
                            <label for="mbs_id">MBS</label>

                            <select class="form-control font_size_12  " id="mbs_id" name="mbs_id" width="200px">
                                <option value="">Select MBS Name</option>
                                @if (!empty($mBanking))
                                    @foreach ($mBanking as $pk => $mBanking)
                                        <option value="{{ $mBanking }}">{{ $mBanking }}</option>
                                    @endforeach
                                @endif
                            </select>

                            {{-- <select class="form-control font_size_12  " id="mbs_id" name="mbs_id" width="200px">
                                <option value="">Select MBS Name</option>
                                <option value="bKash">Bkash</option>
                                <option value="rocket">Rocket</option>
                                <option value="nogod">Nogod</option>
                            </select> --}}
                        </div>

                        {{-- <div class="col-md-2">
                            <label for="patient_id">Patient </label>
                            <input type="text" class="form-control" name="patient_id" id="patient_id" autocomlete="off" placeholder="Patient ID" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                        </div>
                        <div class="col-md-2">
                            <label for="invoice_id">Voucher</label>
                            <input type="text" class="form-control" name="invoice_id" id="invoice_id" placeholder="Voucher No" autocomlete="off" />
                            <input type="hidden" class="form-control" id="hdn_invoice_id" name="hdn_invoice_id" />
                        </div> --}}
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-md-6" style="margin-right: -30px;">
                                    <label for="type">From</label>
                                    <input type="text" class="form-control date_picker" name="date_from"
                                        id="date_from" value="" autocomlete="off" placeholder="From Date" />
                                </div>
                                <div class="col-md-6">
                                    <label for="type">To </label>
                                    <input type="text" class="form-control date_picker" name="date_to" id="date_to"
                                        value="" autocomlete="off" placeholder="To Date" />
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-1 mt-2">
                            <div>
                                <input type="checkbox" id="bank" name="bank" value="1" />
                                <label for="bank">Bank</label>
                            </div>
                            <div>
                                <input type="checkbox" id="mbs" name="mbs" value="1" />
                                <label for="mbs">MBS </label>
                            </div>
                        </div>


                        <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                        <div class="col-md-2">
                            <button type="button" id="card_payment_report_search"
                                class="btn btn-md btn-success mt-4">Search</button>
                            <button type="submit" id="finc_report" class="btn btn-md btn-primary mt-4 print" onclick="exportPDFCard()"> Export
                                PDF</button>
                                <button type="button" id="summary" class="btn btn-info btn-md mt-4"
                                onclick="exportPDFCardCashier()"><i class="fa fa-print"></i> Cashier Wise
                                Report</button>
                            {{--							<label class="mt-4">&nbsp;</label> --}}
                            {{--							@php $action = route('financial-list'); @endphp --}}
                            {{--							<button type="button" class="btn btn-success btn-md" onclick="generateReport(this, 'frmFinancialSearch', '{{ $action }}')">Search</button> --}}

                            {{--							<label class="mt-4">&nbsp;</label> --}}
                            {{--							<a href="{{ route('report.invoice_print') }}" title="Print Invoice" target="_blank" class="btn btn-primary btn-md">Export PDF</a> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Banking Payment Detail List</h5>
            </div>
            <div class="card-body">
                <div class="mt-2" id="financial-list">
                    @include('admin.reports.card_payment_report_table')
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                format: 'dd/mm/yyyy',
                endDate: '+0d',
            });
        });

        $("#sidebar-left").addClass("active");
        $("#content").addClass("active");
        openPatientAutocomplete('#patient_id');
        openInvoiceAutocomplete('#invoice_id');
        openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');
        openDoctorAutocomplete('#primary_doctor', 'doctor_id');




        $(document).on("click", "#card_payment_report_search", function(e) {
            var formID = $("#frmCardPaymentSearch").attr("id");
            var formMethod = $("#frmCardPaymentSearch").attr("method");
            $("#frmCardPaymentSearch").attr('action',
                "{{ url('report/card-payment-details-search') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('report/card-payment-details-search') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#financial-list").html(data);
                    $("#frmCardPaymentSearch").attr('action',
                        "{{ route('report.card-payment-details-print') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });


    });
    function exportPDFCardCashier(element) {
        $("#hdn_report_type").val("CASHIER");
        $("#frmCardPaymentSearch").submit();
    }
    function exportPDFCard(element) {
        $("#hdn_report_type").val("");
        $("#frmCardPaymentSearch").submit();
    }
</script>
