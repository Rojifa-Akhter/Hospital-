<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<section id="full_doctor_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Issued Items Reports</h5>
                <small>Store / Issued Items Report List</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="issuedItemReportSearchForm" action="{{ route('v1.item-issue-report-fms-new-pdf') }}"
                    method="post" target="_blank">
                    @csrf

                    <div class="form-row justify-content-center">
                        <div class="col-sm-2">
                            <label class="col-form-label col-form-label-sm" for="item_name">
                                Item Name</label>

                            <input type="text" class="form-control form-control-sm" id="item_name" name="item_name">
                            <input type="hidden" class="form-control form-control-sm" id="item_id_hidden"
                                name="item_id_hidden">

                        </div>
                        <div class="col-sm-2">
                            <label class="col-form-label col-form-label-sm" for="select_store">
                                Main Store <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm search-param select2" id="sub_store_id"
                                name="sub_store_id" required>
                                <option value="">Select Store</option>
                                @if (!empty($main_store_list))

                                    @foreach ($main_store_list as $store)
                                        <option value="{{ $store->serviceunit_no_pk }}">
                                            {{ $store->serviceunit_name }}
                                        </option>
                                    @endforeach

                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label col-form-label-sm " for="date_from">Issued Date <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">From</div>
                                </div>
                                <?php $currentDate = date('d-m-Y'); ?>
                                <input type="text" class="form-control form-control-sm m-0 date_picker"
                                    id="date_from" name="date_from"
                                    value="{{ date('d-m-Y', strtotime('-6 days', strtotime($currentDate))) }}"
                                    placeholder="dd-mm-yyyy" autocomplete="off">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">To</div>
                                </div>
                                <input type="text" class="form-control form-control-sm m-0 date_picker"
                                    id="date_to" name="date_to" value="{{ date('d-m-Y') }}" placeholder="dd-mm-yyyy"
                                    autocomplete="off">
                            </div>

                        </div>

                        <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                        <div class="col-md-4">
                            <div class="btn-group btn-block " role="group">
                                <button type="button" class="btn btn-md btn-success btn-block mt-4"
                                    id="itemIssueSearch" onclick=""> <i class="fas fa-search"></i> Search</button>

                                <button type="button" id="IPD"
                                    class="btn btn-md btn-primary btn-block mt-4 print" target="_blank"
                                    onclick="exportPDFIPD()"><i class="fa fa-print"></i> Export In
                                    PDF</button>
                                <button type="button" id="exportinexcel" onclick="exportPDF(this)"
                                    class="btn btn-md btn-warning btn-block mt-4 print"><i class="fa fa-file-excel"></i>
                                    Export In
                                    Excel</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="card">
            <div class="card-header ">

            </div>

            <div class="card-body" id="issue-item-list">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th scope="col">#SL </th>
                                    <th scope="col" class="text-center">Indent No</th>
                                    <th scope="col" class="text-center">Indent Date</th>
                                    <th scope="col" class="text-center">Issue No</th>
                                    <th scope="col" class="text-center">Issue Date</th>
                                    <th scope="col" class="text-center">Issue From</th>
                                    <th scope="col" class="text-center">Issue To</th>
                                    <th scope="col" class="text-center">Item No</th>
                                    <th scope="col" class="text-center">Item Name</th>
                                    <th scope="col" class="text-center">UoM</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-center">Rate</th>
                                    <th scope="col" class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody id="item-info">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>


<script>
    $(document).ready(function() {

        $('.data-table').DataTable({
            // "ordering": false,
            "searching": true,
            // "pageLength": 20,

        });

        $("body").addClass("sidebar-collapse");
        $('.select2').select2();
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

        $('#item_name').on('keyup', function() {
            var itemName = $(this).val();
            if (itemName === '') {
                $('#item_id_hidden').val('');
            }
        });

        item_name_autocomplete_store_wise_gatepass('#item_name', 'item_name', item_type = "INV", function(item,
            obj) {
            console.log(item);

            $('#item_code').val(item.item_code);
            $('#item_id_hidden').val(item.item_id);
            obj.stopImmediatePropagation();
        });


    });



    $(document).on("click", "#itemIssueSearch", function(e) {

        var subStoreId = $("#sub_store_id").val();
        var itemIdHidden = $("#item_id_hidden").val();
        var date_from = $("#date_from").val();
        var date_to = $("#date_to").val();

        if (date_from === "" || date_to === "") {
            alert("Please Select Date Range!");
            return;
        }

        if (subStoreId === "") {
            alert("Please Select Store Name!");
            return;
        }
        if (subStoreId === "") {
            alert("Please Select Store!");
            return;
        }
        // if (itemIdHidden === "") {
        //     alert("Please Give Item Name!");
        //     return;
        // }

        var formID = $("#issuedItemReportSearchForm").attr("id");
        var formMethod = $("#issuedItemReportSearchForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.search-item-issue-report-fms-new') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log(data);
                $("#item-info").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });


    function exportPDF(element) {
        var subStoreId = $("#sub_store_id").val();
        var itemIdHidden = $("#item_id_hidden").val();
        var date_from = $("#date_from").val();
        var date_to = $("#date_to").val();

        if (date_from === "" || date_to === "") {
            alert("Please Select Date Range!");
            return;
        }
        if (subStoreId === "") {
            alert("Please Select Store Name!");
            return;
        }
        if (subStoreId === "") {
            alert("Please Select Store!");
            return;
        }
        // if (itemIdHidden === "") {
        //     alert("Please Give Item Name!");
        //     return;
        // }
        $("#hdn_report_type").val("EXCEL");
        $("#issuedItemReportSearchForm").submit();
    }

    function exportPDFIPD(element) {
        var subStoreId = $("#sub_store_id").val();
        var itemIdHidden = $("#item_id_hidden").val();
        var date_from = $("#date_from").val();
        var date_to = $("#date_to").val();

        if (date_from === "" || date_to === "") {
            alert("Please Select Date Range!");
            return;
        }
        if (subStoreId === "") {
            alert("Please Select Store Name!");
            return;
        }
        if (subStoreId === "") {
            alert("Please Select Store!");
            return;
        }
        // if (itemIdHidden === "") {
        //     alert("Please Give Item Name!");
        //     return;
        // }
        $("#hdn_report_type").val("PDF");
        $("#issuedItemReportSearchForm").submit();
    }
</script>
