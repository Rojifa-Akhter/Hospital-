<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

    <form action="{{ route('v1-department-consumption.store') }}" method="POST" id="v1-department-consumption">
        @csrf
        <section class="paitent__registration_details">
            <div class="container-fluid">
              <table class="table table-bordered table-hover table-striped">
                <thead class="global-uhl-table-bg">
                    <th colspan="3" class="text-left">Item Name : {{isset(($item_info) ) && !empty($item_info) ? $item_info->item_name :'' }}</th>                   
                    <th class="text-left">Stock Qty : {{!empty($main_stock) ? $main_stock : 0}} , Indent Qty : {{!empty($indent_qty) ? ($indent_qty -$issue_qty): 0}}</th>
                    <th>Req. Qty </th>
                    <th><input  style="width: 100px;" type="text" class="number_only text-right form-control request_qty" autocomplete="off" id="request_qty" placeholder="Enter qty" onkeyup="distributeQty(this)"></th>
                </thead>

                <tbody>
                    <tr>
                        <th>SL#</th>
                        <th class="text-left">Internal Batch</th>
                        <th class="text-left">External Batch</th>
                        <th class="text-left">Exp. Date</th>
                        <th class="text-right" style="width: 100px;">Qty</th>
                        <th class="text-right" style="width: 100px;">Req. Qty</th>
                    </tr>  
                               
                @if(!empty($all_batch))
              
               
                    @foreach($all_batch as $value)
                   
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                            {{$value->internal_batch_no_uq}}
                            <input type="hidden" class="internal_batch_no " id="internal_batch_no" name="internal_batch_no" value=" {{$value->internal_batch_no_uq}}">
                            <input type="hidden" id="cost_price" class="cost_price" value="{{!empty($value->cost_price) ? $value->cost_price : ''}}" >
                            
                            <input type="hidden" id="purchaseorderdtl_no_pk" class="purchaseorderdtl_no_pk" value="{{!empty($value->purchaseorderdtl_no_pk) ? $value->purchaseorderdtl_no_pk : ''}}" >
                          
                            <input type="hidden" id="invoicedtl_no_pk" class="invoicedtl_no_pk" value="{{!empty($value->invoicedtl_no_pk) ? $value->invoicedtl_no_pk : ''}}" >
                            <input type="hidden" id="itemreceivedtl_no_pk" class="itemreceivedtl_no_pk" value="{{!empty($value->itemreceivedtl_no_pk) ? $value->itemreceivedtl_no_pk : ''}}" >
                            <input type="hidden" id="purchase_price" class="purchase_price" value="{{!empty($value->purchase_price) ? $value->purchase_price : ''}}" >
                        </td>
                        <td>
                            {{$value->batch_no}}
                            <input type="hidden" class="external_batch_no" id="external_batch_no" name="external_batch_no" value=" {{$value->batch_no}}">
                        </td>
                        <td>
                            {{$value->expiry_date !="" ? date('d/m/Y',strtotime($value->expiry_date)) : ""}}
                            <input type="hidden" class="exp_date" id="exp_date" name="exp_date" value="  {{$value->expiry_date !='' ? date('Y-m-d',strtotime($value->expiry_date)) : ''}}">
                        </td>
                        <td class="text-right batch_qty" style="width: 100px;" id="batch_qty">{{$value->item_qty}}</td>
                        <td class="text-right req_qty_set" style="width: 100px;"><input type="text" class="req_aty form-control" style="width: 100px; text-align:right" id="req_aty" readonly value="0"></td>
                    </tr>
                    
                 
                    @endforeach
                @endif  
                </tbody>
                <tfoot>
                    <td colspan="6" class="text-right"> <button type="button" class="btn btn-md btn-success p-5" data-dismiss="modal" onclick="set_batch(this)">Set</button> </td>
                </tfoot>
              </table>
              <input type="hidden" id="total_batch_qty" value="{{!empty($main_stock) ? $main_stock : 0}}" >
              <input type="hidden" id="indent_qty" value="{{!empty($indent_qty) ? ($indent_qty - $issue_qty) : 0}}" >
              <input type="hidden" id="item_on_fk" value="{{!empty($item_id) ? $item_id : ''}}" >
              <input type="hidden" id="inv_requisitiondtl_no_pk" class="inv_requisitiondtl_no_pk" value="{{!empty($req_dtl) ? $req_dtl : ''}}" >
           
              <input type="hidden" id="item_uom" value="{{!empty($item_uom) ? $item_uom : ''}}" >
              <!-- <input type="hidden" id="req_dtl" value="{{!empty($req_dtl) ? $req_dtl : ''}}" > -->
             
            </div>
        </section>
    </form>


</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>


function distributeQty(element) {
 
    var req_qty=$(element).val() !="" ?parseFloat( $(element).val()) :0;
    var total_batch_qty= parseFloat($('#total_batch_qty').val());
    var indent_qty= parseFloat($('#indent_qty').val());
   
    if (req_qty > total_batch_qty || req_qty > indent_qty) {
        alert('Enter Qty Invalid');
        $(element).val('');
        distributeQty(element)
        return false;
    }
    console.log( req_qty , total_batch_qty );
   $('.batch_qty').each(function(){
     req_qty=req_qty;
    var batch_qty=parseFloat($(this).html());
  
    if (req_qty <= batch_qty) {
     
        $(this).parent('tr').find('#req_aty').val(req_qty);
        $(this).parent('tr').nextAll().find('.req_aty').val(0);
    
      return false;
    }else if (req_qty > batch_qty) {
        var setQty=req_qty - batch_qty;
        $(this).parent('tr').find('#req_aty').val(req_qty - setQty);
      
        req_qty =setQty;
    } 
 
   })
  
}

function set_batch(element) {
    
    var batch_hidden='';
    var item_no=$('#item_on_fk').val();
    var total_qty=0;
    // var cost_price=$('#cost_price').val();
    // var purchase_price=$('#purchase_price').val();    
    var uom=$('#item_uom').val();
    var req_dtl=$('#inv_requisitiondtl_no_pk').val();
    $('.req_aty').each(function(){
        if ($(this).val() > 0) {
            var qty=parseFloat($(this).val());
            total_qty +=qty;
            var batch_no=($(this).parents('tr').find('.internal_batch_no').val()).trim();
            var external_batch_no=($(this).parents('tr').find('.external_batch_no').val()).trim();
            var cost_price=($(this).parents('tr').find('.cost_price').val()).trim();
            var purchase_price=($(this).parents('tr').find('.purchase_price').val()).trim();
            var purchaseorderdtl_no_pk=($(this).parents('tr').find('.purchaseorderdtl_no_pk').val()).trim();
      
            var invoicedtl_no_pk=($(this).parents('tr').find('.invoicedtl_no_pk').val()).trim();
            var itemreceivedtl_no_pk=($(this).parents('tr').find('.itemreceivedtl_no_pk').val()).trim();
            var exp_date=($(this).parents('tr').find('.exp_date').val()).trim();
            console.log(exp_date);
            batch_hidden +=`<input type="hidden" class="hidden_batch_no_qty" id="hidden_batch_no_qty" name="hidden_batch_no_qty[]" value="${batch_no+'_'+external_batch_no+'_'+exp_date+'_'+item_no+'_'+qty+'_'+cost_price+'_'+purchase_price+'_'+uom+'_'+req_dtl+'_'+purchaseorderdtl_no_pk+'_'+invoicedtl_no_pk+'_'+itemreceivedtl_no_pk}">`;
            
        }
    })
    $('#add_batch_'+item_no).html(batch_hidden);
    $('#item_quantity_'+item_no).val(total_qty);
    console.log(batch_hidden);
}
$(document).ready(function() {
        $(".common-modal-md").on("shown.bs.modal", function() {
            
            $("#request_qty").focus();
        });
    });

</script>

