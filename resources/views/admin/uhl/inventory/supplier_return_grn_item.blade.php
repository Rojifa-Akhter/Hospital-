@foreach($item_arr as $item)
<tr>
    {{$item['store_su_no']}}
    <input type="hidden" name="store_su_no_fk" id="store_su_no_fk" value="{{$item['store_su_no']}}"/>
    <input type="hidden" name="challan_no" id="challan_no" value="{{$item['challan_no']}}"/>
    <input type="hidden" name="challan_date" id="challan_date" value="{{isset($item['challan_date']) ? $item['challan_date'] : NULL}}"/>
    <input type="hidden" name="module_no_fk" id="module_no_fk" value="{{isset($item['module_no_fk']) ? $item['module_no_fk'] : NULL}}"/>
    <input type="hidden" name="supplier_no_fk" id="supplier_no_fk" value="{{isset($item['supplier_no_fk']) ? $item['supplier_no_fk'] : NULL}}"/>
    <input type="hidden" name="vat_percent" id="vat_percent" value="{{isset($item['vat_percent']) ? $item['vat_percent'] : NULL}}"/>
    <input type="hidden" name="vat_amount" id="vat_amount" value="{{isset($item['vat_amount']) ? $item['vat_amount'] : NULL}}"/>
    <input type="hidden" name="discount_percent" id="discount_percent" value="{{isset($item['discount_percent']) ? $item['discount_percent'] : NULL}}"/>
    <input type="hidden" name="discount_amount" id="discount_amount" value="{{isset($item['discount_amount']) ? $item['discount_amount'] : NULL}}"/>
    <input type="hidden" name="item_no_fk[]" id="item_no_fk" value="{{isset($item['item_no_fk']) ? $item['item_no_fk'] : NULL}}"/>
    <input type="hidden" name="internal_batch_no_uq[]" id="internal_batch_no_uq" value="{{isset($item['internal_batch_no_uq']) ? $item['internal_batch_no_uq'] : NULL}}"/>
    <input type="hidden" name="batch_no[]" id="batch_no" value="{{isset($item['batch_no']) ? $item['batch_no'] : NULL}}"/>
    <input type="hidden" name="expiry_date[]" id="expiry_date" value="{{isset($item['expiry_date']) ? date("Y-m-d",strtotime($item['expiry_date'])) : NULL}}"/>
    <input type="hidden" name="invoice_no" id="invoice_no" value="{{isset($item['invoice_no']) ? $item['invoice_no'] : NULL}}"/>
    <input type="hidden" name="itemreceive_no_pk" id="itemreceive_no_pk" value="{{isset($item['itemreceive_no_pk']) ? $item['itemreceive_no_pk'] : NULL}}"/>
    <input type="hidden" name="itemreceivedtl_no_pk[]" id="itemreceivedtl_no_pk" value="{{isset($item['itemreceivedtl_no_pk']) ? $item['itemreceivedtl_no_pk'] : NULL}}"/>
    <input type="hidden" name="inv_requisitiondtl_no_pk" id="inv_requisitiondtl_no_pk" value="{{isset($item['inv_requisitiondtl_no_pk']) ? $item['inv_requisitiondtl_no_pk'] : NULL}}"/>
    <input type="hidden" name="cost_price[]" id="cost_price" value="{{isset($item['cost_price']) ? $item['cost_price'] : NULL}}"/>
    <input type="hidden" name="purchase_price[]" id="purchase_price" value="{{isset($item['trade_price']) ? $item['trade_price'] : NULL}}"/>
    <input type="hidden" name="po_no[]" id="po_no" value="{{isset($item['po_no']) ? $item['po_no'] : NULL}}"/>
    <input type="hidden" name="item_qty[]" id="item_qty" value="{{isset($item['item_qty']) ? $item['item_qty'] : NULL}}"/>
    <input type="hidden" name="item_uom[]" id="item_uom" value="{{isset($item['item_uom']) ? $item['item_uom'] : NULL}}"/>
    <input type="hidden" name="supp_rtn_data" id="supp_rtn_data" value="{{isset($item['itemreturn_date']) ? date("Y-m-d", strtotime($item['itemreturn_date'])) : NULL}}"/>
    <input type="hidden" name="return_type_text" id="return_type_text" value="{{isset($item['return_type_text']) ? $item['return_type_text'] : NULL}}"/>
    <input type="hidden" name="return_reason_type" id="return_reason_type" value="{{isset($item['return_reason_type']) ? $item['return_reason_type'] : NULL}}"/>
    <input type="hidden" name="getpass_no_fk" id="getpass_no_fk" value="{{isset($item['getpass_no_fk']) ? $item['getpass_no_fk'] : NULL}}"/>
    <td>{{$loop->iteration}}</td>
    <td>{{$item['item_name']}}</td>
    <td>{{$item['batch_no']}}</td>
    <td>{{$item['internal_batch_no_uq']}}</td>
    <td>{{$item['expiry_date']}}</td>
    <td class="text-center">
        {{$item['main_store_stock']}}
        <input type="hidden" class="main_stock_qty" name="main_stock_qty[]" value="{{$item['main_store_stock']}}"/>
    </td>
    <td class="text-center">
        {{$item['item_qty']}}
        <input type="hidden" class="item_qty" name="item_qty[]" value="{{$item['item_qty']}}"/>
    </td>
    <td class="text-center">
        {{$item['rtn_item_qty']}}
        <input type="hidden" class="rtnd_item_qty" name="rtnd_item_qty[]" value="{{$item['rtn_item_qty']}}"/>
    </td>
    <td class="text-center"><input type="text" class="rtn_item_qty" name="rtn_item_qty[]" value="" onkeyup="item_amount(this)"/></td>
    {{-- <td class="text-center"><input type="text" class="rtn_item_qty" name="rtn_item_qty[]" value="{{($item['main_store_stock'])}}" onkeyup="item_amount(this)"/></td> --}}
    <td class="text-center">{{$item['trade_price']}}</td>
    <td class="text-right"></td>
    <td class="text-right">
        <input type="hidden" class="total_amt" name="total_amt" id="total_amt" value="0" />
        <input type="hidden" class="item_total_amt" name="item_total_amt[]" id="item_total_amt" value="{{$item['item_qty']*$item['trade_price']}}" />
        <input type="hidden" class="trade_price" name="trade_price[]" id="trade_price" value="{{$item['trade_price']}}" />
        <span class="item_total_amt_pr">{{$item['item_qty']*$item['trade_price']}}</span>
    </td>
    <td class="text-center">
        <input type="checkbox" name="chk_total_amt[]" class="chk_total_amt" value="{{$item['item_no_fk']}}" onclick="single_check(this)">
        <button type="button" class="btn btn-sm btn-danger" onclick="item_dtl(this)"><i class="fas fa-trash-alt"></i></button>
    </td>
</tr>
@endforeach

<script>
    $(document).ready(function(){
        let supplier_no_fk = $('#supplier_no_fk').val();

        $('#supplier_name').val(supplier_no_fk).trigger('change');


    });




</script>
