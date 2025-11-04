<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .sorting {
        background-image: none !important;
    }
</style>
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Payment Receipt Report</h5>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="paymentDepositReportSearch" method="post" action="{{ route('payment-deposit-report-pdf') }}"
                    target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">


                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">MRN/Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="patient_id"
                                    name="patient_id" maxlength="50" value="" placeholder="Patient Name Or ID" />
                                <input type="hidden" id="hd_patient_id" name="hd_patient_id" value="" />
                                <div><strong>
                                        <p id="autocomplete_data"></p>
                                    </strong></div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status" class="col-form-label col-form-label-sm">Status</label>
                                <select class="form-control form-control-sm" id="status" name="status">
                                    <option value="">Select Status</option>
                                    <option value="allocate">Allocate</option>
                                    <option value="unallocate">Unallocate</option>
                                    <option value="refund">Refund</option>
                                    <option value="cancel">Cancel</option>
                                </select>
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
                                        id="search_date_from" name="date_from" value="" placeholder="dd/mm/yyyy"
                                        autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="search_date_to" name="date_to" value="" placeholder="dd/mm/yyyy"
                                        autocomplete="off">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3">
                            <button type="button" id="payme_deposit_report_search"
                                class="btn btn-md btn-success mt-4">Search</button>
                            <button type="submit" id="finc_report" class="btn btn-md btn-primary mt-4 print"> Export
                                PDF</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Payment Receipt Report</h5>
            </div>

            <div class="card-body">
                <div class="row mt-2" id="payment-deposit-report-list">
                    @include('admin.ipd.payment_deposit_report_list')
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openPatientAutocomplete('#patient_id', 'patient_name', patientInfo);

    function patientInfo(selectedPatient) {
        document.getElementById('hd_patient_id').value = selectedPatient.patient_id ?? '';
    }

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            format: 'dd/mm/yyyy',
        });
    });
    $(document).on("click", "#payme_deposit_report_search", function(e) {
        var formID = $("#paymentDepositReportSearch").attr("id");
        var formMethod = $("#paymentDepositReportSearch").attr("method");
        $("#paymentDepositReportSearch").attr('action',
            "{{ url('payment-deposit-report-search') }}");


        let patientId = $('#hd_patient_id').val();
        let dateFrom = $('#search_date_from').val();
        let dateTo = $('#search_date_to').val();

        if (dateFrom !== "" || dateTo !== "") {
            if (dateFrom === "") {
                alert('Select From Date');
                return;
            }
            if (dateTo === "") {
                alert('Select To Date');
                return;
            }
        } else if (patientId === "") {
            alert('Please select patient or date range');
            return;
        }

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('payment-deposit-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#payment-deposit-report-list").html(data);
                $("#paymentDepositReportSearch").attr('action',
                    "{{ route('payment-deposit-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
