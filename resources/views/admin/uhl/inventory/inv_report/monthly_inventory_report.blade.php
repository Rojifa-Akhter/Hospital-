<style>
    /* .sticky_header {
        position: sticky;
        top: 90px;

    } */

    .input-group-prepend {
        height: 30px !important;
    }

    .sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 100px;
        padding: 50px;
        font-size: 20px;
    }
</style>
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Monthly Inventory Report</h5>
                <small>Inventory Management / Monthly Inventory Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body p-4">
                <form method="post" action="{{ route('hrm.daily_attendance_report_print') }}" id="frmSearch"
                    target="_blank">
                    @csrf
                    <div class="form-group  form-row">
                        <input type="hidden" name="id" value="">
                        <label for="" class="col-form-label col-form-label-sm ">
                            From Date</label>
                        <div class="col-md-1">
                            <input type="text" class="form-control form-control-sm date_picker" id="from_date"
                                name="from_date" value="{{ date('d-m-Y') }}" placeholder="YYYY/DD/MM">
                            <span class="focus_input"></span>
                        </div>
                        <label for="" class="col-form-label col-form-label-sm">To
                            Date</label>
                        <div class="col-md-1">
                            <input type="text" class="form-control form-control-sm date_picker" id="to_date"
                                name="to_date" value="{{ date('d-m-Y') }}" placeholder="YYYY/DD/MM">
                            <span class="focus_input"></span>
                        </div>

                        <label for="department" class="col-form-label col-form-label-sm ">Department</label>
                        <div class="col-sm-2">
                            <select class="form-control form-control-sm select2" name="department" id="department">
                                <option value="">Select</option>
                                @if (!empty($department))
                                    @foreach ($department as $value)
                                        <option value="{{ $value->stock_su_no_fk }}">
                                            {{ $value->department }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <label for="item_name" class="col-form-label col-form-label-sm">Item Name</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control form-control-sm" id="item_name"
                                name="item_name" value="" placeholder="Enter Item Name" />
                            <span class="focus_input"></span>
                        </div>

                        <input type="hidden" value="EXCEL" name="hdn_report_type" id="hdn_report_type">
                        <div class="col-md-2">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" class="btn btn-md btn-md-global btn-success btn-block mt-0"
                                    id="monthlyInventoryReport" onclick=""> <i class="fas fa-search"></i>
                                    Search</button>
                                {{-- <button type='button' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                    value="1" onclick="exportPDF('PDF', '{{ route('v1.monthly-inventory-report-print') }}')">
                                    <i class="fa fa-file-pdf"></i> PDF</button> --}}

                                <button type='button' class="btn btn-primary btn-block btn-md btn-md-global mt-0 print"
                                    value="1"
                                    onclick="exportPDF('EXCEL', '{{ route('v1.monthly-inventory-report-print') }}')">
                                    <i class="fa fa-file-excel"></i> Excel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-2 table-responsiveX"  id="monthly_inventory_report_container">   
                @include('admin.uhl.inventory.inv_report.monthly_inventory_report_list')                
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");
    $('.select2').select2();
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    $(document).on("click", "#monthlyInventoryReport", function(e) {
        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('v1/search-monthly-inventory-report') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#monthly_inventory_report_container").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        e.stopImmediatePropagation();
    });

    function exportPDF(reportType, route) {
        $("#hdn_report_type").val(reportType);

        $('form').attr('action', route);

        $("#frmSearch").submit();
    }

    function exportexcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#frmSearch").submit();
    }
</script>
