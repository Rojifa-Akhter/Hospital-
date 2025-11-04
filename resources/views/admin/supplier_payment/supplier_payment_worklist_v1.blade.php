<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">Supplier Payment</h5>
            <small>Supplier Payment / Supplier Payment Worklist</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="admitted-patient" role="tabpanel" aria-labelledby="admitted-patient-tab">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-row justify-content-center">
                                <div class="form-group col-md-4">
                                    <label class="col-form-label col-form-label-sm" for="date_from">Bill Send Date <span class="text-danger">*</span></label>
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
                                    <label class="col-form-label col-form-label-sm" for="grn_no">GRN No</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="grn_no" name="grn_no" value="" placeholder="grn no" autocomplete="off" oninput="grnSearch()">
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="supplier">Supplier</label>
                                    <select class="form-control form-control-sm m-0 select2" id="supplier" name="supplier">
                                        <option value="">select</option>
                                        @if(!empty($supplier_list))
                                            @foreach($supplier_list as $value)
                                        <option value="{{$value->supplier_no_pk}}">{{$value->supplier_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="payment_status">Payment Status</label>
                                    <select class="form-control form-control-sm m-0" id="payment_status" name="payment_status">
                                        <option value="">All</option>
                                        <option value="1" selected>Pending</option>
                                        <option value="2">Partial Paid</option>
                                        <option value="3">Paid</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <div class="btn-group btn-block mt-4" role="group">
                                        <button type="button" class="btn btn-md btn-success btn-md-global" id="search_approval_from_account" data-action="" onclick="getSupplierPaymentList()">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <form action="{{route('supplier-payment-accounts-save')}}" method="post" id="payAll">
            @csrf
            <div class="form-row">

                <div class="col-md-12 mt-2">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="admitted-patient" role="tabpanel" aria-labelledby="admitted-patient-tab">
                            <div class="card">
                                <div class="card-body">

                                    <div class="form-row justify-content-end">

                                        <div class="form-group col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="general_ledger">General Ledger</label>
                                           
                                             <select class="form-control form-control-sm select2" id="general_ledger" name="general_ledger">
                                                <option value="">--Select--</option>
                                                @foreach($chartof_accounts as $account)
                                                    <option value="{{ $account->account_no_pk }}">{{ $account->account_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="payment_type">Payment Type</label>
                                            <select class="form-control form-control-sm select2" id="payment_type" name="payment_type">
                                                <option value="">--Select--</option>
                                                @foreach($voucher_type as $account)
                                                    <option value="{{ $account->voucher_type_name }}">{{ $account->voucher_type_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label class="col-form-label col-form-label-sm" for="supplier">Check No</label>
                                            <select class="form-control form-control-sm select2" id="cheque_no" name="cheque_no">
                                                <option value="">-Select-</option>
                                                @foreach($verifiedChequeNos as $account)
                                                    <option value="{{ $account->checque_no }}">{{ $account->checque_no }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="col-form-label col-form-label-sm" for="date_from">Cheque Date <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm m-0 date-picker" id="cheque_date" name="cheque_date" value="" placeholder="dd-mm-yyyy" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-2">

                                            <div class="btn-group btn-block mt-4" role="group">
                                                <button type="button" class="btn btn-md btn-primary w-25" onclick="PayAll()">Pay</button>
                                            </div>
                                        </div>

                                        {{-- <div class="col-md-2">
                                            <div class="btn-group btn-block mt-4" role="group">
                                                <button type="button" class="btn btn-md btn-success btn-md-global" id="search_approval_from_account" data-action="" onclick="getSupplierPaymentList()">
                                                    Search
                                                </button>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            {{-- <div class="row justify-content-end">
                <div class="col-4 text-center mt-2">
                    <button type="button" class="btn btn-md btn-primary w-25" onclick="PayAll()">Pay</button>
                </div>
            </div> --}}
            <div class="card-body table-responsive">
                <table width="100%" class="table table-striped table-bordered table-hover supplier_payment_worklist" id="supplier_payment_worklist" border="1">
                    <thead class="global-uhl-table-bg">
                        <tr class="global-uhl-table-bg">
                            <th class="text-center" style="width:2%;">Sl.</th>
                            <th class="text-center" style="width:5%;">Date</th>
                            <th class="text-center" style="width:5%;">GRN No</th>
                            <th class="text-center" style="width:5%;">PO No</th>
                            <th class="text-center" style="width:5%;">Challan No</th>
                            <th style="width:10%;">Store</th>
                            <th style="width:10%;">Supplier</th>
                            <th class="text-right" style="width:5%;">Receive Amt</th>
                            <th class="text-right" style="width:5%;">Return Amt</th>
                            <th class="text-right" style="width:7%;">Current Amt</th>
                            <th class="text-right" style="width:7%;">Paid Amt</th>
                            <th class="text-right" style="width:5%;">Paid Amt VAT</th>
                            <th class="text-right" style="width:5%;">Paid Amt Tax</th>
                            <th class="text-right" style="width:5%;">VAT</th>
                            <th class="text-right" style="width:5%;">TAX</th>
                            <th class="text-right" style="width:3%;">
                                <div style="display: flex;justify-content:center">
                                    <div class="mt-1"> <input type="checkbox" name="checked_all" id="checked_all" value="1" class="form-control form-control-sm" onclick="checkedAll()"/></div>
                                    <div><label class="form-check-label" for="checked_all">&nbsp;All</label></div>
                                </div>
                            </th>
                            <th class="text-center" style="width:7%;">Pay Amount</th>
                            <th class="text-center" style="width:5%;">Payment Status</th>
                            <th class="text-center" style="width:10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="19" class="text-center">Data Fetching ...</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </form>
    </div>

</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");

    $(document).ready(function(){
        $('.select2').select2();

        var currentDate = new Date();
        $("#date_to").datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            clearBtn: true,
            autoclose: true
        }).datepicker('setDate', currentDate);



        currentDate.setDate(currentDate.getDate() - 30);
        $("#date_from").datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            clearBtn: true,
            autoclose: true
        }).datepicker('setDate', currentDate);

        var currentDate = new Date();
        $("#cheque_date").datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            clearBtn: true,
            autoclose: true
        }).datepicker('setDate', currentDate);

        getSupplierPaymentList(true);
    })
    
    function getSupplierPaymentList(ind = null){
            var grn_no = $('#grn_no').val();
            var status = $('#status').val();
            var supplier = $('#supplier').val();
            var requisition_no = $('#requisition_no').val();
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            var payment_status = $('#payment_status').val();

            $.ajax({
                url:"{{route('supplier-payment-worklist-search')}}",
                type:"post",
                data: {
                        grn_no: grn_no,
                        status: status,
                        requisition_no: requisition_no,
                        date_from: date_from,
                        date_to: date_to,
                        supplier: supplier,
                        payment_status: payment_status,
                    },
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
        if($.fn.DataTable.isDataTable('.supplier_payment_worklist')) {$('.supplier_payment_worklist').DataTable().destroy();}  
            $('.supplier_payment_worklist tbody').empty();
            var rows = [];
            var table = $('.supplier_payment_worklist').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 1, 2, 3, 4, 11, 12, 13,14], className: 'text-center' },
                        { targets: [5, 6], className: 'text-left' },
                        { targets: [7, 8, 9, 10], className: 'text-right' },
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

            var checkbox = ``;
            var amount_input = ``;
            data.forEach(function(item, index) {

                var bill_payment = parseFloat(item.payable_amnt) - (parseFloat(item.paid_amount)+parseFloat(item.tax_amount)+parseFloat(item.vat_amount));

                // if(bill_payment != 0){
                        var date = new Date(item.bill_date);
                        var day = date.getDate();
                        var month = date.getMonth() + 1; 
                        var year = date.getFullYear();
                        var bill_date = padZero(day) + "/" + padZero(month) + "/" + year;

                            date = new Date(item.au_entry_at);
                            day = date.getDate();
                            month = date.getMonth() + 1; 
                            year = date.getFullYear();
                        var bill_send_date = padZero(day) + "/" + padZero(month) + "/" + year;


                            edit_link = ``;
                            paid_amount = 0;
                            paid_status = '';
                            paid_amount = item.paid_amount == null ? 0 : item.paid_amount;

                            
                            if(Number(bill_payment) == 0){
                                paid_status = `<span class="badge badge-success">Paid</span>`;
                            }
                            else if(parseFloat(paid_amount) == parseFloat(item.payable_amnt)){
                                paid_status = `<span class="badge badge-success">Paid</span>`;
                                edit_link+=`<span class="btn btn-sm btn-secondary ml-2  open-modal btnView" data-action="{{route('partial-supplier-payment-history','')}}/${item.itemreceive_no_fk}" data-modal="common-modal-md" data-title="Payment history" title="Payment History" data-id="${item.itemreceive_no_fk}">Pay History</span>`;
                            }
                            else if(parseFloat(paid_amount) == 0 && parseFloat(item.payable_amnt) > 0){
                                paid_status = `<span class="badge badge-warning">Pending</span>`;
                                edit_link+=`<span class="btn btn-sm btn-info ml-2  open-modal btnView" data-action="{{route('partial-supplier-payment','')}}/${item.itemreceive_no_fk}" data-modal="common-modal-sm" data-title="Payment" title="Payment" data-id="${item.itemreceive_no_fk}">Pay</span>`;
                            }
                            else if(parseFloat(paid_amount) < parseFloat(item.payable_amnt)){
                                paid_status = `<span class="badge badge-primary">Partial Paid</span>`;
                                edit_link+=`<span class="btn btn-sm btn-info ml-2  open-modal btnView" data-action="{{route('partial-supplier-payment','')}}/${item.itemreceive_no_fk}" data-modal="common-modal-sm" data-title="Payment" title="Payment" data-id="${item.itemreceive_no_fk}">Pay</span>`;
                                edit_link+=`<span class="btn btn-sm btn-secondary ml-2  open-modal btnView" data-action="{{route('partial-supplier-payment-history','')}}/${item.itemreceive_no_fk}" data-modal="common-modal-md" data-title="Payment history" title="Payment History" data-id="${item.itemreceive_no_fk}">Pay History</span>`;
                            }
                            else{
                                paid_status = `<span class="badge badge-warning">Pending</span>`;
                                edit_link+=`<span class="btn btn-sm btn-info ml-2  open-modal btnView" data-action="{{route('partial-supplier-payment','')}}/${item.itemreceive_no_fk}" data-modal="common-modal-sm" data-title="Payment" title="Payment" data-id="${item.itemreceive_no_fk}">Pay</span>`;
                            }



                            edit_link+=` <span class="btn btn-sm btn-success open-modal btnView" data-action="{{route('show-grn-bill-progress','')}}/${item.itemreceive_no_fk}" data-modal="common-modal-sm" data-title="Show GRN Bill Status" title="Show GRN Bill Status" data-id="${item.itemreceive_no_fk}"><i class="fas fa-eye"></i></span>`;
                            

                            checkbox = `<input type="checkbox" name="is_checked[]" id="is_checked_${item.itemreceive_no_fk}" value="1"  class="form-control form-control-sm all " onclick="checkedField('is_checked_${item.itemreceive_no_fk}', 'amount_${item.itemreceive_no_fk}')"/>`;
                            amount_input = `<input type="number" name="amount[]" id="amount_${item.itemreceive_no_fk}" max="${bill_payment}" min="0" style="text-align:right" value="0" class="form-control form-control-sm input_checked" readonly oninput="valueCheck('amount_${item.itemreceive_no_fk}','${bill_payment}')"/>`;
                            amount_input_tax = `<input type="number" name="amount_tax[]" id="amount_tax_${item.itemreceive_no_fk}" max="${bill_payment}" min="0" style="text-align:right" value="0" class="form-control form-control-sm input_checked" oninput="valueCheck('amount_${item.itemreceive_no_fk}','${bill_payment}')"/>`;
                            amount_input_vat = `<input type="number" name="amount_vat[]" id="amount_vat_${item.itemreceive_no_fk}" max="${bill_payment}" min="0" style="text-align:right" value="0" class="form-control form-control-sm input_checked"  oninput="valueCheck('amount_${item.itemreceive_no_fk}','${bill_payment}')"/>`;
                            

                            if(bill_payment == 0){
                                checkbox = ``;
                                amount_input = ``;
                            }
                            
                            
                            var rowData = [
                                ++index,
                                bill_send_date,
                                `${item.itemreceive_no_fk}<input type="hidden" name="grn_no[]" value="${item.itemreceive_no_fk}" />`,
                                item.purchaseorder_no_fk,
                                item.challan_no,
                                item.serviceunit_name,
                                item.supplier_name,
                                numberFormat(item.grnmst_amnt, 2, '.', ','),
                                numberFormat(item.grnrtn_amt, 2, '.', ','),
                                numberFormat(bill_payment, 2, '.', ','),
                                numberFormat(item.paid_amount, 2, '.', ','),
                                numberFormat(item.vat_amount, 2, '.', ','),
                                numberFormat(item.tax_amount, 2, '.', ','),
                                amount_input_vat,
                                amount_input_tax,
                                checkbox,
                                amount_input,
                                paid_status,
                                edit_link
                            ];
                            rows.push(rowData);

                // }
                
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        
    }

    function emptyTableData(){
        $('.supplier_payment_worklist tbody').html(`
                <tr>
                    <td colspan="19" class="text-center">Data Not Found</td>
                </tr>`
            );
    }

    function padZero(number) {
        return number < 10 ? "0" + number : number;
    }
    
    function checkedField(id, input_id){
        if($("#" + id).is(":checked")){
            $("#" + input_id).prop('readonly', false);
        }else{
            $("#" + input_id).prop('readonly', true);
        }
    }

    function valueCheck(id, val){
        var current_val = $("#" + id).val();
        let new_id = id.replace("amount_", "");
        console.log(new_id);

        var taxInput = $("#amount_tax_" + new_id);
        var vatInput = $("#amount_vat_" + new_id);

        var taxVal = parseFloat(taxInput.val()) || 0;
        var vatVal = parseFloat(vatInput.val()) || 0;

         console.log(taxVal);

        var total = taxVal + vatVal;

        console.log(total);

        if(parseFloat(current_val) > (parseFloat(val)-total)){
            alert('Maximum available amount is '+ (val-total));
             $("#" + id).val(val - total);
            return false;
        }
    }

    function checkedAll(){
        if($("#checked_all").is(":checked")){
            $(".all").prop('checked', true);
            $(".input_checked").attr('readonly', false);
        }
        else{
            $(".all").prop('checked', false);
            $(".input_checked").attr('readonly', true);
        }
    }

    function grnSearch(){
        if($("#grn_no").val() != ""){
            $("#date_to").val('');
            $("#date_from").val('');
        }
    }



    function PayAll(){
        let formElement = document.querySelector('#payAll');
        let formData = new FormData(formElement);
        let hasError = false;
        let checked = '';

        $('input[name="amount[]"]').each(function(index) {                    
            checked = $('input[name="is_checked[]"]').eq(index).attr('id');
            if($("#" + checked).is(':checked')){
                if($(this).val() == null || $(this).val() == 0) {
                    alert('Amount Required!');
                    hasError = true;
                    return false;
                }
            }
        })


        if(hasError == true){
            alert('Amount Required!');
            return false;
        }


        $.ajax({
                url:"{{route('partial-supplier-payment-all')}}",
                type:"post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI();
                },
                success:function(data){  
                    $.unblockUI();
                    getSupplierPaymentList(null);
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.message);   
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
</script>