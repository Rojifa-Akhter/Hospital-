<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-10">
                        <h5 class="mt-2 mb-0">GRN Register Item Wise</h5>
                        <small>Store / Inventory / GRN Register Item Wise</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-body border-bottom-3 p-2">
                        <form action="{{ route('getGRNWorkListPDF') }}" id="grn_worklist" class="grn_worklist"
                            method="POST" target="_blank">
                            @csrf
                            <div class="form-row">
                                <div class="col-lg-1 col-md-1 col-12">
                                    <div>
                                        <label for="supplier_id" class="col-form-label">Supplier</label>
                                        <select class="form-control form-control-sm select2" id="supplier_id"
                                            name="supplier_id">
                                            <option value="">Select Supplier</option>
                                            @if (!empty($allSuppliers))
                                                @foreach ($allSuppliers as $allSupplier)
                                                    <option value="{{ $allSupplier->supplier_no_pk }}">
                                                        {{ $allSupplier->supplier_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <div>
                                        <label for="main_store" class="col-form-label">Main Store</label>
                                        <select class="form-control form-control-sm select2" id="main_store"
                                            name="main_store">
                                            <option value="">Select</option>
                                            @if (!empty($mainStore))
                                                @foreach ($mainStore as $value)
                                                    <option value="{{ $value->serviceunit_no_pk }}">
                                                        {{ $value->serviceunit_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" id="report_type" name="report_type" value="">

                                <div class="col-lg-2 col-md-2 col-12">
                                    <div>
                                        <label for="item_code" class="col-form-label">Item ID.</label>
                                        {{-- <input type="text" class="form-control form-control-sm" id="item_code"
                                            name="item_code" placeholder="Enter Item ID."> --}}

                                        <select class="form-control form-control-sm select2" id="supplier_id"
                                            name="supplier_id">
                                            <option value="">Select Supplier</option>
                                            @if (!empty($items))
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->item_no_pk }}">
                                                       <strong></strong> {{ $item->item_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 col-12">
                                    <div>
                                        <label for="grn_no" class="col-form-label">GRN No</label>
                                        <input type="text" class="form-control form-control-sm" id="grn_no"
                                            name="grn_no" placeholder="GRN Number ">
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-1 col-12">
                                    <div>
                                        <label for="from_date" class="col-form-label">From Date</label>
                                        <input type="text" class="form-control from_date datepicker" name="from_date"
                                            id="from_date" value="" placeholder="dd/mm/yy">
                                    </div>
                                </div>

                                <div class="col-lg-1 col-md-1 col-12">
                                    <div>
                                        <label for="to_date" class="col-form-label">To Date</label>
                                        <input type="text" class="form-control datepicker" name="to_date"
                                            id="to_date" value="" placeholder="dd/mm/yy">
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-12 mt-4">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" id="btnSearchGRN" class="btn btn-success btn-md-global"
                                            onclick="getGRNWorkList()"><i class="fa fa-search"></i> Search</button>
                                        <button type="button" id="btnReportGRN" class="btn btn-warning btn-md-global"
                                            onclick="reportGRN();print(this)" reportType="PDF"><i
                                                class="fa fa-file"></i> Report</button>
                                        <button type="submit" class="btn btn-primary btn-md-global" target="_blank"
                                            reportType="EXCEL" onclick="print(this)">
                                            Export Excel
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript -->
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    // openBillingItemAutocomplete("#item_code", "", "", '');
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");

    $(function() {
        $('.datepicker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#cashier_report_search", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");
        $("#searchForm").attr('action', "{{ url('report/cashier-wise-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('report/cashier-wise-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#cashier_report_data").html(data);
                $("#searchForm").attr('action', "{{ route('report.cashier-wise-report-print') }}");
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
    function exportPDFSummary(element) {
        $("#hdn_report_type").val("SUMMARY");
        $("#searchForm").submit();
    }

    function exportPDFpdf(element) {
        $("#hdn_report_type").val("");
        $("#searchForm").submit();
    }
</script>
