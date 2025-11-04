<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <form action="" id="stockAsOnReport" method="POST" target="_blank">
        @csrf
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-9">
                                <h5 class="mt-2 mb-0">Stock As On Report</h5>
                                <small>Stock As On Report</small>
                            </div>

                            {{-- <div class="col-md-3">
                                <div class="btn-group btn-block" role="group">
                                    <button type="submit" class="btn btn-info btn-block btn-md mt-0 print"
                                        value="1" id="PDF">Export PDF</button>
                                    <button type="submit" class="btn btn-secondary btn-block btn-md mt-0 print"
                                        value="2" id="EXCEL">Export Excel</button>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center"> <!-- Center align all content -->
                    <div class="col-md-12"> <!-- Adjust width for better alignment -->
                        <div class="card">
                            <div class="card-header bg-success text-left">
                                <h5><i class="fas fa-search"></i> Search</h5>
                            </div>

                            <div class="card-body text-center"> <!-- Center align all elements -->
                                <div class="form-row justify-content-center"> <!-- Center align form elements -->
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <select name="department" id="department" class="form-control select2">
                                                <option value="">Select</option>
                                                @if (!empty($department))
                                                    @foreach ($department as $dept)
                                                        <option value="{{ $dept->serviceunit_no_pk }}">
                                                            {{ $dept->serviceunit_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <?php $currentDate = date('d-m-Y'); ?>
                                        <div class="form-group">
                                            <label for="from_date">Date</label>
                                            <input type="text" id="from_date" name="from_date"
                                                class="form-control date_picker text-center" value="{{ $currentDate }}" />
                                        </div>
                                    </div>
                                    <div class="mt-4 col-md-2">
                                        <button type="button" id="stockAsReportButton"
                                            class="btn btn-md btn-success btn-md-global">Search</button>
                                            <button type="submit" class="btn btn-info btn-md mt-0 print"
                                            value="1" id="PDF">Export PDF</button>
                                        <button type="submit" class="btn btn-secondary btn-md mt-0 print"
                                            value="2" id="EXCEL">Export Excel</button>
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
                                                <th style="width: 100px;" class="text-left">Department</th>
                                                <th style="width: 120px;" class="text-left">Category</th>
                                                <th style="width: 120px;" class="text-left">Subcategory</th>
                                                <th style="width: 100px;" class="text-center">Item No.</th>
                                                <th style="width: 180px;" class="text-left">Item Name</th>
                                                <th style="width: 180px;" class="text-left">Generic Name</th>
                                                <th style="width: 120px;" class="text-left">Batch No</th>
                                                <th style="width: 120px;" class="text-left">Expiry Date</th>
                                                <th style="width: 90px;" class="text-right">Stock In Hand</th>
                                                <th style="width: 110px;" class="text-right">Stock Value</th>
                                                <th style="width: 100px;" class="text-center">GRN No</th>
                                                <th style="width: 120px;" class="text-center">GRN Date</th>
                                                {{-- <th style="width: 100px;" class="text-right">Last Purchase Price</th> --}}
                                                {{-- <th style="width: 100px;" class="text-right">Last Sales Price</th> --}}
                                                {{-- <th style="width: 90px;" class="text-right">Opening Qty.</th> --}}
                                                {{-- <th style="width: 90px;" class="text-right">Stock In</th> --}}
                                                {{-- <th style="width: 90px;" class="text-right">Stock Out</th> --}}
                                               {{-- <th style="width: 110px;" class="text-right">Total Sales Price</th> --}}
                                            </tr>

                                        </thead>
                                        <tbody id="stockAsOnReportTable">
                                            @include('admin.uhl.pharmacy_report.stock-as-on-report-data')
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

    $(document).on("click", "#stockAsReportButton", function(e) {
        var formID = $("#stockAsOnReport").attr("id");
        var formMethod = $("#stockAsOnReport").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('stock-as-on-report-search-v1') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('.data-table').DataTable().destroy();
                $("#stockAsOnReportTable").html(data);

                $('.data-table').DataTable({
                    "ordering": false,
                    "searching": true,
                    "bPaginate": true,
                    "pageLength": 10,
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
            $('form').attr('action', "{{ route('stock-as-on-report-print-v1') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('stock-as-on-report-excel-v1') }}");
        }
    });
    
</script>
