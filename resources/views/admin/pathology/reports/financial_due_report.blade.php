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
                <h5 class="mt-2 mb-0">Due Report</h5>
                <small>Financial Accounts / Due Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="frmCashierSummarySearch" method="post"
                    action="{{ route('financial-due-report-pdf') }}" target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">


                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Cashier Name </label>
                                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                       name="primary_doctor" maxlength="50" value="" placeholder="Cashier Name"
                                        />
                                <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                                <div><strong><p id="autocomplete_data"></p></strong></div>
                            </div>
                        </div>
                        <div class="col-md-1">
                        <label for="paid" class=" col-form-label col-form-label-sm mt-4">paid </label> &nbsp;  <input type="checkbox" name="paid" id="paid" value="1" >
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Module Name </label>
                                <select name="module" id="module" class="form-control">
                                    <option value="">select</option>
                                    @if (!empty($module))
                                        @foreach ( $module as $value)
                                            <option value="{{$value->module_no_pk}}">{{$value->module_name.' ('.$value->module_code.' )'}}</option>
                                        @endforeach
                                    @endif
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
                            <button type="button" id="cashier_summary_search"
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
                <h5>Cashier Summary Report</h5>
            </div>

            <div class="card-body">
                <div class="row mt-2" id="cashier-wise-summary-list">
                    @include('admin.reports.financial_due_report_list')
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            format: 'dd/mm/yyyy',
        });
    });
    $(document).on("click", "#cashier_summary_search", function(e) {
        var formID = $("#frmCashierSummarySearch").attr("id");
        var formMethod = $("#frmCashierSummarySearch").attr("method");
        $("#frmCashierSummarySearch").attr('action',
        "{{ url('financial-due-report-search') }}");
        if ($('#search_date_from').val() =="") {
            alert('Select From Date');
            return;
        }else if($('#search_date_to').val() ==""){
            alert('Select To Date');
            return;
        }
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('financial-due-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#cashier-wise-summary-list").html(data);
                $("#frmCashierSummarySearch").attr('action',
                    "{{ route('financial-due-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
