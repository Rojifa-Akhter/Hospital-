<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section id="create_corporate">
    <div class="container-fluid">
        {{-- page header --}}
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-10 mb-1">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Corporate Work List</h5>
                    <small>Corporate / Corporate Work List</small>
                </div>
            </div>
            <div class="col-md-2 mt-3">

                <button class="btn btn-outline-primary btn-md float-right open-modal mt-2" data-modal="common-modal-md"
                    data-action="{{ route('corporate-form') }}" data-title="Add New Corporate">Add New
                    Corporate</button>
            </div>
        </div>





        {{-- Search Bar Started --}}
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <form id="corporateForm" method="post" action="{{ route('corporate.search-worklist-pdf') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="invoice_id">Active Status</label>
                            <select class="form-control" id="active_status" name="active_status">
                                <option selected value="">Choose Status</option>
                                <option value="1">Active
                                </option>
                                <option value="2">Proposed
                                </option>
                                <option value="0">Inactive
                                </option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-6" style="margin-right: -30px;">
                                    <label for="type">From</label>
                                    <input type="text" class="form-control date_picker" name="date_from"
                                        value="" id="date_from" autocomlete="off" placeholder="From Date" />
                                </div>
                                <div class="col-md-6">
                                    <label for="type">To </label>
                                    <input type="text" class="form-control date_picker" name="date_to" value=""
                                        id="date_to" autocomlete="off" placeholder="To Date" />
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">

                        <div class="col-md-4 btn-group">
                            <button type="button" id="corporate_search_btn"
                                class="btn btn-md btn-success mt-4">Search</button>

                            {{-- <button type="submit" target="_blank" id="finc_report" class="btn btn-md btn-primary mt-4 print" > Export
                                PDF</button> --}}


                            <button type="button" id="IPD" class="btn btn-md btn-primary mt-4" target="_blank"
                                onclick="exportPdfCorporate()"><i class="fa fa-print"></i> Export In
                                Report</button>

                            <button type="button" id="exportinexcel" onclick="exportExcelCorporate(this)"
                                class="btn btn-md btn-warning mt-4"><i
                                    class="fa
                                             fa-file-excel"></i>
                                Export In
                                Excel</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Search Bar End --}}

        {{-- page body start --}}
        <!-- form start -->
        <!--  1st row-->
        <div id="corporate_worklist">
            @include('admin.corporate.corporate_worklist')
        </div>
        <!-- form end -->

        {{-- page body End --}}
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
    $(function() {
        $("body").addClass("sidebar-collapse");
        $('#datatable').DataTable();


        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                format: 'dd/mm/yyyy',
                clearBtn: true,
                autoclose: true,
                endDate: '+0d',
            });
        });


        $(document).on("click", "#corporate_search_btn", function(e) {
            var formID = $("#corporateForm").attr("id");
            var formMethod = $("#corporateForm").attr("method");
            $("#corporateForm").attr('action', "{{ url('search/corporate/worklist') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('search/corporate/worklist') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#corporate_worklist").html(data);
                    $("#corporateForm").attr('action',
                        "{{ route('corporate.search-worklist-pdf') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });

    });



    function exportExcelCorporate(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#corporateForm").submit();
    }

    function exportPdfCorporate(element) {
        console.log('exportPdfCorporate')
        $("#hdn_report_type").val("PDF");
        $("#corporateForm").submit();
    }
</script>
