<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{asset('datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>

.sticky_foot{
    position: sticky;
    bottom: 0;
    background: #3C4168 !important;
    position: -webkit-sticky;
    z-index: 4;
    width: 100%;
    color: white;
   
  
}
</style>
@php
$disposalMst_no=!empty($disposalMst->disposalmst_no_pk) ? $disposalMst->disposalmst_no_pk :'';
$store_no=!empty($disposalMst->su_no_pk) ? $disposalMst->su_no_pk :'';
$supplier_no=!empty($disposalMst->supplier_pk_no) ? $disposalMst->supplier_pk_no :'';
$disposal_date=!empty($disposalMst->disposalmst_date) ? date('d-m-Y',strtotime($disposalMst->disposalmst_date)) :date('d-m-Y');
$disable=!empty($disposalMst->post_ind) ? 'disabled="disabled"' :''; 
 @endphp
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Expired Medicine Disposal</h5>
            <small>Store / Expired Medicine Disposal</small>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Expired Medicine Disposal</h5>

                </div>
                <div class="card-body">
                    <form id="search_stock_ledger" action="#"
                        method="post">
                        @csrf
                        <input type="hidden" name="disposalMst_no" value="{{$disposalMst_no}}">
                        <div class="row">

                            <input type="hidden" name="print_type" id="print_type" value="">
                           

                            <div class="col-md-12">
                                <div class="form-row justify-content-center py-2">
                                <div class="col-md-2">
                                        <div class="form-group">
                                           
                                            <label class="col-form-label col-form-label-sm" for="select_store">Select
                                                Store <span class="text-danger">*</span></label>
                                            <select class="form-control form-control-sm search-param" id="store_id" name="store_id" required>
                                                <option value="">Select Store</option>
                                                @if (!empty($stores))

                                                    @foreach ($stores as $store)
                                                        <option value="{{ $store->serviceunit_no_pk }}" @if($store_no == $store->serviceunit_no_pk ) selected @endif>
                                                            {{ $store->serviceunit_name }}</option>
                                                    @endforeach

                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="suppler_id">Select
                                                Supplier <span class="text-danger">*</span></label>
                                            <select class="form-control form-control-sm search-param" id="suppler_id" name="suppler_id" required>
                                                <option value="">Select Supplier</option>
                                                @if (!empty($allSuppliers))

                                                    @foreach ($allSuppliers as $value)
                                                        <option value="{{ $value->supplier_no_pk }}"  @if($supplier_no == $value->supplier_no_pk ) selected @endif>
                                                            {{ $value->supplier_name }}</option>
                                                    @endforeach

                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="disposalmst_date">Disposal Date</label>
                                                <input type="text" class="form-control form-control-sm m-0 date_picker" id="disposalmst_date"
                                                name="disposalmst_date" value="{{$disposal_date}}" placeholder="DD-MM-YYYY" >
                                        </div>
                                    </div>


                                  
                                </div>
                            </div>
                            <div class="col-md-12">

                            <table>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Uom</th>                                    
                                    <th>Expired Quantity</th>
                                    <th>P. Rate</th>
                                    <th>Amount</th>
                                    <th>Batch No</th>
                                    <th>Expired Date</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="hidden" id="item_id_hidden" name="item_id">
                                            <input type="text" class="form-control form-control-sm m-0" id="item_name" name="" value="" onkeyup="removeName(this)" placeholder="Item Name">
                                    </td>
                                    <td>
                                         <input type="hidden" id="hdn_uom" name="" value="">
                                            <input type="text" class="form-control form-control-sm m-0" id="uom"
                                                name="" value="" readonly>
                                    </td>
                                    <td>
                                         <input type="text" class="form-control form-control-sm m-0 number_only" id="expired_qty" name="" value="" onkeyup="amountCal(this)">
                                    </td>
                                    <td>
                                            <input type="text" class="form-control form-control-sm m-0 " id="p_rate" name=""  value="" onkeyup="priceEdit(this)">
                                    </td>
                                   
                                    <td>
                                            <input type="text" class="form-control form-control-sm m-0 " id="amount" name="" value="" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm m-0" id="batch_no"
                                                name="" value="" >
                                    </td>
                                    <td>
                                         <input type="text" class="form-control form-control-sm m-0 date_picker" id="expire_date"
                                                name="" value="" placeholder="DD-MM-YYYY" >
                                    </td>
                                    <td>
                                    <button type="button" class="btn btn-info btn-md " id="item_add" onclick="addItem(this)">Add</button>
                                    </td>
                                </tr>
                            </table>

                            </div>
                            <div class="col-md-12" id="stock_list">
                      
                                <table class="table data-table table-bordered m-0 data-table"  width="100%" >
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center " scope="col">SL</th>
                                            <th class="text-left " scope="col">Item Name</th>
                                            <th class="text-left " scope="col">UoM</th>
                                            <th class="text-left " scope="col">Batch No.</th>
                                            <th class="text-left " scope="col">Expired Date</th>
                                            <th class="text-right " scope="col">Purchase Price</th>
                                            <th class="text-center " scope="col">Expired Qty.</th>
                                            <th class="text-right " scope="col">Amount</th>
                                            <th class="text-center " scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        @if (!empty($disposaldtl))
                                            @foreach ($disposaldtl as $value)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                    <input type="hidden" name="disposalDtl[]" id="disposalDtl" value="{{ $value->disposaldtl_no_pk }}">
                                                </td>
                                                <td>
                                                    <input type="hidden" class="item_id_hidden" id="item_id_hidden" name="item_id[]" value="{{ $value->item_no_fk }}"><input type="text" class="form-control form-control-sm m-0" id="item_name" name="item_name[]" value="{{ $value->item_name }}" onkeyup="removeName(this)" placeholder="Item Name" readonly>
                                                </td>
                                                <td>
                                                    <input type="hidden" id="hdn_uom" name="hdn_uom[]" value="{{ $value->uom_no_fk }}"><input type="text" class="form-control form-control-sm m-0" id="uom" name="uom[]" value="{{ $value->uom_name }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm m-0" id="batch_no" name="batch_no[]" value="{{$value->batch_no}}" readonly >
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm m-0 date_picker" id="expire_date" name="expire_date[]" value="{{$value->expire_date !='' ? date('d-m-Y', strtotime($value->disposaldtl_date)) :''}}" placeholder="DD-MM-YYYY" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm m-0 text-right" id="p_rate" name="p_rate[]"  value="{{ $value->rate }}" onkeyup='priceEdit(this)'>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm m-0 number_only text-center" id="expired_qty" name="expired_qty[]" value="{{ $value->qty }}" placeholder="" onkeyup='amountCal(this)' >
                                                </td>
                                                <td>
                                                        <input type="text" class="form-control form-control-sm m-0 text-right" id="amount" name="amount[]" value="{{ $value->amt }}" readonly>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-md " id="item_add" onclick="removeRow(this)"><i class="oi oi-circle-x"></i></button>
                                                </td>
                                            </tr>                                              
                                            @endforeach
                                      
                                        @endif
                                    </tbody>                              
                                <tfoot class="sticky_foot">                               
                                    <tr>                                      
                                        <td class="text-right " colspan="5"> <strong> Total = </strong> </td>
                                        <td class="text-right " id="total_price"></td>
                                        <td class="text-center " id="total_qty"></td>
                                        <td class="text-right " id="total_amt" ></td>
                                        <td></td>
                                    </tr>
                              
                                </tfoot>
                            </table> 
                                
                                <div>
                                    @php
                                    $response_action=route('pharmacy.expired_medicine_disposal');

                                    @endphp
                                <button type="button" class="btn btn-md btn-warning" id="DRAFT"  onclick="save(this)" {{$disable}}>Draft</button>
                                <button type="button" class="btn btn-md btn-success" id="POST"  onclick="save(this)" {{$disable}}>Post</button>
                                </div>
                                                             
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>


<script>


    $(document).ready(function() {
        // var table = $('.data-table').DataTable({
        //     "ordering": false,
        //     // "bPaginate": true,
        //     " paging": false,
        //     " searching": false,
        //     "bAutoWidth": false
        // });

        $('.date_picker').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			clearBtn: true,

		});

        openReceiveItemAutocomplete('#item_name','', 'item_name', function(item, obj) {
            console.log(item)
            var this_item='#item_name';

            $(this_item).parents('td').parents('tr').find('#item_id_hidden').val(item.item_id);
            $(this_item).parents('td').parents('tr').find('#hdn_uom').val(item.uom_no_fk);
            $(this_item).parents('td').parents('tr').find('#uom').val(item.uom_name);
            $(this_item).parents('td').parents('tr').find('#p_rate').val(item.purchase_price);

            obj.stopImmediatePropagation();
        });      

    })

    function removeName(element) {
            console.log($(element).val()+'_bellal');
            if($(element).val() =='') {               
                $(element).parents('td').parents('tr').find('input').val('');
            }
        }
    function amountCal(element) {
        var price= $(element).parents('td').parents('tr').find('#p_rate').val();
        var qty= $(element).val();
            if(price !=null && qty !="") {
                 $(element).parents('td').parents('tr').find('#amount').val(price * qty);
            }else{
                $(element).parents('td').parents('tr').find('#amount').val(0);
            }
            total_calculation();
        }

    function addItem(element) {      

        var item_name = $('#item_name').val();
        var uom = $('#uom').val();
        var p_rate = $('#p_rate').val();
        var expired_qty = $('#expired_qty').val();
        var amount = $('#amount').val();
        var batch_no = $('#batch_no').val();
        var expire_date = $('#expire_date').val();

        if (item_name =="") {
            alert('Enter Item Name');
            return;
        }else if(uom ==""){
            alert('Enter Item Uom');
            return;
        }else if(p_rate ==""){
            alert('Enter Item Price');
            return;
        }else if(expired_qty ==""){
            alert('Enter Item Qty');
            return;
        }else if(amount ==""){
            alert('Enter Item Amount');
            return;
        }else if(batch_no ==""){
            alert('Enter Item Batch');
            return;
        }else if(expire_date ==""){
            alert('Enter Item Expite Date');
            return;
        }
      
        var item_id =  $(element).parents('td').parents('tr').find('#item_id_hidden').val();
        var item_name =  $(element).parents('td').parents('tr').find('#item_name').val();
        var hdn_uom =  $(element).parents('td').parents('tr').find('#hdn_uom').val();
        var uom =  $(element).parents('td').parents('tr').find('#uom').val();
        var expired_qty =  $(element).parents('td').parents('tr').find('#expired_qty').val();
        var batch_no =  $(element).parents('td').parents('tr').find('#batch_no').val();
        var expire_date =  $(element).parents('td').parents('tr').find('#expire_date').val();
        var p_rate =  $(element).parents('td').parents('tr').find('#p_rate').val();
        var amount =  $(element).parents('td').parents('tr').find('#amount').val();
        var sl=$('#myTable tr').length;
        console.log(item_id,item_name, hdn_uom ,  uom ,expired_qty , batch_no , expire_date );
        if (sl == 0) {
            $('#myTable').after(`<tr><td>${sl++} <input type="hidden" name="disposalDtl[]" id="disposalDtl" value=""></td><td><input type="hidden" class="item_id_hidden" id="item_id_hidden" name="item_id[]" value="${item_id}"><input type="text" class="form-control form-control-sm m-0" id="item_name" name="item_name[]" value="${item_name}" onkeyup="removeName(this)" placeholder="Item Name" readonly></td><td><input type="hidden" id="hdn_uom" name="hdn_uom[]" value="${hdn_uom}"><input type="text" class="form-control form-control-sm m-0" id="uom" name="uom[]" value="${uom}" readonly></td><td><input type="text" class="form-control form-control-sm m-0" id="batch_no" name="batch_no[]" value="${batch_no}" readonly ></td><td><input type="text" class="form-control form-control-sm m-0 date_picker" id="expire_date" name="expire_date[]" value="${expire_date}" placeholder="DD-MM-YYYY" readonly></td><td><input type="text" class="form-control form-control-sm m-0 text-right" id="p_rate" name="p_rate[]"  value="${p_rate}" onkeyup="priceEdit(this)"></td><td><input type="text" class="form-control form-control-sm m-0 number_only text-center" id="expired_qty" name="expired_qty[]" value="${expired_qty}" placeholder="" onkeyup="amountCal(this)"></td><td><input type="text" class="form-control form-control-sm m-0 text-right" id="amount" name="amount[]" value="${amount}" readonly></td><td><button type="button" class="btn btn-danger btn-md " id="item_add" onclick="removeRow(this)"><i class="oi oi-circle-x"></i></button></td></tr>`);
        }else{
            $('#myTable tr:last').after(`<tr><td>${sl++} <input type="hidden" name="disposalDtl[]" id="disposalDtl" value=""></td><td><input type="hidden" class="item_id_hidden" id="item_id_hidden" name="item_id[]" value="${item_id}"><input type="text" class="form-control form-control-sm m-0" id="item_name" name="item_name[]" value="${item_name}" onkeyup="removeName(this)" placeholder="Item Name" readonly></td><td><input type="hidden" id="hdn_uom" name="hdn_uom[]" value="${hdn_uom}"><input type="text" class="form-control form-control-sm m-0" id="uom" name="uom[]" value="${uom}" readonly></td><td><input type="text" class="form-control form-control-sm m-0" id="batch_no" name="batch_no[]" value="${batch_no}" readonly ></td><td><input type="text" class="form-control form-control-sm m-0 date_picker" id="expire_date" name="expire_date[]" value="${expire_date}" placeholder="DD-MM-YYYY" readonly></td><td><input type="text" class="form-control form-control-sm m-0 text-right" id="p_rate" name="p_rate[]"  value="${p_rate}" onkeyup="priceEdit(this)"></td><td><input type="text" class="form-control form-control-sm m-0 number_only text-center" id="expired_qty" name="expired_qty[]" value="${expired_qty}" placeholder="" onkeyup="amountCal(this)"></td><td><input type="text" class="form-control form-control-sm m-0 text-right" id="amount" name="amount[]" value="${amount}" readonly></td><td><button type="button" class="btn btn-danger btn-md " id="item_add" onclick="removeRow(this)"><i class="oi oi-circle-x"></i></button></td></tr>`);
        }
       

        $(element).parents('td').parents('tr').find('input').val('');
        $(element).parents('td').parents('tr').find('#item_name').focus();
        total_calculation();
    }

     function removeRow(element) {
        if (confirm('Are You Sure ?')) {
            $(element).parents('td').parents('tr').remove();
            total_calculation();
        }
     }

     function save(thisElement) {
        event.preventDefault();
        var formID = $(thisElement).parents("form").attr("id");
        if ($(thisElement).attr('id')=='DRAFT') {
            var url_inof= "{{route('pharmacy.expired_medicine_disposal_store','DRAFT')}}" ;
        }else{
            var url_inof= "{{route('pharmacy.expired_medicine_disposal_store','POST')}}" ;
        }
       console.log(url_inof)       
        var formMethod = $(thisElement).parents("form").attr("method");
        var response_action="{{route('pharmacy.expired_medicine_disposal')}}";
       var customFunc='';
        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {

            $.ajax({
                async: true,
                data: $('#' + formID).serialize(),
                url: url_inof,
                type: formMethod,
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                      
                    var url = "{{route('pharmacy.expired_medicine_disposal_report_print',':id')}}";
                    url = url.replace(":id", data.disposal_id);
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg +
                        `<br>  <a href='${url}'  class='btn btn-primary btn-md cursor-pointer text-center' target='_blank' data-id='${url}' id='grn_report' title='Print Disposal Report'>Disposal Report</a>`
                    );

                    $("#" + formID).find("input, textarea").not('.keep_me').val("");                
                    dynamicFunc.afterSaveLoadPage(response_action);
                },
                complete: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $.unblockUI();
                }
            });
        }
        event.stopImmediatePropagation();
    }

function priceEdit(element) {
    var price=$(element).val() !='' ? $(element).val() :0;
    var qty =$(element).parents('td').parents('tr').find('#expired_qty').val() !="" ? $(element).parents('td').parents('tr').find('#expired_qty').val() : 0;
    var amount =qty * price;
    $(element).parents('td').parents('tr').find('#amount').val(amount);
    console.log(price,qty,amount);
    total_calculation();
}

$(document).ready(function() {
    total_calculation();
})
function total_calculation() {
    var qty = 0;
    var p_rate =0;
    var amount = 0;
  
    $(".item_id_hidden").each(function(){
         qty +=  parseFloat($(this).parents('td').parents('tr').find('#expired_qty').val());
         p_rate +=  parseFloat($(this).parents('td').parents('tr').find('#p_rate').val());
         amount +=  parseFloat($(this).parents('td').parents('tr').find('#amount').val());
        console.log($(this).val(),qty);
  });
  $('#total_price').html((p_rate.toFixed(2)));
  $('#total_qty').html(qty);
  $('#total_amt').html(amount);
}


</script>
