
@if(!empty($depreciation_arr))
@foreach($depreciation_arr as $value)
<tr>
    <td class="text-left">{{$loop->iteration}}</td>
    <td class="text-left" >{{$value->asset_tag_uid}}</td>
    <td class="text-left">{{$value->item_name}}</td>
    <td class="text-left">{{$value->item_category_par}}</td>
    <td class="text-left">{{$value->item_sub_category_itype}}</td>
    <td class="text-left">{{$value->curr_location_room}} <br>{{$value->curr_user_incharge}} </td>
    <td class="text-left">{{$value->item_serviceunit_name}}</td>
    <td class="text-left">{{$value->purchase_uid}}</td>
    <td class="text-left">{{$value->purchase_date !="" ? date('d/m/Y',strtotime($value->purchase_date)) : ''}}</td>
    <td class="text-left">{{$value->year_of_purchase}}</td>
    <!-- <td class="text-center">{{$value->bill_number}}</td>
    <td class="text-center">{{$value->bill_date !="" ? date('d/m/Y',strtotime($value->bill_date)) :''}}</td> -->
    <td class="text-left">{{$value->challan_no}}</td>
    <td class="text-left">{{$value->challan_date !="" ? date('d/m/Y',strtotime($value->challan_date)) :''}}</td>
    <td class="text-left">{{$value->itemreceive_uid}}</td>
    <td class="text-left">{{$value->grn_date !="" ? date('d/m/Y',strtotime($value->grn_date)) :''}}</td>
    <td class="text-left">{{$value->item_model_number}}</td>
    <td class="text-left">{{$value->item_serial_number}}</td>
    <td class="text-left">{{$value->journal_code}} <br> {{$value->journal_date !="" ? date('d/m/Y',strtotime($value->journal_date)) :''}}</td>
    <td class="text-left">{{$value->journal_code_payment}}</td>
    <td class="text-center">{{$value->no_of_unit}}</td>
    <td class="text-center">{{$value->unit_value}}</td>
    <td class="text-right">{{$value->total_value}}</td>
    <td class="text-right">{{$value->usage_status}}</td>
    <td class="text-right" style="font-weight: 700;">{{$value->asset_remarks}}</td>
    <td class="text-left">{{$value->supplier_name}}</td>
    <td class="text-left">{{$value->supplier_address}}</td>
    <td class="text-left">{{$value->supplier_bin}}</td>
    <td class="text-left">{{$value->supplier_tin}}</td>
</tr>
@endforeach
@endif
