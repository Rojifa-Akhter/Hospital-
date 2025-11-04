<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="" id="pharmacyStockReportSearch" method="POST" target="_blank">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">As On Date Stock Report</h5>
                                <small>As On Date Stock Report</small>
                            </div>

                            <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                    <button type="submit" class="btn btn-info btn-block btn-md mt-0 print"
                                        value="1" id="PDF">Export PDF</button>
                                    <button type="submit" class="btn btn-secondary btn-block btn-md mt-0 print"
                                        value="2" id="EXCEL">Export Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h5><i class="fas fa-search"></i> Search</h5>
                            </div>

                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <div class="input-group">
                                                <Select name="department" id="department" class="form-control select2">
                                                    <option value="">Select</option>
                                                    @if (!empty($department))
                                                        @foreach ($department as $dept)
                                                        <option value="{{ $dept->serviceunit_no_pk }}">{{ $dept->serviceunit_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </Select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="supplier_name">Supplier Name</label>
                                            <div class="input-group">
                                                <Select name="supplier_name" id="supplier_name" class="form-control select2">
                                                    <option value="">Select</option>
                                                    @if (!empty($suppliers_name))
                                                        @foreach ($suppliers_name as $supplier)
                                                        <option value="{{ $supplier->supplier_no_pk }}">{{ $supplier->supplier_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </Select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <?php
                                        $currentDate = date('d-m-Y');
                                        $sevenDaysAgo = date('d-m-Y', strtotime('-6 days', strtotime($currentDate)));
                                        $pay = 0;
                                        ?>
                                        <div class="form-group">
                                            <label for="from_date">Request Date</label>
                                            <div class="input-group">
                                                <input type="text" id="from_date" name="from_date"
                                                    class="form-control date_picker" value="{{ $sevenDaysAgo }}"/>
                                                <input type="text" id="to_date" name="to_date"
                                                    class="form-control date_picker" value="{{ $currentDate }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="button" id="pharmacyStockReportSearchButton"
                                                class="btn btn-md btn-success mt-4 btn-md-global">Search</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped data-table">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th style="width: 50px;" class="text-center">SL</th>
                                                <th style="width: 100px;" class="text-center">Item No.</th>
                                                <th style="width: 180px;" class="text-left">Item Name</th>
                                                <th style="width: 180px;" class="text-left">Generic Name</th>
                                                <th style="width: 100px;" class="text-right">Last Purchase Price</th>
                                                <th style="width: 100px;" class="text-right">Last Sales Price</th>
                                                <th style="width: 90px;" class="text-right">Opening Qty.</th>
                                                <th style="width: 90px;" class="text-right">Stock In</th>
                                                <th style="width: 90px;" class="text-right">Stock Out</th>
                                                <th style="width: 90px;" class="text-right">Closing Qty</th>
                                                <th style="width: 110px;" class="text-right">Total Purchase Price</th>
                                                <th style="width: 110px;" class="text-right">Total Sales Price</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pharmacyStockReportSearchTable">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </form>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $("body").addClass("sidebar-collapse");
        $('.select2').select2();
        $('.data-table').DataTable({
            "ordering": false,
            "searching": true,
            "bPaginate": true,
            "pageLength": 100,

        });

        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

    });

        $(document).on("click", "#pharmacyStockReportSearchButton", function(e) {
        var formID = $("#pharmacyStockReportSearch").attr("id");
        var formMethod = $("#pharmacyStockReportSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('pharmacy.v1.pharmacy-stock-report-search-v1') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('.data-table').DataTable().destroy();
                $("#pharmacyStockReportSearchTable").html(data);

                $('.data-table').DataTable({
                    "ordering": false,
                    "searching": true,
                    "bPaginate": true,
                    "pageLength": 100,
                });
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });



    $(document).on("click", ".print", function(e) {
        var print = $(this).val();
        if (print == 1) {
            $('form').attr('action', "{{ route('pharmacy.v1.pharmacy-stock-report-print-v1') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('pharmacy.v1.pharmacy-stock-report-excel-v1') }}");
        }
    });
</script>
