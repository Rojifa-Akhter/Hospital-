@php
    
    $grn_total = 0;
    $batch=0;
@endphp
      
@foreach($po_child_details_info as $item)
<tr>
    
    <td><input type="text" class="form-control form-control-sm" value="{{$loop->iteration}}" name="po_sl[]" id="posl{{$loop->iteration}}" required></td>
    <td class="item_name">
    <input type="hidden" id="item_no" class="item_no" value="{{$item->item_no_fk}}" > 
    <input type="hidden" id="po_dtl_no_{{$item->item_no_fk}}" name="purchaseorderdtl_no_pk" class="po_dtl_no" value="{{$item->purchaseorderdtl_no_pk}}" > 
    <input type="hidden" id="pr_dtl_no_{{$item->item_no_fk}}" name="pr_no_fk" class="pr_dtl_no" value="{{$item->inv_requisitiondtl_po_no_fk}}" > 
        {{$item->item_name}} 

        @if(isset($batch_dtl)&&!empty($batch_dtl))   
        <span class="item_batch_info">  
            @foreach($batch_dtl as $value)
                @if($value->item_no_fk == $item->item_no_fk && $value->batch_no !='')
                @php 
                   $batch=1;
                 @endphp
                
                 <span class="badge badge-secondary" style="display: block;">{{$value->batch_no}}-{{$value->item_qty}}</span>
               
                @endif
            @endforeach
            </span>         
        @endif
        <!-- @if($batch ==0)
        <span class="item_batch_info"></span>
        @endif -->
       
    </td>
    <td>
        @php
       
        $item_room = '<option value="">Select</option>';
            $selected_room = '';
          
            foreach($room_location as $location) {
                if($item->store_room_no_pk != '') {
                    $selected_room = $item->store_room_no_pk;
                    $room_select= $selected_room == $location['room_no_pk'] ? 'selected' :'';
                   
                    $item_room .= '<option  value="'.$location['room_no_pk'].'" '.$room_select.' >'.$location['room_name'].'</option>';
                } else {
                    $item_room .= '<option value="'.$location['room_no_pk'].'">'.$location['room_name'].'</option>';
                }
            }
           
            $selected_uom = '';
            $selected_uom_no = '';
            $item_uom = '<option value="">Select</option>';
                        if ($item->uom_no_fk != '')
                            if ($item->uom == $item->uom_no_fk) {
                                $selected_uom = $item->uom_name;
                                $selected_uom_no =$item->uom;
                                $item_uom .=
                                    '<option data-conversion="'.$item->pr_uom_conversion_qty.'" selected  value="'.$item->uom_no_fk.'_'.$item->uom_name.'">'.$item->uom_name.'</option>';
                            } else {
                                $item_uom .=
                                '<option data-conversion="'.$item->pr_uom_conversion_qty.'"  value="'.$item->uom_no_fk.'_'.$item->uom_name.'">'.$item->uom_name.'</option>';
                            }
                        if ($item->item_uom_name_2nd != '')
                            if ($item->uom == $item->uom_no_fk_2nd) {
                                $selected_uom = $item->uom_name;
                                $selected_uom_no =$item->uom;
                                $item_uom .=
                                '<option data-conversion="'.$item->uom_no_fk_2nd_conv_ratio.'" selected value="'.$item->uom_no_fk_2nd.'_'.$item->item_uom_name_2nd.'">'.$item->item_uom_name_2nd.'</option>';
                            } else {
                                $item_uom .=
                                '<option data-conversion="'.$item->uom_no_fk_2nd_conv_ratio.'" value="'.$item->uom_no_fk_2nd.'_'.$item->item_uom_name_2nd.'">'.$item->item_uom_name_2nd.'</option>';
                            }
                        if ($item->uom_no_fk_3rd != '')
                            if ($item->uom == $item->uom_no_fk_3rd) {
                                $selected_uom = $item->uom_name;
                                $selected_uom_no =$item->uom;
                                $item_uom .=
                                '<option data-conversion="'.$item->uom_no_fk_3rd_conv_ratio.'" selected value="'.$item->uom_no_fk_3rd.'_'.$item->item_uom_name_3rd.'">'.$item->item_uom_name_3rd.'</option>';
                            } else {
                                $item_uom .=
                                '<option data-conversion="'.$item->uom_no_fk_3rd_conv_ratio.'" value="'.$item->uom_no_fk_3rd.'_'.$item->item_uom_name_3rd.'">'.$item->item_uom_name_3rd.'</option>';
                            }
                        if ($item->uom_no_fk_4th != '')
                            if ($item->uom == $item->uom_no_fk_4th) {
                                $selected_uom = $item->uom_name;
                                $selected_uom_no =$item->uom;
                                $item_uom .=
                                '<option data-conversion="'.$item->uom_no_fk_4th_conv_ratio.'" selected value="'.$item->uom_no_fk_4th.'_'.$item->item_uom_name_4th.'">'.$item->item_uom_name_4th.'</option>';
                            } else {
                                $item_uom .=
                                '<option data-conversion="'.$item->uom_no_fk_4th_conv_ratio.'" value="'.$item->uom_no_fk_4th.'_'.$item->item_uom_name_4th.'">'.$item->item_uom_name_4th.'</option>';
                            }

        @endphp
        <select class="form-control pur_unit" id="pur_item_uom{{$item->item_no_fk}}" name="pur_item_uom_{{$item->item_no_fk}}[]" onchange="setConversionQty(this)">
            {!!trim($item_uom,'" ')!!}
        </select>
        <input type="hidden" class="item_old_price" name="item_old_price_{{$item->item_no_fk}}[]" id="item_old_price{{$item->item_no_fk}}" value="{{$item->purchase_price}}"/>     
        <input type="hidden" class="tr_item_pk_no" name="item_id[]" id="item_id{{$item->item_no_fk}}" value="{{$item->item_no_fk}}"/>   
    </td>
    <td class="item_conversion">
        @php
            $item_total = 0;
            $item_pur_price = 0;
            $purchase_qty_pc = 0;
            $total_qty = 0;
            $total_purchase_price = 0;
            $const_price = 0;
            $item_conv_qty = 0;
           
            if ($item->uom == $item->uom_no_fk) {
                
                $item_conv_qty =  $item->pr_uom_conversion_qty;
                $item_pur_price = $item->pr_uom_conversion_qty*$item->trade_price;
                $item_total = ($item->item_qty - number_format($item->freeitem_qty))*$item_pur_price;
               
                $grn_total += $item_total;

                $purchase_qty_pc = $item->item_qty*$item->pr_uom_conversion_qty;
            
                $total_qty = ($purchase_qty_pc);

                $total_purchase_price = $item->item_qty*$item_pur_price;

                $const_price = $item->cost_price;// $total_purchase_price/$total_qty;
            }
           
            if ($item->uom == $item->uom_no_fk_2nd) {
                $item_conv_qty =  $item->uom_no_fk_2nd_conv_ratio;
                $item_pur_price = $item->uom_no_fk_2nd_conv_ratio*$item->trade_price;
                $item_total =( $item->item_qty- number_format($item->freeitem_qty)) *$item_pur_price;

                $grn_total += $item_total;

                $purchase_qty_pc = $item->item_qty*$item->uom_no_fk_2nd_conv_ratio;
            
                $total_qty = ($purchase_qty_pc);

                $total_purchase_price = $item->item_qty*$item_pur_price;

                $const_price = $item->cost_price;// $total_purchase_price/$total_qty;
            }

            if ($item->uom == $item->uom_no_fk_3rd) {
                $item_conv_qty =  $item->uom_no_fk_3rd_conv_ratio;
                $item_pur_price = $item->uom_no_fk_3rd_conv_ratio*$item->trade_price;
                $item_total = (($item->item_qty- number_format($item->freeitem_qty))/$item->pr_uom_conversion_qty)*$item_pur_price;

                $grn_total += $item_total;

                $purchase_qty_pc = ($item->item_qty/$item->pr_uom_conversion_qty)*$item->uom_no_fk_3rd_conv_ratio;
            
                $total_qty = ($purchase_qty_pc);

                $total_purchase_price = ($item->item_qty/$item->pr_uom_conversion_qty)*$item_pur_price;

                $const_price = $item->cost_price;// $total_purchase_price/$total_qty;
            }

            if ($item->uom == $item->uom_no_fk_4th) {
                $item_conv_qty =  $item->uom_no_fk_4th_conv_ratio;
                $item_pur_price = $item->uom_no_fk_4th_conv_ratio*$item->trade_price;
                $item_total = (($item->item_qty - number_format($item->freeitem_qty))/$item->pr_uom_conversion_qty)*$item_pur_price;

                $grn_total += $item_total;


                $purchase_qty_pc = ($item->item_qty/$item->pr_uom_conversion_qty)*$item->uom_no_fk_4th_conv_ratio;
            
                $total_qty = ($purchase_qty_pc);

                $total_purchase_price = ($item->item_qty/$item->pr_uom_conversion_qty)*$item_pur_price;

                $const_price = $item->cost_price;// $total_purchase_price/$total_qty;
            }


         

        @endphp
        {{$item_conv_qty}}
    </td>
    <input type="hidden" class="item_conv_qty" name="item_conv_qty_{{$item->item_no_fk}}[]" id="item_conv_qty{{$item->item_no_fk}}" data-item_conv_qty="{{$item->item_no_fk}}" value=""/>
    <td>{{$item->uom_name}}</td>
    <input type="hidden" name="item_uom_no_fk_{{$item->item_no_fk}}[]" id="item_uom_no_fk{{$item->item_no_fk}}" value="{{$item->uom_no_fk}}"/>
    <td>{{$item->entry_qty}}</td>
    <td>{{($item->item_qty/$item->pr_uom_conversion_qty)}}</td>
    <td class="pur_item_location">
        <select class="form-control" id="pur_item_location{{$item->item_no_fk}}" name="pur_item_location_{{$item->item_no_fk}}[]" onchange="setConstPrice(this)">
            {!!trim($item_room,'" ')!!}
        </select>
    </td>
    <td>
        <input type="text" class="form-control form-control-sm text-right grn_qty" name="grn_qty_{{$item->item_no_fk}}[]" id="grn_qty{{$item->item_no_fk}}" value="{{($item->item_qty/$item->pr_uom_conversion_qty) - number_format($item->freeitem_qty)}}" onkeyup="setConstPrice(this)" placeholder="" />
    </td>
    <td>
        <input type="text" class="form-control form-control-sm text-right grn_free_qty" name="grn_free_qty_{{$item->item_no_fk}}[]" id="grn_free_qty{{$item->item_no_fk}}" onkeyup="setConstPrice(this)" placeholder="" value="{{$item->freeitem_qty}}" />
    </td>
    <td>
        <input type="text" class="form-control form-control-sm text-right temperature" name="temperature_{{$item->item_no_fk}}[]"  style="width:30px" id="temperature_{{$item->item_no_fk}}" placeholder="" onkeyup="setConstPrice(this)" />
    </td>
    <td>    
        <select class="form-control temp_deg" id="temp_deg_{{$item->item_no_fk}}" name="temp_deg_{{$item->item_no_fk}}[]">
            <option value="°C">°C</option>
            <option value="°F">°F</option>
        </select>
    </td>
    <td class="td_purchase_price"><input type="text" class="form-control form-control-sm item_wise_purchase_price" name="item_purchase_price_{{$item->item_no_fk}}[]" id="item_purchase_price{{$item->item_no_fk}}" onkeyup="setConstPrice(this)" value="{{$item_pur_price}}"/></td>
    <input type="hidden" name="item_purchase_price_{{$item->item_no_fk}}[]" id="item_purchase_price{{$item->item_no_fk}}" value="{{$item->trade_price}}"/>
    <input type="hidden" name="item_sales_price_{{$item->item_no_fk}}[]" id="item_sales_price{{$item->item_no_fk}}" value="{{$item->sales_price}}"/>
    <td class="item_purchase_cost_price">{{number_format($const_price,2)}}</td>
    <td>
        <input type="text" class="form-control form-control-sm text-right item_purchase_price" name="item_purchase_price_input{{$item->item_no_fk}}[]" id="item_purchase_price_input{{$item->item_no_fk}}" value="{{$item_total}}" placeholder="0.00" />
    </td>

    @php 
        $is_batch=0;
    @endphp
    
    @if(!empty($batch_checked))
        @foreach($batch_checked as $value)
        $is_batch +=1;
            @if($value->item_no_fk == $item->item_no_fk && $value->batch_no !=null )
            @php 
                $is_batch=1;
            @endphp
               
            @elseif($value->item_no_fk == $item->item_no_fk && $value->batch_no ==null )
            @php 
                $is_batch=0;
            @endphp
                
            @endif
           
                @if($is_batch ==1 )
                 @break
             @endif
        @endforeach
        
    @endif

                <td class="text-center">
                    <span class="btn btn-sm btn-dark batch_popup" data-toggle="modal" data-batch_item="{{$item->item_no_fk}}_{{(($item->item_qty-$item->freeitem_qty)/$item->pr_uom_conversion_qty)}}_{{$item->freeitem_qty}}_{{$item_pur_price}}_{{$item->sales_price*$item_conv_qty}}_{{$const_price*$item_conv_qty}}_{{$selected_uom_no}}_{{$selected_uom}}_{{$item_conv_qty}}_°C_{{$item->store_room_no_pk}}_{{$item->purchaseorderdtl_no_pk}}_{{$item->inv_requisitiondtl_po_no_fk}}" data-item-sl="#posl{{$loop->iteration}}" data-target="#exampleModal" onclick="batch_popup(this)" data-is_batch="{{$is_batch}}">
                        <i class="fa fa-eye"></i>
                    </span>
                </td>
   
    <td class="text-center">
        <button class="btn btn-sm btn-danger del_tr_item" onclick="del_tr_item(this)"><i class="fas fa-trash-alt"></i></button>
    </td>
</tr>
@endforeach