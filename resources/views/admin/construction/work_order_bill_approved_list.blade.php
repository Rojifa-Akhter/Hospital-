
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<style>
    .center{
        display: flex;
        justify-content: center;
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
    .excel-icon{
        font-size: 22px;
        color:green
    }
    .list-group-item{
        border:none !important;
        padding: 5px 5px !important;
        padding-bottom: 0px !important;
        background-color: unset;
    }
</style>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-10">
                        <h5 class="mt-2 mb-0">Work Order Bill Approved Worklist</h5>
                        <small>Construction / Work Order Bill Approved Worklist</small>
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
                            <form action="#" id="grn_worklist" class="grn_worklist">
                                <div class="form-row">

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div>
                                            <label for="department" class="col-form-label">Department</label>
                                            <select  class="form-control form-control-sm" name="department"  id="department" >                       
                                                <option value="">All</option>
                                                @foreach($department as $item)
                                                    <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div>
                                            <label for="vendor" class="col-form-label">Vendor</label>
                                            <select class="form-control form-control-sm select2" id="vendor" name="vendor">
                                                <option value="">All</option>
                                                @foreach ($vendor as $item)
                                                    <option value="{{$item->vendor_name}}">{{$item->vendor_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-1 col-md-1 col-12">
                                        <div>
                                            <label for="work_order_no" class="col-form-label">Work Order No</label>
                                            <input type="text" class="form-control form-control-sm" id="work_order_no" name="work_order_no" placeholder="Work Order No">
                                        </div>
                                    </div>       

                                    <div class="col-lg-3 col-md-3 col-12">
                                        <label for="from_date" class="col-form-label">From Date / To Date</label>
                                        <div class="input-group mb-3">                                       
                                            <input type="text" class="form-control from_date" name="from_date" id="from_date" value="" placeholder="dd/mm/yy">                                            
                                            <div class="input-group-append">
                                                <input type="text" class="form-control datepicker" name="to_date" id="to_date" value="" placeholder="dd/mm/yy">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-1 col-md-1 col-12">
                                        <div>
                                            <label for="generated_status" class="col-form-label">Status</label>
                                            <select  class="form-control form-control-sm" name="generated_status"  id="generated_status" >                       
                                                <option value="">All</option>
                                                <option value="1">Fully Paid</option>
                                                <option value="2">Partialy Paid</option>
                                                <option value="3">Not Paid</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-sm-12 mt-4">
                                        <div class="btn-group btn-block " role="group">
                                            <button type="button" id="btnSearchGRN" class="btn btn-success btn-md-global" onclick="getWorkOrderList()"><i class="fa fa-search"></i> Search</button>
                                            <button type="reset" class="btn btn-info btn-md-global"><i class="fa fa-redo"></i> Reset</button>
                                            <button type="button" class="btn btn-warning btn-md-global" onclick="downloadWorklist('pdf')" ><i class="fas fa-file-pdf"></i>&nbsp;Export PDF</button>
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
                                    <table class="table table-bordered table-hover table-striped work_order_list_approved" id="work_order_list_approved">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th style="width:3%">SL</th>
                                                <th style="width:6%">Work Order</th>
                                                <th style="width:6%">Bill No</th>
                                                <th style="width:6%">Bill Date</th>                                              
                                                <th style="width:7%">Approved Date</th>                                              
                                                <th style="width:9%">Department</th>
                                                <th style="width:9%">Vendor</th>
                                                <th style="width:8%">Approval Status</th>
                                                <th style="width:7%" class="text-center">Total Amt.</th>
                                                <th style="width:7%">Paid Amount</th>
                                                <th style="width:7%">Due Amount</th>
                                                <th style="width:8%">Payment Status</th>
                                                <th style="width:16%; white-space:nowrap">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="13" class="text-center">Data Fetching ...</td>
                                            </tr>
                                        </tbody>
                                    </table>
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

<script>
    $("body").addClass("sidebar-collapse");
    $(document).ready(function(){
        $('.select2').select2();
        var currentDate = new Date();

        $('.datepicker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd/mm/yyyy',
            maxDate:currentDate,
		}).datepicker('setDate', currentDate);

        currentDate.setDate(currentDate.getDate() - 30);
        $('.from_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
            changeMonth: true,
            changeYear: true,
			format: 'dd/mm/yyyy',
            maxDate:currentDate,
		}).datepicker('setDate', currentDate);


        $('#work_order_no').focus(function() {
            $("#from_date").val('');
            $("#to_date").val('');
        });

        getWorkOrderList(true);
    })

    function getWorkOrderList(ind = null){
        let formElement = document.querySelector('#grn_worklist');
        let formData = new FormData(formElement);

            $.ajax({
                url:"{{route('construction.search-work-order-bill-approved-worklist')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    if(ind == null){
                        blockUI();
                    }
                },
                success:function(data){  
                    $.unblockUI();
                        if(data.data.length > 0)
                            setTableData(data.data); 
                        else
                            emptyTableData();

                },
                error:function(err){
                    $.unblockUI();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
    }

    function  setTableData(data){
        if($.fn.DataTable.isDataTable('.work_order_list_approved')) {$('.work_order_list_approved').DataTable().destroy();}  
            $('.work_order_list_approved tbody').empty();
            var rows = [];
            var table = $('.work_order_list_approved').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0,1,2,3,7,11,12], className: 'text-center' },
                        { targets: [6,4,5], className: 'text-left' },
                        { targets: [8,9,10], className: 'text-right' },
                    ],
                "lengthMenu": [[15, 25, 50, 75, 100, -1], [15, 25, 50, 75, 100, "All"]], 
                "pageLength": 15
                });


            var edit_link = ``;
            var bill_generate = ``;
            var aprroval_satatus = ``;
            var approve_text  = ``;
            var paid_status  = '';
            var paid_amount  = 0;
            var due_amount  = 0;
            data.forEach(function(item, index) {

                var date = new Date(item.bill_date);
                var day = date.getDate();
                var month = date.getMonth() + 1; 
                var year = date.getFullYear();
                var bill_date = padZero(day) + "/" + padZero(month) + "/" + year;

                    date = new Date(item.work_start_date);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                var start_date = padZero(day) + "/" + padZero(month) + "/" + year;

                    date = new Date(item.work_completion_date);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                var end_date = padZero(day) + "/" + padZero(month) + "/" + year;

                var last_approve_dt = '';

                if(item.last_approve_dt != null){
                    date = new Date(item.last_approve_dt);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                    last_approve_dt = padZero(day) + "/" + padZero(month) + "/" + year;
                }
                    

                edit_link = ``;
            
                edit_link+=`<a href="{{ route('construction.show-bill','') }}/${item.workorderbill_no_pk}" target="_blank" class="btn btn-success btn-sm mr-2">Bill Print</a>`;
                    
                
                if(item.att_doc != null){
                    edit_link+=`<a href="{{asset('/uploads/construction/${item.att_doc}')}}" target="_blank" class="btn btn-sm btn-success mr-2" title=" File"><i class="fas fa-file"></i></a>`;
                }

                if(item.attechment_file != null){
                    edit_link+=`<a href="{{asset('/images/uploads/construction/bill/${item.attechment_file}')}}" target="_blank" class="btn btn-sm btn-info mr-2" title="Bill Attachment"><i class="fas fa-file"></i></a>`;
                }


                    edit_link+=`<a href="{{ route('construction.show-work-order','') }}/${item.workordermst_no_pk}" target="_blank" class="btn btn-warning btn-sm">Print</a>`;
                    
                    approvalStatusText = item.approval_status_text;

                if(approvalStatusText != null){
                    if(approvalStatusText.indexOf('REJECTED') >= 0 || approvalStatusText.indexOf('HOLD') >= 0){
                        approve_text = `<a style="cursor:pointer" class="open-modal"
                            data-action="{{ route('v1.my.approval.level.detail-work-order-bill-generate-list','') }}/${item.workorderbill_no_pk}"
                            data-id="${item.workorderbill_no_pk}" data-modal="common-modal-sm"
                            data-title="Level Detail" title="Level Detail">
                            <span class="badge badge-warning">(${item.approval_level_status_text})</span>
                        </a>
                        <span class="text-danger">${approvalStatusText.indexOf('HOLD') >= 1 ? 'Hold' : 'Rejected'}</span>`;

                    }
                    else{
                        if(item.approval_level_status_text != ''){
                                var lavel = item.approval_level_status_text.split('/');
                                var approval_status = lavel[0] == lavel[1] ? 'Approved' : 'Pending';
                                var approval_person = item.approval_level_status_text != '' ? item.approval_level_status_text.split('/') : '';                    
                                if(approval_person != '' && approval_person[0] == approval_person[1]){

                                    approve_text = `<a style="cursor:pointer" class="open-modal"
                                        data-action="{{ route('v1.my.approval.level.detail-work-order-bill-generate-list', '') }}/${item.workorderbill_no_pk}"
                                        data-id="${item.workorderbill_no_pk}" data-modal="common-modal-sm"
                                        data-title="Level Detail" title="Level Detail">
                                        <span class="badge badge-success">(${item.approval_level_status_text})
                                        </span>
                                    </a>`;
                                }
                                else{
                                    approve_text = `<a style="cursor:pointer" class="open-modal"
                                        data-action="{{ route('v1.my.approval.level.detail-work-order-bill-generate-list', '') }}/${item.workorderbill_no_pk}"
                                        data-id="${item.workorderbill_no_pk}" data-modal="common-modal-sm"
                                        data-title="Level Detail" title="Level Detail">
                                        <span class="badge badge-warning">(${item.approval_level_status_text})</span>
                                    </a>`;
                                }    
                            }

                            approve_text+=`<span>${approval_status}</span>`;
                    }
                }

                
                    paid_amount = 0;
                    paid_status = '';
                    paid_amount = item.paid_amount == null ? 0 : item.paid_amount;

                    if(parseFloat(paid_amount) == parseFloat(item.total_amount)){
                        paid_status = `<span class="badge badge-success">Paid</span>`;
                        edit_link+=`<span class="btn btn-sm btn-secondary ml-2  open-modal btnView" data-action="{{route('construction.partial-payment-history','')}}/${item.workorderbill_no_pk}" data-modal="common-modal-md" data-title="Payment history" title="Payment History" data-id="${item.workorderbill_no_pk}">Pay History</span>`;
                    }
                    else if(parseFloat(paid_amount) == 0 && parseFloat(item.total_amount) > 0){

                        paid_status = `<span class="badge badge-warning">Pending</span>`;
                        edit_link+=`<span class="btn btn-sm btn-info ml-2  open-modal btnView" data-action="{{route('construction.partial-payment','')}}/${item.workorderbill_no_pk}" data-modal="common-modal-sm" data-title="Payment" title="Payment" data-id="${item.workorderbill_no_pk}">Pay</span>`;
                    }
                    else if(parseFloat(paid_amount) < parseFloat(item.total_amount)){
                        paid_status = `<span class="badge badge-primary">Partial Paid</span>`;
                        edit_link+=`<span class="btn btn-sm btn-info ml-2  open-modal btnView" data-action="{{route('construction.partial-payment','')}}/${item.workorderbill_no_pk}" data-modal="common-modal-sm" data-title="Payment" title="Payment" data-id="${item.workorderbill_no_pk}">Pay</span>`;
                        edit_link+=`<span class="btn btn-sm btn-secondary ml-2  open-modal btnView" data-action="{{route('construction.partial-payment-history','')}}/${item.workorderbill_no_pk}" data-modal="common-modal-md" data-title="Payment history" title="Payment History" data-id="${item.workorderbill_no_pk}">Pay History</span>`;
                    }
                    else{
                        paid_status = `<span class="badge badge-warning">Pending</span>`;
                        edit_link+=`<span class="btn btn-sm btn-info ml-2  open-modal btnView" data-action="{{route('construction.partial-payment','')}}/${item.workorderbill_no_pk}" data-modal="common-modal-sm" data-title="Payment" title="Payment" data-id="${item.workorderbill_no_pk}">Pay</span>`;
                    }

                    var rowData = [
                        ++index,
                        item.workordermst_no_pk,
                        item.workorderbill_no_pk,
                        bill_date,
                        last_approve_dt,
                        item.department,
                        item.vendor_name,
                        approve_text,
                        numberFormat(item.total_amount, 2, '.', ','),
                        numberFormat(paid_amount, 2, '.', ','),
                        numberFormat(item.total_amount - paid_amount, 2, '.', ','),
                        paid_status,
                        edit_link
                    ];
                    rows.push(rowData);
                    approve_text = '';
                
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
    }

    function emptyTableData(){
        $('.work_order_list_approved tbody').html(`
                <tr>
                    <td colspan="14" class="text-center">Data Not Found</td>
                </tr>`
            );
    }

    function padZero(number) {
        return number < 10 ? "0" + number : number;
    }

    function downloadPaymentHistory(type, bill_pk){
            var url = '{{route('construction.download-payment-history-pdf')}}';

            $.ajax({
                url: url,
                method: 'post',
                data:{bill_pk:bill_pk},
                xhrFields: {
                    responseType: 'blob' 
                },
                success: function(data) {
                    var downloadLink = document.createElement('a');
                    var url = window.URL.createObjectURL(new Blob([data]));
                    downloadLink.href = url;
                    downloadLink.setAttribute('download', 'work_order_payment_history.pdf');
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                    window.URL.revokeObjectURL(url);
                },
                error: function(xhr, status, error) {
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error);
                }
            });
    }

    function downloadWorklist(type){
            var url = '{{route('construction.download-approved-work-order')}}';

            var department = $("#department").val();
            var vendor = $("#vendor").val();
            var work_order_no = $("#work_order_no").val();
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            var generated_status = $("#generated_status").val();
            
            $.ajax({
                url: url,
                method: 'post',
                data:{
                        department:department,
                        vendor:vendor,
                        work_order_no:work_order_no,
                        generated_status:generated_status,
                        from_date:from_date,
                        to_date:to_date,
                    },
                xhrFields: {
                    responseType: 'blob' 
                },
                success: function(data) {
                    var downloadLink = document.createElement('a');
                    var url = window.URL.createObjectURL(new Blob([data]));
                    downloadLink.href = url;
                    downloadLink.setAttribute('download', 'approved_work_order_worklist.pdf');
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                    window.URL.revokeObjectURL(url);
                },
                error: function(xhr, status, error) {
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error);
                }
            });
    }
  
</script>



