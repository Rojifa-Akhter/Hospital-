<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Cashier Wise Collection Report</h5>
                <small>Report / Cashier Wise Collection Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
            <div class="card-body">
                <form action="{{ route('hrm.cashier_wise_collection_search_data_print') }}" id="CashierSearchForm" method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Cashier Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                       name="primary_doctor" maxlength="50" value="" placeholder="Cashier Name"
                                        />
                                <input type="hidden" id="doctor_id" name="doctor_id" value=""/>
                                <div><strong><p id="autocomplete_data"></p></strong></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_from" name="search_date_from" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="search_date_to" name="search_date_to" value="" placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="cashier_collection_report_search"  class="btn btn-md btn-success btn-block mt-4">Search</button>
                                <button type="submit" id="cashier_report"  class="btn btn-md btn-primary btn-block mt-4 print"> Export PDF</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="cashier_collection_report_data">
                        @include('admin.reports.hrm.cashier_wise_collection_data_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    // openCashierAutocomplete("#card_no", 'card_hidn');
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');
    // openCashierAutocomplete("#card_no", 'card_hidn', function (item, obj) {
    //     $('#card_no').val(item.person_id);
    //     // $('#card_hidn').val(item.full_name);
    //     $('#card_no').attr('type','text');
    //
    //     obj.stopImmediatePropagation();
    // });
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',

        });
    });

    $(document).on("click", "#cashier_collection_report_search", function(e) {
        var formID = $("#CashierSearchForm").attr("id");
        var formMethod = $("#CashierSearchForm").attr("method");
        $("#CashierSearchForm").attr('action',"{{ url('hrm/cashier_wise_collection_search_data') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url:"{{ url('hrm/cashier_wise_collection_search_data') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#cashier_collection_report_data").html(data);
                $("#CashierSearchForm").attr('action',"{{ route('hrm.cashier_wise_collection_search_data_print') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    // $(document).on("click", ".print", function(e) {
    // 	var formID = $("#searchForm").attr("id");
    // 	var formMethod = $("#searchForm").attr("method");

    // 	$.ajax({
    // 		data: $('#' + formID).serialize(),
    // 		url:"{{ route('report.cashier-wise-report-print') }}",
    // 		type: 'post',
    // 		beforeSend: function() {
    // 			var url = "{{ route('report.cashier-wise-report-print') }}";
    // 			alert(url);

    // 			blockUI();

    // 		},
    // 		success: function(data) {
    // 			$("#searchData").html(data);
    // 		},
    // 		complete: function() {
    // 			$.unblockUI();
    // 		}
    // 	});
    // });


    // 		$(document).on("click", ".print", function(e) {
    // 		var print = $(this).val();

    // 		if (print ==1 ) {
    // 			$('form').attr('action', "");
    // 		}
    // });
</script>
