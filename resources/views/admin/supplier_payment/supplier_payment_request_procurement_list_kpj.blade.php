@if(!empty($grn_data))
@foreach($grn_data as $value)
<tr>
    
    <input type="hidden" id="" name="po_no_{{$value->itemreceive_no_pk}}" value="{{$value->po_no}}">
    <input type="hidden" id="" name="challan_no_{{$value->itemreceive_no_pk}}" value="{{$value->challan_no}}">
    <input type="hidden" id="" name="store_no_{{$value->itemreceive_no_pk}}" value="{{$value->store_su_no_fk}}">
    <input type="hidden" id="" name="supplier_no_{{$value->itemreceive_no_pk}}" value="{{$value->supplier_no_fk}}">
    <input type="hidden" id="" name="total_grn_amt_{{$value->itemreceive_no_pk}}" value="{{number_format($value->total_grn_amt,2,'.','')}}">
    <input type="hidden" id="" name="return_amt_{{$value->itemreceive_no_pk}}" value="{{number_format($value->return_amt,2,'.','')}}">
    <input type="hidden" id="" name="discount_{{$value->itemreceive_no_pk}}" value="{{number_format($value->discount_amount,2,'.','')}}">
    <input type="hidden" id="" name="vat_amt_{{$value->itemreceive_no_pk}}" value="{{number_format($value->vat_amount,2,'.','')}}">
    <input type="hidden" id="" name="alt_amt_{{$value->itemreceive_no_pk}}" value="{{number_format($value->ait_amount,2,'.','')}}">
    <input type="hidden" id="" name="ser_charge_amount_itm_{{$value->itemreceive_no_pk}}" value="{{number_format($value->ser_charge_amount_itm,2,'.','')}}">
    <input type="hidden" id="" name="current_amt_{{$value->itemreceive_no_pk}}" value="{{number_format($value->current_amt,2,'.','')}}">
   
    <td style="text-align: center;"> {{$loop->iteration}}</td>
    <td class="text-center">{{$value->itemreceive_uid}}</td>
    <td class="text-center">{{$value->purchase_uid}}</td>
    <td class="text-center">{{$value->challan_no}}</td>
    <td>{{$value->serviceunit_name}}</td>
    <td>{{$value->supplier_name}}</td>
    <td class="text-right">{{number_format($value->total_grn_amt,2,'.','')}}</td>
    <td class="text-right">{{number_format($value->return_amt,2,'.','')}}</td>
    <td class="text-right">{{number_format($value->discount_amount,2,'.','')}}</td>
    <td class="text-right">{{number_format($value->vat_amount,2,'.','')}}</td>
    <td class="text-right">{{number_format($value->ser_charge_amount_itm,2,'.','')}}</td>
    <td class="text-right">{{number_format($value->ait_amount,2,'.','')}}</td>
    <td class="text-right">{{number_format($value->current_amt,2,'.','')}}</td>
    <td class="text-center">
        <input type="checkbox" id="payment_select" name="payment_select[]" class="payment_select" value="{{$value->itemreceive_no_pk}}">
        <a href="{{route('v2.grn-report-print',$value->itemreceive_no_pk)}}" target="_blank" class="btn btn-warning btn-sm">GRN</a>
        <!-- <span class="btn btn-sm btn-outline-primary open-modal" data-id="" data-action="" data-modal="common-modal" data-title="Edit Blood Requisition" title="Edit"><i class="fa fa-pencil-alt"></i></span>
        <span class="btn btn-sm btn-outline-success open-modal" data-id="" data-action="" data-modal="common-modal" data-title="Add Donor" title="Add Donor">Add Donor</span>
        <span class="btn btn-sm btn-outline-info open-modal" data-id="" data-action="" data-modal="common-modal" data-title="Donor List" title="Donor list"> Donor List</span>
        <a href="" title="requisition pdf" target="_blank"><i class="fa fa-file-pdf"></i></a> -->


        <span class="btn btn-sm btn-success open-modal btnView" data-action="{{route('show-grn-bill-progress',$value->itemreceive_no_pk)}}" data-modal="common-modal-sm" data-title="Show GRN Bill Status" title="Show GRN Bill Status" data-id="{{$value->itemreceive_no_pk}}"><i class="fas fa-eye"></i></span>
    </td>
</tr>
@endforeach

@endif