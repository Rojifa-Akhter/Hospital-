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
                    <th class="text-left">Stock Qty : {{!empty($main_stock) ? $main_stock : 0}}</th>
                    <th>Req. Qty </th>
                    <th><input  style="width: 100px;" type="text" class="number_only text-right form-control" autocomplete="off" id="request_qty" placeholder="Enter qty" onkeyup="distributeQty(this)"></th>
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
                            <input type="hidden" class="purchase_rate " id="purchase_rate" name="purchase_rate" value=" {{$value->purchase_price}}">
                            <input type="hidden" class="cost_price " id="cost_price" name="cost_price" value=" {{$value->cost_price}}">
                            <input type="hidden" class="itemreceivedtl_no_pk " id="itemreceivedtl_no_pk" name="itemreceivedtl_no_pk" value=" {{$value->itemreceivedtl_no_pk}}">
                        </td>
                        <td>
                            {{$value->batch_no}}
                            <input type="hidden" class="external_batch_no" id="external_batch_no" name="external_batch_no" value=" {{$value->batch_no}}">
                        </td>
                        <td>
                            {{$value->expiry_date !="" ? date('d/m/Y',strtotime($value->expiry_date)) : ""}}
                            <input type="hidden" class="exp_date" id="exp_date" name="exp_date" value="  {{$value->expiry_date !='' ? date('d/m/Y',strtotime($value->expiry_date)) : ''}}">
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
              <input type="hidden" id="item_on_fk" value="{{!empty($item_id) ? $item_id : ''}}" >
            </div>
        </section>
    </form>


</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

$(document).ready(function() {
        $(".common-modal-md").on("shown.bs.modal", function() {
            
            $("#request_qty").focus();
        });
    });

function distributeQty(element) {
 

    var req_qty=$(element).val() !="" ?parseFloat( $(element).val()) :0;
    var total_batch_qty= parseFloat($('#total_batch_qty').val());
    
    if (req_qty > total_batch_qty) {
        alert('Enter Qty Invalid');
        $(element).val('');
        distributeQty(element);
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
   
 
   
    var sales_price=0;
    var uom=$('#uom_no_fk').val();
    $('.req_aty').each(function(){
        if ($(this).val() > 0) {
            var qty=parseFloat($(this).val());
            total_qty +=qty;
            var purchase_price=($(this).parents('tr').find('.purchase_rate').val()).trim();          
            var cost_price=($(this).parents('tr').find('.cost_price').val()).trim();          
            var batch_no=($(this).parents('tr').find('.internal_batch_no').val()).trim();
            var external_batch_no=($(this).parents('tr').find('.external_batch_no').val()).trim();
            var exp_date=($(this).parents('tr').find('.exp_date').val()).trim();
            var itemreceivedtl_no_pk=($(this).parents('tr').find('.itemreceivedtl_no_pk').val()).trim();
     
            batch_hidden +=`<input type="hidden" class="hidden_batch_no_qty" id="hidden_batch_no_qty" name="hidden_batch_no_qty[]" value="${batch_no+'_'+external_batch_no+'_'+exp_date+'_'+item_no+'_'+qty+'_'+purchase_price+'_'+sales_price+'_'+uom+'_'+cost_price+'_'+itemreceivedtl_no_pk}">`;
            
        }
    })
    $('#batch_block').html(batch_hidden);
    // $('#purchase_price').val(cost_price);
    $('#quantity').val(total_qty);
    console.log(batch_hidden);
}
</script>

