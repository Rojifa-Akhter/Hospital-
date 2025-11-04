<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{asset('node_modules/datatables/media/css/jquery.dataTables.css')}}" rel="stylesheet">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Supplier Bill Process Request </h5>
            <small>Supplier Payment / Supplier Bill Process Request</small>
        </div>
        <!-- <div class="col-md-6 text-right">
            <div id="top-action" class="mt-0">
                <a class="btn btn-outline-primary btn-md uhl_common_outline_btn" rel="tab" href="{{ route('ipd.quick-admission') }}"><i
                        class="fa fa-plus"></i> Quick Admission</a>
            </div>
        </div> -->
    </div>
    <form action="{{route('income-summary-report-dummy-pdf','invoice')}}" method="post" id="pdfPrint" target="_blank" >
        @csrf
        <div class="form-row">
            <div class="col-md-12 mt-2">
                <div class="tab-content p-" id="myTabContent">
                    <div class="tab-pane fade active show" id="admitted-patient" role="tabpanel" aria-labelledby="admitted-patient-tab">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-row justify-content-center">
                                    <div class="form-group col-md-4">
                                        <label class="col-form-label col-form-label-sm" for="date_from"> Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">From</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker" id="date_from" name="date_from" value="" placeholder="dd-mm-yyyy" autocomplete="off">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">To</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm m-0 date-picker" id="date_to" name="date_to" value="" placeholder="dd-mm-yyyy" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="col-form-label col-form-label-sm" for="discount_percent">Discount (%) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm m-0" id="discount_percent" name="discount_percent" value="" placeholder="%" autocomplete="off">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="btn-group btn-block mt-4" role="group">
                                            <button type="button" id="save_btn" class="btn btn-success btn-md btn-md-global uhl_common_btn">Process</button>
                                            <button type="button" class="btn btn-md btn-success btn-md-global" id="btnSearch" data-action="">
                                                Search
                                            </button>
                                           
                                            <button type="submit" class="btn btn-md btn-info btn-md-global print"  id="invoice" value="invoice">Invoice wise Print</button>
                                            <button type="submit" class="btn btn-md btn-warning btn-md-global print"  id="Date" value="Date">Date wise Print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="card">

        <div class="card-body table-responsive">
            <table width="100%" class="data-table" border="1">
                <thead>
                    <tr class="global-uhl-table-bg">
                        <th class="text-center" style="width: 30px;">Sl.</th>
                        <th class="text-center" style="width: 100px;">Invoice No</th>
                        <th class="text-left" style="width: 100px;">Invoice Date</th>
                        <th class="text-left" style="width: 100px;">Patinet Name</th>
                        <th class="text-left" style="width: 100px;">Patinet Id</th>
                        <th class="text-left" style="width: 100px;">Admission No</th>
                        <th class="text-left" style="width: 100px;">Age</th>
                        <th class="text-left" style="width: 100px;">Gender</th>
                        <th class="text-left" style="width: 100px;">Cashier Name</th>
                        <th class="text-right" style="width: 100px;">Sales Amt</th>
                        <th class="text-right" style="width: 100px;">Discount Amt</th>
                        <th class="text-right" style="width: 100px;">Payment Amt</th>
                        <th class="text-right" style="width: 100px;">Payable Amt</th>

                    </tr>
                </thead>
                <tbody id="supplier_payment">
                    @include('admin.reports.financial_summary.income_summary_report_dummy_list')
                </tbody>
            </table>
        </div>
    </div>

</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{asset('node_modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $('.data-table').DataTable({
        "ordering": false,
        "bAutoWidth": false
    });
    $(".date-picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true
    });

    $(document).on("click", "#save_btn", function(e) {
        var discount_percent = $('#discount_percent').val();      
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        if (date_from == '' || date_to == '' || discount_percent == '') {
            alert("Enter value");
            return false;
        }
        $.ajax({
            data: {
                discount_percent: discount_percent,              
                date_from: date_from,
                date_to: date_to
            },
            url: "{{ route('income-summary-report-dummy-process') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data)
                // $('.data-table').DataTable().destroy();
                $("#supplier_payment").html(data);
                // $('.data-table').DataTable({
                //     "ordering": false,
                //     "bAutoWidth": false
                // });
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    $(document).on("click", "#btnSearch", function(e) {
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        if (date_from == '' || date_to == '') {
            alert("Enter value");
            return false;
        }
        $.ajax({
            data: {
                date_from: date_from,
                date_to: date_to
            },
            url: "{{ route('income-summary-report-dummy-search') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#supplier_payment").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on('click','.print',function() {
        // var buttonValue = $(this).find('button[type="submit"]').val();
        var buttonValue = $(this).val();
        var url="{{route('income-summary-report-dummy-pdf',':id')}}"  
        console.log(buttonValue)
        if (buttonValue === 'invoice') {
            url=url.replace(':id','invoice');
        } else if (buttonValue === 'Date') {
            url=url.replace(':id','date');          
        }
        $('form').attr('action',url);
    });


    function search_list(params) {
        $('#btnSearch').click();
    }
</script>