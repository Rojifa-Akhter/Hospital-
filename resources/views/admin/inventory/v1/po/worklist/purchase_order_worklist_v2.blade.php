<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .select2-container .select2-dropdown {
        width: 400px !important; /* Specify the desired width here */        
    }
    .select2-selection__rendered{
        text-align: left !important;     
    }
    .select2-results__option{
        font-size: 12px !important;
    }
    .text-left{
        text-align:left;
    }
    .w-40{
        width:40%;
    }
    .w-60{
        width:60%;
    }
</style>

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Supply Chain Management</h5>
                            <small>Supply Chain Management / Purchase Order Workist</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="searchPOWorklist" class="searchPOWorklist">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-2 col-12">
                                        <div class="form-group form-row">
                                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" name="status" id="status">
                                                    <option value="" selected>All</option>
                                                    <option value="DRAFT">DRAFT</option>
                                                    <option value="POST">POST</option>
                                                    <option value="ISSUE">ISSUE</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="start_range" class="col-sm-4 col-form-label">From/To Date</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" placeholder="From Date" name="from_date" id="from_date" autocomplete="off">
                                                    <input type="text" class="form-control form-control-sm" placeholder="To Date" name="to_date" id="to_date" autocomplete="off">
                                                  </div>
                                               
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="form-group form-row">
                                            <label for="supplier" class="col-sm-4 col-form-label">Supplier</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" name="supplier" id="supplier">
                                                    <option value="" selected>All</option>
                                                    @if (!empty($allSuppliers))
                                                        @foreach ($allSuppliers as $allSupplier)
                                                            <option value="{{ $allSupplier->supplier_no_pk }}">{{ $allSupplier->supplier_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                               
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-2 col-12">
                                        <div class="form-group form-row">
                                            <label for="supplier" class="col-sm-4 col-form-label">Store</label>
                                            <div class="col-sm-8">
                                                <select type="text" class="form-control form-control-sm" id="main_store_id" name="main_store_id" onchange="changeStore()">
                                                    <option value="" selected>All</option>
                                                    @foreach ($main_store_list as $item)
                                                        @if($item->status == 1)
                                                            <option value="{{$item->serviceunit_no_pk}}"  data-name="{{$item->serviceunit_code}} - {{$item->serviceunit_name}}">{{$item->serviceunit_code}} - {{$item->serviceunit_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                               
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1 col-12">
                                        <div class="form-group form-row">
                                            <label for="po_no" class="col-sm-4 col-form-label px-0">PO No</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="number" id="po_no" name="po_no" placeholder="PO No">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <div class="form-group form-row">
                                            <div class="co-12">
                                                <button class="btn btn-md-global btn-success" id="search_po" onclick="searchPOWorklistForm(true)" type="button">Search</button>
                                                {{-- <button class="btn btn-md-global btn-danger" type="reset" onclick="resetForm()">Reset</button> --}}
                                                <button class="btn btn-md-global btn-warning" onclick="exportExcel()" type="button">Export to Excel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover purchase_order_list_v2" id="purchase_order_table_v2">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" style="width:5%">SL No</th>
                                            <th class="text-center" style="width:10%">PO No</th>
                                            <th class="text-center" style="width:10%">PO Date</th>
                                            <th class="text-center" style="width:15%">Supplier Name</th>
                                            <th class="text-center" style="width:10%">No of Item </th>
                                            <th class="text-center" style="width:15%">PO Amount</th>
                                            <th class="text-center" style="width:5%">Status</th>
                                            <th class="text-center" style="width:15%">Approval Status</th>
                                            <th class="text-center" style="width:15%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                   
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<!-- Amount Details Show -->
<input type="hidden" id="profileShowModalButton" class="btn btn-primary" data-toggle="modal" data-target="#profileShowModal">

<div class="modal fade" id="profileShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Amount Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
            <div class="d-flex justify-content-between">
                <h6 class="">PO No: <span id="po_no_modal"></span></h6>
                <h6 class="">Currency: <span id="currency_modal"></span></h6>
            </div>
            
            <table class="table table-striped table-bordered mt-3">
                <tbody>
                  <tr>
                    <th class="text-left w-40" style="text-align: left !important">Sub Total </th>
                    <td id="sub_total" class="w-60" style="text-align: right !important"></td>
                  </tr>
                  <tr>
                    <th class="text-left w-40" style="text-align: left !important">Vat (%) </th>
                    <td id="vat_percent" class="w-60" style="text-align: right !important"></td>
                  </tr>
                  <tr>
                    <th class="w-40" style="text-align: left !important">Vat Amount</th>
                    <td id="vat_amount" class="w-60" style="text-align: right !important"></td>
                  </tr>
                  <tr>
                    <th class="w-40" style="text-align: left !important">Discount (%) </th>
                    <td id="discount_percent" class="w-60" style="text-align: right !important"></td>
                  </tr>
                  <tr>
                    <th class="w-40" style="text-align: left !important">Discount Amount</th>
                    <td id="discount_amount" class="w-60" style="text-align: right !important"></td>
                  </tr>
                  <tr>
                    <th class="w-40" style="text-align: left !important">AIT (%) </th>
                    <td id="ait_percent" class="w-60" style="text-align: right !important"></td>
                  </tr>
                  <tr>
                    <th class="w-40" style="text-align: left !important">AIT Amount</th>
                    <td id="ait_amount" class="w-60" style="text-align: right !important"></td>
                  </tr>
                  <tr>
                    <th class="w-40" style="text-align: left !important">Service Charge(%) </th>
                    <td id="service_charge" class="w-60" style="text-align: right !important"></td>
                  </tr>
                  <tr>
                    <th class="w-40" style="text-align: left !important">Service Charge Amount</th>
                    <td id="service_charge_amount" class="w-60" style="text-align: right !important"></td>
                  </tr>
                  <tr>
                    <th class="w-40" style="text-align: left !important"><b>Total</b></th>
                    <td id="total" class="w-60" style="text-align: right !important"></td>
                  </tr>
                </tbody>
            </table>
        </div>
      </div>
    </div>
</div>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
      $("body").addClass("sidebar-collapse");
      $(document).ready(function(){
        var currentDate = new Date();
        var sevenDaysAgo = new Date(currentDate);
            sevenDaysAgo.setDate(currentDate.getDate() - 6);
            
        $('#from_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		}).datepicker('setDate', sevenDaysAgo);

        $('#to_date').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
			format: 'dd/mm/yyyy',
		}).datepicker('setDate', currentDate);
      })
</script>
<script>
    $("#searchPOWorklist").validate({
        rules:{
            from_date:{
                dateDMY:true 
            },
            to_date:{
                dateDMY:true
            },
        },
        messages:{
        }
    });
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });


        $(document).ready(function(){
            $('.select2').select2();
            $('th').addClass('text-center')

            searchPOWorklistForm();
        })


        function showAmount(po_no,currency,subTotal,vat_percent,vat_amount,ait_percent,ait_amount,sc_percent,sc_amount,discount_percent,discount_amount,total){
            $('#profileShowModalButton').click(); 
            $('#po_no_modal').text(po_no); 
            $('#currency_modal').text(currency); 
            $('#sub_total').text(numberFormat(subTotal == 'null' ? 0.00 : subTotal, 2, '.', ',')); 
            $('#vat_percent').text(numberFormat(vat_percent == 'null' ? 0.00 : vat_percent, 2, '.', ',')); 
            $('#vat_amount').text(numberFormat(vat_amount == 'null' ? 0 : vat_amount, 2, '.', ',')); 
            $('#ait_percent').text(numberFormat(ait_percent == 'null' ? 0.00 : ait_percent, 2, '.', ',')); 
            $('#ait_amount').text(numberFormat(ait_amount == 'null' ? 0 : ait_amount, 2, '.', ',')); 
            $('#service_charge').text(numberFormat(sc_percent == 'null' ? 0.00 : sc_percent, 2, '.', ','));
            $('#service_charge_amount').text(numberFormat(sc_amount == 'null' ? 0.00 : sc_amount, 2, '.', ',')); 
            $('#discount_percent').text(numberFormat(discount_percent == 'null' ? 0.00 : discount_percent, 2, '.', ',')); 
            $('#discount_amount').text(numberFormat(discount_amount == 'null' ? 0.00 : discount_amount, 2, '.', ',')); 
            $('#total').text(numberFormat(total, 2, '.', ',')); 
        }

        <!-- Submit Form Data -->
        function searchPOWorklistForm(search = null){

                let formElement = document.querySelector('#searchPOWorklist');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v2.inventory.search-po-work-list')}}",
                    type:"post",
                    dataType:"json",
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        if(search != null)
                        blockUI();
                    },
                    success:function(response){
                        if(response.data.length != 0)
                        {
                            setTableData(response.data);
                        }                       
                        else
                        {
                            emptyTable();
                        } 
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
        
        <!-- Set Table Data -->
        function setTableData(data){
            if($.fn.DataTable.isDataTable('#purchase_order_table_v2')) {
                $('#purchase_order_table_v2').DataTable().destroy();
            }        
            $('.purchase_order_list_v2 tbody').empty();  

            var rows = [];
            var table = $('#purchase_order_table_v2').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0,1,2, 4, 6, 7, 8], className: 'text-center' },
                        { targets: [3], className: 'text-left' },
                        { targets: [5], className: 'text-right' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            var approvalStatus = "";
            var po_item = "";
            var total = 0;
            var actions = ``;

            data.forEach(function(item, index) {   
                actions = ``;
                total = parseFloat(item.total_amount == null ? 0 : item.total_amount) + parseFloat(item.vat_amount == null ? 0 : item.vat_amount) + parseFloat(item.ait_amount == null ? 0 : item.ait_amount) + parseFloat(item.service_charge_amount == null ? 0 : item.service_charge_amount) - parseFloat(item.discount_amount == null ? 0 : item.discount_amount);
                po_item = `
                        <table width="100%">
                            <tr>
                                <td class="text-left" style="width:50%"><strong>Total
                                    </strong>
                                </td>
                                <td class="text-right" style="width:50%">
                                    ${item.currency_sign} ${numberFormat(item.total_amount/item.dollar_rate, 2, '.', ',')}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left" style="width:50%">
                                    <strong>VAT/Tax(${numberFormat(item.vat_percent, 2, '.', ',')}%)</strong>

                                </td>
                                <td class="text-right" style="width:50%">
                                    ${item.currency_sign} ${numberFormat(item.vat_amount/item.dollar_rate, 2, '.', ',')}
                                </td>
                            </tr>                           
                            <tr>
                                <td class="text-left" style="width:50%">
                                    <strong>AIT(${numberFormat(item.ait_percent == null ? 0 : item.ait_percent, 2, '.', ',')}%)</strong>

                                </td>
                                <td class="text-right" style="width:50%">
                                    ${item.currency_sign} ${numberFormat(item.ait_amount/item.dollar_rate, 2, '.', ',')}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left" style="width:50%">
                                    <strong>Service Charge(${numberFormat(item.service_charge_percent == null ? 0 : item.service_charge_percent, 2, '.', ',')}%)</strong>

                                </td>
                                <td class="text-right" style="width:50%">
                                    ${item.currency_sign} ${numberFormat(item.service_charge_amount/item.dollar_rate, 2, '.', ',')}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left" style="width:50%"><strong>Discount
                                     (${numberFormat(item.discount_percent, 2, '.', ',')}%)
                                    </strong></td>
                                <td class="text-right" style="width:50%">
                                    ${item.currency_sign} ${numberFormat(item.discount_amount/item.dollar_rate, 2, '.', ',')}
                                </td>
                            </tr>
                         
                            <tr>
                                <td class="text-left" style="width:50%">
                                    <strong>Payable</strong>
                                </td>
                                <td class="text-right" style="width:50%">${item.currency_sign} 
                                    ${numberFormat(total/item.dollar_rate, 2, '.', ',')}
                                </td>
                            </tr>
                        </table>
                        `;  

                var approvalLevelStatusText = item.approval_level_status_text;
                var levels = [];
                var approvalStatus = "";
                var approve_text = "";
                var approvalStatusText = "";
                var hospitalCode = "{{ session()->get('user.ses_hospital_code') }}";
                if (approvalLevelStatusText != null) {
                    levels = approvalLevelStatusText.split('/');
                    //console.log(approvalLevelStatusText,levels);
                     approvalStatus = levels[0] === levels[1] ? 'Approved' : 'Pending';
                    if(hospitalCode === 'UNICO') {
                        actions+=`<a target="_blank" href="{{ route('v2.purchase-order-print-with-md', '') }}/${item.purchaseorder_no_pk}" class="btn btn-sm btn-info ml-1" title="Print With Print"><i class="fas fa-print"></i> with md</a>`;
                    }
                }
                var editUrl = "{{ route('v2.purchase-order-edit', '') }}/" + item.purchaseorder_no_pk;
                console.log(levels.length,item.po_save_option);
               if (levels.length == 0 || item.po_save_option == 'DRAFT') {
                    actions += `<a href="${editUrl}" class="btn btn-sm btn-info" title="Edit" target="_blank"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>`;
                }
               @if(Session::get('user.ses_hospital_code') != 'KPJ')
                actions+=`<a target="_blank" href="{{ route('v2.purchase-order-print', '') }}/${item.purchaseorder_no_pk}/true"
                                class="btn btn-sm btn-info ml-1" title="Print with Header"><i class="fas fa-print"></i> with header</a>`;
               @endif
                            actions += `<a target="_blank" href="{{ route('v2.purchase-order-print', '') }}/${item.purchaseorder_no_pk}"
                                        class="btn btn-sm btn-info ml-1" title="Print"><i class="fas fa-print"></i></a>`;
                    
                if(item.pr_doc_attachment_path != null){
                    actions+=`<a href="{{asset('/images/uploads/attachment/${item.pr_doc_attachment_path}')}}" target="_blank" class="btn btn-sm btn-success ml-1" title="PR File"><i class="fas fa-file"></i></a>`;
                }
                 
                if(item.po_doc_attachment_path != null){
                    actions+=`<a href="{{asset('/images/uploads/attachment/${item.po_doc_attachment_path}')}}" target="_blank" class="btn btn-sm btn-success ml-1" title="PO File"><i class="fas fa-file"></i></a>`;
                }
                if ( item.approval_level_status_text !=null) {
                    var lavel = item.approval_level_status_text.split('/');
                    var approval_status = lavel[0] == lavel[1] ? 'Approved' : '';
                    var sendUrl =`{{route('v2.purchase-order-send-with-header')}}`;
                    if (approval_status == "Approved" && item.supp_email !="" && `Session::get('user.email_send_ind')==1`) {
                        var send_mail_color=item.email_ind == '1' ? 'btn-outline-success' : 'btn-outline-info';
                        actions+=`<button type="button" class="btn btn-sm ml-1 ${send_mail_color} mt-1 bg-none cursor-pointer" data-po_id="${item.purchaseorder_no_pk}" onclick="pathologyFunc.sendLabReportMail(this,'',${item.purchaseorder_no_pk},'${ sendUrl}' ,$('#search_po'))"><i class="fa fa-envelope"></i></button>`;     
                    }
                }

                if(parseInt(item.submit_ind) != 1 && item.po_save_option != 'POST'){
                    @if(Session::get('user.ses_hospital_code') != "KPJ")
                      actions+=`<button type="button" onclick="updateSubmit('${item.purchaseorder_no_pk}')" class="btn btn-success btn-sm ml-1 mt-1 ">Final Draft</button>`;   
                    @else
                      actions+=`<button type="button" onclick="updateSubmit('${item.purchaseorder_no_pk}')" class="btn btn-success btn-sm ml-1 mt-1 ">Issue</button>`;  
                    @endif
                     
                }
              

                approvalStatusText = item.approval_status_text;

                if(approvalStatusText != null){
                    if(approvalStatusText.indexOf('REJECTED') >= 0 || approvalStatusText.indexOf('HOLD') >= 0){
                        approve_text = `<a style="cursor:pointer" class="open-modal"
                            data-action="{{ route('v1.my.approval.level.detail-po','') }}/${item.purchaseorder_no_pk}"
                            data-id="${item.purchaseorder_no_pk}" data-modal="common-modal-sm"
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
                                        data-action="{{ route('v1.my.approval.level.detail-po', '') }}/${item.purchaseorder_no_pk}"
                                        data-id="${item.purchaseorder_no_pk}" data-modal="common-modal-sm"
                                        data-title="Level Detail" title="Level Detail">
                                        <span class="badge badge-success">(${item.approval_level_status_text})
                                        </span>
                                    </a>`;
                                }
                                else{
                                    approve_text = `<a style="cursor:pointer" class="open-modal"
                                        data-action="{{ route('v1.my.approval.level.detail-po', '') }}/${item.purchaseorder_no_pk}"
                                        data-id="${item.purchaseorder_no_pk}" data-modal="common-modal-sm"
                                        data-title="Level Detail" title="Level Detail">
                                        <span class="badge badge-warning">(${item.approval_level_status_text})</span>
                                    </a>`;
                                }    
                            }

                            approve_text+=`<span>${approval_status}</span>`;
                    }
                }

                var po_no_show = (hospitalCode != 'KPJ') ? item.purchaseorder_no_pk : item.purchase_uid;
                
                var rowData = [
                    ++index,
                    po_no_show,
                    item.purchase_date.substr(0,10),
                    item.supplier_name,
                    item.total_qty,
                    `<span class="primary" style="color:blue;cursor:pointer" onclick="showAmount('${po_no_show}','${item.currency_sign}','${item.total_amount/item.dollar_rate}','${item.vat_percent}','${item.vat_amount/item.dollar_rate}','${item.ait_percent}','${item.ait_amount/item.dollar_rate}','${item.service_charge_percent}','${item.service_charge_amount/item.dollar_rate}','${item.discount_percent}','${item.discount_amount/item.dollar_rate}','${total/item.dollar_rate}')" title="click to show amount details">${item.currency_sign} ${numberFormat(total/item.dollar_rate, 2, '.', ',')}</span>`,
                    item.po_save_option == "ISSUE" ? 'Post' : item.po_save_option,
                    approve_text,
                    actions,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
        }
        
        function emptyTable(){
            $('.purchase_order_list_v2 tbody').empty();
            $('.purchase_order_list_v2 tbody').append(`
                <tr>
                    <td colspan="9" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }

        function resetForm(){
            $("#supplier").val('').trigger('change');
        }


        function updateSubmit(po_id){
            console.log('test',po_id)
            if(confirm('Are you sure?')){
                $.ajax({
                        url:"{{route('v2.inventory.ready-to-post','')}}/"+`${po_id}`,
                        type:"get",
                        beforeSend: function() {
                            blockUI();
                        },
                        success:function(response){
                            searchPOWorklistForm();
                            $('.common-modal-notify').modal('show');
                            $('.common-modal-notify .modal-title').html('Success');
                            $('.common-modal-notify .modal-body').html(response.message);
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
                })
            }
        }

        <!-- Submit Form Data -->
        function exportExcel(search = null){
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            var status = $("#status").val();
            var supplier = $("#supplier").val();
            var po_no = $("#po_no").val();
            var main_store_id = $("#main_store_id").val();
            
            $.ajax({
                url: "{{route('v2.inventory.download-purchase-order')}}",
                method: 'post',
                data:{from_date:from_date, to_date:to_date, status:status, supplier:supplier, po_no:po_no, main_store_id:main_store_id},    
                xhrFields: {responseType: 'blob'},
                success: function(data) {
                    var downloadLink = document.createElement('a');
                    var url = window.URL.createObjectURL(new Blob([data]));
                    downloadLink.href = url;
                    downloadLink.setAttribute('download', 'purchase_order_worklist.xls');
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
